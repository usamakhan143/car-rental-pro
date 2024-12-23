<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Remove the order details section for both admin and customer emails
add_action('woocommerce_email_order_details', 'remove_woocommerce_order_details', 1, 4);

function remove_woocommerce_order_details($order, $sent_to_admin, $plain_text, $email)
{
    remove_action('woocommerce_email_order_details', array(WC()->mailer(), 'order_details'), 10, 4);
    remove_action('woocommerce_email_order_details', array(WC()->mailer(), 'order_totals'), 20, 3);
}

add_filter('woocommerce_email_enabled_new_order', '__return_false');
add_filter('woocommerce_email_classes', 'add_admin_product_purchase_email_class');

function add_admin_product_purchase_email_class($email_classes)
{
    class WC_Admin_Product_Purchase_Email extends WC_Email
    {
        public function __construct()
        {
            $this->id          = 'admin_product_purchase_email';
            $this->title       = __('Admin Booking Purchase Notification', 'text-domain');
            $this->description = __('An email sent to admin when a booking is processed.', 'text-domain');
            $this->heading     = __('New Booking Purchased', 'text-domain');
            $this->subject     = __('New Booking on {site_title}', 'text-domain');

            // Define email templates.
            $this->template_html  = CARRENTAL_PLUGIN_PATH . 'templates/emails/admin-product-purchase.php';
            $this->template_plain = CARRENTAL_PLUGIN_PATH . 'templates/emails/plain/admin-product-purchase.php';

            // Set recipient as admin email.
            $this->recipient = get_option('admin_email');

            parent::__construct();
        }

        public function trigger($order_id)
        {
            if (! $order_id) return;

            $this->object = wc_get_order($order_id);

            if (! $this->is_enabled() || ! $this->get_recipient()) return;

            $this->send($this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments());
        }

        public function get_content_html()
        {
            global $wpdb;

            $order_id = $this->object->get_id();

            // Fetch order meta data
            $post_metas = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM {$wpdb->prefix}wc_orders_meta WHERE order_id = %d", $order_id),
                ARRAY_A
            );

            // Define keys to display
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
                'card_number',
                'expiry',
                'cvv'
            ];

            $meta_data = [];
            foreach ($post_metas as $meta) {
                if (in_array($meta['meta_key'], $fields_to_display)) {
                    $meta_data[$meta['meta_key']] = $meta['meta_value'];
                }
            }

            return wc_get_template_html(
                'admin-product-purchase.php', // Only the file name, relative to the provided base path
                array(
                    'order'         => $this->object,
                    'email_heading' => $this->get_heading(),
                    'sent_to_admin' => true,
                    'plain_text'    => false,
                    'email'         => $this,
                ),
                '', // Leave this empty to bypass theme paths
                CARRENTAL_PLUGIN_PATH . 'templates/emails/' // Your plugin's template directory
            );
        }

        public function get_content_plain()
        {
            return wc_get_template_html(
                $this->template_plain,
                array(
                    'order'         => $this->object,
                    'email_heading' => $this->get_heading(),
                    'sent_to_admin' => true,
                    'plain_text'    => true,
                    'email'         => $this,
                ),
                '', // Leave this empty to prevent WooCommerce from looking in the theme directory
                CARRENTAL_PLUGIN_PATH . 'templates/emails/plain/' // Full path to your plugin's email 
            );
        }
    }

    $email_classes['WC_Admin_Product_Purchase_Email'] = new WC_Admin_Product_Purchase_Email();
    return $email_classes;
}

add_action('woocommerce_order_status_processing', 'send_admin_product_purchase_email', 10, 1);

function send_admin_product_purchase_email($order_id)
{
    $mailer = WC()->mailer();
    $emails = $mailer->get_emails();

    if (! empty($emails['WC_Admin_Product_Purchase_Email'])) {
        $emails['WC_Admin_Product_Purchase_Email']->trigger($order_id);
    }
}
