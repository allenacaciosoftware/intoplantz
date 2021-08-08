<?php
class mo_2f_ajax
{
	function __construct(){

		add_action( 'admin_init'  , array( $this, 'mo_2f_two_factor' ) );
	}

	function mo_2f_two_factor(){
		add_action( 'wp_ajax_mo_two_factor_ajax', array($this,'mo_two_factor_ajax') );
		add_action( 'wp_ajax_nopriv_mo_two_factor_ajax', array($this,'mo_two_factor_ajax') );
	}

	function mo_two_factor_ajax(){
		
		$GLOBALS['mo2f_is_ajax_request'] = true;
		switch ($_POST['mo_2f_two_factor_ajax']) {
			case 'mo2f_ajax_login_redirect':
				$this->mo2f_ajax_login_redirect(); break;
			case 'mo2f_save_email_verification':
				$this->mo2f_save_email_verification();	break;
			case 'mo2f_unlimitted_user':
				$this->mo2f_unlimitted_user();break;
			case 'mo2f_check_user_exist_miniOrange':
				$this->mo2f_check_user_exist_miniOrange();break;
			case 'mo2f_single_user':
				$this->mo2f_single_user();break;
			case 'CheckEVStatus':
				$this->CheckEVStatus();		break;
			case 'mo2f_role_based_2_factor':
				$this->mo2f_role_based_2_factor();break;
			case 'mo2f_enable_disable_twofactor':
				$this->mo2f_enable_disable_twofactor();	break;
			case 'mo2f_enable_disable_inline':
				$this->mo2f_enable_disable_inline();	break;
			case 'mo2f_shift_to_onprem':
				$this->mo2f_shift_to_onprem();break;
			case 'mo2f_enable_disable_twofactor_prompt_on_login':
				$this->mo2f_enable_disable_twofactor_prompt_on_login();break;
			case 'mo2f_save_custom_form_settings':
				$this ->mo2f_save_custom_form_settings();
				break;
			case 'mo2f_enable_disable_debug_log':
				$this ->mo2f_enable_disable_debug_log();
				break;
			case 'mo2f_delete_log_file':
				$this->mo2f_delete_log_file();
				break;
			case 'select_method_setup_wizard':
				$this->select_method_setup_wizard();
				break;
		}
	}
	function select_method_setup_wizard()
	{
		global $Mo2fdbQueries;
		if(!wp_verify_nonce(sanitize_text_field($_POST['nonce']),'miniorange-select-method-setup-wizard'))
		{
			wp_send_json("ERROR");
		}
		
		$current_user = wp_get_current_user();
		$selected_2FA_method = sanitize_text_field($_POST['mo2f_method']);
		
		if(!MO2F_IS_ONPREM)
		{
			update_option('mo_2factor_user_registration_status','REGISTRATION_STARTED');
			update_user_meta( $current_user->ID, 'register_account_popup', 1 );
			update_user_meta( $current_user->ID, 'mo2f_2FA_method_to_configure', $selected_2FA_method );
			wp_send_json("SUCCESS");			
	
		}

		
		$exceeded = $Mo2fdbQueries->check_alluser_limit_exceeded($current_user->ID);
		if(!$exceeded)
			$Mo2fdbQueries->insert_user( $current_user->ID );	
		
		if($selected_2FA_method == 'OTP Over Email')
		{
			wp_send_json("SUCCESS");			
		}
		update_user_meta( $current_user->ID, 'mo2f_2FA_method_to_configure', $selected_2FA_method );
		
		$mo_2factor_admin_registration_status = get_option('mo_2factor_admin_registration_status');
		if($selected_2FA_method == 'OTP Over SMS' && $mo_2factor_admin_registration_status != 'MO_2_FACTOR_CUSTOMER_REGISTERED_SUCCESS')
		{
			update_option('mo_2factor_user_registration_status','REGISTRATION_STARTED');
			update_user_meta( $current_user->ID, 'register_account_popup', 1 );
		}
		else
			update_user_meta( $current_user->ID, 'configure_2FA', 1);
		wp_send_json("SUCCESS");
	}
	function mo2f_ajax_login_redirect()
	{	
		if(!wp_verify_nonce(sanitize_text_field($_POST['nonce']),'miniorange-2-factor-login-nonce'))
		{
			wp_send_json("ERROR");
			exit;
		}
		$username = sanitize_text_field($_POST['username']);
		$password = $_POST['password'];
		apply_filters( 'authenticate', null, $username, $password );
	}
	function mo2f_save_custom_form_settings()
	{

		$customForm = false;
		$nonce = sanitize_text_field($_POST['mo2f_nonce_save_form_settings']);

		if ( ! wp_verify_nonce( $nonce, 'mo2f-nonce-save-form-settings' ) ) {
			$error = new WP_Error();
			$error->add( 'empty_username', '<strong>' . mo2f_lt( 'ERROR' ) . '</strong>: ' . mo2f_lt( 'Invalid Request.' ) );
			//return $error;
		}
		if(isset($_POST['submit_selector']) and
			isset($_POST['email_selector']) and
			isset($_POST['authType']) and
			isset($_POST['customForm']) and
			isset($_POST['form_selector']) and

			$_POST['submit_selector']!="" and
			$_POST['email_selector']!="" and
			$_POST['customForm']!="" and
			$_POST['form_selector']!="")
		{
			$submit_selector 				= sanitize_text_field($_POST['submit_selector']);
			$form_selector					= sanitize_text_field($_POST['form_selector']);
			$email_selector 				= sanitize_text_field($_POST['email_selector']);
			$phone_selector 				= sanitize_text_field($_POST['phone_selector']);
			$authType 						= sanitize_text_field($_POST['authType']);
			$customForm 					= sanitize_text_field( $_POST['customForm']);
			$enableShortcode 				= sanitize_text_field($_POST['enableShortcode']);

			switch ($form_selector)
			{
				case '.bbp-login-form':
					update_site_option('mo2f_custom_reg_bbpress',true);
					update_site_option('mo2f_custom_reg_wocommerce',false);
					update_site_option('mo2f_custom_reg_custom',false);
					break;
				case '.woocommerce-form woocommerce-form-register':
					update_site_option('mo2f_custom_reg_bbpress',false);
					update_site_option('mo2f_custom_reg_wocommerce',true);
					update_site_option('mo2f_custom_reg_custom',false);
					break;
				default:
					update_site_option('mo2f_custom_reg_bbpress',false);
					update_site_option('mo2f_custom_reg_wocommerce',false);
					update_site_option('mo2f_custom_reg_custom',true);
			}

			update_site_option('mo2f_custom_form_name', $form_selector);
			update_site_option('mo2f_custom_email_selector', $email_selector);
			update_site_option('mo2f_custom_phone_selector', $phone_selector);
			update_site_option('mo2f_custom_submit_selector', $submit_selector);
			update_site_option('mo2f_custom_auth_type', $authType);

			update_site_option('enable_form_shortcode',$enableShortcode);
			$saved = true;
		}
		else
		{
			$submit_selector = 'NA';
			$form_selector = 'NA';
			$email_selector = 'NA';
			$authType ='NA';
			$saved = false;
		}
		$return = array(
			'authType' => $authType,
			'submit' => $submit_selector,
			'emailSelector' => $email_selector,
			'phone_selector' => $phone_selector,
			'form' => $form_selector,
			'saved' => $saved,
			'customForm' => $customForm,
			'enableShortcode' => $enableShortcode
		);

		return wp_send_json($return);
	}

