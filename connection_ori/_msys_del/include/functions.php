
<?php
//include 'include/secureurl.php';
//include 'include/security.php';
function dump($var,$no_exit=false) {

	echo "<div align='left'><pre>";
	var_dump($var);
	echo "</pre></div>";

	if (!$no_exit) exit();
}

function data($data) {
	$data=(get_magic_quotes_gpc())?$data:addslashes($data);
	$data=trim($data);
	$data=htmlspecialchars($data);
	return $data;
}

function tarikh($tarikh) {
$tarikh = explode ("/" ,$tarikh);
$tarikh = $tarikh[2] . "-" . $tarikh[1] . "-" . $tarikh[0];
return $tarikh;
}

function chkDate($tarikh) {
$tarikh = explode ("/" ,$tarikh);
$tarikh = (int)checkdate ((int)$tarikh[1], (int)$tarikh[0], (int)$tarikh[2]);
return $tarikh;
}

function tarikh2($tarikh) {
$tarikh = explode ("-" ,$tarikh);
$tarikh = $tarikh[2] . "/" . $tarikh[1] . "/" . $tarikh[0];
return $tarikh;

}

function plskw($p_id,$safesql) {

	if(!is_numeric($p_id)) { ?>
		<script language="JavaScript">
		   for(i=1;i<=3;i++) alert("no value");
        </script>
   <? } else {
		$q_page = $safesql->query(
					"select name from page where page_id=%i",
					array($p_id)
					);
					//echo $q_page;
				 
		$r_page=mysql_query($q_page);
		$row = mysql_fetch_array($r_page, MYSQL_BOTH);
		mysql_free_result($r_page);
		//echo "???".$row['name'];
		if($row['name']) return $row['name'];
		
		
		else return '';
	}
}

 function zero2null($data) {
 	if($data == 0)
	return " ";
	else
	return $data;
 }

function noData($value,$zero=0,$textransform=0) {
	if($value == "0" || $value == ""){
		if($zero == 1)
			return "0";
		else
			return "-";
	}
	else{
		if($textransform == 0)
			return strtoupper($value);
		else
			return $value;
	}
}

function getNama($tblName,$cond,$name,$col='*',$toupper=""){
	$qry = "SELECT $col FROM $tblName WHERE $cond";
	//echo $qry;
	$rs = mysql_query($qry) or die(mysql_error());
	$row=mysql_fetch_assoc($rs);
	$val = $row[$name];
	if($toupper==1)
		return $val;
	else
		return strtoupper($val);
}

function mylookup($Table, $fName, $sWhere){
  $sSQL = "SELECT " . $fName . " FROM " . $Table . " WHERE " . $sWhere;
  $result1 = mysql_query($sSQL);
  $intRecCount1 = mysql_num_rows($result1);
  if($intRecCount1 > 0){
        $row1 = mysql_fetch_array($result1, MYSQL_BOTH);
	     return $row1['0'];
  }  else  return "";
}

function isactive($isaktif="0") {
if ($isaktif == '1') {
    $desc = "Aktif";
} else if ($isaktif == '0') {
    $desc = "Tidak Aktif";
}
return $desc;
}

function isremove($ishapus="0") {
if ($ishapus == '1') {
    $desc = "Ya";
} else if ($ishapus == '0') {
    $desc = "Tidak";
}
return $desc;
}

function generateRandomPassword(){
     $new_pass = "";
     $alphabet = array ("a","b","c","d","e","f","g","h","i","j","k","l",
                                "m","n","o","p","q","r","s","t","u","v","w","x","y","z");
     $characters = array("1","2","3","4","5","6","7","8","9","0", "s", "p", "a", "t","a");
     for($i=0;$i<8;$i++){
         $ran = rand(400,10000);
         if($odd = $ran%2){
             // use chars
             $id = rand(0, sizeOf($characters));
             $new_pass.=$characters[$id];
         }else{
             $id = rand(0, sizeOf($alphabet));
             $new_pass.=$alphabet[$id];
        }
     }
     return $new_pass;
}

	//get field value from table
	function getvalue($field,$tbl,$cond) {
		$sql = "SELECT $field FROM $tbl WHERE $cond";
		$rs = mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows($rs)>0){
			while ($row=mysql_fetch_assoc($rs)){
				$h = $row[$field];
			}
		}
		return $h;
	}


// START : Paging Set the page no

$PageSize = 15;
$StartRow = 0;

if(empty($_GET['PageNo'])){
    if($StartRow == 0){
        $PageNo = $StartRow + 1;
    }
}else{
    $PageNo = $_GET['PageNo'];
    $StartRow = ($PageNo - 1) * $PageSize;
}

//Set the counter start
if($PageNo % $PageSize == 0){
    $CounterStart = $PageNo - ($PageSize - 1);
}else{
    $CounterStart = $PageNo - ($PageNo % $PageSize) + 1;
}

//Counter End
$CounterEnd = $CounterStart + ($PageSize - 1);
// END : Paging Set the page no

?>