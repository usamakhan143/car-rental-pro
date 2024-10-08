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
