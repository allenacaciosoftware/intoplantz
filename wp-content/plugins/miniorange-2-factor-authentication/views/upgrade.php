<?php
	global $Mo2fdbQueries,$mainDir;
	$user = wp_get_current_user();
	$is_NC = MoWpnsUtility::get_mo2f_db_option('mo2f_is_NC', 'get_option');
	$is_customer_registered = $Mo2fdbQueries->get_user_detail( 'user_registration_with_miniorange', $user->ID ) == 'SUCCESS' ? true : false;

	$mo2f_2fa_method_list = array(
		"Google Authenticator",
		"Security Questions",
		"TOTP Based Authenticator",
		"Email Verification",
		"OTP Over Email",
		"OTP Over SMS",
		"OTP Over Whatsapp (Add-on)",
		"OTP Over Telegram",
		"miniOrange QR Code Authentication",
		"miniOrange Soft Token",
		"miniOrange Push Notification",		
		"OTP Over SMS and Email",
		"Hardware Token"
	);

	$mo2f_2fa_method_list_with_plans = array(

		"Google Authenticator"                                         	=> array( true, true,  true, true ),
		"Security Questions"                                  			=> array( true, true,  true, true ),
		"TOTP Based Authenticator"                                      => array( true, true,  true, true ),
		"Email Verification"                                          	=> array( true, true,  true, true ),
		"OTP Over Email"                                          		=> array( true, true,  true, true ),
		"OTP Over SMS"                                          		=> array( true, true,  true, true ),
		"OTP Over Whatsapp (Add-on)"                                    => array( false, false,  false, true ),
		"OTP Over Telegram"                                          	=> array( false, false,  false, true  ),
		"miniOrange QR Code Authentication"                             => array( true, true,  false, false ),
		"miniOrange Soft Token"                                         => array( true, true,  false, false ),
		"miniOrange Push Notification"                                  => array( true, true,  false, false ),
		"OTP Over SMS and Email"                                        => array( true, true,  false, false ),
		"Hardware Token"                                         		=> array( false, true, false, false ),
	);

		$mo2f_2fa_method_description_set = array(
		"Enter the soft token from the account in your Google Authenticator App to login.",
		"Answer the three security questions you had set, to login.",
		"Enter the soft token from the account in your Authy Authenticator/Microsoft Authenticator/TOTP Authenticator App to login.",
		"Accept the verification link sent to your email to login.",
		"You will receive a one time passcode via Email.",
		"You will receive a One Time Passcode via SMS on your Phone",
		"You will receive a One Time Passcode on your Whatsapp account - Supported with twillio",
		"You will receive a One Time Passcode on your Telegram account",
		"Scan the QR code from the account in your miniOrange Authenticator App to login.",
		"Enter the soft token from the account in your miniOrange Authenticator App to login.",
		"Accept a push notification in your miniOrange Authenticator App to login.",		
		"In this method, you receive an sms and an email containing a numeric key which you need to enter.",
		"In this method, you need to connect a usb like token into your computer which generates an alphabetic key.",
	);

	$mo2f_feature_set = array(
		
		"Roles Based and User Based 2fa",
		"Role based Authentication Methods",
		"Force Two Factor",
		"Verification during 2FA Registration",
		"Language Translation Support",
		"Password Less Login",
		"Backup Methods",
		"Role based redirection",
		"Custom SMS Gateway",
		"App Specific Password from mobile Apps",
		"Brute Force Protection",
		"IP Blocking",
		"Monitoring",
		"Strong Password",
		"File Protection"
	);


	$mo2f_feature_set_with_plans = array(

		"Roles Based and User Based 2fa" 										=> array( true, true,  false, true ),
		"Role based Authentication Methods"										=> array( true, true,  true, true ),
		"Force Two Factor"														=> array( true, true,  true, true ),
		"Verification during 2FA Registration"									=> array( true, true,  false, true ),
		"Language Translation Support"                                          => array( true, true,  true, true ),
		"Password Less Login"                            						=> array( true, true,  true, true ),
		"Backup Methods"                                          				=> array( true, true,  false, true),
		"Role based redirection"			                                	=> array( true, true,  true, true ),
		"Custom SMS Gateway"                    								=> array( true, true,  false, true ),
		"App Specific Password from mobile Apps"                       			=> array( true, true,  false, true ),
		"Brute Force Protection"												=> array( false, true, false, false ),
		"IP Blocking"															=> array( false, true,  false, false ),
		"Monitoring"															=> array( false, true,  false, false ),
		"Strong Password"														=> array( false, true,  false, false ),
		"File Protection"														=> array( false, true,  false, false ),

	);

	$mo2f_2fa_feature_description_set = array(

		"Enable and disable 2fa for users based on roles(Like Administrator, Editor and others). It works for custom roles too.",
		"You can choose specific authentication methods for specific user roles",
		"",
		"One time Email Verification for Users during 2FA Registration",
		"You can translate the plugin in a language of your choice",
		"After a valid username is entered, the 2FA prompt will be directly displayed",
		"By using backup you can restore the plugin settings",
		"According to user's role the particular user will be redirected to specific location",
		"Have your own gateway? You can use it, no need to purchase SMS then",
		"For access wordpress on different moblie apps, app specific passwords can be set",
		"This protects your site from attacks which tries to gain access/login to a site with random usernames and passwords.",
		"Allows you to manually/automatically block any IP address that seems malicious from accessing your website. ",
		"Monitor activity of your users. For ex:- login activity, error report",
		"Enforce users to set a strong password.",
		"Allows you to protect sensitive files through the malware scanner and other security features.",
	);

	$mo2f_custom_sms_gateways = array(

		"Solution Infi",			
		"Clickatell",													
		"ClickSend",	
		"Custom SMS Gateway",		
		"Twilio SMS",													
		"SendGrid",
		"Many Other Gateways"

	);

	$mo2f_custom_sms_gateways_feature_set = array(

		"Solution Infi"												=> array( true, true, false, true ),
		"Clickatell"												=> array( true, true, false, true ),
		"ClickSend"													=> array( true, true, false, true ),
		"Custom SMS Gateway"										=> array( true, true, false, true ),		
		"Twilio SMS"												=> array( true, true, false, true ),
		"SendGrid"													=> array( true, true, false, true ),
		"Many Other Gateways"										=> array( true, true, false, true ),

	);

	$mo2f_custom_sms_gateways_description_set = array(

		"Configure and test to add Solution Infi as custom gateway",
		"Configure and test to add Clickatell as custom gateway",
		"Configure and test to add ClickSend as custom gateway",
		"Custom SMS Gateway",
		"Configure and test to add Twilio SMS as custom gateway",
		"Configure and test to add SendGrid as custom gateway",
		"Not Listed? Configure and test to add it as custom gateway",

	);
	$mo2f_addons_set		=	array(
		"RBA & Trusted Devices Management",
		"Personalization",		                 
		"Short Codes"  
	);
	$mo2f_addons           	= array(
		"RBA & Trusted Devices Management" 	=> array( true, true,  false, true ),
		"Personalization"					=> array( true, true,  false, true ),
		"Short Codes"						=> array( true, true,  false, true )
	);
	$mo2f_addons_description_set	=array(
		"Remember Device, Set Device Limit for the users to login, IP Restriction: Limit users to login from specific IPs.",
		"Custom UI of 2FA popups Custom Email and SMS Templates, Customize 'powered by' Logo, Customize Plugin Icon, Customize Plugin Name",
		"Option to turn on/off 2-factor by user, Option to configure the Google Authenticator and Security Questions by user, Option to 'Enable Remember Device' from a custom login form, On-Demand ShortCodes for specific fuctionalities ( like for enabling 2FA for specific pages)",
	);
if ($_GET['page'] == 'mo_2fa_upgrade') {
	?><br><br><?php
}
echo '
<a class="mo2f_back_button" style="font-size: 16px; color: #000;" href="'.$two_fa.'"><span class="dashicons dashicons-arrow-left-alt" style="vertical-align: bottom;"></span> Back To Plugin Configuration</a>';
?>
<br><br>

	<?php 
	if( get_option("mo_wpns_2fa_with_network_security"))
		{
	?>
	<div class="mo_upgrade_toggle">
		<p class="mo_upgrade_toggle_2fa">
	    <input type="radio" name="sitetype" value="Recharge" id="mo2f_2fa_plans" onclick="show_2fa_plans();" style="display: none;">
	    <label for="mo2f_2fa_plans" class="mo_upgrade_toggle_2fa_lable" id="mo_2fa_lite_licensing_plans_title" style="display: none;">&nbsp;&nbsp;&nbsp;2-Factor Authentication</label>
		<label for="mo2f_2fa_plans" class="mo_upgrade_toggle_2fa_lable mo2f_active_plan" id="mo_2fa_lite_licensing_plans_title1" style="display: block;">&nbsp;&nbsp;&nbsp;2-Factor Authentication</label>
		<input type="radio" name="sitetype" value="Recharge" id="mo2f_ns_plans" onclick="mo_ns_show_plans();" style="display: none;">
	    <label for="mo2f_ns_plans" class="mo_upgrade_toggle_2fa_lable" id="mo_ns_licensing_plans_title">Website Security</label>
		<label for="mo2f_ns_plans" class="mo_upgrade_toggle_2fa_lable mo2f_active_plan" id="mo_ns_licensing_plans_title1" style="display: none;">Website Security</label>
		</p>
	</div>
	<?php
		}