	function mo2f_check_user_exist_miniOrange()
	{
		$nonce = sanitize_text_field($_POST['nonce']);

		if ( ! wp_verify_nonce( $nonce, 'checkuserinminiOrangeNonce' ) ) {
			$error = new WP_Error();
			$error->add( 'empty_username', '<strong>' . mo2f_lt( 'ERROR' ) . '</strong>: ' . mo2f_lt( 'Invalid Request.' ) );
			echo "NonceDidNotMatch";
			exit;
		}

		if(!get_option('mo2f_customerKey')){
			echo "NOTLOGGEDIN";
			exit;
		}
		$user = wp_get_current_user();
		global $Mo2fdbQueries;
		$email = $Mo2fdbQueries->get_user_detail( 'mo2f_user_email', $user->ID );
    	if($email == '' or is_null($email))
    		$email = $user->user_email;



    	if(isset($_POST['email']))
    	{
    		$email  = sanitize_text_field($_POST['email']);
    	}

    	$enduser    = new Two_Factor_Setup();
		$check_user = json_decode( $enduser->mo_check_user_already_exist( $email ), true );


		if(strcasecmp($check_user['status'], 'USER_FOUND_UNDER_DIFFERENT_CUSTOMER') == 0 ){
           echo "alreadyExist";
           exit;
	    }
	    else
	    {

	    	update_user_meta($user->ID,'mo2f_email_miniOrange',$email);
	    	echo "USERCANBECREATED";
	    	exit;
	    }

	}
function mo2f_shift_to_onprem(){

		$current_user 	= wp_get_current_user();
		$current_userID = $current_user->ID;
		$miniorangeID = get_option( 'mo2f_miniorange_admin' );
		if(is_null($miniorangeID) or $miniorangeID =='')
			$is_customer_admin = true;
		else
			$is_customer_admin = $miniorangeID == $current_userID ? true : false;
		if($is_customer_admin)
		{
			update_option('is_onprem', 1);
			update_option( 'mo2f_remember_device',0);
			wp_send_json('true');
		}
		else
		{
			$adminUser = get_user_by('id',$miniorangeID);
			$email = $adminUser->user_email;
			wp_send_json($email);
		}

	}

     
    function mo2f_delete_log_file(){
         $nonce = sanitize_text_field($_POST['mo2f_nonce_delete_log']);
            
            if ( ! wp_verify_nonce( $nonce, 'mo2f-nonce-delete-log' ) ) {
                $error = new WP_Error();
                $error->add( 'empty_username', '<strong>' . mo2f_lt( 'ERROR' ) . '</strong>: ' . mo2f_lt( 'Invalid Request.' ) );

            }else{
                $debug_log_path = wp_upload_dir();
                $debug_log_path = $debug_log_path['basedir'];
                $file_name = 'miniorange_debug_log.txt';
                $status = file_exists( $debug_log_path.DIRECTORY_SEPARATOR.$file_name);
               if($status){
                  unlink($debug_log_path.DIRECTORY_SEPARATOR.$file_name);
                  wp_send_json('true');
                }
                else{
                  wp_send_json('false');
                }
             }   
    }
     function mo2f_enable_disable_debug_log(){

			$nonce = sanitize_text_field($_POST['mo2f_nonce_enable_debug_log']);
            
			if ( ! wp_verify_nonce( $nonce, 'mo2f-nonce-enable-debug-log' ) ) {
				$error = new WP_Error();
				$error->add( 'empty_username', '<strong>' . mo2f_lt( 'ERROR' ) . '</strong>: ' . mo2f_lt( 'Invalid Request.' ) );

			}

			$enable = sanitize_text_field($_POST['mo2f_enable_debug_log']);
			if($enable == 'true'){
				update_site_option('mo2f_enable_debug_log' , 1);
				wp_send_json('true');
			}
			else{
				update_site_option('mo2f_enable_debug_log' , 0);
				wp_send_json('false');
			}
		}

