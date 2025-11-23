<?php 
session_start();
$new_file = $_FILES['file1'];
$file_name = $new_file['name'];
$file_name = str_replace(" ","_",$file_name); 
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";

if(!empty($file_name) && $pro=='PROSES'){
	$upload_dir = 'data/';
	$new_file = $_FILES['file1'];
	$file_name = strtolower(str_replace(" ","_",$new_file['name'])); 
	unlink($upload_dir.$file_name);

	if ($_FILES["file1"]["error"] > 0){
	    $text .= "Apologies, an error has occurred.";
	    $text .= "Error Code: " . $_FILES["file1"]["error"];
	} else {
		// print $_FILES["file1"]["tmp_name"];
		$nama_fails =  $upload_dir.$file_name;
		if(move_uploaded_file($_FILES["file1"]["tmp_name"], $nama_fails)) { 
			$text .= "The file ". basename($uploadedfile). " has been uploaded"; 
		} else { 
			$text .= "<br>".$nama_fails."<br>Sorry, there was a problem uploading your file.";
			$text .= "<br>".phpFileUploadErrors($_FILES['file1']['error']); 
			exit;
		}
	}

	require 'zipconverter.php';
	$zip = new zipConverter();
	$zip->setRecursiveness(true); //default is false
	// $zip->addFolder(
	//     array(
	//         './', //path of the current file
	//         '/uploads', //Windows Path
	//         '/zip_folder'  //linux path
	//     )
	// );

	// $zip->addFolder(
	//     array(
	//         '/var/www/upload/20230414145982', 
	//         '/var/www/upload/20231107011354'
	//     )
	// );


	//include '../../connection/common.php';
	//$conn->debug=true;

	$datas = array();
	//$datas = '';
	$row = 0; $bilr=0; $rows=0;
	if (($handle = fopen("data_spp.csv", "r")) !== FALSE) {
	    while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {
	        //$num = count($data);
	        if($row>=1){
		        $bil = $data[0];
		        $id_pemohon = trim($data[1]);
			//print $id_pemohon;
			if($bilr==0){
				$datas[]="/var/www/upload/".$id_pemohon."";
			} else {
				$datas[]="/var/www/upload/".$id_pemohon."";
			}
			$bilr++;
		}
		$row++;
	    }
	}
	//print_r($datas);

	// PREPARING FOLDER TO SEND TO ZIP FILE
	$zip->addFolder($datas);

	$filename = 'files.zip';
	// DELETE FILE IF EXIST
	if (file_exists($filename)) { unlink($filename); }

	// CREATE NEW ZIP FILE
	$zip->setZipPath($filename); //Set your Zip Path with your Zip File's Name
	$result = $zip->createArchive();

	// DOWNLOAD FILES
	if(file_exists($filename)) {

	//Define header information
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: 0");
	header('Content-Disposition: attachment; filename="'.basename($filename).'"');
	header('Content-Length: ' . filesize($filename));
	header('Pragma: public');

	//Clear system output buffer
	flush();

	//Read the size of the file
	readfile($filename);

	//Terminate from the script
	die();
	}
	//echo "<pre>";var_dump($result);echo "</pre>";
}
?>