?>
<span class="cd-switch"></span>
<center>
	<div id="mo2f_plan_type">
	<label id="mo2f_unlimited_users" class="mo2f_toggler mo2f_toggler--is-active">Unlimited Users</label>
		<div class="mo2f_toggle">
		<input type="checkbox" name="mo2f_select_plan_type" id="mo2f_switcher" class="mo2f_check">
		<b class="mo2f_block mo2f_switch"></b>
	</div>
	<label id="mo2f_unlimited_sites" class="mo2f_toggler">Unlimited Sites</label>
	</div>
</center>

<br><br>
<link rel="stylesheet" href=<?php echo $mainDir.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'upgrade.css';?>>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"/>
<div class="mo2f_upgrade_super_div" id="mo2f_twofa_plans">
	<div class="mo2f_upgrade_main_div" id="mo2f_standard_lite_plan">
	<div id="pricing_tabs_mo_standard_lite" class="mo2fa_pricing_tabs_mo mo2fa_pricing_tabs_mo_standard_lite">
		<div id="mo2f_pricing_head_standard_lite" class="mo2fa_pricing_head_supporter"><center><h3 class="mo2fa_pricing_head_mo_2fa">Standard Lite</h3><h4 class="mo2fa_pricing_head_h4">(Basic 2FA)</h4></center></div>
		<div id="mo2f_pricing_head_standard_lite" class="mo2fa_pricing_head_supporter"><center><span class="mo2fa_pricing_head_mo_2fa">$59</span>/Year</center></div>

		<div id="getting_started_2fa_mo_standard_lite">
			<center>
			<a href="#pricing_feature_collection_supporter_standard_lite"><button class="mo2fa_make_my_plan_mo">Getting Started</button></a>
			</center>
		</div>

		<div id="pricing_feature_collection_supporter_standard_lite" class="mo2fa_pricing_feature_collection_supporter">
			<div id="pricing_feature_collection_standard_lite" class="mo2fa_pricing_feature_collection">
				<ul class="mo2fa_ul">
					<p class="mo2fa_feature"><strong>Features</strong></p>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Unlimited Users</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature">
					<i class="fas fa-check"></i>
				    <span class="mo2fa_tooltip_methodlist">5+ Authentication Methods
				    <span class="methodlist">
					<ul class="methods-list-mo2fa" style="margin-left: -43px; ">
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Google Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Security Questions</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Authy Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Microsoft Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>LastPass Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>FreeOTP Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Duo Mobile Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Email Verification</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>OTP Over Email</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>OTP Over SMS</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>miniOrange QR Code Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>miniOrange Soft Token</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>miniOrange Push Notification</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>OTP Over SMS and Email</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>Hardware Token</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>OTP Over Whatsapp</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>OTP Over Telegram</li>
					</ul>
					</span>
				    </span>
					</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_limit_pricing_feature_mo_2fa"><i class="fas fa-times"></i>Force users to set-up 2FA</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_limit_pricing_feature_mo_2fa"><i class="fas fa-times"></i>Remember Device</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_limit_pricing_feature_mo_2fa"><i class="fas fa-times"></i>Role-based 2fa</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Backup Login Method</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Passwordless Login</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_limit_pricing_feature_mo_2fa"><i class="fas fa-times"></i>Strong Password</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_limit_pricing_feature_mo_2fa"><i class="fas fa-times"></i>Custom SMS Gateway </li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_limit_pricing_feature_mo_2fa"><i class="fas fa-times"></i>Add-Ons (Purchase Seperately)</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_limit_pricing_feature_mo_2fa"><i class="fas fa-times"></i>Enable/reconfigure 2fa shortcode</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_limit_pricing_feature_mo_2fa"><i class="fas fa-times"></i>Advance Security Features</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_limit_pricing_feature_mo_2fa"><i class="fas fa-times"></i>Unlimited Email Transactions</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"  id="mo2f_purchase_user_limit_premium_lite_standard_lite"><i class="fas fa-check"></i>Multi-Site Support</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Language Translation Support</li>
				</ul>

			</div>
		</div>
		<div id="pricing_addons_site_based_standard_lite" class="mo2fa_pricing">
				<center>
			<div id="mo2f_purchase_user_limit_standard_lite" style = "margin-top: 50px;">
					<p class="mo2fa_more_details_p mo2fa_class"><a href="#mo2f_more_details" onclick="mo2fa_show_details()">Click here to compare all plans</a></p>
					<p class="mo2fa_more_details_p1 mo2fa_hide1"><a href="#mo2f_more_details" onclick="mo2fa_show_details()">Click here to hide comparison</a></p>
				<center><h3 class="mo2fa_purchase_user_limit_mo mo2fa_purchase_limit_mo">Choose no. of sites</h3>
				<p class="mo2fa_pricing_p">(Yearly subscription fees*)</p>
				<select id="site_price_mo_standard_lite" onchange="mo2f_update_site_limit_standard_lite()" onclick="mo2f_update_site_limit_standard_lite()" class="mo2fa_increase_my_limit">
					<option value="59">1 Site - free with the plan</option>
					<option value="109">2 Sites - $109 per year</option>
					<option value="199">Upto 5 Sites - $199 per year</option>
					<option value="299">Upto 10 Sites - $299 per year</option>
					<option value="399">Upto 25 Sites - $399per year</option>
					<option value="0"> Above 25 - Contact us</option>
				</select>
			</center>
			</div>
			<div id="mo2f_purchase_sms_limit_standard_lite" class="mo2fa_tooltip_sms_info">
				<center><h3 class="mo2fa_purchase_otp_limit mo2fa_purchase_limit_mo">No. of SMS transactions</h3>
				<span class="mo2fa_sms_info">
				<p class="mo2fa_country">Transaction prices & SMS delivery charges depend on country.</p>
				</span>
				</center>
			</div>
			<div class="mo2fa_tooltip_sms_info_cost">
				<select id="sms_price_site_based_mo_standard_lite" onchange="update_sms_limit_site_based_mo_standard_lite()" class="mo2fa_increase_my_limit">
					<option value="0">0 Transaction - $0</option>
					<option value="5">$5 per 100 OTP + SMS Delivery Charges</option>
					<option value="15">$15 per 500 OTP + SMS Delivery Charges</option>
					<option value="22">$22 per 1K OTP + SMS Delivery Charges</option>
					<option value="30">$30 per 5K OTP + SMS Delivery Charges</option>
					<option value="40">$40 per 10K OTP + SMS Delivery Charges</option>
					<option value="90">$90 per 50K OTP + SMS Delivery Charges</option>
				</select>
				<span class="mo2fa_sms_info_cost">
				<p class="mo2fa_country">Only applicable if you will use OTP over SMS as authentication method.</p>
				</span>
			</div>
			<div class="mo2fa_dollar"> <center><span>$</span><span id="mo_pricing_adder_site_based_standard_lite"></span></center></div>

			<div id="custom_my_plan_2fa_mo_standard_lite">
				<center>
				<?php	if( isset($is_customer_registered) && $is_customer_registered) { ?>
				<a onclick="mo2f_upgradeform('wp_security_two_factor_standard_lite_plan','2fa_plan')" target="blank"><button class="mo2fa_upgrade_my_plan">Upgrade</button></a>
				<?php }else{ ?>
				<a onclick="mo2f_register_and_upgradeform('wp_security_two_factor_standard_lite_plan','2fa_plan')" target="blank"><button class="mo2fa_upgrade_my_plan">Upgrade</button></a>
				<?php }?>
				</center>
			</div>
			</center>
		</div>
	</div>	
	<script>
		var base_price_site_based =0;
		var display_my_site_based_price = parseInt(base_price_site_based)+parseInt(0)+parseInt(0)+parseInt(0);
		document.getElementById("mo_pricing_adder_site_based_standard_lite").innerHTML = + display_my_site_based_price;
		jQuery('#site_price_mo_standard_lite').click();
		function mo2f_update_site_limit_standard_lite() {
			var users = document.getElementById("site_price_mo_standard_lite").value;
			var sms_user_selection= document.getElementById("sms_price_site_based_mo_standard_lite").value;
			var users_addion = parseInt(base_price_site_based)+parseInt(users)+parseInt(sms_user_selection);

			document.getElementById("mo_pricing_adder_site_based_standard_lite").innerHTML = + users_addion;

		}

		function update_sms_limit_site_based_mo_standard_lite() {
			var sms = document.getElementById("sms_price_site_based_mo_standard_lite").value;
			var users_sms_selection = document.getElementById("site_price_mo_standard_lite").value;

			var sms_addion = parseInt(base_price_site_based)+parseInt(sms)+parseInt(users_sms_selection );

			document.getElementById("mo_pricing_adder_site_based_standard_lite").innerHTML = + sms_addion;

		}
	</script>
	</div>

