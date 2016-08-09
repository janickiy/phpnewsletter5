<!-- INCLUDE header.tpl -->
<!-- IF '${INFO_ALERT}' != '' -->
<div class="alert alert-info">
  ${INFO_ALERT}
</div>
<!-- END IF -->

<!-- BEGIN show_errors -->
<div class="alert alert-error">
  <a class="close" href="#" data-dismiss="alert">×</a>
  <h4 class="alert-heading">${STR_IDENTIFIED_FOLLOWING_ERRORS}:</h4>
  <ul>
    <!-- BEGIN row -->
    <li> ${ERROR}</li>
    <!-- END row -->
  </ul>
</div>
<!-- END show_errors -->
<!-- IF '${ERROR_ALERT}' != '' -->
<div class="alert alert-error">
  <button class="close" data-dismiss="alert">×</button>
  <strong>${STR_ERROR}!</strong>
  ${ERROR_ALERT}
</div>
<!-- END IF -->

<!-- IF '${MSG_ALERT}' != '' -->
<div class="alert alert-success">
  <button class="close" data-dismiss="alert">×</button>
  ${MSG_ALERT}
</div>
<!-- END IF -->
<a href="./?t=change_password">Сменить пароль</a><br>
<form method="POST" action="./?t=add_account">
  <table class="table-hover table table-bordered esponsive-utilities" border="0" cellspacing="0" cellpadding="0" width="100%">
    <thead>
    <tr>
      <th>${TH_TABLE_LOGIN}</th>
      <th>${TH_TABLE_ROLE}</th>
      <th>${TH_TABLE_ACTION}</th>
    </tr>
    </thead>
    <tbody>

    <!-- BEGIN row -->
    <tr>
      <td>${LOGIN}</td>
      <td>${ROLE}</td>
      <td class="td-middle"><!-- IF '${ALLOW_EDIT}' == 'yes' --> <i class="icon-pencil"></i>  <a title="${STR_EDIT}" href="./?t=edit_account&id=${ID}">${STR_EDIT}</a><!-- END IF --></td>
      <td class="td-middle"><!-- IF '${ALLOW_EDIT}' == 'yes' --> <i class="icon-trash"></i> <a title="${STR_REMOVE}' href="./?t=accounts&action=remove&id=${ID}">${STR_REMOVE}<!-- END IF --></a></td>
    </tr>
    <!-- END row -->

    </tbody>
  </table>
  <br>
  <input class="btn btn-success" type="submit" value="${BUTTON_ADD}">
</form>
<!-- INCLUDE footer.tpl -->