<p>« <a href="./?t=subscribers">${RETURN_BACK}</a></p>
<!-- INCLUDE success.tpl -->
<!-- INCLUDE errors.tpl -->
<!-- INCLUDE info.tpl -->
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
    <!-- BEGIN categories_list --><div class="checkbox">
      <label>
        <input type="checkbox" value="${ID_CAT}" name="id_cat[]"
        <!-- IF '${CHECKED}' != '' -->
        checked="checked"
        <!-- END IF -->
        >${CATEGORY_NAME}
      </label></div>
    <!-- END categories_list -->
  </div>
  <div class="controls">
    <input type="submit" name="action" class="btn btn-success" value="${BUTTON}">
  </div>
</form>