<div class="mo2f_upgrade_main_div" id="mo2f_premium_lite_plan">
	<div id="pricing_tabs_mo_premium_lite" class="mo2fa_pricing_tabs_mo mo2fa_pricing_tabs_mo_premium_lite">
		<div id="mo2f_pricing_head_premium_lite" class="mo2fa_pricing_head_supporter"><center><h3 class="mo2fa_pricing_head_mo_2fa">Premium Lite</h3><h4 class="mo2fa_pricing_head_h4">(2FA with Essential Features)</h4></center></div>
		<div id="mo2f_pricing_head_premium_lite" class="mo2fa_pricing_head_supporter"><center><span class="mo2fa_pricing_head_mo_2fa">$99</span>/Year</center></div>

		<div id="getting_started_2fa_mo_premium_lite">
			<center>
			<a href="#pricing_feature_collection_supporter_premium_lite"><button class="mo2fa_make_my_plan_mo">Getting Started</button></a>
			</center>
		</div>

		<div id="pricing_feature_collection_supporter_premium_lite" class="mo2fa_pricing_feature_collection_supporter">
			<div id="pricing_feature_collection_premium_lite" class="mo2fa_pricing_feature_collection">
				<ul class="mo2fa_ul">
					<p class="mo2fa_feature"><strong>Features</strong></p>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Unlimited Users</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature">
					<i class="fas fa-check"></i>
				    <span class="mo2fa_tooltip_methodlist">10+ Authentication Methods
				    <span class="methodlist">
					<ul class="methods-list-mo2fa" style="margin-left: -43px; ">
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Google Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Security Questions</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Authy Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Microsoft Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>LastPass Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>FreeOTP Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Duo Mobile Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Email Verification</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>OTP Over Email</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>OTP Over SMS</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>miniOrange QR Code Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>miniOrange Soft Token</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>miniOrange Push Notification</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>OTP Over SMS and Email</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>Hardware Token</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>OTP Over Whatsapp</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>OTP Over Telegram</li>
					</ul>
					</span>
				    </span>
					</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Force users to set-up 2FA</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Remember Device</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Role-based 2fa</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i> 3+ Backup Login Methods</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Passwordless Login</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_limit_pricing_feature_mo_2fa"><i class="fas fa-times"></i>Strong Password</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Custom SMS Gateway </li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_limit_pricing_feature_mo_2fa"><i class="fas fa-times"></i>Add-Ons (Purchase Seperately)</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Enable/reconfigure 2fa shortcode</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_limit_pricing_feature_mo_2fa"><i class="fas fa-times"></i>Advance Security Features</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Unlimited Email Transactions</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"  id="mo2f_purchase_user_limit_premium_lite_premium_lite"><i class="fas fa-check"></i>Multi-Site Support</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Language Translation Support</li>
				</ul>

			</div>
		</div>
		<div id="pricing_addons_site_based_premium_lite" class="mo2fa_pricing">
				<center>
			<div id="mo2f_purchase_user_limit_premium_lite" style = "margin-top: 50px;">
					<p class="mo2fa_more_details_p mo2fa_class"><a href="#mo2f_more_details" onclick="mo2fa_show_details()">Click here to compare all plans</a></p>
					<p class="mo2fa_more_details_p1 mo2fa_hide1"><a href="#mo2f_more_details" onclick="mo2fa_show_details()">Click here to hide comparison</a></p>
				<center><h3 class="mo2fa_purchase_user_limit_mo mo2fa_purchase_limit_mo">Choose no. of sites</h3>
				<p class="mo2fa_pricing_p">(Yearly subscription fees*)</p>
				<select id="site_price_mo_premium_lite" onchange="update_site_limit_premium_lite()" onclick="update_site_limit_premium_lite()" class="mo2fa_increase_my_limit">
					<option value="99">1 Site - free with the plan</option>
					<option value="179">2 Sites - $179 per year</option>
					<option value="299">Upto 5 Sites - $299 per year</option>
					<option value="449">Upto 10 Sites - $449 per year</option>
					<option value="599">Upto 25 Sites - $599per year</option>
					<option value="0"> Above 25 - Contact us</option>
				</select>
			</center>
			</div>
			<div id="mo2f_purchase_sms_limit_premium_lite" class="mo2fa_tooltip_sms_info">
		        <center><h3 class="mo2fa_purchase_otp_limit mo2fa_purchase_limit_mo">No. of SMS transactions</h3>
		        <span class="mo2fa_sms_info">
		        <p class="mo2fa_country">Transaction prices & SMS delivery charges depend on country.</p>
		        </span>
		        </center>
		      </div>
		      <div class="mo2fa_tooltip_sms_info_cost">
		        <select id="sms_price_site_based_mo_premium_lite" onchange="update_sms_limit_site_based_mo_premium_lite()" class="mo2fa_increase_my_limit">
		          <option value="0">0 Transaction - $0</option>
		          <option value="5">$5 per 100 OTP + SMS Delivery Charges</option>
		          <option value="15">$15 per 500 OTP + SMS Delivery Charges</option>
		          <option value="22">$22 per 1K OTP + SMS Delivery Charges</option>
		          <option value="30">$30 per 5K OTP + SMS Delivery Charges</option>
		          <option value="40">$40 per 10K OTP + SMS Delivery Charges</option>
		          <option value="90">$90 per 50K OTP + SMS Delivery Charges</option>
		        </select>
		        <span class="mo2fa_sms_info_cost">
		        <p class="mo2fa_country">Only applicable if you will use OTP over SMS as authentication method.</p>
		        </span>
		      </div>
			<div class="mo2fa_dollar"> <center><span>$</span><span id="mo_pricing_adder_site_based_premium_lite"></span></center></div>

			<div id="custom_my_plan_2fa_mo_premium_lite">
				<center>
				<?php	if( isset($is_customer_registered) && $is_customer_registered) { ?>
				<a onclick="mo2f_upgradeform('wp_security_two_factor_premium_lite_plan','2fa_plan')" target="blank"><button class="mo2fa_upgrade_my_plan">Upgrade</button></a>
				<?php }else{ ?>
				<a onclick="mo2f_register_and_upgradeform('wp_security_two_factor_premium_lite_plan','2fa_plan')" target="blank"><button class="mo2fa_upgrade_my_plan">Upgrade</button></a>
				<?php }?>
				</center>
			</div>
			</center>
		</div>
	</div>
	<script>
		var base_price_site_based =0;
		var display_my_site_based_price = parseInt(base_price_site_based)+parseInt(0)+parseInt(0)+parseInt(0);
		document.getElementById("mo_pricing_adder_site_based_premium_lite").innerHTML = + display_my_site_based_price;
		jQuery('#site_price_mo_premium_lite').click();
		function update_site_limit_premium_lite() {
			var users = document.getElementById("site_price_mo_premium_lite").value;
			var sms_user_selection= document.getElementById("sms_price_site_based_mo_premium_lite").value;
			var users_addion = parseInt(base_price_site_based)+parseInt(users)+parseInt(sms_user_selection);

			document.getElementById("mo_pricing_adder_site_based_premium_lite").innerHTML = + users_addion;

		}

		function update_sms_limit_site_based_mo_premium_lite() {
			var sms = document.getElementById("sms_price_site_based_mo_premium_lite").value;
			var users_sms_selection = document.getElementById("site_price_mo_premium_lite").value;

			var sms_addion = parseInt(base_price_site_based)+parseInt(sms)+parseInt(users_sms_selection );

			document.getElementById("mo_pricing_adder_site_based_premium_lite").innerHTML = + sms_addion;

		}


	</script>
</div>

