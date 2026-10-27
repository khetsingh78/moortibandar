<?php

namespace App\Jobs;

use App\Models\Shipment;
use App\Services\Shiprocket\ShiprocketClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class CreateShiprocketShipment implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    public $backoff = [30, 120, 300];

    public $uniqueFor = 900;

    public function __construct(public int $shipmentId)
    {
    }

    public function uniqueId(): string
    {
        return 'shiprocket-shipment-' . $this->shipmentId;
    }

    public function handle(ShiprocketClient $client): void
    {
        $shipment = Shipment::with(['order.user', 'order.orderItems', 'order.shipping', 'order.payment'])
            ->findOrFail($this->shipmentId);

        if ($shipment->status === 'booked') {
            return;
        }

        $shipment->update(['status' => 'processing', 'last_error' => null]);

        try {
            if (!$shipment->provider_shipment_id) {
                $createdOrder = $client->createOrder($shipment->order, $shipment);
                $providerShipmentId = data_get($createdOrder, 'shipment_id');

                if (!$providerShipmentId) {
                    throw new \RuntimeException('Shiprocket did not return a shipment ID.');
                }

                $providerResponses = $shipment->provider_response ?? [];
                $providerResponses['create_order'] = $createdOrder;
                $shipment->update([
                    'provider_order_id' => data_get($createdOrder, 'order_id'),
                    'provider_shipment_id' => (string) $providerShipmentId,
                    'provider_response' => $providerResponses,
                    'provider_status' => 'order_created',
                ]);
            }

            $awbResponse = $client->assignAwb(
                (string) $shipment->provider_shipment_id,
                (string) $shipment->courier_id
            );
            $awb = data_get($awbResponse, 'response.data.awb_code')
                ?: data_get($awbResponse, 'data.awb_code')
                ?: data_get($awbResponse, 'awb_code');

            if (!$awb) {
                throw new \RuntimeException('Shiprocket did not return an AWB code.');
            }

            $providerResponses = $shipment->provider_response ?? [];
            $providerResponses['awb_assignment'] = $awbResponse;
            $courierName = data_get($awbResponse, 'response.data.courier_name')
                ?: data_get($awbResponse, 'data.courier_name')
                ?: $shipment->courier_name;

            $shipment->update([
                'awb_code' => (string) $awb,
                'courier_name' => $courierName,
                'tracking_url' => 'https://shiprocket.co/tracking/' . urlencode((string) $awb),
                'status' => 'booked',
                'provider_status' => 'awb_assigned',
                'provider_response' => $providerResponses,
                'last_error' => null,
            ]);

            $shipment->order->update(['delivery_status' => 'processing']);
        } catch (Throwable $exception) {
            $shipment->update([
                'status' => 'failed',
                'last_error' => mb_substr($exception->getMessage(), 0, 60000),
            ]);

            throw $exception;
        }
    }

    public function failed(Throwable $exception): void
    {
        Shipment::whereKey($this->shipmentId)->where('status', '!=', 'booked')->update([
            'status' => 'failed',
            'last_error' => mb_substr($exception->getMessage(), 0, 60000),
        ]);
    }
}