<!-- INCLUDE header.tpl -->
<!-- IF '${INFO_ALERT}' != '' -->
<div class="alert alert-info">${INFO_ALERT}</div>
<!-- END IF -->

<!-- BEGIN show_errors -->
<div class="alert alert-danger alert-dismissable">
  <button class="close" aria-hidden="true" data-dismiss="alert">×</button>
  <h4 class="alert-heading">${STR_IDENTIFIED_FOLLOWING_ERRORS}:</h4>
  <ul>
    <!-- BEGIN row -->
    <li> ${ERROR}</li>
    <!-- END row -->
  </ul>
</div>
<!-- END show_errors -->
<!-- IF '${MSG_ALERT}' != '' -->
<div class="alert alert-success alert-dismissable">
<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
${MSG_ALERT}
</div>
<!-- END IF -->
<p>« <a href="./?t=accounts">${STR_ACCOUNTS}</a></p>
<form action="${ACTION}" method="post">
  <div class="form-group">
    <label for="current_password">${STR_CURRENT_PASSWORD}:</label>
    <div class="form-group">
      <input type="password" class="form-control" name="current_password" placeholder="${STR_CURRENT_PASSWORD}">
    </div>
  </div>
  <div class="control-group">
    <label for="password">${STR_PASSWORD}:</label>
    <div class="form-group">
      <input type="password" class="form-control" name="password" placeholder="${STR_PASSWORD}">
    </div>
  </div>
  <div class="control-group">
    <label for="password_again">${STR_AGAIN_PASSWORD}:</label>
    <div class="form-group">
      <input type="password" class="form-control" name="password_again" placeholder="${STR_AGAIN_PASSWORD}">
    </div>
  </div>
  <div class="form-group">
    <input type="submit" name="action" class="btn btn-success" value="${BUTTON_SAVE}">
  </div>  
</form>
<!-- INCLUDE footer.tpl -->