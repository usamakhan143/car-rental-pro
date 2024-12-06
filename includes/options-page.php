<?php

use Carbon_Fields\Field;
use Carbon_Fields\Container;

add_action('after_setup_theme', 'load_carbon_fields_crp');
add_action('carbon_fields_register_fields', 'create_options_page_crp');



function load_carbon_fields_crp()
{
    \Carbon_Fields\Carbon_Fields::boot();
}

function create_options_page_crp()
{

    Container::make('theme_options', __('Car Rental Pro'))
        ->set_page_parent('tools.php')
        ->set_icon('dashicons-carrot')
        ->set_page_menu_position(30)
        ->add_fields(array(

            Field::make('checkbox', 'carrental_pro_plugin_active', __('Active')),

            Field::make('checkbox', 'is_weekly_discount_active', __('Enable Weekly Discount')),
            Field::make('text', 'weekly_discount_percentage', 'Weekly Discount:')
                ->set_conditional_logic(array(
                    array(
                        'field' => 'is_weekly_discount_active',
                        'value' => true,
                    )
                ))
                ->set_attribute('placeholder', 'Enter discount in percentage.')
                ->set_attribute('type', 'number'), // Set the input type to number

            Field::make('checkbox', 'is_monthly_discount_active', __('Enable Monthly Discount')),
            Field::make('text', 'monthly_discount_percentage', 'Monthly Discount:')
                ->set_conditional_logic(array(
                    array(
                        'field' => 'is_monthly_discount_active',
                        'value' => true,
                    )
                ))
                ->set_attribute('placeholder', 'Enter discount in percentage.')
                ->set_attribute('type', 'number'), // Set the input type to number

            Field::make('checkbox', 'is_taxandfees_active', __('Enable Taxes & Fees')),
            Field::make('text', 'taxandfees_percentage', 'Tax & Fees:')
                ->set_conditional_logic(array(
                    array(
                        'field' => 'is_taxandfees_active',
                        'value' => true,
                    )
                ))
                ->set_attribute('placeholder', 'Enter value in percentage.')
                ->set_attribute('type', 'number'), // Set the input type to number



            Field::make('checkbox', 'is_additionalfees_active', __('Enable Additional Fees')),
            Field::make('text', 'additionalfees_percentage', 'Additional Fees:')
                ->set_conditional_logic(array(
                    array(
                        'field' => 'is_additionalfees_active',
                        'value' => true,
                    )
                ))
                ->set_attribute('placeholder', 'Enter value in percentage.')
                ->set_attribute('type', 'number'), // Set the input type to number

            Field::make('checkbox', 'is_fulldaybooking_active', __('Set full day booking'))->help_text('Choose whether the booking will be active or not for the full day (Example: for a booking from day 1 to day 2, day 2 will be fully booked only if this option is active)'),

            // Terms and Condition or Privacy Policy Link
            Field::make('checkbox', 'is_termspolicy_active', __('Enable Acceptance')),
            Field::make('radio', 'acceptance_text_selector', __('Choose text to show on checkout page'))
                ->set_conditional_logic(array(
                    array(
                        'field' => 'is_termspolicy_active',
                        'value' => true,
                    )
                ))
                ->set_options(array(
                    'Terms and Conditions' => 'Terms and Conditions',
                    'Privacy Policy' => 'Privacy Policy',
                )),

            Field::make('text', 'terms_policy', 'Terms & Condition OR Privacy Policy Link')->set_width(50)
                ->set_conditional_logic(array(
                    array(
                        'field' => 'is_termspolicy_active',
                        'value' => true,
                    )
                ))
                ->set_attribute('placeholder', 'Enter URL here.'),

            Field::make('html', 'woocommerce_integration_heading')
                ->set_html('<h1>Woocommerce Integration</h1>'),
            Field::make('text', 'woo_consumer_key', 'Consumer Key')->set_width(50)->set_required(true)
                ->set_attribute('placeholder', 'Enter key here.'),
            Field::make('text', 'woo_consumer_secret', 'Consumer Secret')->set_width(50)->set_required(true)
                ->set_attribute('placeholder', 'Enter key here.')->set_attribute('type', 'password'),
        ));
}


// add_action('carbon_fields_register_fields', 'product_attach_custom_fields');
// function product_attach_custom_fields()
// {

//     // If product type is 'simple', add custom fields
//     Container::make('post_meta', __('Vehicle Availibility'))
//         ->where('post_type', '=', 'product')
//         ->add_fields(array(
//             Field::make('complex', 'unavailable_dates', 'Unavailable Dates')
//                 ->set_layout('tabbed-horizontal')
//                 ->add_fields(array(
//                     Field::make('date', 'custom_date_field', __('Select a Date'))
//                         ->set_storage_format('Y-m-d') // Format for storing in the database (ISO format)
//                 )),
//         ));
// }
