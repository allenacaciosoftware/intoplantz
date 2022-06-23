<?php
 ?>
<div class="mo_wpns_divided_layout mo2f_trial_box">
	<div class="mo_wpns_setting_layout" style="width: 110% !important;">
		<h3> Trial Request Form : <div style="float: right;">
			<?php
			echo '<a class="mo_wpns_button mo_wpns_button1 mo2f_offer_contact_us_button" href="'.$two_fa.'">Back</a>';
			?>
		</div></h3>
		<form method="post">
			<input type="hidden" name="option" value="mo2f_trial_request_form" />
			<input type="hidden" name="nonce" value="<?php echo wp_create_nonce('mo2f_trial-nonce')?>">
			<table cellpadding="4" cellspacing="4">
				<tr>
					<td><strong>Email ID : </strong></td>
					<td><input required type="email" name="mo2f_trial_email" style="width: 100%;" value="<?php echo get_option('mo2f_email');?>" placeholder="Email id"  /></td>
				</tr>
				<tr>
					<td><strong>Phone No. : </strong></td>
					<td><input required type="tel" name="mo2f_trial_phone" style="width: 100%;"  id= "mo2f_phone" value="<?php echo $user_phone; ?>" /></td>
				</tr>
				<tr>
					<td valign=top ><strong>Request a Trial for : </strong></td>
					<td>
							<p style = "margin-top:0px">
							    <input type= 'radio' name= 'mo2f_trial_plan' value="All Inclusive" required >All Inclusive (Unlimited Users + Advanced Features)<br>
							</p>
							<p><input type= 'radio' name= 'mo2f_trial_plan' value="Enterprise" required >Enterprise(Unlimited sites)<br></p>
							<p><input type= 'radio' name= 'mo2f_trial_plan' value="notSure" required >I am confused!!<br></p>
                            <a href="<?php echo $upgrade_url; ?>" target="_blank">Checkout our Plans</a>

					</td>
				</tr>
			</table>
			<div style="padding-top: 10px;">
			     <p ><b><i>NOTE: You will receive an email with your trial license key that allows you to use the premium plugin for 7 days. If you choose to purchase the plugin, you can use the license key you receive to convert the trial version into the fully functional version.
                                         You will not need to reinstall the plugin after you purchase a license.</i></b></p>
				    <input type="submit" name="submit" value="Submit Trial Request" class="mo2f_trial_submit_button"/>

			</div>
		</form>		
	</div>
</div>
<script>
    jQuery("#mo2f_phone").intlTelInput();

    jQuery(document).ready(function(){
        var mo2f_trial_query_sent = "<?php echo get_site_option('mo2f_trial_query_sent') ?>"
        if(mo2f_trial_query_sent == 1){
            jQuery(':input[type="submit"]').prop('disabled', true);
            jQuery(':input[type="submit"]').attr('title','You have already sent a trial request for premium plugin. We will get back to you on your email soon.' );
            jQuery(':input[type="submit"]').css('color', 'white');
            jQuery(':input[type="submit"]').css('box-shadow', 'none');
        }
    });
</script>
