<?php 
function DispDate($dtmDate){
	$year = substr($dtmDate, 0, 4); // returns YYYY
	$month = substr($dtmDate, 5, 2); // returns MM
	$day = substr($dtmDate, 8, 2); // returns DD
	if($day == '00' || $day == ''){
		$dtmDate = '';
	}else{			
		$dtmDate = $day."/".$month."/".$year;
	}
	return $dtmDate;
}

function send_mesej($conn, $appli_id, $code_msg, $sent_to, $note){

	if (file_exists('mail_send.php')) {
		include_once 'mail_send.php';
	} else if (file_exists('../_msys/email/mail_send.php')) {
		include_once '../_msys/email/mail_send.php';
	} else if (file_exists('../../_msys/email/mail_send.php')) {
		include_once '../../_msys/email/mail_send.php';
	}
	$ip = $_SERVER['REMOTE_ADDR'];

	// $conn->debug=true;
    	$pid = $appli_id;

	$sql = "SELECT A.`id` AS apply_id, A.`appli_type`, A.`applicant_id`, A.`id`, A.`note_keputusan`, A.`ref_no`, B.`com_name`, 
		B.`com_email`, B.`user_id`, B.`app_name`, A.`appli_dt`   
		FROM `appli` A, `applicant` B WHERE A.`applicant_id`=B.`id` AND A.`id`='{$appli_id}'";
	$rsData = $conn->query($sql);
	
	if($rsData->EOF){
		$sql = "SELECT A.`id` AS apply_id, A.`appli_type`, A.`applicant_id`, A.`id`, A.`note_keputusan`, A.`ref_no`, B.`com_name`, 
			B.`com_email`, B.`user_id`, B.`app_name`, A.`appli_dt`  
			FROM `appli` A, `applicant` B WHERE A.`applicant_id`=B.`id` AND A.`ref_no`='{$appli_id}'";
		$rsData = $conn->query($sql);
	}
	

	$applicant_id = $rsData->fields['applicant_id'];
	$appli_id = $rsData->fields['id'];
	$ref_no = $rsData->fields['ref_no'];
	$appli_dt = $rsData->fields['appli_dt'];
	$com_name = $rsData->fields['com_name'];
	$com_email = $rsData->fields['com_email'];
	$app_name = $rsData->fields['app_name'];
	$user_id = $rsData->fields['user_id'];
	$appli_type = $rsData->fields['appli_type'];
	if(empty($note)){
	    $note = $rsData->fields['note_keputusan'];
    	}

    	$audit = $sql;
    
	$rsNotis = $conn->query("SELECT * FROM `notice_template` WHERE `code`='{$code_msg}'");
	$tajuk = $rsNotis->fields['descr'];
	$mesej = $rsNotis->fields['message'];
	//if($cat=='L1'){ $appli_type = 'Permohonan Lesen Baru'; }
	if(!empty($appli_type)){
    		$rsT = $conn->query("SELECT `descr` FROM `appli_type` WHERE `code`='{$appli_type}'");
    		$appli_type = $rsT->fields['descr'];
    	}
    	$audit .= "<br>".$mesej;

	$sqli = "INSERT INTO `data_auditrail`(id_user, log_user, ip, remarks, trans_date, actions, pages) 
	VALUES ('0', 'admin', '{$ip}', '".addslashes($sql)."', '".date("Y-m-d H:i:s")."', 'emel','notis_email.php')";
    	$conn->execute($sqli);


	if($code_msg=='J001'){
		$rsMtg = $conn->query("SELECT `meeting_dt` FROM `meeting` A, `appli` B WHERE A.`id`=B.`meeting_no` AND B.`id`='{$appli_id}'");
		$meeting_dt = DisplayDate($rsMtg->fields['meeting_dt']);
	}

	if($code_msg=='L102'){
		// $conn->debug=true;
		$rsItem = $conn->query("SELECT count(A.`id`) AS JUM FROM `license_item` A, `appli` B 
			WHERE A.`appli_id`=B.`id` AND B.`id`='{$appli_id}' AND A.`check_sts`='P'");
		$pass = $rsItem->fields['JUM'];
		$rsItem = $conn->query("SELECT count(A.`id`) AS JUM FROM `license_item` A, `appli` B 
			WHERE A.`appli_id`=B.`id` AND B.`id`='{$appli_id}' AND A.`check_sts`='F'");
		$fail = $rsItem->fields['JUM'];

		if(!empty($pass)){ $note = "<br>Jumlah Item Lulus : ".$pass; }
		if(!empty($fail)){ $note .= "<br>Jumlah Item Gagal : ".$fail; }
		// print $note;
	}

    // MESEJ YANG PE:RU DISEDIAKAN
	$mesej = str_replace("[[com_name]]",$com_name,$mesej);
	$mesej = str_replace("[[appli_type]]",$appli_type,$mesej);
	$mesej = str_replace("[[type]]",$appli_type,$mesej);
	
	$mesej = str_replace("[[app_name]]",$app_name,$mesej);
	$mesej = str_replace("[[appli_dt]]",DisplayDate($appli_dt),$mesej);
	$mesej = str_replace("[[ref_no]]",$ref_no,$mesej);
	$mesej = str_replace("[[id_premis]]",$user_id,$mesej);
	$mesej = str_replace("[[meeting_dt]]",$meeting_dt,$mesej);
	
    	if($note=='TJ'){
		//$conn->debug=true;
		$rsTJ = $conn->query("SELECT A.*, B.com_name, B.com_email FROM `appointment` A, applicant B WHERE A.`appm_id`='{$pid}' AND A.applicant_id=B.id");
		$mesej = str_replace("[[tarikh]]",DisplayDate($rsTJ->fields['appm_date']),$mesej);
		$mesej = str_replace("[[masa]]",$rsTJ->fields['appm_time'],$mesej);
		$mesej .= "<br>Ulasan: ".$rsTJ->fields['appm_remarks'];

		$applicant_id = $rsTJ->fields['applicant_id'];
		if(!empty($rsTJ->fields['com_email'])){
			$com_email = $rsTJ->fields['com_email'];
			$com_name = $rsTJ->fields['com_name'];
		} 
		//$dari = 'aemh@dvs.gov.my';				 // system email
		

		//notis_pemohon($code_msg, $applicant_id, $appli_id, $user_id, $com_email, $mesej);

		// HANTAR EMEL KEPADA PEMOHON
		// $com_email='nizamms@gmail.com';
		//$err = mail_smtp('Temujanji', $mesej, $com_email, '', $dari, $cc); 

	} else {
	    $mesej = str_replace("[[note]]",$note, $mesej);
	}
    
	// print $mesej; exit;

	// $mesej = str_replace("[[ref_no]]",$ref_no,$mesej);
	// $mesej = str_replace("[[ref_no]]",$ref_no,$mesej);
	$dari = 'aemh@dvs.gov.my';				 // system email
	$cc = ''; //'xxx@com.my';				 // jika ada
	
// 	print $mesej; exit;

	if($sent_to=='us' || $sent_to=='US'){ 
		// NOTIS KEPADA URUSETIA

		// $rsu = $conn->query("SELECT A.`email`, A.`id`, A.`user_id`, A.`name` FROM `user` A, `user_role` B 
		// 	WHERE A.`id`=B.`user_id` AND B.`role` LIKE 'us' AND A.`state` is NOT NULL AND A.`user_id` IS NOT NULL AND A.`email` IS NOT NULL");
	
		$rsu = $conn->query("SELECT A.`email`, A.`id`, A.`user_id`, A.`name` FROM `user` A 
			WHERE A.`role` LIKE '%us%' AND A.`state` is NOT NULL AND A.`user_id` IS NOT NULL AND A.`email` IS NOT NULL");
		while(!$rsu->EOF){ 
			$staff_id = $rsu->fields['user_id'];
			$staff_email = $rsu->fields['email'];
			$staff_name = $rsu->fields['name'];
			
			// HANTAR NOTIS
			// cat : applicant_id : appli_id : user_id : user_email : message
			notis_admin($code_msg, $applicant_id, $appli_id, $staff_id, $staff_email, $mesej);
	
			// HANTAR EMEL OFF SEKEJAP
			//$staff_email='nizamms@gmail.com';
			$err = mail_smtp($tajuk, $mesej, $staff_email, $staff_name, $dari, $cc); 
			
			// NEXT RECORD
			$rsu->movenext();
		}

	} else if($sent_to=='pdk' || $sent_to=='PDK'){ 
		// NOTIS KEPADA URUSETIA

		$state = dlookup("`applicant`","com_state","`id`=".tosql($applicant_id));

		if($state=='J'){ $negeri = "01"; }
		else if($state=='K'){ $negeri = "02"; }
		else if($state=='D'){ $negeri = "03"; }
		else if($state=='M'){ $negeri = "04"; }
		else if($state=='N'){ $negeri = "05"; }
		else if($state=='C'){ $negeri = "06"; }
		else if($state=='A'){ $negeri = "07"; }
		else if($state=='P'){ $negeri = "08"; }
		else if($state=='R'){ $negeri = "09"; }
		else if($state=='B'){ $negeri = "10"; }
		else if($state=='T'){ $negeri = "11"; }
		else if($state=='QS'){ $negeri = "12"; }
		else if($state=='QA'){ $negeri = "13"; }
		else if($state=='KL'){ $negeri = "14"; }
		else if($state=='LB'){ $negeri = "15"; }
		else if($state=='PJ'){ $negeri = "16"; }


		if(!empty($negeri)){
			$rsu = $conn->query("SELECT A.`email`, A.`id`, A.`user_id`, A.`name` FROM `user` A 
				WHERE A.`role` LIKE '%pdk%' AND A.`state` is NOT NULL AND A.`user_id` IS NOT NULL 
				AND A.`email` IS NOT NULL AND A.`state` LIKE '%".$negeri."%'");
			while(!$rsu->EOF){ 
				$staff_id = $rsu->fields['user_id'];
				$staff_email = $rsu->fields['email'];
				$staff_name = $rsu->fields['name'];
			
				// HANTAR NOTIS
				// cat : applicant_id : appli_id : user_id : user_email : message
				notis_admin($code_msg, $applicant_id, $appli_id, $staff_id, $staff_email, $mesej);
	
				// HANTAR EMEL OFF Sekejap
				// $staff_email='nizamms@gmail.com';
 				$err = mail_smtp($tajuk, $mesej, $staff_email, $staff_name, $dari, $cc); 
			
				// NEXT RECORD
				$rsu->movenext();
			}
		}

	} else if($sent_to=='tj' || $sent_to=='TJ'){ 
		// NOTIS KEPADA URUSETIA
        
        // $conn->debug=true;
        
        $rs = $conn->query("SELECT A.*, B.com_name FROM `appointment` A, `applicant` B WHERE A.`applicant_id`=B.`id` AND A.`appm_id`='{$pid}'");
        $applicant_id = $rs->fields['applicant_id'];
        $appm_pic = $rs->fields['appm_pic'];
        $com_name = $rs->fields['com_name'];
        
		$rsu = $conn->query("SELECT DISTINCT A.`id`, A.`email`, A.`user_id`, A.`name`, C.`urusetia_id` 
		    FROM `user` A, `user_role` B, `appli_pic` C 
		    WHERE A.`id`=B.`user_id` AND A.`id`=C.`urusetia_id` 
		    AND B.`role` LIKE 'us' AND A.`id`='{$appm_pic}' AND A.`user_id` IS NOT NULL AND A.`email` IS NOT NULL");
		while(!$rsu->EOF){ 
			$staff_id = $rsu->fields['user_id'];
			$staff_email = $rsu->fields['email'];
			$staff_name = $rsu->fields['name'];
			
			$mesej .= "<br>Syarikat : ".$com_name;
			// HANTAR NOTIS
			// cat : applicant_id : appli_id : user_id : user_email : message
			notis_admin($code_msg, $applicant_id, $pid, $staff_id, $staff_email, $mesej);
	
			// HANTAR EMEL OFF SEKEJAP
		// 			$staff_email='nizamms@gmail.com';
 			$err = mail_smtp($tajuk, $mesej, $staff_email, $staff_name, $dari, $cc); 
			
			// NEXT RECORD
			$rsu->movenext();
		}

	} else if($sent_to=='owner'){
		
		//print $mesej.'@'.$tajuk.'@'.$com_email.'@'.$com_name.'@'.$dari.'@'.$cc; exit();

		// HANTAR NOTIS KEPADA PEMOHON
		// cat : applicant_id : appli_id : user_id : user_email : message
		notis_pemohon($code_msg, $applicant_id, $appli_id, $user_id, $com_email, $mesej);

		// HANTAR EMEL KEPADA PEMOHON
		// $com_email='nizamms@gmail.com';
		$cc = 'hidayumutalib@gmail.com';
		$err = mail_smtp($tajuk, $mesej, $com_email, $com_name, $dari, $cc); 


	}


}


?>