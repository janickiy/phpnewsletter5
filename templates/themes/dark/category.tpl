<!-- INCLUDE header.tpl -->
<!-- IF '${INFO_ALERT}' != '' -->
<div class="alert alert-info">
<span class="icon icon-exclamation-sign"></span>
${INFO_ALERT}
</div>
<!-- END IF -->

<!-- IF '${ERROR_ALERT}' != '' -->
<div class="alert alert-danger">
  <button class="close" data-dismiss="alert">×</button>
  <span class="icon icon-remove-sign"></span>
  <strong>${STR_ERROR}!</strong> ${ERROR_ALERT} </div>
<!-- END IF -->
<!-- IF '${MSG_ALERT}' != '' -->
<div class="alert alert-success">
  <button class="close" data-dismiss="alert">×</button>
  <span class="icon icon-ok-sign" style=""></span>
  ${MSG_ALERT} </div>
<!-- END IF -->
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
        <a class="btn btn-primary btn" title="${STR_EDIT}" href="./?t=edit_category&id_cat=${ID_CAT}"> <i class="icon icon-edit"></i></a>
        <a class="btn btn-danger btn" title="${STR_REMOVE}" href="./?t=category&remove=${ID_CAT}"
        <!-- IF '${ALERT_REMOVE_SUNBERS}' != '' -->
        onclick="return confirm('${ALERT_REMOVE_SUNBERS}');"
        <!-- END IF -->
        >
        <i class="icon icon-trash"></i></a></td>
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