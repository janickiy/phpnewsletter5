<!-- INCLUDE header.tpl -->
<p>« <a href="./?t=subscribers">${STR_BACK}</a></p>
<!-- IF '${INFO_ALERT}' != '' -->
<div class="alert alert-info">${INFO_ALERT}</div>
<!-- END IF -->

<!-- IF '${ERROR_ALERT}' != '' -->
<div class="alert alert-danger alert-dismissable">
    <button class="close" aria-hidden="true" data-dismiss="alert">×</button>
    <strong>${STR_ERROR}!</strong> ${ERROR_ALERT}
</div>
<!-- END IF -->

<!-- IF '${MSG_ALERT}' != '' -->
<div class="alert alert-success alert-dismissable">
    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
    ${MSG_ALERT}
</div>
<!-- END IF -->

<span class="info-import"></span>
<form class="form-horizontal" enctype="multipart/form-data" action="${ACTION}" method="post">
    <div class="control-group">
      <label class="control-label" for="file">${TABLE_DATABASE_FILE}:</label>
	  <div class="controls">
      <input class="span6 input-xlarge focused" type="file" name="file" value="">
	  </div>
   </div>	
   <div class="control-group">
      <label class="control-label" for="charset">${STR_CHARSET}:</label>
	  <div class="controls">
      <select class="span3 form-control" name="charset">
        <option value="">--${STR_NO}--</option>        
		${OPTION}      
      </select>
	  </div>
     </div>		
    <div class="control-group">
      <label class="control-label" for="id_cat[]">${TABLE_CATEGORY}:</label>
      <!-- BEGIN row -->
	  <label class="checkbox">
	  <div class="controls">
      <input type="checkbox" value="${ID_CAT}" name="id_cat[]">${NAME}
	  </div>
	  </label>      
      <!-- END row -->
   </div>	
    <div class="controls">
      <input class="btn btn-success" type="submit" name="action" value="${BUTTON_ADD}">
    </div>
</form>
<!-- INCLUDE footer.tpl -->