		function mo2f_enable_disable_twofactor(){
			$nonce = sanitize_text_field($_POST['mo2f_nonce_enable_2FA']);

			if ( ! wp_verify_nonce( $nonce, 'mo2f-nonce-enable-2FA' ) ) {
				$error = new WP_Error();
				$error->add( 'empty_username', '<strong>' . mo2f_lt( 'ERROR' ) . '</strong>: ' . mo2f_lt( 'Invalid Request.' ) );

			}

			$enable = sanitize_text_field($_POST['mo2f_enable_2fa']);
			if($enable == 'true'){
				update_option('mo2f_activate_plugin' , 1);
				wp_send_json('true');
			}
			else{
				update_option('mo2f_activate_plugin' , 0);
				wp_send_json('false');
			}
		}

		function mo2f_enable_disable_twofactor_prompt_on_login(){
			
			global $Mo2fdbQueries;
			$user = wp_get_current_user();
			$nonce = sanitize_text_field($_POST['mo2f_nonce_enable_2FA_prompt_on_login']);
			$auth_method = $Mo2fdbQueries->get_user_detail( 'mo2f_configured_2FA_method', $user->ID );
			if ( ! wp_verify_nonce( $nonce, 'mo2f-enable-2FA-on-login-page-option-nonce' ) ) {
				$error = new WP_Error();
				$error->add( 'empty_username', '<strong>' . mo2f_lt( 'ERROR' ) . '</strong>: ' . mo2f_lt( 'Invalid Request.' ) );

			}
			$enable= sanitize_text_field($_POST['mo2f_enable_2fa_prompt_on_login']);
			if(!($auth_method == "Google Authenticator" || $auth_method =="miniOrange Soft Token" || $auth_method == "Authy Authenticator"))
			{
			update_site_option('mo2f_enable_2fa_prompt_on_login_page' , false);
			if(!MO2F_IS_ONPREM)
				wp_send_json('false_method_cloud');
			else
				wp_send_json('false_method_onprem');

			}
			else if($enable == 'true'){
				update_site_option('mo2f_enable_2fa_prompt_on_login_page' , true);
				wp_send_json('true');
			}
			else{
				update_site_option('mo2f_enable_2fa_prompt_on_login_page' , false);
				wp_send_json('false');
			}
		}

