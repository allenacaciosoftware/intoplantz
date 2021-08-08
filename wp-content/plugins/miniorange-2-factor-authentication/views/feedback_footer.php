<?php
global $mo2f_dirName;
require_once $mo2f_dirName . DIRECTORY_SEPARATOR.'includes'. DIRECTORY_SEPARATOR.'lib'. DIRECTORY_SEPARATOR.'mo-2fa-options-enum.php';

$zones = mo_2fa_time_zones::$time_zones;


echo'  <div class="mo_twofa_footer"> 
  <div class="mo-2fa-mail-button">
  <img id= "mo_wpns_support_layout_tour" src="'.dirname(plugin_dir_url(__FILE__)).'/includes/images/mo_support_icon.png" class="show_support_form"  onclick="openForm()">
  </div>
  <button type="button" class="mo-2fa-help-button-text" onclick="openForm()"">24x7 Support<br>Need Help? Drop us an Email</button>
  </div>';
?>


<div id="feedback_form_bg" > 
<div class="mo2f-chat-popup" id="myForm" style="display:none; width: 100%;padding: 1%; padding-top: 50%;background-color: rgba(0,0,0,0.61);">
  
  <div id ='mo_wpns_support_layout_tour_open' style="background-color: white;min-height: 370px;width: 45%; text-align: right;float: right;border-radius: 8px;">
    <div style="min-height: 600px;background-image: linear-gradient(to bottom right, #dffffd, #8feeea);width: 43%;float: left;padding: 10px; border-bottom-left-radius: 8px;border-top-left-radius: 8px;">
          <center>
            <?php
            echo '
              <img src="'.dirname(plugin_dir_url(__FILE__)).'/includes/images/minirange-logo.png" style="width: 46%;">';
            ?>
        <h1 style="  font-family: 'Roboto',sans-serif !important;">Contact Information</h1>
      </center><br>
      <div style="text-align: left;padding: 3%;">
      <form name="f" method="post" action="" id="mo_wpns_query_form_close" >
          <table>
              <tr>
                  <td>
                      <span class="dashicons dashicons-email"></span>
                  </td>
                  <td><h3>2fasupport@xecurify.com</h3>
                  </td>
              </tr>
              <tr>
                  <td>
                      <span class="dashicons dashicons-email"></span>
                  </td>
                  <td><h3>info@xecurify.com</h3>
                  </td>
              </tr>
              <tr>
                  <td>
                      <span class="dashicons dashicons-admin-site-alt3"></span>
                  </td>
                  <td><h3><a href="https://miniorange.com/" target="_blank"> www.miniorange.com</a></h3>
                  </td>
              </tr>
              <tr>
                  <td>

                  </td>
              </tr>

          </table>
          <?php

            echo'
          <div class="call-setup-div">
          <h3 style="margin-top: 0px; margin-left: 5px;">Setup a Screen-share session</h3>
          <label class="switch">
              <input type="checkbox" id="2fa_setup_call" name="2fa_setup_call">
              <span class="slider round"></span>
          </label>
          <span style="padding-left:5px; font-size: 15px;">
              <br>
              <b style="padding: 10px;"><label for="2fa_setup_call"></label>Enable this option to setup a call</b>
          </span>
          <br>
          <div id="call_setup_dets" style="text-align:center; margin-left: 5px; margin-top: 15px;">
              <div>
                  <div style="width: 100% !important; ">
                      <select id="js-timezone" name="mo_2fa_setup_call_timezone" style="width:93%;">
                            <option value="" selected disabled>--Select your Timezone--</option>';

                foreach($zones as $zone=>$value) {
                    echo '<option value="'.$value.'">'. $zone.' </option>';
                }

                                                echo'
                            
                      </select>
                  </div>
              </div>
              <br>
              <div style="width: 100%; position: relative;">
                 <input type="text" id="datepicker" class="mo_2fa_table_textbox" placeholder="Select Date" autocomplete="off" name="mo_2fa_setup_call_date">
              </div>
              <br>
              <div style="width: 100%; position: relative; z-index:999">
                  <input type="text" id="timepicker" placeholder="Select Time" class="mo_2fa_table_textbox" autocomplete="off" name="mo_2fa_setup_call_time">
              </div>
              <br><br><br>
              <div>
                  <p style="margin-right: 20px; margin-bottom: 10px; margin-top: 15px; margin-left: 5px;">
                      <b><font color="#dc143c">Please verify the email before submitting your query.</font></b>
                  </p>
              </div>
          </div>
      </div>';
          

          ?>

      </div>
  </div>
  <div class="mo2f-form-container">
      <span class="mo2f_rating_close" onclick="closeForm()">×</span>
    <h1 style="text-align: center;    font-family: 'Roboto',sans-serif !important;">24/7 Support</h1>
      

    
    <div style="width: 100%;">
                   <div id="low_rating" style="display: block; width: 100%;">
                    <div style=" float: left;">
                        <?php
                        echo '
                        <table class="mo2f_new_support_form_table">
                        <tr><td>
                          <input type="email" class="mo2f_new_support_form_input" id="query_email" name="query_email"  value="'.$email.'" placeholder="Enter your email" required />
                          </td>
                        </tr>
                        <tr><td>
                          <input type="text" class="mo2f_new_support_form_input" name="query_phone" id="query_phone" value="'.$phone.'" placeholder="Enter your Phone number"/>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <textarea id="query" name="query" class="mo2f_new_support_form_input" style="border-radius:25px ; border: 1px solid gray; resize: none;width:100%;" cols="52" rows="9"  onkeyup="mo_wpns_valid(this)" onblur="mo_wpns_valid(this)" onkeypress="mo_wpns_valid(this)" placeholder="Write your query here"></textarea>
                          </td>
                        </tr>
                        <tr>
                        <td colspan="2" style="text-align: center">
                        <div>
                        <input type="hidden" name="mo_2fa_plugin_configuration" value="mo2f_send_plugin_configuration"/>
                            
                            <input type="checkbox" id="mo2f_send_configuration"
                                   name="mo2f_send_configuration"
                                   value="1" checked/>
                                   <p>Send plugin Configuration</p>
                        </div>
                        
                        </td> </tr>
                      </table>
                        ';
                        ?>

                        <div id="send_button" style="display: block; text-align: center;">
                        <input type="button" name="miniorange_skip_feedback"
                               class="button button-primary button-large" value="Send" onclick="document.getElementById('mo_wpns_query_form_close').submit();"/>
                    </div>
                   
                    </div>
                    
                    </div>

    </div>
                <input type="hidden" name="option" value="mo_wpns_send_query"/>
          
    </form></td>
        </tr>
        </tbody>
        </table>

       
  </div>

