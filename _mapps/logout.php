<!doctype html>
<html class="boxed">
<head>
<link href="../salert/sweetalert2.css" rel="stylesheet">
<style>
body{
	margin:0;
}
html { 
/*  background: url(images/JPMA.jpg) no-repeat center center fixed; */
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>

<!-- Head Libs -->
<script src="../salert/sweetalert2.min.js"></script>
<script src="../salert/sweetalert2.common.js"></script>
</head>
<body>
<?php 
session_start();

include '../connection/common.php';
$conn->execute("DELETE FROM $schema2.`user_log` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
//session_destroy();
$_SESSION['SESS_UID']='';


//session_destroy();
$_SESSION['SESS_UID']='';
//session_destroy();
//$_SESSION['SESS_UID']
//exit;
?>
</body>
</html>
<script language="javascript">
/*
swal({
  title: 'Berjaya',
  text: 'Anda telah log keluar daripada sistem.',
  type: 'success',
  confirmButtonClass: "btn-success",
  confirmButtonText: "Ok",
  showConfirmButton: true,
}).then(function () {
  window.location.href = "../index.php?pages=index_logout";
});
*/
window.location.href = "../index.php?pages=index_logout";
</script>