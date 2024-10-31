<?php

add_shortcode('booking_form_style_1', 'showBookingForm');
add_shortcode('checkout_page', 'showCheckout');

// Enqueue custom jQuery library in the footer
add_action('wp_enqueue_scripts', 'carRentalProBeforeBodyClosingScripts');
add_action('wp_enqueue_scripts', 'checkoutPageCssJs');

add_action('wp_enqueue_scripts', 'enqueue_carRentalPro_styles', 20);

function showBookingForm()
{
    if (!is_product()) {
        // Show a message if it's not a product page
        return '<div class="booking-form-warning">This booking form is only available for single product page.</div>';
    }
    // Ensure constants are defined
    if (!defined('CARRENTAL_PLUGIN_URL') || !defined('CARRENTAL_PLUGIN_PATH')) {
        return '<div>Configuration error: Plugin constants not defined.</div>';
    }

    // Enqueue Styles
    wp_enqueue_style(
        'car-rental-pro-bootstrap5',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css',
        array(),
        '5.0.2'
    );

    wp_enqueue_style(
        'car-rental-pro-bookingFormStyle1',
        CARRENTAL_PLUGIN_URL . 'includes/assets/css/forms/booking-forms/booking-form-style1.css',
        array(),
        '1.0.0'
    );

    wp_enqueue_style(
        'car-rental-pro-customDatePicker',
        CARRENTAL_PLUGIN_URL . 'includes/assets/css/custom-date-picker/style1.css',
        array(),
        '1.0.0'
    );

    // Enqueue Scripts
    wp_enqueue_script(
        'car-rental-pro-calendar-elements',
        CARRENTAL_PLUGIN_URL . 'includes/assets/js/custom-date-picker/calendar-elements.js',
        array(),
        '1.0.0',
        true
    );

    // Prepare dynamic PHP data
    // Get the dynamic product price
    $product = wc_get_product(get_the_ID());
    $regular_price = $product->get_regular_price();
    $sale_price = $product->get_sale_price(); // Sale price (if on sale)
    // Get WooCommerce currency symbol
    $currency_symbol = get_woocommerce_currency_symbol();
    // Unavailable dates
    $dates_NA = get_plugin_options_crp('unavailable_dates');

    // Weekly Discount Value
    $is_weekly_discount_active = get_plugin_options_crp('is_weekly_discount_active');
    $weekly_discount_percentage = get_plugin_options_crp('weekly_discount_percentage');

    // Default to 0 if the checkbox is not active or the percentage is not set
    if ($is_weekly_discount_active && isset($weekly_discount_percentage) && is_numeric($weekly_discount_percentage)) {
        $weeklyDis = (float)$weekly_discount_percentage; // Cast to float
    } else {
        $weeklyDis = 0; // Default value if checkbox is unchecked
    }

    // Monthly Discount Value
    $is_monthly_discount_active = get_plugin_options_crp('is_monthly_discount_active');
    $monthly_discount_percentage = get_plugin_options_crp('monthly_discount_percentage');

    // Default to 0 if the checkbox is not active or the percentage is not set
    if ($is_monthly_discount_active && isset($monthly_discount_percentage) && is_numeric($monthly_discount_percentage)) {
        $monthlyDis = (float)$monthly_discount_percentage; // Cast to float
    } else {
        $monthlyDis = 0; // Default value if checkbox is unchecked
    }

    // Tax rate Value
    $is_taxesandfees_active = get_plugin_options_crp('is_taxandfees_active');
    $taxandfeesPercentage = get_plugin_options_crp('taxandfees_percentage');

    // Default to 0 if the checkbox is not active or the percentage is not set
    if ($is_taxesandfees_active && isset($taxandfeesPercentage) && is_numeric($taxandfeesPercentage)) {
        $taxrates = (float)$taxandfeesPercentage; // Cast to float
    } else {
        $taxrates = 0; // Default value if checkbox is unchecked
    }

    $pricing_data = array(
        'regularPrice'      => $regular_price,
        'salePrice'        => $sale_price,
        'taxRate'          => $taxrates,
        'weeklyDiscount'   => $weeklyDis / 100,
        'monthlyDiscount'  => $monthlyDis / 100,
        'currency'         => get_woocommerce_currency(), // Example of dynamic data
        'currencySymbol'   => $currency_symbol,
        'userLoggedIn'     => is_user_logged_in(),
        'dates_na'         => $dates_NA,
        'vehcileId'        => get_the_ID()
        // Add more dynamic data as needed
    );

    // Localize script with pricing data
    wp_localize_script(
        'car-rental-pro-calendar-elements', // The script handle you're attaching the data to
        'CarRentalProData',                // The name of the JavaScript object
        $pricing_data                      // The data to pass
    );

    wp_enqueue_script(
        'car-rental-pro-custom-date-picker',
        CARRENTAL_PLUGIN_URL . 'includes/assets/js/custom-date-picker/custom-date-picker.js',
        array('car-rental-pro-calendar-elements'),
        '1.0.0',
        true
    );

    wp_enqueue_script(
        'car-rental-pro-calculate-pricing',
        CARRENTAL_PLUGIN_URL . 'includes/assets/js/custom-date-picker/calculate-pricing.js',
        array('car-rental-pro-custom-date-picker'),
        '1.0.0',
        true
    );

    // enqueue Booking form scripts
    wp_enqueue_script(
        'car-rental-pro-booking-form-script',
        CARRENTAL_PLUGIN_URL . 'includes/assets/js/booking-form/booking-form.js',
        array('car-rental-pro-custom-date-picker'),
        '1.0.0',
        true
    );

    // Output the booking form template
    ob_start(); // Start output buffering
    include CARRENTAL_PLUGIN_PATH . '/includes/templates/forms/booking-form-styles/booking-form-style1.php';
    return ob_get_clean(); // Return the buffered content
}





