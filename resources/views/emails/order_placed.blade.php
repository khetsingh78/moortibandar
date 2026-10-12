<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">

    ```
    <title>Order Confirmation</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f5f5;
            font-family: Arial, Helvetica, sans-serif;
            color: #333;
        }

        .email-container {
            max-width: 700px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background: #111827;
            color: #ffffff;
            padding: 25px;
            text-align: center;
        }

        .content {
            padding: 30px;
        }

        .order-info {
            background: #f9fafb;
            padding: 15px;
            margin: 20px 0;
            border-radius: 6px;
        }

        .order-info table {
            width: 100%;
        }

        .order-info td {
            padding: 5px 0;
        }

        .products {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .products th,
        .products td {
            border-bottom: 1px solid #e5e7eb;
            padding: 12px 8px;
            text-align: left;
        }

        .products th {
            background: #f9fafb;
        }

        .text-right {
            text-align: right !important;
        }

        .summary {
            width: 100%;
            margin-top: 20px;
        }

        .summary td {
            padding: 8px;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            border-top: 2px solid #111827;
        }

        .address-section {
            margin-top: 30px;
        }

        .address-box {
            background: #f9fafb;
            padding: 15px;
            border-radius: 6px;
            line-height: 1.6;
        }

        .footer {
            background: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #777;
        }
    </style>
    ```

</head>

<body>

    <div class="email-container">


        <!-- Header -->
        <div class="header">
            <h1>Order Confirmed!</h1>
            <p>Thank you for your purchase.</p>
        </div>

        <!-- Content -->
        <div class="content">

            <p>
                Hello <strong>{{ $order->user->name }}</strong>,
            </p>

            <p>
                Thank you for placing your order with us.
                Your order has been successfully placed.
            </p>

            <!-- Order Information -->
            <div class="order-info">

                <table>
                    <tr>
                        <td><strong>Order Number:</strong></td>
                        <td>#{{ $order->id ?? '' }}</td>
                    </tr>

                    <tr>
                        <td><strong>Order Date:</strong></td>
                        <td>
                            {{ $order->created_at->format('d M Y, h:i A') }}
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Payment Method:</strong></td>
                        <td>
                            {{-- {{ ucfirst($order->payment_method) }} --}}
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Payment Status:</strong></td>
                        <td>
                            {{ ucfirst($order->payment_status) }}
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Order Status:</strong></td>
                        <td>
                            {{-- {{ ucfirst($order->status) }} --}}
                        </td>
                    </tr>
                </table>

            </div>

            <!-- Products -->
            <h3>Order Details</h3>

            <table class="products">

                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($order->orderItems as $item)
                        <tr>

                            <td>
                                {{ $item->title ?? '' }}
                            </td>

                            <td>
                                ₹{{ number_format($item->price, 2) }}
                            </td>

                            <td>
                                {{ $item->quantity ?? '' }}
                            </td>

                            <td class="text-right">
                                ₹{{ number_format($item->price * $item->quantity, 2) }}
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

            <!-- Order Summary -->
            <table class="summary">

                <tr>
                    <td>Subtotal</td>
                    <td class="text-right">
                        ₹{{ number_format($order->subtotal, 2) }}
                    </td>
                </tr>

                @if ($order->discount > 0)
                    <tr>
                        <td>Discount</td>
                        <td class="text-right">
                            - ₹{{ number_format($order->discount, 2) }}
                        </td>
                    </tr>
                @endif

                @if ($order->tax > 0)
                    <tr>
                        <td>GST / Tax</td>
                        <td class="text-right">
                            ₹{{ number_format($order->gst, 2) }}
                        </td>
                    </tr>
                @endif

                {{-- @if ($order->shipping_charge > 0)
                    <tr>
                        <td>Shipping</td>
                        <td class="text-right">
                            ₹{{ number_format($order->shipping_charge, 2) }}
                        </td>
                    </tr>
                @endif --}}

                <tr class="total">

                    <td>
                        Grand Total
                    </td>

                    <td class="text-right">
                        ₹{{ number_format($order->total, 2) }}
                    </td>

                </tr>

            </table>

            <!-- Address -->
            <div class="address-section">

                <h3>Shipping Address</h3>

                <div class="address-box">

                    {{ $order->shipping?->address }}<br>

                    {{ $order->shipping?->city }},
                    {{ $order->shipping?->state }}<br>

                    {{ $order->shipping?->pincode }}<br>

                    {{ $order->shipping?->phone }}

                </div>

            </div>

            <p style="margin-top: 30px;">
                We will notify you when your order is shipped.
            </p>

            <p>
                Thank you for shopping with us.
            </p>

        </div>

        <!-- Footer -->
        <div class="footer">

            <p>
                © {{ date('Y') }} Your Store. All rights reserved.
            </p>

            <p>
                This is an automated email. Please do not reply to this email.
            </p>

        </div>
    </div>

</body>

</html>
