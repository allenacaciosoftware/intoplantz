<?php


	if(current_user_can( 'manage_options' )  && isset($_POST['option']) )
	{
		switch(sanitize_text_field($_POST['option']))
		{
			case "mo2f_trial_request_form":
				mo2f_handle_trial_request_form($_POST); break;
		}
	}
	global $mo2f_dirName;
	$current_user = wp_get_current_user();
	$email = isset($current_user->user_email)?$current_user->user_email:null;
	$url = get_site_url();
	$user_phone = $Mo2fdbQueries->get_user_detail( 'mo2f_user_phone', $current_user->ID );


    echo '<link rel="stylesheet" type="text/css" href="' . plugins_url( 'includes/css/style_settings.css', dirname(__FILE__)) . '" />';
	include $mo2f_dirName . 'views'.DIRECTORY_SEPARATOR.'trial.php';

	function mo2f_handle_trial_request_form($post){
		$nonce 	 	= isset($post['nonce'])?sanitize_text_field($post['nonce']):NULL;
		if ( ! wp_verify_nonce( $nonce, 'mo2f_trial-nonce' ) ){
	   			return;
        }

		$email   	= isset($post['mo2f_trial_email'])? $post['mo2f_trial_email'] : NULL;
		$phone   	= isset($post['mo2f_trial_phone'])? $post['mo2f_trial_phone'] : ( $user_phone ? $user_phone : NULL );
		$trial_plan  = isset($post['mo2f_trial_plan'])? $post['mo2f_trial_plan']: NULL;

        if(get_site_option('mo2f_trial_query_sent')){
            do_action('wpns_show_message',MoWpnsMessages::showMessage('TRIAL_REQUEST_ALREADY_SENT'),'ERROR');
            return;
        }

		if(empty($email) || empty($phone)   || empty($trial_plan))
		{
			do_action('wpns_show_message',MoWpnsMessages::showMessage('REQUIRED_FIELDS'),'ERROR');
			return;
		}
		if(!preg_match("/^[\+][0-9]{1,4}\s?[0-9]{7,12}$/", $phone)){
		    do_action('wpns_show_message',MoWpnsMessages::showMessage('INVALID_PHONE'),'ERROR');
            return;
		}
		else{
			$email = filter_var( $email,FILTER_VALIDATE_EMAIL );
			$phone = preg_replace('/[^0-9]/', '', $phone);
			$trial_plan = sanitize_text_field($trial_plan);
			$query = 'REQUEST FOR TRIAL';
			$query .= ' [ Plan Name => ';
			$query .= $trial_plan;
			$query .= ' | Email => ';
			$query .= get_option('mo2f_email').' ]';
			$current_user = wp_get_current_user();


            $url          = MoWpnsConstants::HOST_NAME . "/moas/rest/customer/contact-us";
            global $mowafutility;
            $query = '[WordPress 2 Factor Authentication Plugin: OV3 - '.MO2F_VERSION.']: ' . $query;

            $fields = array(
                        'firstName' => $current_user->user_firstname,
                        'lastName'  => $current_user->user_lastname,
                        'company'   => $_SERVER['SERVER_NAME'],
                        'email'     => $email,
                        'ccEmail'   => '2fasupport@xecurify.com',
                        'phone'     => $phone,
                        'query'     => $query
                    );
            $field_string = json_encode( $fields );

            $mo2fApi= new Mo2f_Api();
            $response = $mo2fApi->make_curl_call($url, $field_string);

			$submitted = $response;

			if(json_last_error() == JSON_ERROR_NONE && $submitted)
            {
                update_site_option('mo2f_trial_query_sent', true);
                do_action('wpns_show_message',MoWpnsMessages::showMessage('TRIAL_REQUEST_SENT'),'SUCCESS');
                return;
            }
            else{
                do_action('wpns_show_message',MoWpnsMessages::showMessage('SUPPORT_FORM_ERROR'),'ERROR');
            }

        }
	}

?>