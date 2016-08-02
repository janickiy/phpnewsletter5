<!-- INCLUDE header.tpl -->
<p>« <a href="./?t=subscribers">${STR_BACK}</a></p>
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
<strong>${STR_ERROR}!</strong>
${ERROR_ALERT}
</div>
<!-- END IF -->
<!-- IF '${MSG_ALERT}' != '' -->
<div class="alert alert-success">
<button class="close" data-dismiss="alert">×</button>
<span class="icon icon-ok-sign"></span>
${MSG_ALERT}
</div>
<!-- END IF -->
<span class="info-import"></span>
<form enctype="multipart/form-data" action="${ACTION}" method="post">
<div class="form-group">
<label for="file">${TABLE_DATABASE_FILE}</label>
<input type="file" name="file" value="">
</div>
<div class="form-group">
<label for="charset">${STR_CHARSET}</label>
<select class="form-control form-primary" name="charset">
<option value="">--${STR_NO}--</option>        
${OPTION}      
</select>
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
    <div class="form-group">
      <input class="btn btn-success" type="submit" name="action" value="${BUTTON_ADD}">
    </div>
</form>
<!-- INCLUDE footer.tpl -->