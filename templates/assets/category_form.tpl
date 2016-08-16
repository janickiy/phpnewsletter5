<!-- IF '${INFO_ALERT}' != '' -->
<div class="alert alert-info">
${INFO_ALERT}
</div>
<!-- END IF -->
<!-- IF '${ERROR_ALERT}' != '' -->
<div class="alert alert-error">
<button class="close" data-dismiss="alert">×</button>
<strong>${STR_ERROR}!</strong>
${ERROR_ALERT}
</div>
<!-- END IF -->
<form class="form-horizontal" action="${ACTION}" method="post">
  <!-- IF '${ID_CAT}' != '' -->
  <input type="hidden" name="id_cat" value="${ID_CAT}">
  <!-- END IF -->
  <div class="control-group">
    <label for="name" class="control-label">${STR_NAME}:</label>
    <div class="controls">
      <input class="span4 input-xlarge focused" type="text" name="name" value="${NAME}">
    </div>
  </div>
  <div class="controls">
    <input type="submit" class="btn btn-success" name="action" value="${BUTTON}">
  </div>
</form>