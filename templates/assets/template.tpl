<!-- INCLUDE header.tpl -->
<script type="text/javascript" src="./templates/js/jquery.paulund_modal_box.js"></script>
<script type="text/javascript">
var base = 60;
pausesend = false;
var clocktimer,dateObj,dh,dm,ds,ms;
var readout = '';
var h = 1;
var m = 1;
var tm = 1;
var s = 0;
var ts = 0;
var ms = 0;
var show = true;
var init = 0;
var ii = 0;
var parselimit = 0;
var st = 0;
var limit,curhour,curmin,cursec;

function clearALL() {
	clearTimeout(clocktimer);
	h = 1;
	m = 1;
	tm = 1;
	s = 0;
	ts = 0;
	ms = 0;
	init = 0;
	show = true;
	readout = '00:00:00';
	var Elemetstags = document.getElementsByTagName('span');
	
	for(var i=0; i<Elemetstags.length; i++){
		if(Elemetstags[i].id == 'timer1') { readout = Elemetstags[i].firstChild.data; }
	}	
		
	document.getElementById("timer1").innerHTML = readout;
	ii = 0;
}

function startTIME() {

var cdateObj = new Date();
var t = (cdateObj.getTime() - dateObj.getTime())-(s*1000);

if(t>999) { s++; }

if(s>=(m*base)) {
	ts = 0;
	m++;
} else {
	ts = parseInt((ms/100)+s);
	if(ts>=base) { ts = ts-((m-1)*base); }
}

if (m>(h*base)) {
	tm = 1;
	h++;
} else {
	tm = parseInt((ms/100)+m);
	if(tm>=base) { tm = tm-((h-1)*base); }
}

if (ts>0) {
	ds = ts; 
	if (ts<10) { ds = '0'+ts; }
} else { 
	ds = '00'; 
}

dm = tm-1;

if(dm>0) { 
	if(dm<10) { dm = '0'+dm; }
} 
else { dm = '00'; }
dh = h-1;
if(dh>0) { 
	if (dh<10) { dh = '0'+dh; }} 
	else { dh = '00'; }
	readout = dh + ':' + dm + ':' + ds;
	if (show == true) { document.getElementById("timer1").innerHTML = readout; }
	clocktimer = setTimeout("startTIME()",1);
}

function findTIME() {
	if (init == 0) {
		dateObj = new Date();
		startTIME();
		init = 1;
	} else {
		if(show == true) { show = false;} 
		else { show = true; }
	}
}

var DOM = (typeof(document.getElementById) != 'undefined');

function Check_action()
{
	if(document.forms[0].action.value == 0) { window.alert('${ALERT_SELECT_ACTION}'); }
}

function CheckAll_Activate(Element,Name)
{
	if (DOM){
		thisCheckBoxes = Element.parentNode.parentNode.parentNode.parentNode.getElementsByTagName('input');

		var m = 0;

		for(var i = 1; i < thisCheckBoxes.length; i++){
			if (thisCheckBoxes[i].name == Name){
				thisCheckBoxes[i].checked = Element.checked;
				if (thisCheckBoxes[i].checked == true) { m++; }
				if (thisCheckBoxes[i].checked == false) { m--; }
			}
		}

		if (m > 0) { document.getElementById("Apply_").disabled = false; }
		else { document.getElementById("Apply_").disabled = true;  }
	}
}

function Count_checked()
{
	var All = document.forms[0];
	var m = 0;

	for(var i = 0; i < All.elements.length; ++i){
		if(All.elements[i].checked) { m++; }
	}

	if(m > 0) { document.getElementById("Apply_").disabled = false; }
	else { document.getElementById("Apply_").disabled = true; }
}

