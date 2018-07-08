<!-- INCLUDE header.tpl -->
<!-- INCLUDE info.tpl -->
<!-- INCLUDE errors.tpl -->
<!-- INCLUDE success.tpl -->
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