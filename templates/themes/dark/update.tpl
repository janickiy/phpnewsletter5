<!-- INCLUDE header.tpl -->
<!-- IF '${INFO_ALERT}' != '' -->
<div class="alert alert-info"><span class="icon icon-exclamation-sign"></span> ${INFO_ALERT} </div>
<!-- END IF -->
<!-- IF '${ERROR_ALERT}' != '' -->
<div class="alert alert-danger">
  <button class="close" data-dismiss="alert">×</button>
  <span class="icon icon-remove-sign"></span>
  <strong>${STR_ERROR}!</strong> ${ERROR_ALERT} </div>
<!-- END IF -->
<!-- IF '${MSG_ALERT}' != '' -->
<div class="alert alert-success">
  <button class="close" data-dismiss="alert">×</button>
  <span class="icon icon-ok-sign"></span>
  ${MSG_ALERT} </div>
<!-- END IF -->
<script type="text/javascript">
$(document).ready(function(){
	$("#start_update").live("click", function(){
	
		$("#btn_refresh").html('<div id="progress_bar" class="bar progress progress-striped"><div class="progress-bar progress-bar-primary" style="width: 1%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" role="progressbar"><span style="padding: 10px" id="status_process">${STR_START_UPDATE}</span></div></div>');	
		
		$.ajax({
			type: "GET",
			url: "./?t=start_update&p=start",
			dataType: "xml",
			success: function(xml){
                $(xml).find("document").each(function () {
					var result = $(this).find("result").text();
					var msg = $(this).find("status").text(); 

					if(result == 'yes'){
						$('.progress-bar').css('width', '20%');
						$("#status_process").text(msg);
						updateFiles();
					}
					else{
						$("#btn_refresh").html('<a id="start_update" class="btn btn-default" href="#"><i class="icon icon-refresh"></i>${BUTTON_UPDATE}</a><span style="padding: 10px">' + msg + '</span>');
					}
				});
			}
		});
	});
});

function updateFiles()
{
	$.ajax({
		type: "GET",
		url: "./?t=start_update&p=update_files",
		dataType: "xml",
		success: function(xml){
			$(xml).find("document").each(function () {
				var result = $(this).find("result").text();
				var msg = $(this).find("status").text();
					
				if(result == 'yes'){
					$('.progress-bar').css('width', '70%');
					updateBD();
				}
				else{
					$("#btn_refresh").html('<a id="start_update" class="btn btn-default" href="#"><i class="icon icon-refresh"></i>${BUTTON_UPDATE}</a><span style="padding: 10px">' + msg + '</span>');
				}
			});
		}
	});
}

function updateBD()
{
	$.ajax({
		type: "GET",
		url: "./?t=start_update&p=update_bd",
		dataType: "xml",
		success: function(xml){
			$(xml).find("document").each(function () {
				var result = $(this).find("result").text();
				var msg = $(this).find("status").text();
					
				if(result == 'yes'){
					$('.progress-bar').css('width', '100%');
					$('#progress_bar').delay(3000).fadeOut(); 
					$('#status_process').delay(3000).text('${MSG_UPDATE_COMPLETED}'); 
				}
				else{
					$("#btn_refresh").html('<a id="start_update" class="btn btn-default" href="#"><i class="icon icon-refresh"></i>${BUTTON_UPDATE}</a><span style="padding: 10px">' + msg + '</span>');
				}
			});
		}
	});
}	

</script>
  <!-- IF '${MSG_NO_UPDATES}' == '' -->
  <div id="btn_refresh"><a id="start_update" class="btn btn-default" href="#"> <i class="icon icon-refresh"></i> ${BUTTON_UPDATE} </a> </div>
  <!-- ELSE -->
  <div class="help-block">${MSG_NO_UPDATES}</div>
  <!-- END IF -->
<form action="${ACTION}" method="post">
  <input type="hidden" name="action" value="post">  
  <div class="form-group">
<label for="license_key">${STR_LICENSE_KEY}</label>
<input class="form-control" type="text" style="text-transform: uppercase;" name="license_key" value="${LICENSE_KEY}">
</div>  
  <div class="controls">
    <input type="submit" class="btn btn-success" value="${BUTTON_SAVE}">
  </div>
</form>
<!-- INCLUDE footer.tpl -->