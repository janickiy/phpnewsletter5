<!-- INCLUDE header.tpl -->
<script type="text/javascript">

  (function($) {

    $.fn.scrollPagination = function(options) {

      var settings = {
        nop     : 25,
        offset  : 25,
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

        if ($settings.scroll == true)
          $initmessage = '${SHOW_MORE}';
        else
          $initmessage = '${STR_CLICK}';

        $("#msgShow").html('<div class="btn">'+$initmessage+'</div>');

        function getData() {
          var order = new Array();;
          order['email']    = "email";
          order['time']     = "time";

          var strtmp = "id";

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

          url = getUrlVars()["url"];

          $.post('./?t=ajax&action=showredirectlogs', {
            number	: $settings.nop,
            offset	: offset,
            url		: url,
            strtmp  : strtmp,

          }, function(data) {
            $("#msgShow").html($initmessage);

            if(data == null || data.item == null) {
              $("#msgShow").html($settings.error);
              $("#msgShow").addClass("disabled");
            }
            else {
              offset = offset+$settings.nop;

              for(var i=0; i < data.item.length; i++) {
                if(data.item[i].email == null) $("#msgShow").html('${STR_SHOW_MORE}');
                var content = '';
                content += '<tr><td>' + data.item[i].email + '</td><td>' + data.item[i].time + '</td></tr>';
                $('#logTable > tbody > tr:last').after(content);
              }

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

    $('#page-wrapper').scrollPagination({
      nop     : 25,
      offset  : 25,
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
    document.cookie = "pnumber_redirect_log=" + pnumber;
    location.reload();
  }

</script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<!-- IF '${INFO_ALERT}' != '' -->

<div class="alert alert-info"> ${INFO_ALERT} </div>
<!-- END IF -->
<!-- BEGIN LogList -->
<!-- IF 'ACCOUNT_ROLE' == 'admin' || 'ACCOUNT_ROLE' == 'moderator' --><p><a class="btn" href="./?t=redirect_log&clear_log"> <i class="icon-trash"></i> ${STR_CLEAR_LOG} </a></p><!-- END IF -->
<!-- INCLUDE info.tpl -->
<!-- IF '${ERROR_ALERT}' != '' -->
<div class="alert alert-error">
  <button class="close" data-dismiss="alert">×</button>
  <strong>${STR_ERROR}!</strong> ${ERROR_ALERT} </div>
<!-- END IF -->
<!-- INCLUDE success.tpl -->
<p><a class="btn btn-outline btn-danger" href="./?t=redirect_log&clear_log"> <i class="fa fa-trash-o"></i> ${STR_CLEAR_LOG} </a></p>
<table class="table-hover table table-bordered" border="0" cellspacing="0" cellpadding="0" width="100%">
  <thead>
  <tr>
    <th>URL</th>
    <th>${STR_NUMBER_REDIRECT}</th>
    <th>${STR_DOWNLOAD_REPORT}</th>
  </tr>
  </thead>
  <tbody>
  <!-- BEGIN redirect_log -->
  <tr>
    <td>${URL}</td>
    <td><a href="./?t=redirect_log&url=${URL}">${NUMBER_REDIRECT}</a></td>
    <td><!-- IF '${ALLOW_DOWNLOAD}' == 'yes' --><span class="IconExcel"></span><a title="${STR_DOWNLOADSTAT}" href="./?t=redirectlogstatxls&url=${URL}">${STR_DOWNLOAD}</a><!-- END IF --></td>
  </tr>
  <!-- END redirect_log -->
  </tbody>
</table>
<!-- BEGIN pagination -->
<div class="row">
  <div class="col-sm-6">
    <div class="dataTables_length">
      <label>
        ${STR_PNUMBER}: <select onchange="PnumberChange(this);" class="span1 form-control" id="pnumber" name="pnumber">
          <option value="10"<!-- IF '${PNUMBER}' == 10 --> selected="selected"<!-- END IF -->> 10 </option>
          <option value="20"<!-- IF '${PNUMBER}' == 20 --> selected="selected"<!-- END IF -->> 20 </option>
          <option value="50"<!-- IF '${PNUMBER}' == 50 --> selected="selected"<!-- END IF -->> 50 </option>
          <option value="100"<!-- IF '${PNUMBER}' == 100 --> selected="selected"<!-- END IF -->> 100 </option>
        </select>
      </label>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="dataTables_paginate paging_simple_numbers">
      <ul class="pagination">
        <!-- IF '${PERVPAGE}' != '' -->
        <li class="paginate_button previous">${PERVPAGE}</li>
        <!-- END IF -->
        <!-- IF '${PERV}' != '' -->
        <li class="paginate_button previous">${PERV}</li>
        <!-- END IF -->
        <!-- IF '${PAGE2LEFT}' != '' -->
        <li class="paginate_button ">${PAGE2LEFT}</li>
        <!-- END IF -->
        <!-- IF '${PAGE1LEFT}' != '' -->
        <li class="paginate_button ">${PAGE1LEFT}</li>
        <!-- END IF -->
        <!-- IF '${CURRENT_PAGE}' != '' -->
        <li class="paginate_button active">${CURRENT_PAGE}</li>
        <!-- END IF -->
        <!-- IF '${PAGE1RIGHT}' != '' -->
        <li class="paginate_button ">${PAGE1RIGHT}</li>
        <!-- END IF -->
        <!-- IF '${PAGE2RIGHT}' != '' -->
        <li class="paginate_button ">${PAGE2RIGHT}</li>
        <!-- END IF -->
        <!-- IF '${NEXTPAGE}' != '' -->
        <li class="paginate_button next">${NEXTPAGE}</li>
        <!-- END IF -->
        <!-- IF '${NEXT}' != '' -->
        <li class="paginate_button next">${NEXT}</li>
        <!-- END IF -->
      </ul>
    </div>
  </div>
</div>
<!-- END pagination -->

  <!-- END LogList -->
  <!-- BEGIN DetailLog -->
  <p>« <a href="./?t=redirect_log">${STR_BACK}</a></p>
  <table id="logTable" class="table-hover table table-bordered" border="0" cellspacing="0" cellpadding="0" width="100%">
    <thead>
      <tr>
        <th class="${THCLASS_EMAIL}"><a href="./?t=redirect_log&email=${GET_EMAIL}&url=${URL}">E-mail</a></th>
        <th class="${THCLASS_TIME}"><a href="./?t=redirect_log&time=${GET_TIME}&url=${URL}">${TH_TABLE_TIME}</a></th>
      </tr>
    </thead>
    <tbody>
      <!-- BEGIN row -->
      <tr>
        <td>${EMAIL}</td>
        <td>${TIME}</td>
      </tr>
      <!-- END row -->
    </tbody>
  </table>
  <p>
    <div class="btn" class="loading-bar" id="msgShow"></div>
</p>
<!-- END DetailLog -->
<!-- INCLUDE footer.tpl -->