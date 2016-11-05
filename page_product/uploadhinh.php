<?php 
	$file_id = "";
	if(isset($_FILE["ip_anhlon"])){

		$file_id = $_FILE["ip_anhlon"];

	}else if(isset($_FILE["ip_anhnho"])){
		$file_id = $_FILE["ip_anhnho"];
	}

	$file_dir = "../hinhsanpham/"
	$filename = $file_id["name"];
	$file_tmp = $file_id["tmp_name"];
	
	if(move_uploaded_file($file_tmp, $file_dir.$filename)){
		$output = array["Upload thành công"];
	}else{
		$output = array["Up load thất bại"];
	}

	echo json_encode($output);
?>