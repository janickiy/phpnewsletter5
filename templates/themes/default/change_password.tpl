<!-- INCLUDE header.tpl -->
<!-- IF '${INFO_ALERT}' != '' -->
<div class="alert alert-info">
${INFO_ALERT}
</div>
<!-- END IF -->

<!-- BEGIN show_errors -->
<div class="alert alert-error">
<a class="close" href="#" data-dismiss="alert">×</a>
<h4 class="alert-heading">${STR_IDENTIFIED_FOLLOWING_ERRORS}:</h4>
<ul>
    <!-- BEGIN row -->
   <li> ${ERROR}</li>
    <!-- END row -->
</ul>
</div>
<!-- END show_errors -->
<!-- IF '${ERROR_ALERT}' != '' -->
<div class="alert alert-error">
<button class="close" data-dismiss="alert">×</button>
<strong>${STR_ERROR}!</strong>
${ERROR_ALERT}
</div>
<!-- END IF -->

<!-- IF '${MSG_ALERT}' != '' -->
<div class="alert alert-success">
<button class="close" data-dismiss="alert">×</button>
${MSG_ALERT}
</div>
<!-- END IF -->
<a href="./?task=security">Учетные записи</a><br>
<form class="form-horizontal" action="${ACTION}" method="post">
  <div class="control-group">
    <label for="current_password" class="control-label">${STR_CURRENT_PASSWORD}:</label>
    <div class="controls">
      <input type="password" class="span3 input-xlarge focused" name="current_password" placeholder="${STR_CURRENT_PASSWORD}">
    </div>
  </div>
  <div class="control-group">
    <label for="password" class="control-label">${STR_PASSWORD}:</label>
    <div class="controls">
      <input type="password" class="span3 input-xlarge focused" name="password" placeholder="${STR_PASSWORD}">
    </div>
  </div>
  <div class="control-group">
    <label for="password_again" class="control-label">${STR_AGAIN_PASSWORD}:</label>
    <div class="controls">
      <input type="password" class="span3 input-xlarge focused" name="password_again" placeholder="${STR_AGAIN_PASSWORD}">
    </div>
  </div>
  <div class="controls">
    <input type="submit" name="action" class="btn btn-success" value="${BUTTON_SAVE}">
  </div>  
</form>
<!-- INCLUDE footer.tpl -->