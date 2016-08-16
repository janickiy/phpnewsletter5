<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="./templates/assets/styles/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="./templates/assets/styles/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="./templates/assets/styles/styles.css" rel="stylesheet" media="screen">
<link href="./templates/assets/styles/DT_bootstrap.css" rel="stylesheet" media="screen">
<link type="text/css" href="./templates/assets/styles/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<link href="./templates/assets/styles/css/font-awesome.min.css" rel="stylesheet">
<title>PHP Newsletter | ${TITLE_PAGE}</title>
<script type="text/javascript" src="./templates/js/jquery.min.js"></script>
<script type="text/javascript" src="./templates/js/jquery.hide_alertblock.js"></script>
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
<div class="container-fluid">
<div class="row-fluid">
<div class="span3" id="sidebar"> <span class="logo"></span> <span class="version">${SCRIPT_VERSION}</span>
  <div id="mailing_status">
    <!-- IF '${MAILING_STATUS}' == 'start' -->
    <span title="${STR_LAUNCHEDMAILING}" id="startmailing" class="startmailing"></span>
    <!-- ELSE -->
    <span title="${STR_STOPMAILING}" class="stopmailing"></span>
    <!-- END IF -->
  </div>
  <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
    <li <!-- IF '${ACTIVE_MENU}' == '' -->class="active"<!-- END IF -->><a href="./" title="${MENU_TEMPLATES_TITLE}"><i class="fa fa-envelope"></i> ${MENU_TEMPLATES}</a></li>
	<!-- IF '${MENU_CREATE_TEMPLATE_ITEM}' == 'show' --><li <!-- IF '${ACTIVE_MENU}' == 'create_template' -->class="active"<!-- END IF -->><a href="./?t=create_template" title="${MENU_CREATE_NEW_TEMPLATE_TITLE}"><i class="fa fa-plus"></i> ${MENU_CREATE_NEW_TEMPLATE}</a><span class="menu-create-tmpl-icon"></span></li><!-- END IF -->
    <li <!-- IF '${ACTIVE_MENU}' == 'subscribers' -->class="active"<!-- END IF -->><a href="./?t=subscribers" title="${MENU_SUBSCRIBERS_TITLE}"><i class="fa fa-users"></i> ${MENU_SUBSCRIBERS}</a></li>
	<!-- IF '${MENU_CATEGORY_ITEM}' == 'show' --><li <!-- IF '${ACTIVE_MENU}' == 'category' -->class="active"<!-- END IF -->><a href="./?t=category" title="${MENU_CATEGORY_TITLE}"><i class="fa fa-list"></i> ${MENU_CATEGORY}</a></li><!-- END IF -->
    <li <!-- IF '${ACTIVE_MENU}' == 'log' -->class="active"<!-- END IF -->><a href="./?t=log" title="${MENU_LOG_TITLE}"><i class="fa fa-area-chart"></i> ${MENU_LOG}</a></li>
	<!-- IF '${MENU_SETTINGS_ITEM}' == 'show' --><li <!-- IF '${ACTIVE_MENU}' == 'settings' -->class="active"<!-- END IF -->><a href="./?t=settings" title="${MENU_SETTINGS_TITLE}"><i class="fa fa-gear"></i> ${MENU_SETTINGS}</a></li><!-- END IF -->
	<!-- IF '${MENU_ACCOUNTS_ITEM}' == 'show' --><li <!-- IF '${ACTIVE_MENU}' == 'accounts' -->class="active"<!-- END IF -->><a href="./?t=accounts" title="${MENU_ACCOUNTS_TITLE}"><i class="fa fa-key"></i> ${MENU_ACCOUNTS}</a></li><!-- END IF -->
	<!-- IF '${MENU_UPDATE_ITEM}' == 'show' --><li <!-- IF '${ACTIVE_MENU}' == 'update' -->class="active"<!-- END IF -->><a href="./?t=update" title="${MENU_UPDATE_TITLE}"><i class="fa fa-refresh"></i> ${MENU_UPDATE}</a> </li><!-- END IF -->
    <li <!-- IF '${ACTIVE_MENU}' == 'faq' -->class="active"<!-- END IF -->><a href="./?t=faq" title="FAQ"><i class="fa fa-question-circle"></i> FAQ</a></li>
  </ul>
</div>
<div class="span9" id="content">
<div class="row"><p class="text-right">${ACCOUNT_LOGIN} <a href="./?t=logout">${STR_LOGOUT}</a></p></div>
<div class="row-fluid">
  <div class="alert alert-error alert-block" id="alert_error_block" style="display:none; position: relative; z-index: 1000;"> <a class="close" href="#" data-dismiss="alert">×</a>
    <h4 class="alert-heading">${STR_ERROR}!</h4>
    <span id="alert_error_msg">${PAGE_ALERT_ERROR_MSG}</span> </div>
  <div class="alert alert-block" id="alert_msg_block" style="display:none; position: relative; z-index: 1000;"> <a class="close" href="#" data-dismiss="alert">×</a>
    <h4 class="alert-heading">${STR_WARNING}!</h4>
    <span id="alert_warning_msg">${PAGE_ALERT_WARNING_MSG}</span> </div>
</div>
<div class="row-fluid">
<!-- block -->
<div class="block">
<div class="navbar navbar-inner block-header">
  <div class="muted pull-left"><strong>${TITLE}</strong></div>
</div>
<div class="block-content collapse in">
<div class="span12">