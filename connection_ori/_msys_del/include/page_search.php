<script language="JavaScript1.2" type="text/javascript">
function do_page(URL){
	document.frm.action = URL;
	document.frm.target = '_self';
	document.frm.submit();
}
function do_post(){
	var data = document.frm.data.value;
	document.frm.action = "index.php?data="+data;
	document.frm.target = '_self';
	document.frm.submit();
}
</script>
<script language="javascript" type="text/javascript">	
function do_cetak(strFileName,id){
	kat = document.frm.kategori.value;
	pus = document.frm.pusat_id.value;
	sesi = document.frm.get_sesi.value;
	//alert(kat);
	if(kat=='-'){
		alert("Sila pilih Program Pengajian terlebih dahulu");
		return false;
	} else if(sesi=='-'){
		alert("Sila pilih sesi kemasukan terlebih dahulu");
		return false;
	} else {
		strFileName = strFileName + '?kat='+kat+'&pus='+pus+'&sesi='+sesi;
		window.open(strFileName,"Items","toolbar=no,location=no,directories=no,status=no,menubar=yes,scrollbars=yes,resizable=yes,copyhistory=no,width=900,height=450,top=55,left=160");
	}
}

function do_excell(URL){
		document.frm.action = URL;
		document.frm.target = '_blank';
		document.frm.submit();
}
</script>
<?
$data = $_GET['data'];
//$kategori = $_POST['kategori'];
//$conn->debug=true;
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<?
        $sql_k = "SELECT * FROM ref_kursus WHERE kstatus=0";
		if($pusat<>'1'){ $sql_k .= " AND kid=1"; $kategori=1; }
        $rsk = &$conn->Execute($sql_k);
    ?>
    <tr>
        <td align="right"><b>Program Pengajian :</b></td>
        <td>&nbsp;&nbsp;
            <select name="kategori" onchange="do_post()">
            <? 	if($pusat=='1'){ ?>
                <option value="-"> -- Semua Program -- </option>
            <? } ?>
                <? while(!$rsk->EOF) { ?>
                <option value="<?php print $rsk->fields['kid'];?>" <? if($kategori==$rsk->fields['kid']){ print 'selected';}?>><?php print $rsk->fields['kursus'];?></option>
                <? $rsk->MoveNext(); } ?>
            </select>
        </td>
    </tr>
	<?
	if($kategori==1){
        $sql_p = "SELECT * FROM ref_pusat_pengajian WHERE pusat_status=0 ";
		if($pusat<>'1'){ $sql_p .= " AND pusat_id=".tosql($pusat,"Number"); $pusat_id=$pusat; }
		$sql_p .= " ORDER BY pusat_no";
        $rsp = &$conn->Execute($sql_p);
    ?>
    <tr>
        <td align="right"><b>Pusat Pengajian :</b></td>
        <td>&nbsp;&nbsp;
            <select name="pusat_id" onchange="do_post()">
            <? 	if($pusat=='1'){ ?>
            	<option value="-"> -- Semua Pusat pengajian -- </option>
            <? } ?>
                <? while(!$rsp->EOF) { ?>
                <option value="<?php print $rsp->fields['pusat_id'];?>" <? if($pusat_id==$rsp->fields['pusat_id']){ print 'selected';}?>
                ><? print "[ ".$rsp->fields['pusat_no'] . " ] ".$rsp->fields['pusat_nama'];?></option>
                <? $rsp->MoveNext(); } ?>
            </select>
        </td>
    </tr>
	<? } else {
		print '<input type="hidden" name="pusat_id" value="">';
	}
        $sql_s = "SELECT * FROM ref_sesi";
		$sql_s .= " WHERE sesi_id<>'' ";
		if(!empty($kategori) && $kategori<>'-'){ $sql_s .= " AND kursus_id=".$kategori; }
		$sql_s .= " ORDER BY sesi DESC";
        $rss = &$conn->Execute($sql_s);
    ?>
    <tr>
        <td align="right"><b>Sesi Kemasukan :</b></td>
        <td>&nbsp;&nbsp;
            <select name="get_sesi" onchange="do_post()">
            	<option value="-"> -- Semua Sesi -- </option>
                <? while(!$rss->EOF) { ?>
                <option value="<?php print $rss->fields['sesi_id'];?>" <? if($get_sesi==$rss->fields['sesi_id']){ print 'selected';}?>><?php print $rss->fields['sesi'];?></option>
                <? $rss->MoveNext(); } ?>
            </select>
        </td>
    </tr>
	<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?php print $href_search;?>')">
            <? if(!empty($href_cetak)){ ?>
            <input type="button" name="Cari" value="  Cetak Senarai  " onClick="do_cetak('<?php print $href_cetak;?>')">
            <? } ?>
            <? if(!empty($href_excel)){ ?>
            <input type="button" name="Cari" value="  Salin ke Excel  " onClick="do_excell('<?php print $href_excel;?>')">
            <? } ?>
            <input type="hidden" name="data" value="<?php print $data;?>" />
		</td>
	</tr>
	<tr> 
	  <td>&nbsp;</td>
	</tr>
	<tr> 
		<td align="left">Jumlah Rekod : <b><?php print $RecordCount;?></b></td>
		<td align="right"><b>Sebanyak 
		<select name="linepage" onChange="do_page('<?php print $href_search;?>')">
			<option value="10" <? if($PageSize==10){ echo 'selected'; }?>>10</option>
			<option value="20" <? if($PageSize==20){ echo 'selected'; }?>>20</option>
			<option value="50" <? if($PageSize==50){ echo 'selected'; }?>>50</option>
			<option value="100" <? if($PageSize==100){ echo 'selected'; }?>>100</option>
		</select> rekod dipaparkan bagi setiap halaman.&nbsp;&nbsp;&nbsp;</b> 
	  </td>
	</tr>
</table>