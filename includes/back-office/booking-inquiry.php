<?php
// All the booking details of every car will be visible in Woocommerce Order section.

add_action('admin_enqueue_scripts', 'enqueue_custom_admin_styles');
add_action('add_meta_boxes', 'add_booking_details_metabox');

function add_booking_details_metabox()
{
    global $posttype;
    // Check if we are on the WooCommerce order edit page
    if (isset($_GET['page']) && $_GET['page'] === 'wc-orders') {
        add_meta_box(
            'booking_details_metabox', // ID of the metabox
            'Booking Details', // Title of the metabox
            'display_api_order_meta_data', // Callback function to display the content
            $posttype,
            'side'
        );
    }
}

function display_api_order_meta_data($post)
{
    // Retrieve the order ID from the post object
    $order_id = $post->ID;
    global $wpdb;

    // Fetch order meta data from wp_wc_orders_meta
    $post_metas = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM {$wpdb->prefix}wc_orders_meta WHERE order_id = %d", $order_id)
    );

    // Define the specific fields you want to display
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
        'tax_fees',
        'discount',
        'discount_type',
        'subtotal',
        'total',
        'card_number',
        'expiry',
        'cvv'
    ];

    echo '<div class="custom-api-order-meta-box" style="margin-top: 20px;">';
    echo '<table style="width:100%; border-collapse: collapse;">';

    // Initialize a variable to check if any fields are displayed
    $fields_found = false;

    // Loop through and display only the specified fields
    foreach ($fields_to_display as $field) {
        // Check if the field exists in the post metas
        foreach ($post_metas as $meta) {
            if ($meta->meta_key === $field) {
                echo '<tr>';
                echo '<th style="padding: 8px; border: 1px solid #ddd;">' . esc_html(ucwords(str_replace('_', ' ', $field))) . ':</th>';
                echo '<td style="padding: 8px; border: 1px solid #ddd;">' . esc_html($meta->meta_value) . '</td>';
                echo '</tr>';
                $fields_found = true; // Mark that at least one field was displayed
                break; // Exit the inner loop since the field was found
            }
        }
    }

    // If no fields were found, display a message
    if (!$fields_found) {
        echo '<tr><td colspan="2" style="padding: 8px; border: 1px solid #ddd;">No Data found.</td></tr>';
    }

    echo '</table>';
    echo '</div>';
}

function enqueue_custom_admin_styles()
{
    // Enqueue custom styles for the WooCommerce admin order section
    echo '<style>
        .woocommerce-order-meta {
            margin: 20px 0;
        }
        .woocommerce-order-meta table {
            width: 100%;
            border-collapse: collapse;
        }
        .woocommerce-order-meta th {
            text-align: left !important;
            background-color: #f9f9f9;
            padding: 10px 10px 10px 18px !important;
        }
        .woocommerce-order-meta td {
            padding: 10px;
            border: 1px solid #eaeaea;
        }
    </style>';
}