<div class="mo2f_upgrade_main_div" id="mo2f_premium_plan">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

	<div id="pricing_tabs_mo" class="mo2fa_pricing_tabs_mo mo2fa_pricing_tabs_mo_premium">
		<div class="mo2fa_recommended"><center><h4 class="mo2fa_h4">Recommended</h4></center> </div>
		<div id="mo2f_pricing_head_all_inclusive" class="mo2fa_pricing_head_supporter" style="margin-top: 4em !important;"> <center><h3 class="mo2fa_pricing_head_mo_2fa">Premium</h3><h4 class="mo2fa_pricing_head_h4">(2FA with Advanced Features + Website Security)</h4></center></div>
		<div id="mo2f_pricing_head_all_inclusive"  class="mo2fa_pricing_head_supporter"><center><span class="mo2fa_pricing_head_mo_2fa">$199</span>/Year</center></div>
		<div id="getting_started_2fa_mo_all_inclusive">
		<center>
			<a href="#pricing_feature_collection_supporter_all_inclusive"><button class="mo2fa_make_my_plan_mo">Getting Started</button></a>
	</center>
		</div>

		<div id="pricing_feature_collection_supporter_all_inclusive" class="mo2fa_pricing_feature_collection_supporter">
			<div id="pricing_feature_collection_all_inclusive" class="mo2fa_pricing_feature_collection">
				<ul class="mo2fa_ul">
					<p class="mo2fa_feature"><strong>Features</strong></p>

					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Unlimited Users</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i><span class="mo2fa_tooltip_methodlist">10+ Authentication Methods
				    <span class="methodlist methodlist_left">
					<ul class="methods-list-mo2fa" style="margin-left: -43px; ">
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Google Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Security Questions</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Authy Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Microsoft Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>LastPass Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>FreeOTP Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Duo Mobile Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Email Verification</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>OTP Over Email</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>OTP Over SMS</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>miniOrange QR Code Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>miniOrange Soft Token</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>miniOrange Push Notification</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>OTP Over SMS and Email</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>Hardware Token</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>OTP Over Whatsapp</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>OTP Over Telegram</li>
					</ul>
					</span>
				    </span></li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Force users to set-up 2FA</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i> Remember Device</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i> Role-based 2fa</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i> 3+ Backup Login Methods</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Passwordless Login</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Strong Password</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Custom SMS Gateway </li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Add-Ons (Included)</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Enable/reconfigure 2fa shortcode</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Advance Security Features</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Unlimited Email Transactions</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"  id="addon_all_inclusive"><i class="fas fa-check"></i>Multi-Site Support</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Language Translation Support</li>
				</ul>

			</div>
		</div>
		<div id="pricing_addons_all_inclusive" class="mo2fa_pricing">
			<div id="mo2f_purchase_user_limit_all_inclusive" style = "margin-top: 50px;">
				<p class="mo2fa_more_details_p mo2fa_class"><a href="#mo2f_more_details" onclick="mo2fa_show_details()">Click here to compare all plans</a></p>
					<p class="mo2fa_more_details_p1 mo2fa_hide1"><a href="#mo2f_more_details" onclick="mo2fa_show_details()">Click here to hide comparison</a></p>
				<center><h3 class="mo2fa_purchase_user_limit_mo mo2fa_purchase_limit_mo">Choose no. of sites</h3>
					<p class="mo2fa_pricing_p">(Yearly subscription fees*)</p>
				<select id="all_inclusive_price_mo" onclick="update_site_limit_all_inclusive()" onchange="update_site_limit_all_inclusive()" class="mo2fa_increase_my_limit">
					<option value="199">1 Site - free with the plan</option>
					<option value="299">2 Sites - $299 per year</option>
					<option value="499">Upto 5 Sites - $499 per year</option>
					<option value="799">Upto 10 Sites - $799 per year</option>
					<option value="1099">Upto 25 Sites - $1099 per year</option>
					<option value="0">Above 25 - Contact us</option>
				</select>
				</center>
			</div>
			<div id="mo2f_purchase_sms_limit_all_inclusive">
				<center>
				<div class="mo2fa_tooltip_sms_info">
					<h3 class="mo2fa_purchase_otp_limit mo2fa_purchase_limit_mo">No. of SMS transactions  </h3>
				<span class="mo2fa_sms_info mo2fa_left_sms_info">
				<p class="mo2fa_country">Transaction prices & SMS delivery charges depend on country.</p>
				</span>
				</div>
				<div class="mo2fa_tooltip_sms_info_cost">
				<select id="sms_price_all_inclusive_mo" onchange="update_sms_limit_all_inclusive()" class="mo2fa_increase_my_limit">
					<option value="0">0 Transaction - $0</option>
					<option value="5">$5 per 100 OTP + SMS Delivery Charges</option>
					<option value="15">$15 per 500 OTP + SMS Delivery Charges</option>
					<option value="22">$22 per 1K OTP + SMS Delivery Charges</option>
					<option value="30">$30 per 5K OTP + SMS Delivery Charges</option>
					<option value="40">$40 per 10K OTP + SMS Delivery Charges</option>
					<option value="90">$90 per 50K OTP + SMS Delivery Charges</option>
				</select>
				<span class="mo2fa_sms_info_cost mo2fa_left_sms_info_cost">
				<p class="mo2fa_country">Only applicable if you will use OTP over SMS as authentication method.</p>
				</span>
				</center>
			</div>
			<div class="mo2fa_dollar"> <center><span>$</span><span id="display_my_all_inclusive_pricing"></span></center></div>

			<div id="custom_my_plan_2fa_mo">
				<center>
				<?php	if( isset($is_customer_registered) && $is_customer_registered) { ?>
				<a onclick="mo2f_upgradeform('wp_security_two_factor_all_inclusive_plan','2fa_plan')" target="blank"><button class="mo2fa_upgrade_my_plan">Upgrade</button></a>
				<?php }else{ ?>
				<a onclick="mo2f_register_and_upgradeform('wp_security_two_factor_all_inclusive_plan','2fa_plan')" target="blank"><button class="mo2fa_upgrade_my_plan">Upgrade</button></a>
				<?php }?>
				</center>
			</div>
		</div>
	</div>
	<script>

		var base_price_site_all_inclusive =0;
		var display_my_all_inclusive_price = parseInt(base_price_site_all_inclusive)+parseInt(0)+parseInt(0)+parseInt(0);
		document.getElementById("display_my_all_inclusive_pricing").innerHTML = + display_my_all_inclusive_price;
		jQuery('#all_inclusive_price_mo').click();
		function update_site_limit_all_inclusive() {
			var sites_all_inclusive = document.getElementById("all_inclusive_price_mo").value;
			var sms_user_selection_all_inclusive= document.getElementById("sms_price_all_inclusive_mo").value;
			var total_inclusive = parseInt(base_price_site_all_inclusive)+parseInt(sites_all_inclusive)+parseInt(sms_user_selection_all_inclusive);

			document.getElementById("display_my_all_inclusive_pricing").innerHTML = + total_inclusive;

		}

		function update_sms_limit_all_inclusive() {
			var sms = document.getElementById("sms_price_all_inclusive_mo").value;
			var sms_site_selection = document.getElementById("all_inclusive_price_mo").value;
			var sms_all_inclusive_mo_2fa= parseInt(base_price_site_all_inclusive)+parseInt(sms)+parseInt(sms_site_selection);

			document.getElementById("display_my_all_inclusive_pricing").innerHTML = + sms_all_inclusive_mo_2fa;

		}

	</script>
