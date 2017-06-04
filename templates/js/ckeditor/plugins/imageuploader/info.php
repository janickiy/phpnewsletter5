<?php 

if (isset($_FILES["fic"]["name"])) {
	$path = isset($_POST['path']) ? urldecode($_POST['path']) : '';
	if (move_uploaded_file($_FILES["fic"]["tmp_name"], $path . $_FILES["fic"]["name"])) {
         echo "yes"; 
	} else echo "no"; 
} 