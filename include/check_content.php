<?
function chk_content($str_content){
	global $conn;
	$text = $str_content;
	$span='';
	$sSQL="SELECT * FROM tblcontent WHERE content_type='MISC' AND content_status='Y' ";
	//$result = mysql_query($sSQL);
	//echo $sSQL;
	$row = &$conn->query($sSQL);
	while(!$row->EOF){
		//$title = "<u>".$row['content_title']."</u>";
		$title = $row->fields['content_title'];
		$cid = $row->fields['contentid'];
		//echo $title;
		$content = stripslashes($row->fields['content_text']);
		$data = "<a href=\"#\" onClick=\"Javascript:window.open('view_kamus.php?ID=".$cid."','About','top=100,left=200,width=750,height=400,scrollbars=1;menubar=0,status=0,toolbar=0,resizeable=0');\" title=\"Please click\">$title</a>";
		$text = str_replace("_".$title."_",$data,$text);
		$text = str_replace("_".strtolower($title)."_",$data,$text);
		$text = str_replace("_".ucwords($title)."_",$data,$text); 
		$row->movenext();
	}
	return $text.$span;
}
?>
<!--<span>-->
<!--<a href="#docu" onmouseover="Tip('An HTML element can be converted to a tooltip just by its ID. See <a href=#docu>documentation<\/a>.', TITLE, 'Extended Possibilities', WIDTH, 300, SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 1, CLOSEBTN, true, CLICKCLOSE, true)" onmouseout="UnTip()">Documentation</a>.-->