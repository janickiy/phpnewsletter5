<!-- INCLUDE header.tpl -->
<script type="text/javascript">

var DOM = (typeof(document.getElementById) != 'undefined');

function CheckAll_Activate(Element,Name)
{
	if(DOM){
		thisCheckBoxes = Element.parentNode.parentNode.parentNode.parentNode.parentNode.getElementsByTagName('input');

		var m = 0;

		for(var i = 1; i < thisCheckBoxes.length; i++){
			if(thisCheckBoxes[i].name == Name){
				thisCheckBoxes[i].checked = Element.checked;
				if(thisCheckBoxes[i].checked == true) m++;
				if(thisCheckBoxes[i].checked == false) m--;
			}
		}

		if(m > 0) { document.getElementById("Apply_").disabled = false; }
		else { document.getElementById("Apply_").disabled = true;  }
	}
}

function Count_checked()
{
	var All = document.forms[1];
	var m = 0;

	for(var i = 0; i < All.elements.length; ++i){
		if(All.elements[i].checked) { m++; }
	}

	if(m > 0) { document.getElementById("Apply_").disabled = false; }
	else { document.getElementById("Apply_").disabled = true; }
}
	
function PnumberChange()
{
	var pnumber = document.getElementById("pnumber").value;
	document.cookie = "pnumber_subscribers=" + pnumber;
	location.reload();
}

</script>
<!-- IF '${INFO_ALERT}' != '' -->

<div class="alert alert-info"> ${INFO_ALERT} </div>
<!-- END IF -->
<ul class="BtnPanelIcon">
  <li><a title="${PROMPT_ADD_USER}" href="./?t=add_user"> <span class="fa fa-user-plus fa-2x"></span> <span class="IconText">${STR_ADD_USER}</span> </a> </li>
  <li><a title="${PROMPT_REMOVE_SUBSCRIBERS}" onclick="return confirm('${ALERT_CLEAR_ALL}');" href="./?t=subscribers&remove=all"> <span class="fa fa-trash-o fa-2x"></span> <span class="IconText">${STR_REMOVE_ALL_SUBSCRIBERS}</span> </a> </li>
  <li><a title="${PROMPT_IMPORT_SUBSCRIBERS}" href="./?t=import"> <span class="fa fa-download fa-2x"></span> <span class="IconText">${STR_IMPORT_USER}</span> </a> </li>
  <li><a title="${PROMPT_EXPORT_SUBSCRIBERS}" href="./?t=export"> <span class="fa fa-upload fa-2x"></span> <span class="IconText">${STR_EXPORT_USER}</span> </a> </li>
</ul>
<form class="form-inline" id="searchform" method="GET" name="searchform" action="${ACTION}">
  <div class="control-group">
    <input type="hidden" name="task" value="subscribers">
    <input type="text" onfocus="if (this.value == '${FORM_SEARCH_NAME}')
        {this.value = '';}" onblur="if (this.value == '')
        {this.value = '${FORM_SEARCH_NAME}';}" id="story" name="search" value="${FORM_SEARCH_NAME}">
    <input class="btn btn-info" type="submit" value="${BUTTON_FIND}" id="searchsubmit">
  </div>
</form>
<!-- BEGIN show_return_back -->
<p>« <a href="./?t=subscribers">${STR_BACK}</a></p>
<!-- END show_return_back -->
<!-- IF '${ERROR_ALERT}' != '' -->
<div class="alert alert-error">
  <button class="close" data-dismiss="alert">×</button>
   <strong>${STR_ERROR}!</strong> ${ERROR_ALERT} </div>
<!-- END IF -->
<!-- IF '${MSG_ALERT}' != '' -->
<div class="alert alert-success">
  <button class="close" data-dismiss="alert">×</button>
  ${MSG_ALERT} </div>
