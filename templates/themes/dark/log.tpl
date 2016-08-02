<!-- INCLUDE header.tpl -->
<script type="text/javascript">

(function($) {

	$.fn.scrollPagination = function(options) {
		
		var settings = { 
			nop     : 50,
			offset  : 50,
			error   : '${STR_THERE_ARE_NO_MORE_ENTRIES}',
			delay   : 500,
			scroll  : true 
		}		
		
		if(options) {
			$.extend(settings, options);
		}
		
		return this.each(function() {		
			
			$this = $(this);
			$settings = settings;
			var offset = $settings.offset;
			var busy = false;
			
			if($settings.scroll == true) $initmessage = '${SHOW_MORE}';
			else $initmessage = '${STR_CLICK}';
			
			$("#msgShow").html('<div class="btn">'+$initmessage+'</div>');
			
			function getData() {
				var order = new Array();;
				order['name']     = "s.name";
				order['email']    = "email";
				order['time']     = "a.time";
				order['success']  = "success";
				order['readmail'] = "readmail";
				order['catname']  = "c.name";
			
				var strtmp = "id_log";
				
				for (var key in order) {
					var val = order [key];

					if(getUrlVars()[key] != undefined){
						if(getUrlVars()[key] == "up"){
							strtmp = val;
						}
						else{
							strtmp = val + " DESC";
						}
					}	
				} 
			
				id_log = getUrlVars()["id_log"];	
			
				$.post('./?t=ajax_log', {
					action		: 'scrollpagination',
				    number		: $settings.nop,
				    offset		: offset,
					id_log		: id_log,
					strtmp		: strtmp,  
					    
				}, function(data) {
					$("#msgShow").html($initmessage);

					if(data == "") { 
						$("#msgShow").html($settings.error);
						$("#msgShow").addClass("disabled");
					}
					else {
					    offset = offset+$settings.nop; 
						
						$('#logTable > tbody > tr:last').after(data);

						busy = false;
					}						
				});					
			}	
			
			getData();
			
			if($settings.scroll == true) {
				$(window).scroll(function() {
					if($(window).scrollTop() + $(window).height() > $this.height() && !busy) {
						busy = true;
						
						$this.find('.loading-bar').html('${STR_LOADING_DATA}');
						
						setTimeout(function() {
							getData();
						}, $settings.delay);							
					}	
				});
			}
			
			$this.find('.loading-bar').click(function() {
			
				if(busy == false) {
					busy = true;
					getData();
				}			
			});
			
		});
	}

})(jQuery);

$(document).ready(function() {

	$('#content').scrollPagination({
		nop     : 50, 
		offset  : 50, 
		error   : '${STR_THERE_ARE_NO_MORE_ENTRIES}', 
		delay   : 500, 
		scroll  : true 		
	});	
});

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

function PnumberChange()
{
	var pnumber = document.getElementById("pnumber").value;
	document.cookie = "pnumber_log=" + pnumber;
	location.reload();
}

</script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<!-- IF '${INFO_ALERT}' != '' -->

<div class="alert alert-info"> <span class="icon icon-exclamation-sign"></span>${INFO_ALERT} </div>
<!-- END IF -->
<!-- BEGIN LogList -->
<p><a class="btn btn-danger" href="./?t=log&clear_log"> <i class="icon icon-trash"></i> ${STR_CLEAR_LOG} </a></p>
<!-- IF '${INFO_ALERT}' != '' -->
<div class="alert alert-info"> ${INFO_ALERT} </div>
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
  <span class="icon icon-ok-sign"></span>
  ${MSG_ALERT} </div>