function sendout()
{
	var m = 0;
	pausesend = false;

	var All = document.forms[0];
	for(var i = 0; i<All.elements.length; ++i){
		if(All.elements[i].checked) { m++; }
	}
	
	typesend = 1;
	completed = null;
	successful = 0;
	unsuccessful = 0;
	totalmail = 0;
	
	findTIME();
	
	if (m == 0) {
		saveResult('${ALERT_MALING_NOT_SELECTED}');
	}	
	else{
		if(show == false) $('#timer1').text('00:00:00');
		$('#timer2').text('00:00:00');
		$("#pausesendout").removeClass().addClass('pausesendout_active');
		$("#stopsendout").removeClass().addClass('stopsendout_active');
		$("#refreshemail").removeClass().addClass('refreshemail_noactive');
		$("#sendout").removeClass().addClass('sendout_noactive');
		$("#process").removeClass().addClass('showprocess');

		getcoutprocess();
		onlinelogprocess();
		process();
	}	
}

function refreshsend()
{
	pausesend = false;
	typesend = 2;
	completed = null;
	successful = 0;
	unsuccessful = 0;
	totalmail = 0;

	$('#timer2').text('00:00:00');
	$("#process").removeClass().addClass('showprocess');
	$("#refreshemail").removeClass().addClass('refreshemail_noactive');
	$("#sendout").removeClass().addClass('sendout_noactive');

	findTIME();
	getcoutprocess();
	onlinelogprocess();
	process();	
}

function stopsend(str)
{
	$.ajax({
		type: 'GET',
		url:'./?t=process&status=' + str,
		dataType : "json",
		success:function(data){
			$("#pause").val(1);
			pausesend = true;
			show = false;
			$("#process").removeClass();
			$("#pausesendout").removeClass().addClass('pausesendout_noactive');
			$("#stopsendout").removeClass().addClass('stopsendout_noactive');
			$("#sendout").removeClass().addClass('sendout_active');
			$("#refreshemail").removeClass().addClass('refreshemail_noactive');
			if (str == 'stop'){
				$('#timer2').text('00:00:00');
				clearALL();
			}
		},
		error: function(error) { saveResult("${ALERT_ERROR_SERVER}: " + error); },
		complete: function() {
			if (data.status == 'stop') { window.location="./"; }
		}
	});
}

function getcoutprocess()
{
	if (pausesend == false && completed === null) {
		$.ajax({
			type:'GET',
			url:'./?t=ajax&action=countsend&id_log=' + id_log,
			dataType : "json",
			success:function(data){
				if (id_log != undefined) {
					var totalmail = data.total;
					var successful = data.success;
					var unsuccessful = data.unsuccessful;
					var timeleft = data.time;

					$('#totalsendlog').text(totalmail);
					$('#unsuccessful').text(unsuccessful);
					$('#successful').text(successful);
					$('#timer2').text(timeleft);
					onlinelogprocess();
					setTimeout('getcoutprocess(id_log)', 2000);
				}
				else{ setTimeout('getcoutprocess()', 1000); }
			}
		});
	}
}

function onlinelogprocess()
{
	if (pausesend == false && completed === null) {
		$.ajax({
			type:'GET',
			url:'./?t=ajax&action=logonline',
			dataType : "json",
			success:function(data){
				var msg = '';
				var status;
				var email;
				data.item[0].

				for(var i=0; i < data.item.length; i++)	{
					if (data.item[i].status == "yes")
						status = '${STR_SENT}';
					else
						status = '${STR_WASNT_SENT}';
					email = data.item[i].email;

					if(email != 'undefined'){
						msg += email + ' - ' + status;
						msg += '<br>';
					}
					$('#onlinelog').text(msg);
				}
			},
			error: function(error) { saveResult("${ALERT_ERROR_SERVER}: " + error); }
		});
	}
}

function process()
{
	var oForm = document.forms[0];
	var sBody = getRequestBody(oForm);
	
	if (pausesend == false){
		if (typesend == 1){
			var url = "./?t=send&typesend=1";
		}	
		else{ 
			var url = "./?t=send&typesend=2";
		}

		$.ajax({
			type:'POST',
			url:url,
			data:sBody,
			dataType:"json",
			success:function(data){
				if (data.completed == 'yes'){
					$("#process").removeClass();
					completeProcess();
				}
				else{
					setTimeout('process()', 3000);
				}
			}
		});
	}
}

