<?php

add_shortcode('booking_form_style_1', 'showBookingForm');
add_action('wp_footer', 'carRentalProBeforeBodyClosingScripts', 9999);
add_action('wp_enqueue_scripts', 'enqueue_carRentalPro_styles', 100);

function showBookingForm()
{
    include CARRENTAL_PLUGIN_PATH . '/includes/templates/forms/booking-form-styles/booking-form-style1.php';
}

function enqueue_carRentalPro_styles()
{
    // Check if the current page or post contains your plugin's shortcode
    if (is_page() || is_single()) {
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
}

function carRentalProBeforeBodyClosingScripts()
{
    if (is_page() && (has_shortcode(get_the_content(), 'booking_form_style_1'))) {
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
