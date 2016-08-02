<!-- INCLUDE header.tpl -->
<!-- IF '${INFO_ALERT}' != '' -->
<div class="alert alert-info">
<span class="icon icon-exclamation-sign"></span>
${INFO_ALERT}
</div>
<!-- END IF -->
<!-- BEGIN show_errors -->
<div class="alert alert-danger">
<a class="close" href="#" data-dismiss="alert">×</a>
<span class="icon icon-remove-sign"></span>
<h4 class="alert-heading">${STR_IDENTIFIED_FOLLOWING_ERRORS}:</h4>
<ul>
    <!-- BEGIN row -->
	<li> ${ERROR}</li>
    <!-- END row -->
</ul>
</div>
<!-- END show_errors -->
<!-- IF '${ERROR_ALERT}' != '' -->
<div class="alert alert-danger">
<button class="close" data-dismiss="alert">×</button>
<span class="icon icon-remove-sign"></span>
<strong>${STR_ERROR}!</strong>
${ERROR_ALERT}
</div>
<!-- END IF -->
<!-- IF '${MSG_ALERT}' != '' -->
<div class="alert alert-success">
<button class="close" data-dismiss="alert">×</button>
<span class="icon icon-ok-sign"></span>
${MSG_ALERT}
</div>
<!-- END IF -->
<form action="${ACTION}" method="post">
<div class="form-group">
<label for="current_password">${STR_CURRENT_PASSWORD}</label>
<input class="form-control" type="password" name="current_password" placeholder="${STR_CURRENT_PASSWORD}">
</div>
<div class="form-group">
<label for="password">${STR_PASSWORD}</label>
<input class="form-control" type="password" name="password" placeholder="${STR_PASSWORD}">
</div>
<div class="form-group">
<label for="password_again">${STR_AGAIN_PASSWORD}</label>
<input class="form-control" class="span3 input-xlarge focused" name="password_again" placeholder="${STR_AGAIN_PASSWORD}">
</div>
  <div class="controls">
    <input type="submit" name="action" class="btn btn-success" value="${BUTTON_SAVE}">
  </div>  
</form>
<!-- INCLUDE footer.tpl -->