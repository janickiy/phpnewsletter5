<!-- INCLUDE header.tpl -->
<!-- INCLUDE info.tpl -->
<!-- INCLUDE errors.tpl -->
<!-- INCLUDE success.tpl -->
<p><a href="./?t=change_password">${STR_CHANGE_PASSWORD}</a><p>
<form method="POST" action="./?t=add_account">
  <table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
      <th>${TH_TABLE_LOGIN}</th>
      <th>${TH_TABLE_NAME}</th>
      <th>${TH_TABLE_DESCRIPTION}</th>
      <th>${TH_TABLE_ROLE}</th>
      <th>${TH_TABLE_ACTION}</th>
    </tr>
    </thead>
    <tbody>
    <!-- BEGIN row -->
    <tr>
      <td>${LOGIN}</td>
      <td>${NAME}</td>
      <td>${DESCRIPTION}</td>
      <td>${ROLE}</td>
      <td>
        <!-- IF '${ALLOW_EDIT}' == 'yes' -->
        <a class="btn btn-outline btn-default" title="${STR_EDIT}" href="./?t=edit_account&id=${ID}"><i class="fa fa-edit"></i></a> <a class="btn btn-outline btn-danger" title="${STR_REMOVE}" href="./?t=accounts&action=remove&id=${ID}"><i class="fa fa-trash-o"></i></a>
        <!-- END IF -->
      </td>
    </tr>
    <!-- END row -->
    </tbody>
  </table>
  <br>
  <input class="btn btn-success" type="submit" value="${BUTTON_ADD}">
</form>
<!-- INCLUDE footer.tpl -->