<!-- INCLUDE info.tpl -->
<!-- INCLUDE errors.tpl -->
<!-- INCLUDE success.tpl -->
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