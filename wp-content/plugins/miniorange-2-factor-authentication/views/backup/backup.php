
<div class="nav-tab-wrapper">
	<button class="nav-tab" onclick="mo2f_wpns_openTabbackup(this)" id="mo2f_setting_backup">Manual Backup</button>
    <button class="nav-tab" onclick="mo2f_wpns_openTabbackup(this)" id="mo2f_schedule_view">Scheduled Backup</button>
    <button class="nav-tab" onclick="mo2f_wpns_openTabbackup(this)" id="mo2f_report_view">Report</button>
  
</div>

<div class="tabcontent" id="mo2f_setting_backup_div">
	<div class="mo_wpns_divided_layout">
		<table style="width: 100%;">
			<tr>
				<td style="width:100%;vertical-align:top;" id="configurationForm2">
					<?php include_once $mo2f_dirName . 'controllers'.DIRECTORY_SEPARATOR.'backup'.DIRECTORY_SEPARATOR.'backup_controller.php'; ?>
			</tr>
		</table>
	</div>
</div>
<div class="tabcontent" id="mo2f_schedule_view_div">
	<div class="mo_wpns_divided_layout">
		<table style="width: 100%;">
			<tr>
				<td style="width:100%;vertical-align:top;" id="configurationForm3">
					<?php include_once $mo2f_dirName . 'controllers'.DIRECTORY_SEPARATOR.'backup'.DIRECTORY_SEPARATOR.'backup_schdule.php'; ?>
			</tr>
		</table>
	</div>
</div>
<div class="tabcontent" id="mo2f_report_view_div">
	<div class="mo_wpns_divided_layout">
		<table style="width: 100%;">
			<tr>
				<td style="width:100%;vertical-align:top;" id="configurationForm4">
					<?php include_once $mo2f_dirName . 'controllers'.DIRECTORY_SEPARATOR.'backup'.DIRECTORY_SEPARATOR.'backup_created_report.php'; ?>
			</tr>
		</table>
	</div>
</div>

<script>
	jQuery('#backup_tab').addClass('nav-tab-active');
	
	function mo2f_wpns_openTabbackup(elmt){
		var tabname = elmt.id;
		var tabarray = ["mo2f_setting_backup","mo2f_schedule_view","mo2f_report_view"];
		for (var i = 0; i < tabarray.length; i++) {
			if(tabarray[i] == tabname){
				jQuery("#"+tabarray[i]).addClass("nav-tab-active");
				jQuery("#"+tabarray[i]+"_div").css("display", "block");
			}else{
				jQuery("#"+tabarray[i]).removeClass("nav-tab-active");
				jQuery("#"+tabarray[i]+"_div").css("display", "none");
			}
		}
		
		localStorage.setItem("backup_last_tab", tabname);
	}	

	var tab = localStorage.getItem("backup_last_tab"); 

	if(tab)
		document.getElementById(tab).click();
	else{
		document.getElementById("mo2f_setting_backup").click();
	}
</script>