</div>
<div class="mo2f_upgrade_main_div mo2fa_hide" id="mo2f_enterprise_plan">
	<div id="pricing_tabs_mo" class="mo2fa_pricing_tabs_mo mo2fa_pricing_tabs_mo_enterprise">

		<div id="pricing_head" style="text-align: center;">
			<h3 class="mo2fa_pricing_head_mo_2fa">Enterprise</h3> 
			<h4 class="mo2fa_pricing_head_h4">Starting From </h4>
		</div>
		<div id="mo2f_pricing_head_cost" class="mo2fa_pricing_head_supporter">
			<center><span class="mo2fa_pricing_head_mo_2fa">$59</span>/Year</center>
		</div>

		<div id="getting_started_2fa_mo">
			<center>
			<a href="#pricing_feature_collection_supporter"><button class="mo2fa_make_my_plan_mo mo2fa_enterprise_getting_started">Getting Started</button></a>
			</center>
		</div>

		<div id="pricing_feature_collection_supporter" class="mo2fa_pricing_feature_collection_supporter">

			<div id="pricing_feature_collection" class="mo2fa_pricing_feature_collection">
				<ul class="mo2fa_ul">
					<p class="mo2fa_feature"><strong>Features</strong></p>

					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Unlimited sites</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i><span class="mo2fa_tooltip_methodlist">15+ Authentication Methods
				    <span class="methodlist">
					<ul class="methods-list-mo2fa" style="margin-left: -43px; ">
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Google Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Security Questions</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Authy Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Microsoft Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>LastPass Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>FreeOTP Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Duo Mobile Authenticator</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Email Verification</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>OTP Over Email</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>OTP Over SMS</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>miniOrange QR Code Authentication</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>miniOrange Soft Token</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>miniOrange Push Notification</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>OTP Over SMS and Email</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>Hardware Token</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-mo-size-cross"><i class="fas fa-times  mo2fa_fa-times icon-mo2fa-methods"></i>OTP Over Whatsapp</li>
						<li class="feature_collect_mo-2fa mo2fa_method-list-size"><i class="fas fa-check mo2fa_fa-check icon-mo2fa-methods"></i>OTP Over Telegram</li>
					</ul>
					</span>
				    </span></li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Force users to set-up 2FA</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Remember device</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Role based</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i> 3+ Backup Login Methods</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Passwordless Login </li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Strong Password</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Custom SMS Gateway </li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Add-Ons (Limited)</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Enable/reconfigure 2fa shortcode</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Advance Security Features</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_limit_pricing_feature_mo_2fa"><i class="fas fa-times"></i>Unlimited Email Transactions</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature" id="addon"><i class="fas fa-check" id="addon"></i>Multi-Site Support</li>
					<li class="mo2fa_feature_collect_mo-2fa mo2fa_unltimate_feature"><i class="fas fa-check"></i>Language Translation Support</li>
				</ul>

			</div>
		</div>
		<div id="pricing_addons" class="mo2fa_pricing">
			<center>
			<div id="mo2f_purchase_user_limit" style = "margin-top: 50px;">
				<p class="mo2fa_more_details_p mo2fa_class"><a href="#mo2f_more_details" onclick="mo2fa_show_details()">Click here to compare all plans</a></p>
					<p class="mo2fa_more_details_p1 mo2fa_hide1"><a href="#mo2f_more_details" onclick="mo2fa_show_details()">Click here to hide comparison</a></p>
				<center><h3 class="mo2fa_purchase_user_limit_mo mo2fa_purchase_limit_mo">Choose No. of Users </h3>
					<p class="mo2fa_pricing_p">(Yearly subscription fees*)</p>
				<select id="user_price" onclick="update_user_limit()" onchange="update_user_limit()" class="mo2fa_increase_my_limit">
					<option value="59">Upto-5 users -  $59 per year</option>
					<option value="128">Upto-50 users - $128 per year</option>
					<option value="228">Upto-100 users - $228 per year</option>
					<option value="378">Upto-500 users - $378 per year</option>
					<option value="528">Upto-1000 users - $528 per year</option>
					<option value="828">Upto-5000 users - $828 per year</option>
					<option value="1028">Upto-10000 users - $1028 per year</option>
					<option value="1528">Upto-20000 users - $1528 per year</option>
					<option value="0">Unlimited Users - Contact Us</option>
				</select>
				</center>
			</div>
			<div id="mo2f_purchase_sms_limit" class="mo2fa_tooltip_sms_info">
        <center><h3 class="mo2fa_purchase_otp_limit mo2fa_purchase_limit_mo">No. of SMS transactions</h3>
        <span class="mo2fa_sms_info">
        <p class="mo2fa_country">Transaction prices & SMS delivery charges depend on country.</p>
        </span>
        </center>
      </div>
      <div class="mo2fa_tooltip_sms_info_cost">
        <select id="sms_price" onchange="update_sms_limit()" class="mo2fa_increase_my_limit">
          <option value="0">0 Transaction - $0</option>
          <option value="5">$5 per 100 OTP + SMS Delivery Charges</option>
          <option value="15">$15 per 500 OTP + SMS Delivery Charges</option>
          <option value="22">$22 per 1K OTP + SMS Delivery Charges</option>
          <option value="30">$30 per 5K OTP + SMS Delivery Charges</option>
          <option value="40">$40 per 10K OTP + SMS Delivery Charges</option>
          <option value="90">$90 per 50K OTP + SMS Delivery Charges</option>
        </select>
        <span class="mo2fa_sms_info_cost">
        <p class="mo2fa_country">Only applicable if you will use OTP over SMS as authentication method.</p>
        </span>
      </div>
			<div class="mo2fa_dollar"> <center><span>$</span><span id="mo_pricing_adder"></span></center></div>

			<div id="details">
				<center>
				<?php	if( isset($is_customer_registered) && $is_customer_registered) { ?>
				<a onclick="mo2f_upgradeform('wp_2fa_enterprise_plan','2fa_plan')" target="blank"><button class="mo2fa_upgrade_my_plan">Upgrade</button></a>
				<?php }else{ ?>
				<a onclick="mo2f_register_and_upgradeform('wp_2fa_enterprise_plan','2fa_plan')" target="blank"><button class="mo2fa_upgrade_my_plan">Upgrade</button></a>
				<?php }?>
				</center>
			</div>
		</center>
		</div>
	</div>

	<script>
		var base_price =0;
		var display_me = parseInt(base_price)+parseInt(30)+parseInt(0)+parseInt(0);
		document.getElementById("mo_pricing_adder").innerHTML = + display_me;
		jQuery('#user_price').click();
		function update_user_limit() {
			var users = document.getElementById("user_price").value;
			var sms_user_selection= document.getElementById("sms_price").value;
			var users_addion = parseInt(base_price)+parseInt(users)+parseInt(sms_user_selection);

			document.getElementById("mo_pricing_adder").innerHTML = + users_addion;

		}

		function update_sms_limit() {
			var sms = document.getElementById("sms_price").value;
			var users_sms_selection = document.getElementById("user_price").value;

			var sms_addion = parseInt(base_price)+parseInt(sms)+parseInt(users_sms_selection );

			document.getElementById("mo_pricing_adder").innerHTML = + sms_addion;

		}

	</script>

</div>
</div>
<div id="mo2fa_compare">
	<center>
	<div class=""><a href="#mo2f_more_details" onclick="mo2fa_show_details()"><button class="mo2fa_upgrade_my_plan mo2fa_compare1">Click here to Compare Features</button></a></div>
	<div><a href="#mo2f_more_details" onclick="mo2fa_show_details()"><button  style="display: none;" class="mo2fa_upgrade_my_plan mo2fa_compare1">Click here to Hide Comparison</button></a></div>
	</center>
</div>
<div id="mo_ns_features_only" style="display: none;">
	<div class="mo_wpns_upgrade_security_title" >
		<div class="mo_wpns_upgrade_page_title_name">
			<h1 style="margin-top: 0%;padding: 10% 0% 0% 0%; color: white;font-size: 200%;">
		WAF</h1><hr class="mo_wpns_upgrade_page_hr"></div>
		
	<div class="mo_wpns_upgrade_page_ns_background">
			<center>
			<h4 class="mo_wpns_upgrade_page_starting_price">Starting From</h4>
			<h1 class="mo_wpns_upgrade_pade_pricing">$50</h1>
			
				<?php echo mo2f_waf_yearly_standard_pricing(); ?>
				
				
			</center>
	
	<div style="text-align: center;">
	<?php	
	if(isset($is_customer_registered) && $is_customer_registered) {
			?>
	            <button
	                        class="button button-primary button-large mo_wpns_upgrade_page_button"
	                        onclick="mo2f_upgradeform('wp_security_waf_plan','2fa_plan')">Upgrade</button>
	        <?php }

			
	        else{ ?>
				<button
	                        class="button button-primary button-large mo_wpns_upgrade_page_button"
	                        onclick="mo2f_register_and_upgradeform('wp_security_waf_plan','2fa_plan')">Upgrade</button>
	        <?php } 
	        ?>
	</div>
			<div><center><b>
		<ul>
			<li>Realtime IP Blocking</li>
			<li>Live Traffic and Audit</li>
			<li>IP Blocking and Whitelisting</li>
			<li>OWASP TOP 10 Firewall Rules</li>
			<li>Standard Rate Limiting/ DOS Protection</li>
			<li><a onclick="wpns_pricing()">Know more</a></li>
		</ul>
		</b></center></div>
	</div>
	</div>
	<div class="mo_wpns_upgrade_page_space_in_div"></div>
	<div class="mo_wpns_upgrade_security_title" >
		<div class="mo_wpns_upgrade_page_title_name">
			<h1 style="margin-top: 0%;padding: 10% 0% 0% 0%; color: white;font-size: 200%;">
		Login and Spam</h1><hr class="mo_wpns_upgrade_page_hr"></div>
		
		<div class="mo_wpns_upgrade_page_ns_background">
			<center>
			<h4 class="mo_wpns_upgrade_page_starting_price">Starting From</h4>
			<h1 class="mo_wpns_upgrade_pade_pricing">$15</h1>
			
				<?php echo mo2f_login_yearly_standard_pricing(); ?>
				
				
			</center>
			
		<div style="text-align: center;">
		<?php if( isset($is_customer_registered)&& $is_customer_registered ) {
			?>
	            <button class="button button-primary button-large mo_wpns_upgrade_page_button"
	                        onclick="mo2f_upgradeform('wp_security_login_and_spam_plan','2fa_plan')">Upgrade</button>
	        <?php }else{ ?>

	           <button class="button button-primary button-large mo_wpns_upgrade_page_button"
	                    onclick="mo2f_register_and_upgradeform('wp_security_login_and_spam_plan','2fa_plan')">Upgrade</button>
	        <?php } 
	        ?>
		</div>
			<div><center><b>
				<ul>
					<li>Limit login Attempts</li>
					<li>CAPTCHA on login</li>
					<li>Blocking time period</li>
					<li>Enforce Strong Password</li>
					<li>SPAM Content and Comment Protection</li>
					<li><a onclick="wpns_pricing()">Know more</a></li>
				</ul>
			</b></center></div>
		</div>
		
		
	</div>
	<div class="mo_wpns_upgrade_page_space_in_div"></div>
	<div class="mo_wpns_upgrade_security_title" >
		<div class="mo_wpns_upgrade_page_title_name">
			<h1 style="margin-top: 0%;padding: 10% 0% 0% 0%; color: white;font-size: 200%;">
		Malware Scanner</h1><hr class="mo_wpns_upgrade_page_hr"></div>
		
			<div class="mo_wpns_upgrade_page_ns_background">
			<center>
			<h4 class="mo_wpns_upgrade_page_starting_price">Starting From</h4>
			<h1 class="mo_wpns_upgrade_pade_pricing">$15</h1>
			
				<?php echo mo2f_scanner_yearly_standard_pricing(); ?>
				
				
			</center>
			<div style="text-align: center;">
			<?php if( isset($is_customer_registered) && $is_customer_registered) {
			?>
                <button
                            class="button button-primary button-large mo_wpns_upgrade_page_button"
                            onclick="mo2f_upgradeform('wp_security_malware_plan','2fa_plan')">Upgrade</button>
            <?php }else{ ?>

               <button
                            class="button button-primary button-large mo_wpns_upgrade_page_button"
                            onclick="mo2f_register_and_upgradeform('wp_security_malware_plan','2fa_plan')">Upgrade</button>
            <?php } 
            ?>
		</div>
			<div><center><b>
				<ul>
					<li>Malware Detection</li>
					<li>Blacklisted Domains</li>
					<li>Action On Malicious Files</li>
					<li>Repository Version Comparison</li>
					<li>Detect any changes in the files</li>
					<li><a onclick="wpns_pricing()">Know more</a></li>
				</ul>
			</b></center></div>
	</div>
	</div>
	<div class="mo_wpns_upgrade_page_space_in_div"></div>
	<div class="mo_wpns_upgrade_security_title" >
		<div class="mo_wpns_upgrade_page_title_name">
			<h1 style="margin-top: 0%;padding: 10% 0% 0% 0%; color: white;font-size: 200%;">
		Encrypted Backup</h1><hr class="mo_wpns_upgrade_page_hr"></div>
		
	<div class="mo_wpns_upgrade_page_ns_background">

		<center>
			<h4 class="mo_wpns_upgrade_page_starting_price">Starting From</h4>
			<h1 class="mo_wpns_upgrade_pade_pricing">$30</h1>
			
				<?php echo mo2f_backup_yearly_standard_pricing(); ?>
				
				
			</center>
			<div style="text-align: center;">
	<?php	if( isset($is_customer_registered) && $is_customer_registered) {
		?>
            <button
                        class="button button-primary button-large mo_wpns_upgrade_page_button"
                        onclick="mo2f_upgradeform('wp_security_backup_plan','2fa_plan')">Upgrade</button>
        <?php }else{ ?>
			<button
                        class="button button-primary button-large mo_wpns_upgrade_page_button"
                        onclick="mo2f_register_and_upgradeform('wp_security_backup_plan' ,'2fa_plan')">Upgrade</button>
        <?php } 
        ?>
		
		</div>
			<div><center><b>
				<ul>
					<li>Schedule Backup</li>
					<li>Encrypted Backup</li>
					<li>Files/Database Backup</li>
					<li>Restore and Migration</li>
					<li>Password Protected Zip files</li>
					<li><a onclick="wpns_pricing()">Know more</a></li>
				</ul>
			</b></center></div>
	</div></div>
