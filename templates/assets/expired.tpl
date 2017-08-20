<!-- INCLUDE header.tpl -->
<!-- INCLUDE info.tpl -->
<!-- INCLUDE errors.tpl -->
<!-- INCLUDE success.tpl -->
<p>${STR_MSG}</p>
<form action="${ACTION}" method="post">
    <input type="hidden" name="action" value="post">
    <div class="form-group">
        <label for="license_key">${STR_LICENSE_KEY}</label>
        <input class="form-control" type="text" style="text-transform: uppercase;" name="license_key" value="${LICENSE_KEY}">
    </div>
    <div class="controls">
        <input type="submit" class="btn btn-success" value="${BUTTON_SAVE}">
    </div>
</form>
<!-- INCLUDE footer.tpl -->