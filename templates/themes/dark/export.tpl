<!-- INCLUDE header.tpl -->

<p>« <a href="./?t=subscribers">${STR_BACK}</a></p>
<!-- IF '${INFO_ALERT}' != '' -->
<div class="alert alert-info"> <span class="icon icon-exclamation-sign"></span> ${INFO_ALERT} </div>
<!-- END IF -->
<form class="form-horizontal bootstrap-validator-form" action="${ACTION}" target=_blank method="post">
  <div class="control-group">
    <label class="control-label" for="export_type">${STR_EXPORT}:</label>
    <div class="controls">
      <label class="radio-inline">
        <input type="radio" value="1" checked name="export_type">
        ${STR_EXPORT_TEXT} </label>
      <label class="radio-inline">
        <input type="radio" value="2" name="export_type">
        ${STR_EXPORT_EXCEL} </label>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="zip">${STR_COMPRESSION}:</label>
    <div class="controls">
      <label class="radio-inline">
        <input type="radio" checked value="1" name="zip">
        ${STR_COMPRESSION_OPTION_1} </label>
      <label class="radio-inline">
        <input type="radio" value="2" name="zip">
        ${STR_COMPRESSION_OPTION_2} </label>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="id_cat[]" checked="checked">${TABLE_CATEGORY}:</label>
    <div class="controls">
      <!-- BEGIN row -->
      <label class="checkbox">
      <div class="controls">
        <input type="checkbox" value="${ID_CAT}" name="id_cat[]" checked="checked">
        ${NAME} </div>
      </label>
      <!-- END row -->
    </div>
  </div>
  <div class="control-group">
    <input style="margin-top: 10px;" type="submit" class="btn btn-success" name="action" value="${BUTTON_APPLY}">
  </div>
</form>
<!-- INCLUDE footer.tpl -->