function completeProcess()
{
	$("#pausesendout").removeClass().addClass('pausesendout_noactive');
	$("#stopsendout").removeClass().addClass('stopsendout_noactive');
	$("#sendout").removeClass().addClass('sendout_active');
	$("#refreshemail").removeClass().addClass('refreshemail_active');
	$("#process").removeClass();
	$("#timer2").text('00:00:00');

	show = false;
	clearALL();
	getcoutprocess();
}


function saveResult(sText){
	var sElem = document.getElementById("divStatus");
	sElem.innerHTML = sText;
}

function getRequestBody(oForm) {
	var aParams = new Array();
	
	for(var i = 0; i < oForm.elements.length; i++) {
		var sParam = encodeURIComponent(oForm.elements[i].name);
	
		if(sParam != ''){
			if(oForm.elements[i].name == 'activate[]'){
				if(oForm.elements[i].checked){
					var sParam = encodeURIComponent(oForm.elements[i].name);
					sParam += "=";
					sParam += encodeURIComponent(oForm.elements[i].value);
				}			
			}
			else{	
				var sParam = encodeURIComponent(oForm.elements[i].name);
				sParam += "=";
				sParam += encodeURIComponent(oForm.elements[i].value);			
			}
		
			aParams.push(sParam);
		}		
	}	

	return aParams.join("&");
}

function PnumberChange()
{
	var pnumber = document.getElementById("pnumber").value;
	document.cookie = "pnumber=" + pnumber;
	location.reload();
}

</script>

<!-- IF '${INFO_ALERT}' != '' -->
<div class="alert alert-info">
${INFO_ALERT}
</div>
<!-- END IF -->

<!-- IF '${ERROR_ALERT}' != '' -->
<div class="alert alert-error">
  <button class="close" data-dismiss="alert">×</button>
  <strong>${STR_ERROR}!</strong> ${ERROR_ALERT} </div>
<!-- END IF -->
<form action="${ACTION}" onSubmit="if(this.action.value == 0){window.alert('${ALERT_SELECT_ACTION}');return false;}if(this.action.value == 4){return confirm('${ALERT_CONFIRM_REMOVE}');} if(this.action.value == 1) return false" method="post">
  <table class="table-hover table table-bordered" border="0" cellspacing="0" cellpadding="0" width="100%">
    <thead>
      <tr>
        <th style="text-align: center;"><input type="checkbox" title="TABLECOLMN_CHECK_ALLBOX" onclick="CheckAll_Activate(this,'activate[]');"></th>
        <th width="5%">ID</th>
	    <th width="50%">${TH_TABLE_MAILER}</th>
        <th>${TH_TABLE_CATEGORY}</th>
        <th>${TH_TABLE_ACTIVITY}</th>
        <th>${TH_TABLE_POSITION}</th>
        <th>${TH_TABLE_EDIT}</th>
      </tr>
    </thead>
    <!-- BEGIN row -->
    <tbody>
      <!-- BEGIN column -->
      <tr class="td-middle${CLASS_NOACTIVE}">
        <td><input type="checkbox" onclick="Count_checked();" title="${TABLECOLMN_CHECKBOX}" value="${ROW_ID_TEMPLATE}" name=activate[]></td>
        <td>${ROW_ID_TEMPLATE}</td>
	    <td style="text-align: left;"><a title="${STR_EDIT_MAILINGTEXT}" href="./?t=edit_template&id_template=${ROW_ID_TEMPLATE}">${ROW_TMPLNAME}</a><br>
          <br>
          ${ROW_CONTENT}
          </div></td>
        <td>${ROW_CATNAME}</td>
        <td>${ROW_ACTIVE}</td>
        <td><p><a href="./?id_template=${ROW_ID_TEMPLATE}&pos=up" class="btn" title="${STR_DOWN}"><i class="icon-arrow-up"></i></a></p>
		<input class="span8" type="text" name="pos" value="${ROW_POS}">
          <p><a href="./?id_template=${ROW_ID_TEMPLATE}&pos=down" class="btn" title="${STR_DOWN}"><i class="icon-arrow-down"></i></a></p>
		  
		</td>
        <td><a href="./?t=edit_template&id_template=${ROW_ID_TEMPLATE}" class="btn" title="${STR_EDIT}"><i class="icon-pencil"></i></a></td>
      </tr>
      <!-- END column -->
      <!-- END row -->
    </tbody>
  </table>
  <div class="form-inline">
    <div class="control-group">
      <select id="select_action" class="span3 form-control" name="action">
        <option value="0">--${STR_ACTION}--</option>
        <option value="1">${STR_SENDOUT}</option>
        <option value="2">${STR_ACTIVATE}</option>
        <option value="3">${STR_DEACTIVATE}</option>
        <option value="4">${STR_REMOVE}</option>
      </select>
      <span class="help-inline">
      <input type="submit" id="Apply_" value="${STR_APPLY}" class="btn btn-success" disabled="" name="">
      </span> </div>
  </div>
