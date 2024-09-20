<?php

add_shortcode('booking_form_style_1', 'showBookingForm');
add_action('wp_footer', 'carRentalProBeforeBodyClosingScripts', 9999);
add_action('wp_enqueue_scripts', 'enqueue_carRentalPro_styles', 20);

function showBookingForm()
{
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
    $pricing_data = array(
        'pricePerDay'      => $regular_price,
        'salePrice'        => $sale_price,
        'taxRate'          => 9,
        'weeklyDiscount'   => 0.15,
        'monthlyDiscount'  => 0.3,
        'currency'         => get_woocommerce_currency(), // Example of dynamic data
        'userLoggedIn'     => is_user_logged_in(),
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

    // Optionally enqueue additional scripts
    // wp_enqueue_script(
    //     'car-rental-pro-additional-scripts',
    //     CARRENTAL_PLUGIN_URL . 'includes/assets/js/custom-date-picker/additional-scripts.js',
    //     array('car-rental-pro-calculate-pricing'),
    //     '1.0.0',
    //     true
    // );

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
        $bookingFormStyle1 = CARRENTAL_PLUGIN_URL . 'includes/assets/css/forms/booking-forms/booking-form-style1.css';
        $customDatePicker = CARRENTAL_PLUGIN_URL . 'includes/assets/css/custom-date-picker/style1.css';

        wp_register_style('car-rental-pro-bootstrap5', $bootstrap5, array(), '1.0.0');
        wp_register_style('car-rental-pro-bookingFormStyle1', $bookingFormStyle1, array(), '1.0.0');
        wp_register_style('car-rental-pro-customDatePicker', $customDatePicker, array(), '1.0.0');


        // Enqueue your plugin's styles
        wp_enqueue_style('car-rental-pro-bootstrap5');
        wp_enqueue_style('car-rental-pro-bookingFormStyle1');
        wp_enqueue_style('car-rental-pro-customDatePicker');
    }
}

function carRentalProBeforeBodyClosingScripts()
{
    if ((is_page() || is_single() || is_product() || is_singular()) && (has_shortcode(get_the_content(), 'booking_form_style_1'))) {
?>
        <script src="<?php echo CARRENTAL_PLUGIN_URL . 'includes/assets/js/custom-date-picker/calendar-elements.js'; ?>"> </script>
        <script>
            // Pricing Variables
            const pricePerDay = 450; // Base price per day
            const taxRate = 9; // Fixed taxes and fees percentage
            const weeklyDiscount = 0.15; // 15% weekly discount for 7+ days
            const monthlyDiscount = 0.3; // 30% monthly discount for 30+ days
        </script>
        <script src="<?php echo CARRENTAL_PLUGIN_URL . 'includes/assets/js/custom-date-picker/custom-date-picker.js'; ?>"> </script>
        <script src="<?php echo CARRENTAL_PLUGIN_URL . 'includes/assets/js/custom-date-picker/calculate-pricing.js'; ?>"></script>

        <script>
            // code here...
        </script>
<?php
    }
}