		function mo2f_enable_disable_inline(){
			$nonce = sanitize_text_field($_POST['mo2f_nonce_enable_inline']);

			if ( ! wp_verify_nonce( $nonce, 'mo2f-nonce-enable-inline' ) ) {
				wp_send_json("error");
			}
			$enable = sanitize_text_field($_POST['mo2f_inline_registration']);
			if($enable == 'true'){
				update_site_option('mo2f_inline_registration' , 1);
				wp_send_json('true');
			}
			else{
				update_site_option('mo2f_inline_registration' , 0);
				wp_send_json('false');
			}
		}

		function mo2f_role_based_2_factor(){
			if ( !wp_verify_nonce($_POST['nonce'],'unlimittedUserNonce') ){
    			   			wp_send_json('ERROR');
    			   			return;
                        }
					    global $wp_roles;
		                if (!isset($wp_roles))
			             $wp_roles = new WP_Roles();
                        foreach($wp_roles->role_names as $id => $name) {
                        	update_option('mo2fa_'.$id, 0);
                        }

                        if(isset($_POST['enabledrole'])){
                        $enabledrole = $_POST['enabledrole'];
                         }
                         else{
                         	$enabledrole = array();
                         }
                         foreach($enabledrole as $role){
   							 update_option($role, 1);
  						}
                        wp_send_json('true');
                        return;
		 }
		function mo2f_single_user()
		{
			if(!wp_verify_nonce($_POST['nonce'],'singleUserNonce'))
			{
				echo "NonceDidNotMatch";
				exit;
			}
			else
			{
				$current_user 	= wp_get_current_user();
				$current_userID = $current_user->ID;
				$miniorangeID = get_option( 'mo2f_miniorange_admin' );
				$is_customer_admin = $miniorangeID == $current_userID ? true : false;

				if(is_null($miniorangeID) or $miniorangeID =='')
					$is_customer_admin = true;

				if($is_customer_admin)
				{
					update_option('is_onprem', 0);
					wp_send_json('true');
				}
				else
				{
					$adminUser = get_user_by('id',$miniorangeID);
					$email = $adminUser->user_email;
					wp_send_json($email);
				}

			}
		}

