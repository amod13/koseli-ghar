<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">

    <div style="max-width: 600px; margin: auto; background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; color: #28a745;">Thank you for your order, {{ $userDetail->first_name }}!</h2>

        <p style="font-size: 16px;">We’re happy to let you know that we’ve received your order.</p>

        <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <tr>
                <td style="font-weight: bold; padding: 8px;">Order ID:</td>
                <td style="padding: 8px;">#{{ $order->id }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px;">Customer Name:</td>
                <td style="padding: 8px;">{{ $userDetail->first_name }} {{ $userDetail->middle_name }} {{ $userDetail->last_name }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 8px;">Payment Method:</td>
                <td style="padding: 8px;">{{ ucfirst($order->payment_method) }}</td>
            </tr>
        </table>

        <h3 style="margin-top: 30px;">Order Details</h3>
        <table style="width: 100%; margin-top: 10px; border-collapse: collapse; border: 1px solid #dee2e6;">
            <thead style="background-color: #f1f1f1;">
                <tr>
                    <th style="padding: 10px; text-align: left; border: 1px solid #dee2e6;">Product</th>
                    <th style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">Quantity</th>
                    <th style="padding: 10px; text-align: right; border: 1px solid #dee2e6;">Price</th>
                    <th style="padding: 10px; text-align: right; border: 1px solid #dee2e6;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr>
                        <td style="padding: 10px; border: 1px solid #dee2e6;">{{ $item->product->name ?? 'N/A' }}</td>
                        <td style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">{{ $item->quantity }}</td>
                        <td style="padding: 10px; text-align: right; border: 1px solid #dee2e6;">NPR {{ number_format($item->price, 2) }}</td>
                        <td style="padding: 10px; text-align: right; border: 1px solid #dee2e6;">NPR {{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="padding: 10px; text-align: right; font-weight: bold; border: 1px solid #dee2e6;">Grand Total:</td>
                    <td style="padding: 10px; text-align: right; font-weight: bold; border: 1px solid #dee2e6;">NPR {{ number_format($order->total_price, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <p style="font-size: 15px; margin-top: 20px;">We will notify you once your order is shipped. If you have any questions, feel free to contact 9861500625.</p>

        <hr style="margin: 30px 0;">

        <p style="text-align: center; font-size: 14px; color: #6c757d;">
            &copy; {{ date('Y') }} itsamagri. All rights reserved.
        </p>
    </div>

</body>
</html>
