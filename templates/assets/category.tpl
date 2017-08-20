<!-- INCLUDE header.tpl -->
<!-- INCLUDE info.tpl -->
<!-- INCLUDE errors.tpl -->
<!-- INCLUDE success.tpl -->
<table class="table table-striped table-bordered table-hover" border="0" cellspacing="0" cellpadding="0" width="100%">
  <thead>
  <tr>
    <th>${TH_TABLE_NAME}</th>
    <th>${TH_TABLE_NUMBER_SUBSCRIBERS}</th>
    <th>${TH_TABLE_ACTION}</th>
  </tr>
  </thead>
  <tbody>
  <!-- BEGIN row -->
  <tr class="td-middle">
    <td>${NAME}</td>
    <td>${COUNT}</td>
    <td width="150" class="center">
      <a class="btn btn-outline btn-default" title="${STR_EDIT}" href="./?t=edit_category&id_cat=${ID_CAT}"> <i class="fa fa-edit"></i></a>
      <a class="btn btn-outline btn-danger" title="${STR_REMOVE}" href="./?t=category&remove=${ID_CAT}"
      <!-- IF '${ALERT_REMOVE_SUNBERS}' != '' -->onclick="return confirm('${ALERT_REMOVE_SUNBERS}');"
      <!-- END IF -->><i class="fa fa-trash-o"></i></a>
    </td>
  </tr>
  <!-- END row -->
  </tbody>
</table>
<br>
<form action="./?t=add_category" method="post">
  <div class="controls">
    <input type="submit" class="btn btn-success" value="${BUTTON_ADD_CATEGORY}">
  </div>
</form>
<!-- INCLUDE footer.tpl -->