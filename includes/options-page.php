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
                ->set_attribute('type', 'number') // Set the input type to number


        ));
}


add_action('carbon_fields_register_fields', 'product_attach_custom_fields');
function product_attach_custom_fields()
{

    // If product type is 'simple', add custom fields
    Container::make('post_meta', __('Vehicle Availibility'))
        ->where('post_type', '=', 'product')
        ->add_fields(array(
            Field::make('complex', 'unavailable_dates', 'Unavailable Dates')
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                    Field::make('date', 'custom_date_field', __('Select a Date'))
                        ->set_storage_format('Y-m-d') // Format for storing in the database (ISO format)
                )),
        ));
}
