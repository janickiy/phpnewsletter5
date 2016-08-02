<p>« <a href="./?t=subscribers">${RETURN_BACK}</a></p>
<!-- IF '${INFO_ALERT}' != '' -->
<div class="alert alert-info"><span class="icon icon-exclamation-sign"></span> ${INFO_ALERT} </div>
<!-- END IF -->
<!-- IF '${ERROR_ALERT}' != '' -->
<div class="alert alert-danger">
  <button class="close" data-dismiss="alert">×</button>
  <span class="icon icon-remove-sign"></span>
  <strong>${STR_ERROR}!</strong> ${ERROR_ALERT} </div>
<!-- END IF -->
<!-- BEGIN show_errors -->
<div class="alert alert-danger"> <a class="close" href="#" data-dismiss="alert">×</a>
<span class="icon icon-remove-sign"></span>
  <h4 class="alert-heading">${STR_IDENTIFIED_FOLLOWING_ERRORS}:</h4>
  <ul>
    <!-- BEGIN row -->
    <li> ${ERROR}</li>
    <!-- END row -->
  </ul>
</div>
<!-- END show_errors -->
<form action="${ACTION}" method="post">
  <!-- IF '${ID_USER}' != '' -->
  <input type="hidden" name="id_user" value="${ID_USER}">
  <!-- END IF -->  
  <div class="form-group">
<label for="name">${FORM_NAME}</label>
<input class="form-control" type="text" name="name" value="${NAME}">
</div>  
    <div class="form-group">
<label for="email">${FORM_EMAIL}</label>
<input class="form-control" type="text" name="email" value="${EMAIL}">
</div>
  <div class="form-group">
<label  for="id_cat[]">${FORM_CATEGORY}</label>
<!-- BEGIN row --><div class="checkbox">
<label>
<input type="checkbox" value="${ID_CAT}" name="id_cat[]" 
      <!-- IF '${CHECKED}' != '' -->
      checked="checked"
      <!-- END IF -->
      >${CATEGORY_NAME}
    </label></div>
    <!-- END row -->
</div>  
  <div class="controls">
    <input type="submit" name="action" class="btn btn-success" value="${BUTTON}">
  </div>
</form>