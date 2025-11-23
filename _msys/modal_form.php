<?php include '../connection/common.php'; ?>
<script>
//function do_delete(URL){
//	if(confirm("Adakah anda pasti?")){
//		document.simpeni.action = URL;
//		document.simpeni.target = '_self';
//		document.simpeni.submit();
//	}
//}

function do_delete(URL){
	if(confirm("Adakah anda pasti untuk menghapuskan data sekolah agama ini?")){
		$.ajax({
			//url:'admin/pentadbiran/klausa_sql.php?pro=SAVE', //&datas='+datas,
			url:URL,
			type:'POST',
			//dataType: 'json',
			beforeSend: function () {
				$('.btn-primary').attr("disabled","disabled");
				$('.dispmodal').css('opacity', '.5');
			},
			data: $("form").serialize(),
			//data: datas,
			success: function(data){
				//alert("Successfully submitted.");
				console.log(data);
				var getData = data.split(";");
				var err = getData[0];
				var desc = getData[1];
				//alert(err)
				if(err=='OK'){
					swal({
					  title: 'Berjaya',
					  text: 'Rekod anda telah berjaya dihapuskan dari senarai',
					  type: 'success',
					  confirmButtonClass: "btn-success",
					  confirmButtonText: "Ok",
					  showConfirmButton: true
					}).then(function () {
						//reload = window.location; 
						//window.location = reload;
						window.location.href = desc;
						
					});
				} else {
					swal({
					  title: 'Makluman',
					  text: 'Rekod tidak berjaya dihapuskan',
					  type: 'warning',
					  confirmButtonClass: "btn-warning",
					  confirmButtonText: "Ok",
					  showConfirmButton: true
					});
				}
				//console.log(data);
			}
		});
	}
}

function do_cetak(URL){
	document.simpeni.action = URL;
	document.simpeni.target = '_blank';
	document.simpeni.submit();
}

function query_data(strFileName){
	var code = document.simpeni.kategori.value; 
	var URL = strFileName + '?code=' + code;
	//alert(URL);
	//document.simpeni.action = URL;
	//document.simpeni.target = '_blank';
	//document.simpeni.submit();
	callToServer(URL);
}

function query_subjek(strFileName){
	var code = document.simpeni.kategori.value; 
	var pusat = document.simpeni.subkategori.value; 
	var URL = strFileName + '?code=' + code +'&pusat=' + pusat;
	//alert(URL);
	//document.simpeni.action = URL;
	//document.simpeni.target = '_blank';
	//document.simpeni.submit();
	callToServer(URL);
}


/***************************************
 *** To get value from remote server ***
 *** and place them to listbox       ***
 ***************************************/
function handleResponse(ID,Data,lst){
	strID = new String(ID);
	strData = new String(Data);
	if(strID == ''){
		document.simpeni.elements[lst].length = 0;
		document.simpeni.elements[lst].options[0]= new Option('Pilih','');
	}else{
		splitID = strID.split(",");
		splitData = strData.split(",");
		document.simpeni.elements[lst].options[0]= new Option('Pilih','');
		for(i=1;i<=splitID.length;i++){
			document.simpeni.elements[lst].options[i]= new Option(splitData[i-1],splitID[i-1]);
		}
		document.simpeni.elements[lst].length = splitID.length + 1;
	}
}

function close_paparan(){
	//parent.emailwindow.hide();
	refresh = parent.location; 
	parent.location = refresh;
}
</script>
<?php
$get_win = $_GET['win'];
$win = base64_decode($_GET['win']);
//$win=isset($_REQUEST["win"])?$_REQUEST["win"]:"";
$get_win = explode(";", $win);
$mpage = $get_win[0]; // piece1
$id = $get_win[1]; // piece1
$_SESSION['page_name']=$mpage;
//if(!empty($_SESSION["s_logid"]) && $_SESSION["s_logid"]=='1'){
//print "PG: ".$mpage . " / " . $id;
function update_content($id_sekolah,$user_id){
	global $conn;
	//$conn->debug=true;
	$sqlu = "UPDATE tbl_sekolah SET update_dt=".tosql(date("Y-m-d H:i:s")).", update_by='{$user_id}' 
		WHERE uid='{$id_sekolah}'";
	$conn->execute($sqlu);
	//exit;	
}

function calcutateAge($dob){
	$dob = date("Y-m-d",strtotime($dob));
	$dobObject = new DateTime($dob);
	$nowObject = new DateTime();
	$diff = $dobObject->diff($nowObject);
	return $diff->y;
}
//}
?>

<!--<body>
<form name="simpeni" method="post" action="" enctype="multipart/form-data" >
<div align="center">-->
<!--<table id="example2" class="table table-bordered table-responsive ">
	<tr>
    	<td>
			<?php //include $mpage;?>
        </td>
    </tr>
</table>-->
<!--</div>
</form>
</body>-->
<!--</html>-->
<!-- <form name="simpeni" method="post" action="" enctype="multipart/form-data" > -->
<div class="row">
<div class="col-md-12">
<section class="panel">
	<div class="modal-body" id="rekod">
		<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="close_paparan()">×</button> -->
		<?php include $mpage;?>
	</div>
</section>
</div>
</div>
<!-- </form> -->
<?php $conn->close(); ?>
