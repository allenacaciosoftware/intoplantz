<?php
global $mo2f_dirName;
$security_features_nonce = wp_create_nonce('mo_2fa_security_features_nonce');

	$user = wp_get_current_user();
	$userID = wp_get_current_user()->ID;
	$onprem_admin = get_option('mo2f_onprem_admin');
	$roles = ( array ) $user->roles;
	$is_onprem = MO2F_IS_ONPREM;
        $flag  = 0;
  		foreach ( $roles as $role ) {
            if(get_option('mo2fa_'.$role)=='1')
            	$flag=1;
        }
	if(!$safe)
	{
		if (MoWpnsUtility::get_mo2f_db_option('mo_wpns_2fa_with_network_security', 'site_option')) 
		{
			echo MoWpnsMessages::showMessage('WHITELIST_SELF');		
		}
	}
	
	if((!get_user_meta($userID, 'mo_backup_code_generated', true) || ($backup_codes_remaining == 5 && !get_user_meta($userID, 'mo_backup_code_downloaded', true))) && $mo2f_two_fa_method != '' && !get_user_meta($userID, 'donot_show_backup_code_notice', true)){
		echo MoWpnsMessages::showMessage('GET_BACKUP_CODES');
	}
?>
<br><br>
<?php
if( isset( $_GET[ 'page' ]) && $_GET['page'] != 'mo_2fa_upgrade') 
	{	
			echo'<div class="wrap">';

				$date1 = "2022-01-10";
				$dateTimestamp1 = strtotime($date1);

				$date2 = date("Y-m-d");
				$dateTimestamp2 = strtotime($date2);

				if($dateTimestamp2<=$dateTimestamp1 && ($userID == $onprem_admin) && !get_site_option("mo2f_banner_never_show_again"))
				{
					echo'<div class="mo2f_offer_main_div">

					

					<div class="mo2f_offer_first_section">
                        <p class="mo2f_offer_christmas">CHRISTMAS</p>
                        <h3 class= "mo2fa_hr_line"><span>&</span></h3>
                        <p class="mo2f_offer_cyber">NEW YEAR&nbsp;<spn style="color:white;">SALE</span></p>
                    </div>

					<div class="mo2f_offer_middle_section">
						<p class="mo2f_offer_get_upto"><span style="font-size: 30px;">GET UPTO <span style="color: white;font-size: larger; font-weight:bold">50%</span> OFF ON PREMIUM PLUGINS</p><br>
						<p class="mo2f_offer_valid">Offer valid for limited period only!</p>
					</div>

					<div id="mo2f_offer_last_section" class="mo2f_offer_last_section"><button class="mo2f_banner_never_show_again mo2f_close">CLOSE <span class=" mo2f_cross">X</span></button><a class="mo2f_offer_contact_us" href="'.$request_offer_url.'">Contact Us</a></p></div>

					</div><br><br>';
				}
				echo' <div><img width="50" height="50" style="float:left;margin-top:5px;" src="'.$logo_url.'"></div>
				<h1>';
				if(current_user_can('administrator')){
					echo'
						<a class="add-new-h2" style="font-size:17px;"  href="'.$profile_url.'">My Account</a>
						<a class="add-new-h2" style="font-size:17px;" href="'.$help_url.'">FAQs</a>
						<a class="add-new-h2" style="font-size:17px;background-color:orange; color:black;" href="'.$addons_url.'">AddOns Plans</a>
						<a class="add-new-h2" id ="mo_2fa_upgrade_tour" style="font-size:17px;;background-color:orange; color:black;" href="'.$upgrade_url.'">See Plans and Pricing</a>';
					echo'	<span style="text-align:right;"> 

					<form id="mo_wpns_2fa_with_network_security" method="post" action="" style="margin-top: -2%; width: 30%; text-align: right; padding-left: 70%;">
					<input type="hidden" name="mo_security_features_nonce" value="'.$security_features_nonce.'"/>

						<input type="hidden" name="option" value="mo_wpns_2fa_with_network_security">
						<div><br><i>2FA + Website Security</i><span>
						<label class="mo_wpns_switch">
						<input type="checkbox" name="mo_wpns_2fa_with_network_security" '.$network_security_features.'  onchange="document.getElementById(\'mo_wpns_2fa_with_network_security\').submit();"> 
						<span class="mo_wpns_slider mo_wpns_round"></span>
						</label></span>
						</div>
						
						</form>
						</span>';
					}
					
					
					echo '<div id = "wpns_nav_message"></div>';
				echo'</h1>			
		</div>';
?>


		<?php 
		if(MoWpnsUtility::get_mo2f_db_option('mo_wpns_2fa_with_network_security', 'get_option')){ ?>
			<?php if($_GET['page'] != 'mo_2fa_troubleshooting' && $_GET['page'] != 'mo_2fa_addons' && $_GET['page'] != 'mo_2fa_account'){ ?>
				<div class="nav-tab-wrapper">
					<?php
								echo '<a id="mo_2fa_dashboard"  class="nav-tab" href="'.$dashboard_url.'" >Dashboard</a>';
								
								echo '<a id="mo_2fa_2fa" class="nav-tab" href="'.$two_fa.'" >Two Factor</a>';	
						
								echo '<a id="mo_2fa_waf" class="nav-tab"  href="'.$waf.'" >Firewall</a>';
				
								echo '<a id="login_spam_tab" class="nav-tab"  href="'.$login_and_spam.'" >Login and Spam</a>';
							
								echo '<a id="backup_tab" class="nav-tab"  href="'.$backup.'" >Encrypted Backup</a>';
							
								echo '<a id="malware_tab" class="nav-tab"  href="'.$scan_url.'">Malware Scan</a>';
							
								echo '<a id="adv_block_tab" class="nav-tab"  href="'.$advance_block.'">IP Blocking</a>';
						?>
				</div>
<?php 
		}
	}
}
?>

