<?php 
//include '../../common_mig.php';
//error_reporting(E_ERROR | E_PARSE);
error_reporting(0);
$new_file = $_FILES['file1'];
//echo "Mana fail-->".$_FILES['binFile'];
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$file_name = str_replace(" ","_",$new_file['name']); 
$types=isset($_REQUEST["types"])?$_REQUEST["types"]:"";
$kodupkk=isset($_REQUEST["kodupkk"])?$_REQUEST["kodupkk"]:"";
$tahun=isset($_REQUEST["tahun"])?$_REQUEST["tahun"]:"";
$uid=isset($_REQUEST["uid"])?$_REQUEST["uid"]:"";

//print $file_name.":".$kodupkk;


function phpFileUploadErrors($err){
 	
    if($err==0){ $msg = 'There is no error, the file uploaded with success'; }
    else if($err==0){ $msg = 'The uploaded file exceeds the upload_max_filesize directive in php.ini'; }
    else if($err==0){ $msg = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form'; }
    else if($err==0){ $msg = 'The uploaded file was only partially uploaded'; }
    else if($err==0){ $msg = 'No file was uploaded'; }
    else if($err==0){ $msg = 'Missing a temporary folder'; }
    else if($err==0){ $msg = 'Failed to write file to disk.'; }
    else if($err==0){ $msg = 'A PHP extension stopped the file upload.'; }
	return $msg;
};

if(!empty($file_name)){

	
} else {
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	var fd = new FormData();
    var files = $('#file1')[0].files[0];
    fd.append('file1',files);
	if( document.getElementById("file1").files.length == 0 ){ 
		alert("Sila pilih maklumat nama dokumen terlebih dahulu.");
		document.simpeni.file1.focus();
		return true;
	} else {
		$.ajax({
            url:URL,
            type:'POST',
            //dataType: 'json',
            beforeSend: function () {
                //$('.btn-primary').attr("disabled","disabled");
                //$('.modal-body').css('opacity', '.5');
            },
            data: fd,
			processData: false,
	        contentType: false,
            //data: $("form").serialize(),
            //data: datas,
            success: function(data){
                // console.log(data);
                // alert(data);
                if(data==''){
                    swal({
                      title: 'Amaran',
                      text: "Terdapat ralat semasa proses muat naik data dilaksanakan",
                      //text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya didaftarkan.',
                      type: 'error',
                      confirmButtonClass: "btn-warning",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    }).then(function () {
                      	// $('.btn-primary').attr("enabled","enabled");
                		// $('.modal-body').css('opacity', '0');
                    });
                } else {
                    swal({
                      title: 'Berjaya',
                      text: 'Sila klik untuk proses muatturun data yang telah diproses',
                      type: 'success',
                      confirmButtonClass: "btn-success",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
        		showCancelButton: true,
                    }).then(function () {
                        window.location.href = data;
                        //reload = window.location; 
                        //window.location = reload;
                    });
                } 
            },
        //data: datas
        });
	}
}
function do_close(){
	parent.emailwindow.hide();
}
function close_paparan(){
	//parent.emailwindow.hide();
	refresh = parent.location; 
	parent.location = refresh;
}
</script>
<!-- <form name="simpeni" method="post" action="" enctype="multipart/form-data" > -->
	<table id="example2" class="table table-bordered">
        <tr valign="top" bgcolor="#fcbd9c"> 
            <td height="30" colspan="0" valign="middle">
            <font size="2" face="Arial, Helvetica, sans-serif">
                &nbsp;&nbsp;<strong>MUATNAIK MAKLUMAT PEMOHON MYSPP - MUATTURUN DI+OKUMEN SOKONGAN</strong></font>
            </td>
        </tr>
    </table>
<table width="100%" cellpadding="5" cellspacing="0" border="0">
	<tr>
        <td colspan="2">
        	<!--<b>Type : </b>
            <select name="types">
            	<option value=",">,</option>
            	<option value=";">;</option>
            </select>
            
            &nbsp;&nbsp;&nbsp;&nbsp;-->
            <b>Nama Fail Upload : </b>
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
            <input type="hidden" name="action1" value="1">
            <input type="file" name="file1" id="file1" size="100">
            <!-- <input type="file" name="file1" size="50" onChange="checkFile(this)"> -->
        </td>
    </tr>
    <tr>
        <td colspan="3" align="center">
            <input type="button" value="Proses Data" class="btn btn-primary" title="Sila klik untuk menyimpan maklumat" 
            	onClick="form_hantar('zip/proses_zip1.php?pro=PROSES')" >
            <input type="button" value="Kembali" class="btn btn-default" title="Tutup paparan skrin" onclick="close_paparan()"  ><br>
        </td>
    </tr>
</table>
<!-- </form> -->
<?php } ?>
    