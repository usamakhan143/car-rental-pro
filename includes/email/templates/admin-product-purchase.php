<?php
if (!defined('ABSPATH')) exit;

global $wpdb;

// Fetch order meta data
$order_id = $order->get_id(); // Get the dynamic order ID
$post_metas = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM {$wpdb->prefix}wc_orders_meta WHERE order_id = %d", $order_id),
    ARRAY_A
);

// Prepare data for display
$fields_to_display = [
    'pickup_or_delivery',
    'oneway',
    'delivery_address',
    'return_address',
    'age_bracket',
    'start_date',
    'end_date',
    'start_time',
    'end_time',
    'days_booked',
    'extras',
    'tax_fees',
    'discount',
    'discount_type',
    'subtotal',
    'total',
    // Sensitive data removed for security
    // 'card_number',
    // 'expiry',
    // 'cvv'
];

$meta_data = [];
foreach ($post_metas as $meta) {
    if (in_array($meta['meta_key'], $fields_to_display)) {
        $meta_data[$meta['meta_key']] = $meta['meta_value'];
    }
}

// Get the customer billing information
$billing_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
$billing_email = $order->get_billing_email();
$billing_phone = $order->get_billing_phone();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            overflow: hidden;
        }

        .header {
            background-color: #0073aa;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }

        .header h1 {
            margin: 0;
            color: #ffffff;
            font-size: 24px;
        }

        .content {
            padding: 20px;
        }

        .section-title {
            font-size: 18px;
            color: #0073aa;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .info-table th,
        .info-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .info-table th {
            background-color: #f7f7f7;
        }

        .footer {
            background: #f1f1f1;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
        }

        .footer a {
            color: #0073aa;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>New Booking: #<?php echo esc_html($order_id); ?></h1>
        </div>

        <!-- Booking Details -->
        <div class="content">
            <h2 class="section-title">Booking Summary</h2>
            <table class="info-table">
                <tr>
                    <th>Label</th>
                    <th>Value</th>
                </tr>
                <tr>
                    <td>Vehicle</td>
                    <td><?php $items = $order->get_items(); // Fetch all items from the order
                        if (!empty($items)) {
                            $first_item = reset($items); // Get the first item from the array
                            echo esc_html($first_item->get_name()); // Display the product name
                        } else {
                            echo 'N/A'; // Fallback if no items are found
                        } ?></td>
                </tr>
                <tr>
                    <td>Pickup/Delivery</td>
                    <td><?php echo esc_html($meta_data['pickup_or_delivery'] ?? 'N/A'); ?></td>
                </tr>
                <tr>
                    <td>Oneway</td>
                    <td><?php echo esc_html($meta_data['oneway'] ?? 'N/A'); ?></td>
                </tr>
                <tr>
                    <td>Delivery Address</td>
                    <td><?php echo esc_html($meta_data['delivery_address'] ?? 'N/A'); ?></td>
                </tr>
                <tr>
                    <td>Return Address</td>
                    <td><?php echo esc_html($meta_data['return_address'] ?? 'N/A'); ?></td>
                </tr>
                <tr>
                    <td>Age Bracket</td>
                    <td><?php echo esc_html($meta_data['age_bracket'] ?? 'N/A'); ?></td>
                </tr>
            </table>

            <h2 class="section-title">Rental Period</h2>
            <table class="info-table">
                <tr>
                    <th>Label</th>
                    <th>Value</th>
                </tr>
                <tr>
                    <td>Start Date</td>
                    <td><?php echo esc_html($meta_data['start_date'] ?? 'N/A'); ?></td>
                </tr>
                <tr>
                    <td>End Date</td>
                    <td><?php echo esc_html($meta_data['end_date'] ?? 'N/A'); ?></td>
                </tr>
                <tr>
                    <td>Start Time</td>
                    <td><?php echo esc_html($meta_data['start_time'] ?? 'N/A'); ?></td>
                </tr>
                <tr>
                    <td>End Time</td>
                    <td><?php echo esc_html($meta_data['end_time'] ?? 'N/A'); ?></td>
                </tr>
                <tr>
                    <td>Days Booked</td>
                    <td><?php echo esc_html($meta_data['days_booked'] ?? 'N/A'); ?></td>
                </tr>
            </table>

            <h2 class="section-title">Extras</h2>
            <table class="info-table">
                <tr>
                    <th>Extras</th>
                    <td><?php echo esc_html($meta_data['extras'] ?? 'N/A'); ?></td>
                </tr>
            </table>

            <h2 class="section-title">Payment Details</h2>
            <table class="info-table">
                <tr>
                    <th>Tax & Fees</th>
                    <td><?php echo esc_html($meta_data['tax_fees'] ?? 'N/A'); ?></td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td><?php echo esc_html($meta_data['discount'] ?? 'N/A'); ?></td>
                </tr>
                <tr>
                    <td>Discount Type</td>
                    <td><?php echo esc_html($meta_data['discount_type'] ?? 'N/A'); ?></td>
                </tr>
                <tr>
                    <td>Subtotal</td>
                    <td><?php echo esc_html($meta_data['subtotal'] ?? 'N/A'); ?></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td><?php echo esc_html($meta_data['total'] ?? 'N/A'); ?></td>
                </tr>
            </table>

            <h2 class="section-title">Billing Information</h2>
            <table class="info-table">
                <tr>
                    <th>Name</th>
                    <td><?php echo esc_html($billing_name); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo esc_html($billing_email); ?></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><?php echo esc_html($billing_phone); ?></td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>If you have any questions about your booking, contact us at
                <a href="mailto:support@yourcompany.com">support@yourcompany.com</a>.
            </p>
            <p>Your Company © 2024</p>
        </div>
    </div>
</body>

</html>