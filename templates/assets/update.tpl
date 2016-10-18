<!-- INCLUDE header.tpl -->
<!-- IF '${INFO_ALERT}' != '' -->
<div class="alert alert-info">${INFO_ALERT}</div>
<!-- END IF -->
<!-- IF '${ERROR_ALERT}' != '' -->
<div class="alert alert-danger alert-dismissable">
	<button class="close" aria-hidden="true" data-dismiss="alert">×</button>
	<strong>${STR_ERROR}!</strong> ${ERROR_ALERT}
</div>
<!-- END IF -->
<!-- IF '${MSG_ALERT}' != '' -->
<div class="alert alert-success alert-dismissable">
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	${MSG_ALERT}
</div>
<!-- END IF -->
<script type="text/javascript">
$(document).ready(function(){
	$("#start_update").on("click", function(){
		$("#btn_refresh").html('<div id="progress_bar" class="span6 progress progress-striped active"><div class="bar" style="width: 1%;"></div></div><span style="padding: 10px" id="status_process">${STR_START_UPDATE}</span>');
		
		$.ajax({
			type: "GET",
			cache: false,
			url: "./?t=ajax&action=start_update&p=start",
			dataType: "json",
			success: function(data){
  				if (data.result == 'yes'){
					$('.bar').css('width', '20%');
					$("#status_process").text(data.status);
					updateFiles();
				}
				else{
					$("#btn_refresh").html('<a id="start_update" class="btn" href="#"><i class="icon-refresh"></i>${BUTTON_UPDATE}</a><span style="padding: 10px">' + data.status + '</span>');
				}
			}
		});
	});
});

function updateFiles()
{
	$.ajax({
		type: "GET",
		cache: false,
		url: "./?t=ajax&start_update&p=update_files",
		dataType: "json",
		success: function(data){
			if (data.result == 'yes'){
				$('.bar').css('width', '70%');
				updateBD();
			}
			else{
				$("#btn_refresh").html('<a id="start_update" class="btn" href="#"><i class="icon-refresh"></i>${BUTTON_UPDATE}</a><span style="padding: 10px">' + data.status + '</span>');
			}
		}
	});
}

function updateBD()
{
	$.ajax({
		type: "GET",
		cache: false,
		url: "./?t=ajax&start_update&p=update_bd",
		dataType: "json",
		success: function(data){
			if (data.result == 'yes'){
				$('.bar').css('width', '100%');
				$('#progress_bar').delay(3000).fadeOut();
				$('#status_process').delay(3000).text('${MSG_UPDATE_COMPLETED}');
			}
			else{
				$("#btn_refresh").html('<a id="start_update" class="btn" href="#"><i class="icon-refresh"></i>${BUTTON_UPDATE}</a><span style="padding: 10px">' + data.status + '</span>');
			}
		}
	});
}	

</script>
<form action="${ACTION}" method="post">
	<input type="hidden" name="action" value="post">
	<div class="form-group">
		<label for="license_key">${STR_LICENSE_KEY}</label>
		<input class="form-control" type="text" style="text-transform: uppercase;" name="license_key" value="${LICENSE_KEY}" disabled>
	</div>
	<div class="controls">
		<input type="submit" class="btn btn-success" value="${BUTTON_SAVE}" disabled>
	</div>
</form>
<!-- INCLUDE footer.tpl -->