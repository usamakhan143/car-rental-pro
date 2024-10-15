<?php

/**
 * Plugin Name: Car Rental Pro
 * Description: This plugin is used for car rental booking websites.
 * Author: Usama Khan
 * Author URI: https://github.com/usamakhan143
 * Version: 1.0.1
 * Requires PHP: 7.4
 * Text Domain: carrental-plugin-translate
 */

// Register activation hook
register_activation_hook(__FILE__, 'custom_plugin_activation');

function custom_plugin_activation()
{
    // Check if WooCommerce is active
    if (!is_plugin_active('woocommerce/woocommerce.php')) {
        // WooCommerce is not active
        deactivate_plugins(plugin_basename(__FILE__)); // Deactivate your plugin
        wp_die('This plugin requires WooCommerce to be installed and activated.');
    }

    $checkout_page = get_page_by_path('make-payment');
    if (!$checkout_page) {
        $checkout_page_id = wp_insert_post(array(
            'post_title'   => 'Vehicle Booking',
            'post_content' => '[checkout_page]',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_name'    => 'vehicle-booking', // This sets the page slug
        ));

        if ($checkout_page_id) {
            // Page creation successful
            error_log('checkout page created with its ID. checkout ID:' . $checkout_page_id);
        } else {
            // Page creation failed
            error_log('Failed to create Checkout page');
        }
    } else {
        // Page already exists
        error_log('checkout page already exists');
    }
}

function disable_woocommerce_deactivate_button()
{
    // Check if WooCommerce is active and the custom addon is not active
    if (is_plugin_active('woocommerce/woocommerce.php') && !is_plugin_active(__FILE__)) {
?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                // Disable the WooCommerce Deactivate button
                var wc_deactivate_button = $('#the-list tr[data-slug="woocommerce"] .deactivate a');
                wc_deactivate_button.addClass('disabled').attr('href', 'javascript:void(0);').css('pointer-events', 'none').css('opacity', '0.5');

                // Optionally add a tooltip message
                wc_deactivate_button.attr('title', 'You cannot deactivate WooCommerce until the custom addon is active.');
            });
        </script>
<?php
    }
}
add_action('admin_print_footer_scripts', 'disable_woocommerce_deactivate_button');

// Plugin deactivation hook
register_deactivation_hook(__FILE__, 'car_rental_pro_deactivate');
function car_rental_pro_deactivate()
{
    // Check if the "Checkout" page exists
    $checkout_page = get_page_by_path('vehicle-booking');

    // If the page exists, delete it
    if ($checkout_page) {
        $deletedCheckout = wp_delete_post($checkout_page->ID, true);

        if ($deletedCheckout) {
            // Page deletion successful
            error_log('Car rental pro checkout page deleted');
        } else {
            // Page deletion failed
            error_log('Failed to delete Car rental pro Checkout page');
        }
    }
}

if (!defined('ABSPATH')) {
    exit;
}


if (!class_exists('CarrentalPro')) {


    class CarrentalPro
    {

        function __construct()
        {
            define('CARRENTAL_PLUGIN_URL', plugin_dir_url(__FILE__));
            define('CARRENTAL_PLUGIN_PATH', plugin_dir_path(__FILE__));
            require_once(CARRENTAL_PLUGIN_PATH . '/vendor/autoload.php');
        }

        function initialize()
        {
            include_once(CARRENTAL_PLUGIN_PATH . 'includes/utilities.php');
            include_once(CARRENTAL_PLUGIN_PATH . 'includes/car-rental-pro.php');
            include_once(CARRENTAL_PLUGIN_PATH . 'includes/options-page.php');
        }
    }
}


$CarrentalPro = new CarrentalPro();
$CarrentalPro->initialize();


add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'ap_add_plugin_page_settings_link');
function ap_add_plugin_page_settings_link($links)
{
    $links[] = '<a href="' .
        admin_url('tools.php?page=crb_carbon_fields_container_car_rental_pro.php') .
        '">' . __('Settings') . '</a>';
    return $links;
}