</div>
</div>
</div>

<script>
    function moSharingSizeValidate(e){
        var t=parseInt(e.value.trim());t>60?e.value=60:10>t&&(e.value=10)
    }
    function moSharingSpaceValidate(e){
        var t=parseInt(e.value.trim());t>50?e.value=50:0>t&&(e.value=0)
    }
    function moLoginSizeValidate(e){
        var t=parseInt(e.value.trim());t>60?e.value=60:20>t&&(e.value=20)
    }
    function moLoginSpaceValidate(e){
        var t=parseInt(e.value.trim());t>60?e.value=60:0>t&&(e.value=0)
    }
    function moLoginWidthValidate(e){
        var t=parseInt(e.value.trim());t>1000?e.value=1000:140>t&&(e.value=140)
    }
    function moLoginHeightValidate(e){
        var t=parseInt(e.value.trim());t>50?e.value=50:35>t&&(e.value=35)
    }
    var min_time = "00:00";

    jQuery( function() {

        jQuery("#call_setup_dets").hide();
        jQuery("#2fa_setup_call").click(function() {
            if(jQuery(this).is(":checked")) {
                jQuery("#call_setup_dets").show();
                document.getElementById("js-timezone").required = true;
                document.getElementById("datepicker").required = true;
                document.getElementById("timepicker").required = true;
                document.getElementById("query").required = false;

                var date = new Date();
                var hrs = date.getHours();
                var mins = date.getMinutes();
                if(hrs == 23 && mins > 30){
                    jQuery("#datepicker").datepicker("option", "minDate", 1);
                    jQuery("#datepicker").datepicker("setDate", +1);
                    jQuery("#timepicker").timepicker("option", "minTime", "00:00");
                } else{
                    jQuery("#datepicker").datepicker("option", "minDate", 0);
                    jQuery("#datepicker").datepicker("setDate", new Date());
                }
            } else {
                jQuery("#call_setup_dets").hide();
                document.getElementById("timepicker").required = false;
                document.getElementById("datepicker").required = false;
                document.getElementById("js-timezone").required = false;
                document.getElementById("query").required = true;
            }
        });

        jQuery( "#datepicker" ).datepicker({
            minDate: 0,
            dateFormat: "M dd, yy"
        });


        jQuery("#datepicker").datepicker().on("change", function (ev) {
            var sel_date = jQuery(this).val();
            var selected_date = new Date(sel_date);
            var today_date = new Date();

            if( (selected_date.getDate() == today_date.getDate()) && (selected_date.getMonth() == today_date.getMonth()) ){
                jQuery("#timepicker").timepicker("option", "minTime", new Date());
            }
            else{
                jQuery("#timepicker").timepicker("option", "minTime", "00:00");
            }
        });

        jQuery("#timepicker").timepicker({
            timeFormat: "HH:mm",
            interval: 30,
            minTime: new Date(),
            disableTextInput: true,
            dynamic: false,
            dropdown: true,
            scrollbar: true,
            forceRoundTime: true
        });
    });

    jQuery(function() { jQuery("#js-timezone").select2(); });
function openForm() {
  document.getElementById("myForm").style.display = "block";
  document.getElementById("feedback_form_bg").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
  document.getElementById("feedback_form_bg").style.display = "none";

}
</script>