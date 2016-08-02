<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>PHP Newsletter | ${TITLE_PAGE}</title>
<link rel="stylesheet" href="./templates/themes/dark/css/font-awesome.min.css">
<link rel="stylesheet" href="./templates/themes/dark/css/bootstrap.min.css">
<link rel="stylesheet" href="./templates/themes/dark/css/fonts.css">
<link rel="stylesheet" href="./templates/themes/dark/css/soft-admin.css"/>
<link type="text/css" href="./templates/themes/dark/css/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<link type="text/css" rel="stylesheet" href="./templates/themes/dark/css/icheck.css?v=1.0.1">
<link href="./templates/themes/default/styles/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="./templates/themes/dark/css/soft-theme-dark.css"/>
<link rel="stylesheet" href="./templates/themes/dark/css/styles.css">
<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/jquery.hide_alertblock.js"></script>
<link href="./templates/themes/dark/styles/DT_bootstrap.css" rel="stylesheet" media="screen">
</head>
<body>
<script type="text/javascript">
	$(document).ready(function(){  
		$.ajax({
			type: "GET",
			url: "./?t=alert_update",
			dataType: "xml",
			success: function(xml){
				$(xml).find("document").each(function () {
					$('#alert_msg_block').fadeIn('700');
					$("#alert_warning_msg").append($(this).find("warning").text());
				});
			}
		});
		
		$.ajax({
			type: "GET",
			url: "./?t=check_licensekey",
			dataType: "xml",
			success: function(xml){
				$(xml).find("document").each(function () {
				var result = $(this).find("result").text();				
					if(result == 'no'){
						$('#alert_error_block').fadeIn('700');
						$("#alert_error_msg").append($(this).find("error_msg").text());
					}
				});
			}
		});
		
		setInterval(function() {
			$.ajax({
				type: "GET",
				url: "./?t=xmldaemonstat",
				dataType: "xml",
				success: function(xml){
					$(xml).find("document").each(function () {
						if($(this).find("status").text() == 'start'){ 
							$("#mailing_status").html('<span title="${STR_LAUNCHEDMAILING}" id="startmailing" class="startmailing"></span>');
						}
						else {
							$("#mailing_status").html('<span title="${STR_STOPMAILING}" class="stopmailing"></span>');
						}			
					});
				}
			});
		}, 5000);
		
		 $('.startmailing').live('click', stopMailing);
	});
		
	
	function stopMailing ()
	{
		$.ajax({
			type: "GET",
			url: "./?t=process&status=stop",
			success: function(data){
				$("#mailing_status").html('<span title="${STR_STOPMAILING}" class="stopmailing"></span>');
			}
		});
	}	

</script>
<div class="cntnr">
<div class="left hidden-xs">
  <div class="logo">
  <span class="logo_pic"></span>
  <span class="version">${SCRIPT_VERSION}</span>
  <div id="mailing_status">
    <!-- IF '${MAILING_STATUS}' == 'start' -->
    <span title="${STR_LAUNCHEDMAILING}" id="startmailing" class="startmailing"></span>
    <!-- ELSE -->
    <span title="${STR_STOPMAILING}" class="stopmailing"></span>
    <!-- END IF -->
  </div>
  </div>
  <div class="sidebar">
    <div class="accordion">
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="sbtn btn-default<!-- IF '${ACTIVE_MENU}' == '' --> active<!-- END IF -->" title="${MENU_TEMPLATES_TITLE}" href="./"> <i class="fa fa-envelope"></i>&nbsp;${MENU_TEMPLATES} </a> </div>
      </div>
    </div>
    <div class="accordion">
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="sbtn btn-default<!-- IF '${ACTIVE_MENU}' == 'create_template' -->  active<!-- END IF -->" title="${MENU_CREATE_NEW_TEMPLATE_TITLE}" href="./?t=create_template"> <i class="fa fa-plus"></i>&nbsp;${MENU_CREATE_NEW_TEMPLATE} </a> </div>
      </div>
    </div>
    <div class="accordion">
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="sbtn btn-default<!-- IF '${ACTIVE_MENU}' == 'subscribers' -->  active<!-- END IF -->" href="./?t=subscribers" title="${MENU_SUBSCRIBERS_TITLE}"> <i class="fa fa-users"></i>&nbsp;${MENU_SUBSCRIBERS} </a> </div>
      </div>
    </div>
    <div class="accordion">
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="sbtn btn-default<!-- IF '${ACTIVE_MENU}' == 'category' -->  active<!-- END IF -->" href="./?t=category" title="${MENU_CATEGORY_TITLE}"> <i class="fa fa-list"></i>&nbsp;${MENU_CATEGORY} </a> </div>
      </div>
    </div>
    <div class="accordion">
      <div class="accordion-group">
        <div class="accordion-heading"> <a class="sbtn btn-default<!-- IF '${ACTIVE_MENU}' == 'log' -->  active<!-- END IF -->" href="./?t=log" title="${MENU_LOG_TITLE}"> <i class="fa fa-area-chart"></i>&nbsp;${MENU_LOG} </a> </div>
      </div>
      <div class="accordion">
        <div class="accordion-group">
          <div class="accordion-heading"> <a class="sbtn btn-default<!-- IF '${ACTIVE_MENU}' == 'settings' -->  active<!-- END IF -->" href="./?t=settings" title="${MENU_SETTINGS_TITLE}"> <i class="fa fa-gear"></i>&nbsp;${MENU_SETTINGS} </a> </div>
        </div>
      </div>
      <div class="accordion">
        <div class="accordion-group">
          <div class="accordion-heading"> <a class="sbtn btn-default<!-- IF '${ACTIVE_MENU}' == 'security' -->  active<!-- END IF -->" href="./?t=security" title="${MENU_SECURITY_TITLE}"> <i class="fa fa-key"></i>&nbsp;${MENU_SECURITY} </a> </div>
        </div>
      </div>
      <div class="accordion">
        <div class="accordion-group">
          <div class="accordion-heading"> <a class="sbtn btn-default<!-- IF '${ACTIVE_MENU}' == 'update' -->  active<!-- END IF -->" href="./?t=update" title="${MENU_UPDATE_TITLE}"> <i class="fa fa-refresh"></i>&nbsp;${MENU_UPDATE} </a> </div>
        </div>
      </div>
      <div class="accordion">
        <div class="accordion-group">
          <div class="accordion-heading"> <a class="sbtn btn-default<!-- IF '${ACTIVE_MENU}' == 'faq' -->  active
		<!-- END IF -->" href="./?t=faq" title="FAQ"><i class="fa fa-question-circle"></i>&nbsp;FAQ </a> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="right">
<div class="nav">
  <div class="bar">
    <div class="hov">
      <p class="text-center"><a href="./?t=logout">${STR_LOGOUT}</a></p>
    </div>
  </div>
</div>
<div class="content">
<div class="tbl">
<div class="page-h1">
  <h1> ${TITLE} </h1>
</div>
<div class="col-md-12">
<div class="wdgt" id="content">
  <div class="alert alert-warning" style="display:none;" id="alert_msg_block"> 
 
 
  <a class="close" href="#" data-dismiss="alert">×</a>
  
    <h4 class="alert-heading">${STR_WARNING}!</h4>
	<span class="icon icon-warning-sign"></span>
    <span id="alert_warning_msg">${PAGE_ALERT_WARNING_MSG}</span> </div>
</div>