</div>
<center>
	<br>
	<div id="mo2f_more_details" style="display:none;">
<div class="mo2fa_table-scrollbar"></br></br>
<table class="table mo2fa_table_features table-striped">
	<caption class="mo2f_pricing_head_mo_2fa"><h1>Feature Details</h1></caption>
  <thead>
    <tr class="mo2fa_main_category_header" style="font-size: 20px;">
      <th scope="col">Features</th>
      <th scope="col" class="mo2fa_plugins"><center>Standard Lite</center></th>
      <th scope="col" class="mo2fa_plugins"><center>Premium Lite</center></th>
      <th scope="col" class="mo2fa_plugins"><center>Premium</center></th>
      <th scope="col" class="mo2fa_plugins"><center>Enterprise</center></th> 
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Unlimited Sites</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>      
    </tr>
   
    <tr>
     <th scope="row">Unlimited Users</th>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>

    </tr>
   <tr class="bg_category_main_mo_2fa">
     <th scope="row">Authentication Methods</th>
      <td></td>
      <td></td>
      <td></td>   
      <td></td>
    </tr>
    <tr>
     <th scope="row" class="category_feature_mo_2fa">Google Authenticator</th>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
    </tr>
    <tr>
     <th scope="row" class="category_feature_mo_2fa">Security Questions</th>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
    <tr>
    <th scope="row" class="category_feature_mo_2fa">TOTP Based Authenticator</th>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
    <tr>
    <th scope="row" class="category_feature_mo_2fa">Authy Authenticator</th>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr> 
   <tr>
    <th scope="row" class="category_feature_mo_2fa">Email Verification</th>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr> 
    <tr>
    <th scope="row" class="category_feature_mo_2fa">OTP Over Email (Email Charges apply)</th>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center style= "font-weight: bold;">Unlimited</center></td>
      <td><center style= "font-weight: bold;">Unlimited</center></td>
      <td><center><i class="fas fa-check"></i></center></td>


    </tr> 
    <tr>
    <th scope="row" class="category_feature_mo_2fa">OTP Over SMS (SMS Charges apply)</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>

   <tr>
    <th scope="row" class="category_feature_mo_2fa">miniOrange QR Code Authentication</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
    </tr>
     <tr>
    <th scope="row" class="category_feature_mo_2fa">miniOrange Soft Token</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
    </tr>
    <tr>
    <th scope="row" class="category_feature_mo_2fa">miniOrange Push Notification</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
    </tr>
    <tr>
    <th scope="row" class="category_feature_mo_2fa">OTP Over SMS and Email (SMS and Email Charges apply)</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
    <tr>
    <th scope="row" class="category_feature_mo_2fa">Hardware Token</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
    <tr>
    <th scope="row" class="category_feature_mo_2fa">OTP Over Whatsapp (Add-on)</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
    </tr>
    <tr>
    <th scope="row" class="category_feature_mo_2fa">OTP Over Telegram</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>  
      <td><center><i class="fas fa-check"></i></center></td>
    </tr>
     <tr class="bg_category_main_mo_2fa">
     <th scope="row">Backup Login Methods</th>
      <td></td>
      <td></td>   
      <td></td>   
      <td></td>   
    </tr>
    <tr>
    <th scope="row" class="category_feature_mo_2fa">Security Questions (KBA)</th>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
    </tr>
    <tr>
    <th scope="row" class="category_feature_mo_2fa">OTP Over Email</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
    </tr>
    <tr>
    <th scope="row" class="category_feature_mo_2fa">Backup Codes</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
    </tr>
    <tr class="bg_category_main_mo_2fa">
     <th scope="row">Password Policy</th>
      <td></td>
      <td></td>   
      <td></td>   
      <td></td>   

    </tr>
   <tr>
    <th scope="row" class="category_feature_mo_2fa">Passwordless Login</th>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
    </tr> 
    <tr>
    <th scope="row" class="category_feature_mo_2fa">Strong Password</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>

    </tr>
    <tr>
     <th scope="row">Custom Gateway</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
  <tr class="bg_category_main_mo_2fa">
     <th scope="row">Add-Ons</th>
      <td></td>
      <td></td>   
      <td></td>   
      <td></td>   

    </tr>
     <tr>
     <th scope="row" class="category_feature_mo_2fa">Remember Device Add-on</br><p class="description_mo_2fa">You can save your device using the Remember device addon and you will get a two-factor authentication </br>prompt to check your identity if you try to login from different devices.</p></th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
    </tr>
    <tr>
     <th scope="row" class="category_feature_mo_2fa">Personalization Add-on<p class="description_mo_2fa">You'll get many more customization options in Personalization, such as </br>ustom Email and SMS Template, Custom Login Popup, Custom Security Questions, and many more.</p></th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
    </tr>
     <tr>
     <th scope="row" class="category_feature_mo_2fa">Short Codes Add-on<p class="description_mo_2fa">Shortcode Add-ons mostly include Allow 2fa shortcode (you can use this this to add 2fa on any page), </br>Reconfigure 2fa add-on (you can use this add-on to reconfigure your 2fa if you have lost your 2fa verification ability), remember device shortcode.</p></th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
    </tr>
   <tr>
     <th scope="row" class="category_feature_mo_2fa">Session Management</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
    </tr><tr>
     <th scope="row" class="category_feature_mo_2fa">Page Restriction Add-On</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
    </tr><tr>
     <th scope="row" class="category_feature_mo_2fa">Attribute Based Redirection</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
    </tr>
    <th scope="row" class="category_feature_mo_2fa">SCIM-User Provisioning</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
    </tr>
 

    <tr class="bg_category_main_mo_2fa">
     <th scope="row">Advance Wordpress Login Settings</th>
      <td></td>
      <td></td>
      <td></td> 
      <td></td>   
  
    </tr>
     <tr>
     <th scope="row" class="category_feature_mo_2fa">Force Two Factor for Users</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
    </tr>
    <tr>
     <th scope="row" class="category_feature_mo_2fa">Role Based and User Based Authentication settings</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
    </tr>
    <tr>
     <th scope="row" class="category_feature_mo_2fa">Email Verififcation during Two-Factor Registration</th>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
