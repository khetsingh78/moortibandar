<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShiprocketWebhookController extends Controller
{
    public function handle(Request $request, string $token)
    {
        $expectedToken = (string) config('services.shiprocket.webhook_token');
        if ($expectedToken === '' || !hash_equals($expectedToken, $token)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $event = $request->all();
        $payload = data_get($event, 'data', $event);
        $awb = data_get($payload, 'awb')
            ?: data_get($payload, 'awb_code')
            ?: data_get($payload, 'tracking_data.awb_code');
        $providerShipmentId = data_get($payload, 'shipment_id')
            ?: data_get($payload, 'sr_shipment_id');

        $shipmentQuery = Shipment::query();
        if ($awb) {
            $shipmentQuery->where('awb_code', (string) $awb);
        } elseif ($providerShipmentId) {
            $shipmentQuery->where('provider_shipment_id', (string) $providerShipmentId);
        } else {
            $externalOrderId = (string) data_get($payload, 'order_id', '');
            if (!preg_match('/^MJ-(\d+)$/', $externalOrderId, $matches)) {
                Log::notice('Ignored Shiprocket webhook without a known shipment reference.');
                return response()->json(['status' => 'ignored']);
            }

            $shipmentQuery->where('order_id', (int) $matches[1]);
        }

        $shipment = $shipmentQuery->with('order')->first();
        if (!$shipment) {
            return response()->json(['status' => 'ignored']);
        }

        $providerStatus = (string) (
            data_get($payload, 'current_status')
            ?: data_get($payload, 'shipment_status')
            ?: data_get($payload, 'status')
            ?: 'updated'
        );

        $providerResponses = $shipment->provider_response ?? [];
        $providerResponses['tracking_webhook'] = $event;
        $shipment->update([
            'provider_status' => $providerStatus,
            'provider_response' => $providerResponses,
        ]);

        $deliveryStatus = $this->deliveryStatus($providerStatus);
        if ($deliveryStatus && $this->shouldAdvanceOrder($shipment->order, $deliveryStatus)) {
            $shipment->order->update(['delivery_status' => $deliveryStatus]);
        }

        return response()->json(['status' => 'processed']);
    }

    private function deliveryStatus(string $providerStatus): ?string
    {
        $status = strtolower(trim(str_replace(['_', '-'], ' ', $providerStatus)));

        if (in_array($status, ['delivered', 'delivery completed'], true)) {
            return 'delivered';
        }
        if (in_array($status, ['out for delivery', 'ofd'], true)) {
            return 'out_for_delivery';
        }
        if (in_array($status, ['shipped', 'in transit', 'picked up', 'manifested'], true)) {
            return 'shipped';
        }
        if (in_array($status, ['cancelled', 'canceled'], true)) {
            return 'cancelled';
        }
        if (in_array($status, ['returned', 'return to origin', 'rto delivered'], true)) {
            return 'returned';
        }
        if (in_array($status, ['processing', 'pickup scheduled', 'ready to ship'], true)) {
            return 'processing';
        }

        return null;
    }

    private function shouldAdvanceOrder(Order $order, string $nextStatus): bool
    {
        if (in_array($nextStatus, ['cancelled', 'returned'], true)) {
            return $order->delivery_status !== $nextStatus;
        }

        $rank = [
            'pending' => 0,
            'processing' => 1,
            'shipped' => 2,
            'out_for_delivery' => 3,
            'delivered' => 4,
        ];

        return ($rank[$nextStatus] ?? -1) >= ($rank[$order->delivery_status] ?? 0);
    }
}