<!-- END IF -->
<table class="datatable table table-striped table-bordered dataTable" border="0" cellspacing="0" cellpadding="0" width="100%">
  <thead>
    <tr>
      <th>${TH_TABLE_TIME}</th>
      <th>${TH_TABLE_TOTAL}</th>
      <th>${TH_TABLE_SENT}</th>
      <th>${TH_TABLE_NOSENT}</th>
      <th>${TH_TABLE_READ}</th>
      <th>${TH_TABLE_DOWNLOAD_REPORT}</th>
    </tr>
  </thead>
  <tbody>
    <!-- BEGIN row -->
    <tr>
      <td>${TIME}</td>
      <td><a href="./?t=log&id_log=${ID_LOG}">${TOTAL}</a></td>
      <td>${TOTAL_SENT}</td>
      <td>${TOTAL_NOSENT}</td>
      <td>${TOTAL_READ}</td>
      <td><span class="IconExcel"></span><a title="${STR_DOWNLOADSTAT}" href="./?t=logstatxls&id_log=${ID_LOG}">${STR_DOWNLOAD}</a></td>
    </tr>
    <!-- END row -->
  </tbody>
</table>
<!-- BEGIN pagination -->
<div class="form-inline">
  <div class="control-group"> ${STR_PNUMBER}:
    <select onchange="PnumberChange(this);" class="span1 form-control" id="pnumber" name="pnumber">
      <option value="5" <!-- IF '${PNUMBER}' == 5 -->selected="selected"<!-- END IF -->> 5 </option>
      <option value="10" <!-- IF '${PNUMBER}' == 10 -->selected="selected"<!-- END IF -->> 10 </option>
      <option value="15" <!-- IF '${PNUMBER}' == 15 -->selected="selected"<!-- END IF -->> 15 </option>
      <option value="20" <!-- IF '${PNUMBER}' == 20 -->selected="selected"<!-- END IF -->> 20 </option>
      <option value="50" <!-- IF '${PNUMBER}' == 50 -->selected="selected"<!-- END IF -->> 50 </option>
      <option value="100" <!-- IF '${PNUMBER}' == 100 -->selected="selected"<!-- END IF -->> 100 </option>
    </select>
    <div class="pull-right">
      <ul class="pagination">
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
          <li class="active">${CURRENT_PAGE}</li>
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
     </div>
  </div>
  <!-- END pagination -->
  <!-- END LogList -->
  <!-- BEGIN DetailLog -->
  <p>« <a href="./?t=log">${STR_BACK}</a></p>
  <table id="logTable" class="datatable table table-striped table-bordered dataTable" border="0" cellspacing="0" cellpadding="0" width="100%">
    <thead>
      <tr>
        <th class="${THCLASS_NAME}"><a href="./?t=log&name=${GET_NAME}&id_log=${ID_LOG}">${TH_TABLE_MAILER}</a></th>
        <th class="${THCLASS_EMAIL}"><a href="./?t=log&email=${GET_EMAIL}&id_log=${ID_LOG}">E-mail</a></th>
        <th class="${THCLASS_CATNAME}"><a href="./?t=log&catname=${GET_CATNAME}&id_log=${ID_LOG}">${TH_TABLE_CATNAME}</a></th>
        <th class="${THCLASS_TIME}"><a href="./?t=log&time=${GET_TIME}&id_log=${ID_LOG}">${TH_TABLE_TIME}</a></th>
        <th class="${THCLASS_SUCCESS}"><a href="./?t=log&success=${GET_SUCCESS}&id_log=${ID_LOG}">${TH_TABLE_STATUS}</a></th>
        <th class="${THCLASS_READMAIL}"><a href="./?t=log&readmail=${GET_READMAIL}&id_log=${ID_LOG}">${TH_TABLE_READ}</a></th>
        <th>${TH_TABLE_ERROR}</th>
      </tr>
    </thead>
    <tbody>
      <!-- BEGIN row -->
      <tr>
        <td>${NAME}</td>
        <td>${EMAIL}</td>
        <td>${CATNAME}</td>
        <td>${TIME}</td>
        <td>${STATUS}</td>
        <td>${READ}</td>
        <td width="30%">${ERRORMSG}</td>
      </tr>
      <!-- END row -->
    </tbody>
  </table>
  <p>
    <div class="btn btn-default loading-bar" id="msgShow">
</div>
</p>
<!-- END DetailLog -->
<!-- INCLUDE footer.tpl -->