function enqueue_carRentalPro_styles()
{
    // Check if the current page or post contains your plugin's shortcode
    if ((has_shortcode(get_the_content(), 'booking_form_style_1'))) {

        // Register your plugin's styles
        $bootstrap5 = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css";
        $formsGlobalCss = CARRENTAL_PLUGIN_URL . 'includes/assets/css/forms/style.css';
        $bookingFormStyle1 = CARRENTAL_PLUGIN_URL . 'includes/assets/css/forms/booking-forms/booking-form-style1.css';
        $customDatePicker = CARRENTAL_PLUGIN_URL . 'includes/assets/css/custom-date-picker/style1.css';

        wp_register_style('car-rental-pro-bootstrap5', $bootstrap5, array(), '1.0.0');
        wp_register_style('car-rental-pro-bookingFormStyle1', $bookingFormStyle1, array(), '1.0.0');
        wp_register_style('car-rental-pro-customDatePicker', $customDatePicker, array(), '1.0.0');
        wp_register_style('car-rental-pro-formsGlobalCss', $formsGlobalCss, array(), '1.0.0');


        // Enqueue your plugin's styles
        wp_enqueue_style('car-rental-pro-bootstrap5');
        wp_enqueue_style('car-rental-pro-bookingFormStyle1');
        wp_enqueue_style('car-rental-pro-customDatePicker');
        wp_enqueue_style('car-rental-pro-formsGlobalCss');
    }
}

function carRentalProBeforeBodyClosingScripts()
{
    // Define the path to your custom jQuery library
    wp_enqueue_script(
        'car-rental-pro-jquery', // Handle name for your script
        CARRENTAL_PLUGIN_URL . 'node_modules/jquery/dist/jquery.min.js', // Path to your custom jQuery file
        array(), // Dependencies, leave empty if none
        '1.0.0', // Version number, update as needed
        true // Load in the footer
    );

    // Optionally enqueue utilities scripts
    wp_enqueue_script(
        'car-rental-pro-utilities-scripts',
        CARRENTAL_PLUGIN_URL . 'includes/assets/js/utilities.js',
        array(), // Empty if there are no dependencies
        '1.0.0',
        true // Load in the footer
    );
}

add_action('woocommerce_single_product_summary', 'display_custom_dates_on_product_page', 25);

function display_custom_dates_on_product_page()
{
    global $post;

    // Retrieve the repeater field from Carbon Fields
    $dates = carbon_get_post_meta($post->ID, 'unavailable_dates');

    // Debugging: Check if the data is being retrieved
    echo '<pre>';
    print_r($dates); // This will output the raw data to check if it's being retrieved
    echo '</pre>';
}


function showCheckout()
{
    include CARRENTAL_PLUGIN_PATH . '/includes/templates/checkout/checkout.php';
}

function checkoutPageCssJs()
{
    // Check if we are on a single page
    if (is_page()) {
        // Get the current page slug
        $slug = get_post_field('post_name', get_queried_object_id());

        // Check if the slug matches 'abc'
        if ($slug == 'vehicle-booking') {

            wp_enqueue_style(
                'car-rental-pro-checkout-bootstrap',
                CARRENTAL_PLUGIN_URL . 'node_modules/bootstrap/dist/css/bootstrap.min.css',
                array(),
                '1.0.0'
            );

            wp_enqueue_style(
                'car-rental-pro-checkout-fontawesome',
                CARRENTAL_PLUGIN_URL . 'node_modules/@fortawesome/fontawesome-free/css/all.min.css',
                array(),
                '1.0.0'
            );

            wp_enqueue_style(
                'car-rental-pro-checkout-css',
                CARRENTAL_PLUGIN_URL . 'includes/assets/css/checkout/checkout.css',
                array('car-rental-pro-checkout-bootstrap'),
                '1.0.0'
            );

            wp_enqueue_script(
                'car-rental-pro-checkout-page-script',
                CARRENTAL_PLUGIN_URL . 'includes/assets/js/checkout/checkout.js',
                array(),
                '1.0.0',
                true
            );

            wp_enqueue_script(
                'car-rental-pro-checkout-page-bootsrap-script',
                CARRENTAL_PLUGIN_URL . 'node_modules/bootstrap/dist/js/bootstrap.min.js',
                array('car-rental-pro-checkout-css'),
                '1.0.0',
                true
            );
        }
    }
}
