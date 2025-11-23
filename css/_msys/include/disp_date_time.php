<?php 
/*
$days = Array ("Ahad", "Isnin", "Selasa", "Rabu", "Khamis", "Jumaat", "Sabtu");
$months = Array (1=>"Januari",2=>"Februari",3=>"March",4=>"April",5=>"Mei",6=>"Jun",7=>"Julai",8=>"Ogos",9=>"September",10=>"Oktober",11=>"November",12=>"Disember");

putenv("TZ=Singapore");
echo $days[date("w")] . ", " . date("j"). " " .$months[date("n")] . " " . date("Y")."".date(",   h:i a") ; 
*/
?>
<?php if($bah=='ENG'){ ?>
<script type="text/javascript">
//var currenttime = 'January 29, 2007 23:45:22' //SSI method of getting server date
var currenttime = '<?php print date("F d, Y H:i:s", time())?>' //PHP method of getting server date
///////////Stop editting here/////////////////////////////////
var dayarray=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday")
var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
var serverdate=new Date(currenttime)

function padlength(what){
	var output=(what.toString().length==1)? "0"+what : what
	return output
}

function displaytime(){
	serverdate.setSeconds(serverdate.getSeconds()+1)
	var daystring=dayarray[serverdate.getDay()]
	var datestring=padlength(serverdate.getDate())+" "+montharray[serverdate.getMonth()]+" "+serverdate.getFullYear()+", "
	var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds())
	document.getElementById("servertime").innerHTML=daystring+", "+datestring+" "+timestring+"&nbsp;&nbsp;&nbsp;"
}

window.onload=function(){
setInterval("displaytime()", 1000)
}
</script>
<?php } else { ?>
<script type="text/javascript">
//var currenttime = 'January 29, 2007 23:45:22' //SSI method of getting server date
var currenttime = '<?php print date("F d, Y H:i:s", time())?>' //PHP method of getting server date
///////////Stop editting here/////////////////////////////////
var dayarray=new Array("Ahad","Isnin","Selasa","Rabu","Khamis","Jumaat","Sabtu")
var montharray=new Array("Jan","Feb","Mac","Apr","Mei","Jun","Jul","Ogos","Sept","Okt","Nov","Dis")
var serverdate=new Date(currenttime)

function padlength(what){
	var output=(what.toString().length==1)? "0"+what : what
	return output
}

function displaytime(){
	serverdate.setSeconds(serverdate.getSeconds()+1)
	var daystring=dayarray[serverdate.getDay()]
	var datestring=padlength(serverdate.getDate())+" "+montharray[serverdate.getMonth()]+" "+serverdate.getFullYear()+", "
	var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds())
	document.getElementById("servertime").innerHTML=daystring+", "+datestring+" "+timestring+"&nbsp;&nbsp;&nbsp;"
}

window.onload=function(){
setInterval("displaytime()", 1000)
}
</script>
<?php } ?>
<b><span id="servertime"></span></b><!--webbot bot="HTMLMarkup" endspan i-checksum="6746" -->

<?php //$s = mktime(date("G") + 1); print date("Y/m/d h:i:s a", $s);  ?>