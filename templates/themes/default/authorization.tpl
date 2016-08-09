<!DOCTYPE html>
<html>
<head>
<title>${TITLE}</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link href="./templates/themes/default/styles/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="./templates/themes/default/styles/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="./templates/themes/default/styles/styles.css" rel="stylesheet" media="screen">
<link href="./templates/themes/default/styles/DT_bootstrap.css" rel="stylesheet" media="screen">				
</head>
<body>				
<div class="container">
<div class="row">
<div class="row text-center">
<div class="col-md-12">
<br>
<br>
<h2>${STR_ADMIN_AREA}  ${SCRIPT_NAME}</h2>
<br>
</div>
</div>
<form class="form-signin" method="post">
<h4 class="form-signin-heading">${STR_SIGN_IN}</h4>
<input class="input-block-level" type="text" name="login" value="${LOGIN}" placeholder="${STR_LOGIN}">
<input class="input-block-level" type="password" name="password" placeholder="${STR_PASSWORD}">
<input type="submit" class="btn btn-primary" name="admin" value=" OK ">
</form>
</div>
</body>
</html>