<tr>
     <th scope="row" class="category_feature_mo_2fa">Custom Redirect URL</th>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr><tr>
     <th scope="row" class="category_feature_mo_2fa">Inline Registration</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr><tr>
     <th scope="row" class="category_feature_mo_2fa">Mobile Support</th>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr><tr>
     <th scope="row" class="category_feature_mo_2fa">Privacy Policy Settings</th>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr><tr>
     <th scope="row" class="category_feature_mo_2fa">XML-RPC </th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
     <tr class="bg_category_main_mo_2fa">
     <th scope="row">Advance Security Features</th>
      <td></td>
      <td></td>
      <td></td>
      <td></td>   
   
    </tr>
     <tr>
     <th scope="row" class="category_feature_mo_2fa">Brute Force Protection</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
    <tr>
     <th scope="row" class="category_feature_mo_2fa">IP Blocking </th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
     <tr>
     <th scope="row" class="category_feature_mo_2fa">Monitoring</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr> <tr>
     <th scope="row" class="category_feature_mo_2fa">File Protection</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
   <tr>
     <th scope="row" class="category_feature_mo_2fa">Country Blocking </th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
    <tr>
     <th scope="row" class="category_feature_mo_2fa">HTACCESS Level Blocking </th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
    <tr>
     <th scope="row" class="category_feature_mo_2fa">Browser Blocking </th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
   <tr>
     <th scope="row" class="category_feature_mo_2fa">Block Global Blacklisted Email Domains</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
 <tr>
     <th scope="row" class="category_feature_mo_2fa">Manual Block Email Domains</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
   <tr>
     <th scope="row" class="category_feature_mo_2fa">DB Backup</th>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
<tr>
     <th scope="row">Multi-Site Support</th>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
      <td><center><i class="fas fa-times mo2fa_hide"></i></center></td>
    </tr><tr>
     <th scope="row">Language Translation Support</th>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr><tr>
     <th scope="row">Get online support with GoTo/Zoom meeting</th>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>
      <td><center><i class="fas fa-check"></i></center></td>

    </tr>
  </tbody>
</table>
</div>
</div>
</center>
<div class="mo2f_table_layout" id="mo2f_info" style="width: 90%">
	<div>
		<h2><?php echo mo2f_lt('Steps to upgrade to the Premium Plan :');?></h2>
		<ol class="mo2f_licensing_plans_ol">
			<li><?php echo mo2f_lt( 'Click on <b>Proceed</b>/<b>Upgrade</b> button of your preferred plan above.' ); ?></li>
			<li><?php echo mo2f_lt( ' You will be redirected to the miniOrange Console. Enter your miniOrange username and password, after which you will be redirected to the payment page.' ); ?></li>

			<li><?php echo mo2f_lt( 'Select the number of users/sites you wish to upgrade for, and any add-ons if you wish to purchase, and make the payment.' ); ?></li>
			<li><?php echo mo2f_lt( 'After making the payment, you can find the Standard Lite/Premium Lite/Premium/Enterprise plugin to download from the <b>License</b> tab in the left navigation bar of the miniOrange Console.' ); ?></li>
			<li><?php echo mo2f_lt( 'Download the paid plugin from the <b>Releases and Downloads</b> tab through miniOrange Console .' ); ?></li>
			<li><?php echo mo2f_lt( 'Deactivate and delete the free plugin from <b>WordPress dashboard</b> and install the paid plugin downloaded.' ); ?></li>
			<li><?php echo mo2f_lt( 'Login to the paid plugin with the miniOrange account you used to make the payment, after this your users will be able to set up 2FA.' ); ?></li>
		</ol>
	</div>
	<hr>
	<div>
		<h2><?php echo mo2f_lt('Note :');?></h2>
		<ol class="mo2f_licensing_plans_ol">
			<li><?php echo mo2f_lt( 'The plugin works with many of the default custom login forms (like Woocommerce/Theme My Login/Login With Ajax/User Pro/Elementor), however if you face any issues with your custom login form, contact us and we will help you with it.' ); ?></li>
			<li><?php echo mo2f_lt( 'The <b>license key </b>is required to activate the <b>Standard Lite/Premium Lite/Premium</b> Plugins. You will have to login with the miniOrange Account you used to make the purchase then enter license key to activate plugin.' ); ?>

		</li>
	</ol>
</div>
<hr>
<br>
<div>
	<?php echo mo2f_lt( '<b class="mo2fa_note">Refund Policy : </b>At miniOrange, we want to ensure you are 100% happy with your purchase. If the premium plugin you purchased is not working as advertised and you\'ve attempted to resolve any issues with our support team, which couldn\'t get resolved then we will refund the whole amount within 10 days of the purchase. ' ); ?>
