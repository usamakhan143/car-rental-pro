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

        ));
}
