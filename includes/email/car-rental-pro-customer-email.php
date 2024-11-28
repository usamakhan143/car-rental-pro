<?php

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_filter('woocommerce_email_classes', 'add_customer_product_purchase_email_class');

function add_customer_product_purchase_email_class($email_classes)
{
    class WC_Customer_Product_Purchase_Email extends WC_Email
    {
        public function __construct()
        {
            $this->id          = 'customer_product_purchase_email';
            $this->title       = __('Customer Booking Confirmation', 'text-domain');
            $this->description = __('An email sent to customers after a booking is processed.', 'text-domain');
            $this->heading     = __('Your Booking Confirmation', 'text-domain');
            $this->subject     = __('Thank you for your booking on {site_title}', 'text-domain');

            // Define email templates
            $this->template_html  = CARRENTAL_PLUGIN_PATH . 'templates/emails/customer-product-purchase.php';
            $this->template_plain = CARRENTAL_PLUGIN_PATH . 'templates/emails/plain/customer-product-purchase.php';

            // Set recipient as the customer's email
            $this->recipient = '';

            parent::__construct();
        }

        public function trigger($order_id)
        {
            if (! $order_id) return;

            $this->object = wc_get_order($order_id);
            $this->recipient = $this->object->get_billing_email();

            if (! $this->is_enabled() || ! $this->get_recipient()) return;

            $this->send($this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments());
        }

        public function get_content_html()
        {
            return wc_get_template_html(
                'customer-product-purchase.php', // Customer-specific template
                array(
                    'order'         => $this->object,
                    'email_heading' => $this->get_heading(),
                    'sent_to_admin' => false,
                    'plain_text'    => false,
                    'email'         => $this,
                ),
                '', // Leave this empty to bypass theme paths
                CARRENTAL_PLUGIN_PATH . 'templates/emails/' // Plugin's email templates directory
            );
        }

        public function get_content_plain()
        {
            return wc_get_template_html(
                'plain/customer-product-purchase.php', // Customer-specific plain text template
                array(
                    'order'         => $this->object,
                    'email_heading' => $this->get_heading(),
                    'sent_to_admin' => false,
                    'plain_text'    => true,
                    'email'         => $this,
                ),
                '', // Leave this empty to bypass theme paths
                CARRENTAL_PLUGIN_PATH . 'templates/emails/' // Plugin's email templates directory
            );
        }
    }

    $email_classes['WC_Customer_Product_Purchase_Email'] = new WC_Customer_Product_Purchase_Email();
    return $email_classes;
}

add_action('woocommerce_order_status_processing', 'send_customer_product_purchase_email', 10, 1);

function send_customer_product_purchase_email($order_id)
{
    $mailer = WC()->mailer();
    $emails = $mailer->get_emails();

    if (! empty($emails['WC_Customer_Product_Purchase_Email'])) {
        $emails['WC_Customer_Product_Purchase_Email']->trigger($order_id);
    }
}
