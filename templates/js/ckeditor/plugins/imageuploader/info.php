<?php 

if (isset($_FILES["fic"]["name"])) { 
	if (move_uploaded_file($_FILES["fic"]["tmp_name"], $_FILES["fic"]["name"])) { 
         echo "yes"; 
	} else echo "no"; 
} 