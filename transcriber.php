<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php



//DECLARATIONS
$Resumeslocation = "/var/www/html/Untitled Folder/pdfminer/resume";



//AUTHOR: suzukikijai22
if(isset($_FILES['resume'])){

	$errors= array();
	$file_name = $_FILES['resume']['name'];
	$text_name = preg_replace('/(.*)\.[^.]+/', '$1', $file_name).'.txt';
	$file_size =$_FILES['resume']['size'];
	$file_tmp =$_FILES['resume']['tmp_name'];
	$file_type=$_FILES['resume']['type'];
	$file_ext=strtolower(end(explode('.',$_FILES['resume']['name'])));


	$expensions= array("pdf","doc","docx","rtf");

	if(in_array($file_ext,$expensions)=== false){
		$errors[]="extension not allowed, please choose a valid resume/CV format file.";
	}

	if($file_size > 20971520){
		$errors[]='File size must be excately 20 MB';
	}

	if(empty($errors)==true){
		move_uploaded_file($file_tmp,"resume/".$file_name);
		if($file_ext == "pdf"){
			$pythonX3 = `pdftotext "$Resumeslocation/$file_name"`;
		}
		else if($file_ext == "doc"){
			$pythonX3 = `cat "$Resumeslocation/$file_name" > "$Resumeslocation/$text_name"`;
		}
		else if($file_ext == "docx"){
			$pythonX3 = `docx2txt "$Resumeslocation/$file_name"`;
		}
		else if($file_ext == "rtf"){
			$pythonX2 = `unrtf --text --quiet /home/sageadmin/Desktop/sdfsd.rtf | grep "^[^#]"`;
			$pythonX2 = preg_replace('/-+(.*)/', '$1', $pythonX2);
			// echo $pythonX2;
			$pythonX3 = `echo "$pythonX2" > "$Resumeslocation/$text_name"`;
		}
		else if($file_ext == "txt"){
			$pythonX3 = `cat "$Resumeslocation/$file_name" > "$Resumeslocation/$text_name"`;
		}
		

		$pythonX4 = `cat "$Resumeslocation/$text_name"`;
		echo nl2br($pythonX4);
	}else{
		print_r($errors);
	}
}

?>