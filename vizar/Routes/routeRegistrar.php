<?php

function register_routes(){

    register_rest_route( 'vizar', '/telepulesek', array(
        'methods' => 'GET',
        'callback' => array(new Vizar, 'getTelepules'),
    ));

    register_rest_route( 'vizar', '/agazatok', array(
        'methods' => 'GET',
        'callback' => 'vizar_params',
    ));
    
    register_rest_route( 'vizar', '/results', array(
        'methods' => 'POST',
        'callback' => array(new Vizar, 'getResults'),
    ));
    
}

function vizar_params(WP_REST_Request $request) {
    $gazarManager = new Vizar;
    $telepules = $request->get_param( 'telepules' );
    return $gazarManager->getAgazat($telepules);
}


add_action( 'rest_api_init', 'register_routes' );