</div>
<br>
<hr>
<br>
<div><?php echo mo2f_lt( '<b class="mo2fa_note">SMS Charges : </b>If you wish to choose OTP Over SMS/OTP Over SMS and Email as your authentication method,
	SMS transaction prices & SMS delivery charges apply and they depend on country. SMS validity is for lifetime.' ); ?>
</div>
<br>
<hr>
<br>
<div>
		<?php echo mo2f_lt( '<b class="mo2fa_note">Multisite : </b>For your first license 3 subsites will be activated automatically on the same domain. And if you wish to use it for more please contact support ' ); ?>
</div>
<br>
<hr>
<br>
<div>
	<?php echo mo2f_lt( '<b class="mo2fa_note">Privacy Policy : </b><a		href="https://www.miniorange.com/2-factor-authentication-for-wordpress-gdpr">Click Here</a>
		to read our Privacy Policy.' ); ?>
</div>
<br>
<hr>
<br>
<div>
	<?php echo mo2f_lt( '<b class="mo2fa_note">Contact Us : </b>If you have any doubts regarding the licensing plans, you can mail us at <a		href="mailto:info@xecurify.com"><i>info@xecurify.com</i></a>
		or submit a query using the support form.' ); ?>
</div>
</div>
</center>
<div id="mo2f_payment_option" class="mo2f_table_layout" style="width: 90%; display: flex;">
	<div>
		<h3>Supported Payment Methods</h3><hr>
		<div class="mo_2fa_container">
			<div class="mo_2fa_card-deck">
				<div class="mo_2fa_card mo_2fa_animation">
					<div class="mo_2fa_Card-header">
						<?php 
						echo'<img src="'.dirname(plugin_dir_url(__FILE__)).'/includes/images/card.png" class="mo2fa_card">';?>
					</div>
					<hr class="mo2fa_hr">
					<div class="mo_2fa_card-body">
						<p class="mo2fa_payment_p">If payment is done through Credit Card/Intenational debit card, the license would be created automatically once payment is completed. </p>
						<p class="mo2fa_payment_p"><i><b>For guide 
							<?php echo'<a href='.MoWpnsConstants::FAQ_PAYMENT_URL.' target="blank">Click Here.</a>';?></b></i></p>

						</div>
					</div>
					<div class="mo_2fa_card mo_2fa_animation">
						<div class="mo_2fa_Card-header">
							<?php 
							echo'<img src="'.dirname(plugin_dir_url(__FILE__)).'/includes/images/paypal.png" class="mo2fa_card">';?>
						</div>
						<hr class="mo2fa_hr">
						<div class="mo_2fa_card-body">
							<?php echo'<p class="mo2fa_payment_p">Use the following PayPal id for payment via PayPal.</p><p><i><b style="color:#1261d8"><a href="mailto:'.MoWpnsConstants::SUPPORT_EMAIL.'">info@xecurify.com</a></b></i>';?>

						</div>
					</div>
					<div class="mo_2fa_card mo_2fa_animation">
						<div class="mo_2fa_Card-header">
							<?php 
							echo'<img src="'.dirname(plugin_dir_url(__FILE__)).'/includes/images/bank-transfer.png" class="mo2fa_card mo2fa_bank_transfer">';?>

						</div>
						<hr class="mo2fa_hr">
						<div class="mo_2fa_card-body">
							<?php echo'<p class="mo2fa_payment_p">If you want to use Bank Transfer for payment then contact us at <i><b style="color:#1261d8"><a href="mailto:'.MoWpnsConstants::SUPPORT_EMAIL.'">info@xecurify.com</a></b></i> so that we can provide you bank details. </i></p>';?>
						</div>
					</div>
				</div>
			</div>
			<div class="mo_2fa_mo-supportnote">
				<p class="mo2fa_payment_p"><b>Note :</b> Once you have paid through PayPal/Bank Transfer, please inform us at <i><b style="color:#1261d8"><a href="mailto:'.MoWpnsConstants::SUPPORT_EMAIL.'">info@xecurify.com</a></b></i>, so that we can confirm and update your License.</p> 
			</div>
		</div>
	</div>


	<?php
function mo2f_waf_yearly_standard_pricing() {
	?>
    <p class="mo2f_pricing_text mo_wpns_upgrade_page_starting_price"
       id="mo2f_yearly_sub"><?php echo __( 'Yearly subscription fees', 'miniorange-2-factor-authentication' ); ?><br>

	<select id="mo2f_yearly" class="form-control mo2fa_form_control1">
		<option> <?php echo mo2f_lt( '1 site - $50 per year' ); ?> </option>
		<option> <?php echo mo2f_lt( 'Upto 5 sites - $100 per year' ); ?> </option>
		<option> <?php echo mo2f_lt( 'Upto 10 sites - $150 per year' ); ?> </option>

	</select>
</p>

	<?php
}
function mo2f_login_yearly_standard_pricing() {
	?>
    <p class="mo2f_pricing_text mo_wpns_upgrade_page_starting_price"
       id="mo2f_yearly_sub"><?php echo __( 'Yearly subscription fees', 'miniorange-2-factor-authentication' ); ?><br>

	<select id="mo2f_yearly" class="form-control mo2fa_form_control1">
		<option> <?php echo mo2f_lt( '1 site - $15 per year' ); ?> </option>
		<option> <?php echo mo2f_lt( 'Upto 5 sites - $35 per year' ); ?> </option>
		<option> <?php echo mo2f_lt( 'Upto 10 sites - $60 per year' ); ?> </option>

	</select>
</p>

	<?php
}
function mo2f_backup_yearly_standard_pricing() {
	?>
    <p class="mo2f_pricing_text mo_wpns_upgrade_page_starting_price"
       id="mo2f_yearly_sub"><?php echo __( 'Yearly subscription fees', 'miniorange-2-factor-authentication' ); ?><br>

	<select id="mo2f_yearly" class="form-control mo2fa_form_control1">
		<option> <?php echo mo2f_lt( '1 site - $30 per year' ); ?> </option>
		<option> <?php echo mo2f_lt( 'Upto 5 sites - $50 per year' ); ?> </option>
		<option> <?php echo mo2f_lt( 'Upto 10 sites - $70 per year' ); ?> </option>

	</select>
</p>

	<?php
}
function mo2f_scanner_yearly_standard_pricing() {
	?>
    <p class="mo2f_pricing_text mo_wpns_upgrade_page_starting_price" 
       id="mo2f_yearly_sub"><?php echo __( 'Yearly subscription fees', 'miniorange-2-factor-authentication' ); ?><br>

	<select id="mo2f_yearly" class="form-control mo2fa_form_control1">
		<option> <?php echo mo2f_lt( '1 site - $15 per year' ); ?> </option>
		<option> <?php echo mo2f_lt( 'Upto 5 sites - $35 per year' ); ?> </option>
		<option> <?php echo mo2f_lt( 'Upto 10 sites - $60 per year' ); ?> </option>

	</select>
</p>

	<?php
}

function mo2f_get_binary_equivalent_2fa_lite( $mo2f_var ) {
	switch ( $mo2f_var ) {
		case 1:
			return "<div style='color: #2271b1;font-size: x-large;float:left;margin:0px 5px;'>ðŸ—¸</div>";
		case 0:
			return "<div style='color: red;font-size: x-large;float:left;margin:0px 5px;'>Ã—</div>";
		default:
			return $mo2f_var;
	}
}

function mo2f_feature_on_hover_2fa_upgrade( $mo2f_var ) {

	return '<div class="mo2f_tooltip" style="float: right;width: 6%;"><span class="dashicons dashicons-info mo2f_info_tab"></span><span class="mo2f_tooltiptext" style="margin-left:-232px;margin-top: 9px;">'. $mo2f_var .'</span></div>';
}

?>
<form class="mo2f_display_none_forms" id="mo2fa_loginform"
                  action="<?php echo MO_HOST_NAME . '/moas/login'; ?>"
                  target="_blank" method="post">
                <input type="email" name="username" value="<?php echo get_option( 'mo2f_email' ); ?>"/>
                <input type="text" name="redirectUrl"
                       value="<?php echo MO_HOST_NAME . '/moas/initializepayment'; ?>"/>
                <input type="text" name="requestOrigin" id="requestOrigin"/>
            </form>

            <form class="mo2f_display_none_forms" id="mo2fa_register_to_upgrade_form"
                   method="post">
                <input type="hidden" name="requestOrigin" />
                <input type="hidden" name="mo2fa_register_to_upgrade_nonce"
                       value="<?php echo wp_create_nonce( 'miniorange-2-factor-user-reg-to-upgrade-nonce' ); ?>"/>
            </form>
    <script type="text/javascript">

	var switcher = document.getElementById("mo2f_switcher"),
    unlimited_users = document.getElementById("mo2f_unlimited_users"),
    unlimited_sites = document.getElementById("mo2f_unlimited_sites"),
    premium_plan = document.getElementById("mo2f_premium_plan"),
    premium_lite_plan = document.getElementById("mo2f_premium_lite_plan"),
    standard_lite_plan = document.getElementById("mo2f_standard_lite_plan"),
    enterprise_plan = document.getElementById("mo2f_enterprise_plan");

switcher.addEventListener("click", function(){
  switcher.classList.toggle("mo2f_toggler--is-active");
  unlimited_users.classList.toggle("mo2f_toggler--is-active");
  unlimited_sites.classList.toggle("mo2f_toggler--is-active");
  standard_lite_plan.classList.toggle("mo2fa_hide");
  premium_lite_plan.classList.toggle("mo2fa_hide");
  premium_plan.classList.toggle("mo2fa_hide");
  enterprise_plan.classList.toggle("mo2fa_hide");
});

unlimited_users.addEventListener("click", function(){
  switcher.checked = false;
  unlimited_users.classList.add("mo2f_toggler--is-active");
  unlimited_sites.classList.remove("mo2f_toggler--is-active");
  standard_lite_plan.classList.remove("mo2fa_hide");
  premium_lite_plan.classList.remove("mo2fa_hide");
  premium_plan.classList.remove("mo2fa_hide");
  enterprise_plan.classList.add("mo2fa_hide");
});

unlimited_sites.addEventListener("click", function(){
  switcher.checked = true;
  unlimited_users.classList.remove("mo2f_toggler--is-active");
  unlimited_sites.classList.add("mo2f_toggler--is-active");
  standard_lite_plan.classList.add("mo2fa_hide");
  premium_lite_plan.classList.add("mo2fa_hide");
  premium_plan.classList.add("mo2fa_hide");
  enterprise_plan.classList.remove("mo2fa_hide");
});




		function mo2f_upgradeform(planType,planname) 
		{
            jQuery('#requestOrigin').val(planType);
            jQuery('#mo2fa_loginform').submit();
            var data =  {
								'action'				  : 'wpns_login_security',
								'wpns_loginsecurity_ajax' : 'update_plan', 
								'planname'				  : planname,
								'planType'				  : planType,
					}
					jQuery.post(ajaxurl, data, function(response) {
					});
        }
        function mo2f_register_and_upgradeform(planType, planname) 
        {
                    jQuery('#requestOrigin').val(planType);
                    jQuery('input[name="requestOrigin"]').val(planType);
                    jQuery('#mo2fa_register_to_upgrade_form').submit();

                    var data =  {
								'action'				  : 'wpns_login_security',
								'wpns_loginsecurity_ajax' : 'wpns_all_plans', 
								'planname'				  : planname,
						'planType'				  : planType,
					}
					jQuery.post(ajaxurl, data, function(response) {
					});
        }

    	function show_2fa_plans()
    	{
    		document.getElementById('mo2f_info').style.display = "block";
    		document.getElementById('mo_ns_features_only').style.display = "none";
    		document.getElementById('mo2f_twofa_plans').style.display = "flex";
    		document.getElementById('mo2f_plan_type').style.display = "block";
    		document.getElementById('mo_2fa_lite_licensing_plans_title').style.display = "none";
    		document.getElementById('mo_2fa_lite_licensing_plans_title1').style.display = "block";
    		document.getElementById('mo_ns_licensing_plans_title').style.display = "block";
    		document.getElementById('mo_ns_licensing_plans_title1').style.display = "none";
    		document.getElementById('mo2fa_compare').style.display = "block";
    	}
    	function mo_ns_show_plans()
    	{
    		document.getElementById('mo_ns_features_only').style.display = "block";
    		document.getElementById('mo2f_twofa_plans').style.display = "none";
    		document.getElementById('mo2f_plan_type').style.display = "none";
    		document.getElementById('mo2f_info').style.display = "none";
    		document.getElementById('mo2f_more_details').style.display = "none";
    		document.getElementById('mo_2fa_lite_licensing_plans_title').style.display = "block";
    		document.getElementById('mo_2fa_lite_licensing_plans_title1').style.display = "none";
    		document.getElementById('mo_ns_licensing_plans_title').style.display = "none";
    		document.getElementById('mo_ns_licensing_plans_title1').style.display = "block";
    		document.getElementById('mo2fa_compare').style.display = "none";
    	}

    	function wpns_pricing()
		{
			window.open("https://security.miniorange.com/pricing/");
		}

		function mo2fa_show_details()
		{
			jQuery('#mo2f_more_details').toggle();
			jQuery('.mo2fa_more_details_p1').toggle();
			jQuery('.mo2fa_more_details_p').toggle();
			jQuery('.mo2fa_compare1').toggle();
		}

    </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){




});
</script>