<!-- IF '${INFO_ALERT}' != '' -->
<div class="alert alert-info">${INFO_ALERT}</div>
<!-- END IF -->
<!-- IF '${ERROR_ALERT}' != '' -->
<div class="alert alert-danger alert-dismissable">
  <button class="close" aria-hidden="true" data-dismiss="alert">×</button>
  <strong>${STR_ERROR}!</strong> ${ERROR_ALERT}
</div>
<!-- END IF -->
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