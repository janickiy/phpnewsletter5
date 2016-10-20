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
<form action="${ACTION}" method="post">
  <!-- IF '${ID_CAT}' != '' -->
  <input type="hidden" name="id_cat" value="${ID_CAT}">
  <!-- END IF -->
  <div class="form-group">
    <label for="name">${FORM_NAME}</label>
    <input class="form-control" type="text" name="name" value="${NAME}">
  </div>
  <div class="controls">
    <input type="submit" class="btn btn-success" name="action" value="${BUTTON}">
  </div>
</form>