<!-- END IF -->
<!-- BEGIN row -->
<form class="form-horizontal" action="${ACTION}" onSubmit="if(this.action.value == 0){window.alert('${ALERT_SELECT_ACTION}');return false;}if(this.action.value == 3){return confirm('${ALERT_CONFIRM_REMOVE}');}" method="post">
  <table class="table table-striped table-bordered table-hover dataTable" border="0" cellspacing="0" cellpadding="0" width="100%">
    <thead>
      <tr>
        <th><input type="checkbox" title="${STR_CHECK_ALLBOX}" onclick="CheckAll_Activate(this,'activate[]');"></th>
        <th class="${TH_CLASS_NAME}"><a href="./?t=subscribers&name=${GET_NAME}<!-- IF '${SEARCH}' != '' -->&search=${SEARCH}<!-- END IF -->${PAGENAV}">${TABLE_NAME}</a></th>
        <th class="${TH_CLASS_EMAIL}"><a href="./?t=subscribers&email=${GET_EMAIL}${PAGENAV}<!-- IF '${SEARCH}' != '' -->&search=${SEARCH}<!-- END IF -->">${TABLE_EMAIL}</a></th>
        <th class="${TH_CLASS_TIME}"><a href="./?t=subscribers&time=${GET_TIME}${PAGENAV}<!-- IF '${SEARCH}' != '' -->&search=${SEARCH}<!-- END IF -->">${TABLE_ADDED}</a></th>
        <th width="250">IP</th>
        <th class="${TH_CLASS_STATUS}"><a href="./?t=subscribers&status=${GET_STATUS}${PAGENAV}<!-- IF '${SEARCH}' != '' -->&search=${SEARCH}<!-- END IF -->">${TABLE_STATUS}</a></th>
        <th width="300">${TABLE_ACTION}</th>
      </tr>
    </thead>
    <tbody>
      <!-- BEGIN column -->
      <tr class="td-middle<!-- IF '${STATUS_CLASS}' == 'noactive' --> error<!-- END IF -->">
        <td><input type="checkbox" onclick="Count_checked();" title="${STR_CHECK_BOX}" value="${ID_USER}" name="activate[]"></td>
        <td>${NAME}</td>
        <td>${EMAIL}</td>
        <td>${PUTDATE_FORMAT}</td>
        <td><a title="${PROMPT_IP_INFO}" href="./?t=whois&ip=${IP}">${IP}</a></td>
        <td>${STR_STAT}</td>
        <td><a class="btn" href="./?t=edit_user&id_user=${ID_USER}" title="${STR_EDIT}"> <i class="icon-pencil"></i>${STR_EDIT}</a> <a class="btn" href="./?t=subscribers&remove=${ID_USER}" title="${STR_REMOVE}"> <i class="icon-trash"></i> ${STR_REMOVE} </a>
		</td>
      </tr>
      <!-- END column -->
    </tbody>
  </table>
  <div class="form-inline">
    <div class="control-group">
      <select class="span3 form-control" name="action">
        <option value="0"> -- ${FORM_CHOOSE_ACTION} -- </option>
        <option value="1">${FORM_ACTIVATE}</option>
        <option value="2">${FORM_DEACTIVATE}</option>
        <option value="3">${FORM_REMOVE}</option>
      </select>
      <span class="help-inline">
      <input type="submit" class="btn btn-success" id="Apply_" value="${BUTTON_APPLY}" disabled="" name="">
      </span> </div>
  </div>
</form>
<!-- BEGIN pagination -->
<div class="form-inline">
  <div class="control-group"> ${STR_PNUMBER}:
    <select onchange="PnumberChange(this);" class="span1 form-control" id="pnumber" name="pnumber">
      <option value="10" <!-- IF '${PNUMBER}' == 10 -->selected="selected"<!-- END IF -->> 10 </option>
      <option value="20" <!-- IF '${PNUMBER}' == 20 -->selected="selected"<!-- END IF -->> 20 </option>
      <option value="30" <!-- IF '${PNUMBER}' == 30 -->selected="selected"<!-- END IF -->> 30 </option>
      <option value="50" <!-- IF '${PNUMBER}' == 50 -->selected="selected"<!-- END IF -->> 50 </option>
      <option value="100" <!-- IF '${PNUMBER}' == 100 -->selected="selected"<!-- END IF -->> 100 </option>
    </select>
    <span class="help-inline">
    <div class="pagination">
      <ul>
        <!-- IF '${PERVPAGE}' != '' -->
        <li>${PERVPAGE}</li>
        <!-- END IF -->
        <!-- IF '${PERV}' != '' -->
        <li>${PERV}</li>
        <!-- END IF -->
        <!-- IF '${PAGE2LEFT}' != '' -->
        <li>${PAGE2LEFT}</li>
        <!-- END IF -->
        <!-- IF '${PAGE1LEFT}' != '' -->
        <li>${PAGE1LEFT}</li>
        <!-- END IF -->
        <!-- IF '${CURRENT_PAGE}' != '' -->
        <li class="prev disabled">${CURRENT_PAGE}</li>
        <!-- END IF -->
        <!-- IF '${PAGE1RIGHT}' != '' -->
        <li>${PAGE1RIGHT}</li>
        <!-- END IF -->
        <!-- IF '${PAGE2RIGHT}' != '' -->
        <li>${PAGE2RIGHT}</li>
        <!-- END IF -->
        <!-- IF '${NEXTPAGE}' != '' -->
        <li>${NEXTPAGE}</li>
        <!-- END IF -->
        <!-- IF '${NEXT}' != '' -->
        <li>${NEXT}</li>
        <!-- END IF -->
      </ul>
    </div>
    </span> </div>
</div>
<!-- END pagination -->
<p>${STR_NUMBER_OF_SUBSCRIBERS}: ${NUMBER_OF_SUBSCRIBERS}</p>
<!-- END row -->
<!-- IF '${EMPTY_LIST}' != '' -->
<div class="warning_msg">${EMPTY_LIST}</div>
<!-- END IF -->
<!-- BEGIN notfound -->
<div class="alert">
  <button class="close" data-dismiss="alert">×</button>
  ${MSG_NOTFOUND} </div>
<!-- END notfound -->
<!-- INCLUDE footer.tpl -->
