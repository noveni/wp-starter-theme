<?php
/**
 * WP Contact Form 7 - Hooks
 * 
 * Customization for adding to subscribe list
 */

 
// define the wpcf7_submit callback 
function ecrannoir_plugins_action_wpcf7_submit( $contact_form, $result ) { 
    if ( ! class_exists( 'WPCF7_Submission' ) ) {
        return;
    }
   
    if ( $contact_form->in_demo_mode() ) {
		return;
    }
    
    
    $cases = (array) apply_filters( 'wpcf7_flamingo_submit_if',
        array( 'spam', 'mail_sent', 'mail_failed' ) );
    
    if ( empty( $result['status'] )
    or ! in_array( $result['status'], $cases ) ) {
        return;
    }
    $a = 0;

    $submission = WPCF7_Submission::get_instance();

	if ( ! $submission
	or ! $posted_data = $submission->get_posted_data() ) {
		return;
	}

	if ( $submission->get_meta( 'do_not_store' ) ) {
		return;
	}
    
    $fields_senseless =
		$contact_form->scan_form_tags( array( 'feature' => 'do-not-store' ) );

	$exclude_names = array();

	foreach ( $fields_senseless as $tag ) {
		$exclude_names[] = $tag['name'];
	}

    $exclude_names[] = 'g-recaptcha-response';
    
    foreach ( $posted_data as $key => $value ) {
		if ( '_' == substr( $key, 0, 1 )
		or in_array( $key, $exclude_names ) ) {
			unset( $posted_data[$key] );
		}
    }
    
    $email = wpcf7_flamingo_get_value( 'email', $contact_form );
    $name = wpcf7_flamingo_get_value( 'name', $contact_form );
    $phone_number = ecrannoir_module_wpc7_get_value( 'phone', $posted_data );


    // Add the new contact to WP SMS
    $add_result = ecrannoir_module_wpcf7_suscribe_to_wpsms($name, $phone_number, $contact_form->title);
    // if ($add_result['result'] == 'success') {
    //     // go on
    // } else if ($add_result['result'] == 'error') {
    //     $b = $add_result;
    //     die();
    // }
}; 
// add the action 
add_action( 'wpcf7_submit', 'ecrannoir_plugins_action_wpcf7_submit', 10, 2 );


function ecrannoir_module_wpc7_get_value($field, $posted_data) {
    if ( empty( $field ) or empty( $posted_data ) ) {
		return false;
    }

    $value = '';

    $filtered_data = array_filter($posted_data, function($key) use ($field) {
        if (strpos($key, $field) !== false) {
            return true;
        }
        return false;

    }, ARRAY_FILTER_USE_KEY);

    if (!empty($filtered_data)) {
        $value = $posted_data[array_keys($filtered_data)[0]];
    }
    return $value;
    
}


/**
 * Adding a number to the subscriber list of WP SMS Plugin
 */
function ecrannoir_module_wpcf7_suscribe_to_wpsms($name, $phone, $group_name = 'FR') {

    if ( ! class_exists( '\WP_SMS\Newsletter' ) 
    or ! class_exists( 'WP_REST_Request' ) ) {
        return false;
    }
    $group_name = trim(strtoupper($group_name));

    // Retrieve the group
    function get_the_group($group_name) {
        $groups = \WP_SMS\Newsletter::getGroups();

        $the_group = array_filter($groups, function($group, $key) use ($group_name) {
            return trim(strtoupper($group->name)) == $group_name;
        }, ARRAY_FILTER_USE_BOTH);

        $the_group = array_shift($the_group);

        // If no group we create it
        if (empty($the_group)) {
            $addGroupResult = \WP_SMS\Newsletter::addGroup($group_name);
            if ($addGroupResult['result'] == 'success') {
                $the_group = get_the_group($group_name);
            } else {
                return false;
            }
        }
        return $the_group;
    }

    $the_group = get_the_group($group_name);



    $result = \WP_SMS\Newsletter::addSubscriber($name, $phone, $the_group->ID);
    $a = 0;


    return $result;
    /* // Test WP SMS API
    $request = new WP_REST_Request( 'GET', '/wp/v2/posts' );
    $request = new WP_REST_Request( 'POST', '/wpsms/v1/newsletter' );
    $request->set_query_params( [
        'mobile' => $phone,
        'name' => $name,
    ] );
    $response = rest_do_request( $request );
    $server = rest_get_server();
    $data = $server->response_to_data( $response, false );
    $json = wp_json_encode( $data ); */
}


/**
 * Verify Number already exist
 */
function ecrannoir_module_wpcf7_validation_phone($result, $tag) {
    if ( ! class_exists( '\WP_SMS\Newsletter' )) {
        return $result;
    }

    if (strpos($tag->name, 'contact_phone') !== false) {
        if (\WP_SMS\Newsletter::isDuplicate($_POST[$tag->name])) {
            $result->invalidate( $tag, __("The mobile numbers has been already duplicate.", 'ecrannoir') );
        }
    }
    return $result;
}
// add_filter( 'wpcf7_validate_tel*', 'ecrannoir_module_wpcf7_validation_phone', 20, 2 );

function ecrannoir_module_wpcf7_conditional_required($result, $tag) {
    if ( ! class_exists( 'WPCF7_Shortcode' )) {
        return $result;
    }

    $tag = new WPCF7_Shortcode( $tag );
    $name = $tag->name;
    $value = isset( $_POST[$name] ) ? trim( wp_unslash( strtr( (string) $_POST[$name], "\n", " " ) ) ) : '';

    $medium_choice = isset( $_POST['medium_choice'] ) ? strtolower($_POST['medium_choice']) : false;

    if (!$medium_choice) {
        return $result;
    }

    if (strpos($tag->name, 'contact_phone') !== false && $medium_choice == 'sms') {
        if ( '' == $value  ) {
            $result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
        } else {
            $result = ecrannoir_module_wpcf7_validation_phone($result, $tag);
        }
    }
    
    if (strpos($tag->name, 'contact_email') !== false && $medium_choice == 'email') {
        if ( '' == $value  ) {
            $result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
        } elseif ( ! wpcf7_is_email( $value ) ) {
            $result->invalidate( $tag, wpcf7_get_message( 'invalid_email' ) );
        }

    }
   
    return $result;
}
add_filter( 'wpcf7_validate_tel', 'ecrannoir_module_wpcf7_conditional_required', 20, 2 );
add_filter( 'wpcf7_validate_tel*', 'ecrannoir_module_wpcf7_conditional_required', 20, 2 );
add_filter( 'wpcf7_validate_email', 'ecrannoir_module_wpcf7_conditional_required', 20, 2 );
add_filter( 'wpcf7_validate_email*', 'ecrannoir_module_wpcf7_conditional_required', 20, 2 );

// define the wpcf7_validate callback 
function ecrannoir_module_filter_wpcf7_validate( $result, $tags ) { 
    // make filter magic happen here... 
    return $result;
}; 
         
// add the filter 
// add_filter( 'wpcf7_validate', 'ecrannoir_module_filter_wpcf7_validate', 10, 2 ); 
// // define the wpcf7_validate_configuration callback 
// function ecrannoir_module_filter_wpcf7_validate_configuration( $wpcf7_validate_configuration ) { 
//     // make filter magic happen here... 
//     return $wpcf7_validate_configuration; 
// }; 
         
// // add the filter 
// add_filter( 'wpcf7_validate_configuration', 'ecrannoir_module_filter_wpcf7_validate_configuration', 10, 1 ); 