		function mo2f_unlimitted_user()
		{
			if(!wp_verify_nonce($_POST['nonce'],'unlimittedUserNonce'))
			{
				echo "NonceDidNotMatch";
				exit;
			}
			else
			{
				if($_POST['enableOnPremise'] == 'on')
				{
					global $wp_roles;
					if (!isset($wp_roles))
						$wp_roles = new WP_Roles();
					foreach($wp_roles->role_names as $id => $name) {
					add_site_option('mo2fa_'.$id, 1);
						if($id == 'administrator'){
							add_option('mo2fa_'.$id.'_login_url',admin_url());
						}else{
							add_option('mo2fa_'.$id.'_login_url',home_url());
						}
					}
					echo "OnPremiseActive";
					exit;
				}
				else
				{
					echo "OnPremiseDeactive";
					exit;
				}
			}
		}

function mo2f_save_email_verification()
	{
                
			if(!wp_verify_nonce($_POST['nonce'],'EmailVerificationSaveNonce'))
			{
			echo "NonceDidNotMatch";
			exit;
			}
			else
			{
				$user_id = get_current_user_id();              
				$twofactor_transactions = new Mo2fDB;
				$exceeded = $twofactor_transactions->check_alluser_limit_exceeded($user_id);

				if($exceeded){
				echo "USER_LIMIT_EXCEEDED";
				exit;
				}
				$email = sanitize_email($_POST['email']);
				$currentMethod = sanitize_text_field($_POST['current_method']);
				$error = false;
				
				$customer_key               = get_site_option( 'mo2f_customerKey' );
				$api_key                    = get_site_option( 'mo2f_api_key' );

			  
						if (!filter_var($email, FILTER_VALIDATE_EMAIL))
						{
						$error = true;
						}
		if($email!='' && !$error)
		{
		global $Mo2fdbQueries;
		if($currentMethod == 'EmailVerification')
		{


			
			if(MO2F_IS_ONPREM){
		
			update_user_meta($user_id,'tempEmail',$email);
			$enduser = new Customer_Setup();
			$content = $enduser->send_otp_token($email,'OUT OF BAND EMAIL',$customer_key,$api_key);
			$decoded = json_decode($content,true);
			if($decoded['status'] == 'FAILED'){
			echo "smtpnotset";
			exit;
			}
			
			update_user_meta($user_id,'Mo2fTxid',$decoded['txId']);
			$otpToken = '';
			$otpToken .= rand(0,9);
			update_user_meta($user_id,'Mo2fOtpToken',$otpToken);
			
			}



			//for cloud
			if(! MO2F_IS_ONPREM){
			$enduser = new Two_Factor_Setup();
			$enduser->mo2f_update_userinfo($email, "OUT OF BAND EMAIL",null,null,null);
			}
			   // }

			echo "settingsSaved";
			exit;
			}
		elseif ($currentMethod == 'OTPOverEmail')
		{
				update_user_meta($user_id,'tempEmail',$email);
				$enduser = new Customer_Setup();
				                  $content = $enduser->send_otp_token($email,"OTP Over Email",$customer_key,$api_key);

				                  $decoded = json_decode($content,true);
				 if($decoded['status'] == 'FAILED'){


				echo "smtpnotset";
				exit;
				               
				}
				    MO2f_Utility::mo2f_debug_file('OTP has been sent successfully over Email');
				    update_user_meta( $user_id, 'configure_2FA', 1 );
				    update_user_meta($user_id,'Mo2fOtpOverEmailtxId',$decoded['txId']);
				                

		}
			update_user_meta($user_id,'tempRegEmail',$email);
			echo "settingsSaved";
			exit;
			}
		else
		{
		echo "invalidEmail";
		exit;
		}

	}

}

		function CheckEVStatus()
		{
			if(isset($_POST['txid']))
			{
				$txid = sanitize_text_field($_POST['txid']);
				$status = get_site_option($txid);
				if($status ==1 || $status ==0)
				delete_site_option($_POST['txid']);
				echo $status;
				exit();
			}
			echo "empty txid";
			exit;
		}


}

new mo_2f_ajax;
?>