</form>
<script type="text/javascript">

	var modalform = '<span id="onlinelog"></span>';
	modalform += '<h4>${STR_TIME}</h4>';
	modalform += '<input id="pause" type="hidden" value="0">';
	modalform += '<input id="id_log" type="hidden" value="0">';
	modalform += '<input id="lefttime" type="hidden" value="00:00:00">';
	modalform += '${STR_TIME_PASSED}: <span id="timer1">00:00:00</span> ';
	modalform += '${STR_TIME_LEFT}: <span id="timer2">00:00:00</span>';
	modalform += '<div class="online_statistics">${STR_TOTAL}: <span id="totalsendlog">0</span> ';
	modalform += '<span style="color: green">${STR_GOOD}: </span><span style="color: green" id="successful">0</span> <span style="color: red">${STR_BAD}: </span><span style="color: red" id="unsuccessful">0</span><br><br>';
	modalform += '<span onClick="sendout();" id="sendout" title="${STR_SENDOUT_TO_SUBSCRIBERS}" class="sendout_active"></span>';
	modalform += '<span onClick="stopsend(\'pause\');" id="pausesendout" title="${STR_PAUSE_SENDING}" class="pausesendout_noactive"></span>';
	modalform += '<span onClick="refreshsend();" id="refreshemail" title="${STR_REFRESH_SENDING}" class="refreshemail_noactive"></span>';
	modalform += '<span onClick="stopsend(\'stop\');" id="stopsendout" title="${STR_STOP_SENDING}" class="stopsendout_noactive"></span></div>';
	modalform += '<span id="divStatus" class="error"></span>';

	$(document).ready(function(){
		$('#Apply_').paulund_modal_box({
			title:'${STR_ONLINE_MAILINGLOG}',
			description: modalform
		});		
	});	

</script>
<!-- BEGIN pagination -->
 <div class="form-inline">
    <div class="control-group">
		${STR_PNUMBER}: <select onchange="PnumberChange(this);" class="span1 form-control" id="pnumber" name="pnumber">
        <option value="5"<!-- IF '${PNUMBER}' == 5 --> selected="selected"<!-- END IF -->> 5 </option>
        <option value="10"<!-- IF '${PNUMBER}' == 10 --> selected="selected"<!-- END IF -->> 10 </option>
		<option value="15"<!-- IF '${PNUMBER}' == 15 --> selected="selected"<!-- END IF -->> 15 </option>
        <option value="20"<!-- IF '${PNUMBER}' == 20 --> selected="selected"<!-- END IF -->> 20 </option>
		<option value="50"<!-- IF '${PNUMBER}' == 50 --> selected="selected"<!-- END IF -->> 50 </option>
		<option value="100"<!-- IF '${PNUMBER}' == 100 --> selected="selected"<!-- END IF -->> 100 </option>
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
<!-- INCLUDE footer.tpl -->