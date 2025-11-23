<!DOCTYPE html>
<html lang="en" class="fixed">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Sistem eAMH</title>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<?php
include 'connection/common_log.php';
include 'connection/dateformat.php';
// $conn->debug=true;
// $data=isset($_REQUEST["data"])?$_REQUEST["data"]:"";
// $id_mohon = base64_decode($data);
$id_mohon=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
if(!empty($id_mohon)){
	$cur_dt=date("Y-m-d");
	//$sql = "SELECT Z.*,Z.`create_dt` AS cetak_dt, A.id AS APP_ID, A.created_dt, A.ref_no, A.appli_type, A.pmt_amount, B.*, 
	    //FROM cert Z, appli A, applicant B WHERE A.applicant_id=B.id AND Z.applicant_id=B.id AND Z.appli_id=A.id";
	//$sql .= " AND Z.id=".tosql($id_mohon);    
	//$rsData = $conn->query($sql);

	$sql = "SELECT Z.*, Z.`create_dt` AS cetak_dt, A.id AS APP_ID, A.created_dt, A.ref_no, A.appli_type, A.pmt_amount, A.appli_dt, B.* 
    	FROM cert Z, appli A, applicant B WHERE A.applicant_id=B.id AND Z.applicant_id=B.id AND Z.appli_id=A.id";


	$sql .= " AND Z.id=".tosql($id_mohon);    
	$rsData = $conn->query($sql);


	$app_id = $rsData->fields['APP_ID'];
	$applicant = $rsData->fields['applicant_id'];
	// print "CT: ".$rsData->fields['applicant_id'];
	$app_addr = $rsData->fields['com_addr'];
	$create_dt = $rsData->fields['cetak_dt'];

	//print 'aaaaaaaaaaaa'.$create_dt;

	$cert_type = $rsData->fields['cert_type'];
	$cert = dlookup("appli_type","descr","code=".tosql($cert_type));

	$actv = $rsData->fields['is_active'];
	if($actv=='N'){ $fnt = 'red'; } else { $fnt='#000'; }
	if($rsData->fields['end_dt'] < $cur_dt){ $fnt = 'red'; }

    	if($cert_type=='L1' || $cert_type=='L2' || $cert_type=='L3' || $cert_type=='L4' || $cert_type=='L5'){ 
		$tajuk="No. Lesen"; 
		$ty='L';  
		$tajukSijil = "(LESEN UNTUK MENGIMPORT MAKANAN HAIWAN ATAU BAHAN TAMBAHAN MAKANAN HAIWAN)";
		$taj = "Semak Lesen"; 
	} else if($cert_type=='R1' || $cert_type=='R3' || $cert_type=='R5' || $cert_type=='R9' || $cert_type=='R11'){ 
		$tajuk="No. Sijil"; 
		$ty='P'; 
		$tajukSijil = "(PEMBUAT DAN PENJUALAN MAKANAN HAIWAN ATAU BAHAN TAMBAHAN MAKANAN HAIWAN)";
		$taj = "Semak Sijil"; 
	} else if($cert_type=='R2' || $cert_type=='R4' || $cert_type=='R6' || $cert_type=='R10' || $cert_type=='R12'){ 
		$tajuk="No. Sijil"; 
		$ty='S'; 
		$tajukSijil = "(PEMBUAT DAN PENJUALAN MAKANAN HAIWAN ATAU BAHAN TAMBAHAN MAKANAN HAIWAN)";
		$taj = "Semak Sijil"; 
	} else { 
		$tajuk="No. Sijil"; 
	}
    // print $cert_type;

?>
<!--<link rel="stylesheet" href="_msys/assets/vendor/bootstrap/css/bootstrap.css" />-->
<link rel="stylesheet" href="js/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<style type="text/css">
	div, table, tr, td{
		font-family: Arial;
		font-size: 13px;
	}
</style>
        
</head>
<br>
<body>
<div class="container">
<table width="100%" cellpadding="2" cellspacing="0" border="0" align="center" style="background-image: url('images/jata_blur.png');background-repeat: no-repeat;background-position: center;">
	<tr>
		<td colspan="2" align="center">
			<div class="form-group">
				<div class="row">
					<div class="col-md-12"><img src="images/dvs.png" width="76px" height="80px"><br><b>JABATAN PERKHIDMATAN VETERINAR</b></div>
				</div>
			</div>
		</td>
	</tr>
	<tr> 
    	<td align="center" valign="top" width="100%" colspan="2">
	        <div  align="center">
	            <div class="text"><h4><?=$taj;?></h4></div>
	        </div>
				        
	        <div  align="center">
	        AKTA MAKANAN HAIWAN 2009
	        <BR>
			PERATURAN-PERATURAN MAKANAN HAIWAN <?=$tajukSijil;?> 2012
			</BR><br>
			</div>
	        <div class="boxer" style="min-height:220px">
				
				<table width="100%" align="center" cellspacing="5" cellspacing="0"><tr><td align="center">
				<div class="form-group">
					<div class="row">
	                <label class="control-label col-md-3 col-xs-12"><b>Jenis Permohonan</b></label>
	                <div class="col-md-9 col-sm-12 col-xs-12"><?php print ucwords($cert);?></div>
	            	</div>
	            </div> 
	            
				<div class="form-group">
					<div class="row">
	                <label class="control-label col-md-3 col-xs-12"><b><?=$tajuk;?></b></label>
	                <div class="col-md-9 col-sm-12 col-xs-12"><b><?php print $rsData->fields['cert_no'];?></b></div>
	            	</div>
	            </div> 
	            
				<div class="form-group">
	                <div class="row">
	                <label class="control-label col-md-3 col-xs-12"><b>Nama Pemohon : </b></label>
	                <div class="col-md-9 col-sm-12 col-xs-12"><?php print strtoupper($rsData->fields['app_name']);?></div>
	            	</div>
	            </div>    
				<div class="form-group">
	                <div class="row">
	                <label class="control-label col-md-3 col-xs-12"><b>Nama Syarikat : </b></label>
	                <div class="col-md-9 col-sm-12 col-xs-12"><?php print strtoupper($rsData->fields['com_name']." (".$rsData->fields['com_no']);?></div>
	            	</div>
	            </div>   
	            
				<div class="form-group">
	                <div class="row">
	                <label class="control-label col-md-3 col-xs-12"><b>Alamat Syarikat : </b></label>
	                <div class="col-md-9 col-sm-12 col-xs-12"><?php print strtoupper($app_addr);?></div>
	            	</div>
	            </div>    
	            <br>	
				<div class="form-group">
	                <div class="row">
	                <label class="control-label col-md-3 col-xs-12"><b>Tarikh Sah Lesen : </b></label>
	                <div class="col-md-9 col-sm-12 col-xs-12" style="color: <?=$fnt;?>">Lesen ini sah daripada<br>
	                	<?php print DisplayDate($rsData->fields['start_dt']);?> <font color="#000">hingga</font> <?php print DisplayDate($rsData->fields['end_dt']);?></div>
	            	</div>
	            </div>    	
	        	</td></tr></table>
	        	<!--<div align="center"><br>-->
	        	<!--    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Large Modal</button>-->
	        	<!--</div>-->
	        </div>
	    <?php } else { ?>    
	    	<div class="form-group">
                <div class="row">
                <label class="control-label col-md-12 col-xs-12"><b>TIADA MAKLUMAT</b><br>Sila berhubung dengan pihak Veterina untuk pengesahan sijil.</label>
            	</div>
            </div>   
	    <?php } ?>
        </td>
   </tr>  
</table>
<!-- Modal -->
  <!--<div class="modal fade" id="myModal" role="dialog">-->
  <!--  <div class="modal-dialog modal-lg">-->
  <!--    <div class="modal-content">-->
  <!--      <div class="modal-header">-->
  <!--        <button type="button" class="close" data-dismiss="modal">&times;</button>-->
  <!--        <h4 class="modal-title">Modal Header</h4>-->
  <!--      </div>-->
  <!--      <div class="modal-body">-->
  <!--        <p>This is a large modal.</p>-->
  <!--      </div>-->
  <!--      <div class="modal-footer">-->
  <!--        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
  <!--      </div>-->
  <!--    </div>-->
  <!--  </div>-->
  <!--</div>-->
  
  
<?php 
if($ty=='L'){ 
//   $conn->debug=true;
//$sqlItem = "SELECT A.id AS ID_ITEM, A.origin, A.cat, A.name, A.ingredient, A.store_addr 
    //FROM license_item A INNER JOIN appli B ON A.appli_id = B.id 
    //WHERE B.applicant_id=".tosql($rsData->fields['applicant_id'])." AND B.id<='{$app_id}'  ";
//$sqlItem .= " AND A.cert_sts='Y' AND A.check_sts='P' ";

$sqlItem = "SELECT A.id AS ID_ITEM, A.origin, A.cat, A.name, A.ingredient, A.store_addr 
    FROM license_item A INNER JOIN appli B ON A.appli_id = B.id, cert C";
$sqlItem .=" WHERE B.applicant_id=".tosql($rsData->fields['applicant_id'])." AND C.applicant_id=".tosql($rsData->fields['applicant_id']); 
    //WHERE B.applicant_id=".tosql($rsData->fields['applicant_id'])." AND B.id<='{$app_id}' AND C.applicant_id=".tosql($rsData->fields['applicant_id']);
$sqlItem .= " AND A.cert_sts='Y' AND A.check_sts='P' AND B.appli_sts IN('AP','PM')";
$sqlItem .= " AND C.`create_dt`<='{$create_dt}'";

$sqlItem .= " GROUP BY ID_ITEM ORDER BY ID_ITEM ASC";


$rsItem_det = $conn->query($sqlItem);

// print $sqlItem;
$bil=0;
?>
<div align="center"><b>Senarai Item</b></div>
<table class="table" width="100%" cellpadding="5" cellspacing="0" border="1">
    <thead>
        <tr style="background-color: #ccc;">
            <td width="5%">Bil</td>
            <td width="30%">Item</td>
            <td width="25%">Negara Asal**</td>
            <td width="40%">Kategori Makanan***</td>
            <!--<td width="33%">Tempat penyimpanan/stor(Alamat)</td>-->
        </tr>
    </thead>
    <tbody>
    <?php $ext='';
        while(!$rsItem_det->EOF){ $bil++; 
        $item_id = $rsItem_det->fields['id'];
        $negara='';
        if(!empty($rsItem_det->fields['origin'])){ 
            $negara = dlookup("country","country_name","country_code=".tosql($rsItem_det->fields['origin']));
        }
        $kategori = dlookup("ref","descr","code=".tosql($rsItem_det->fields['cat']));
        if(empty($ext) && strcmp(strtoupper($rsItem_det->fields['ingredient']), "BERAS HANCUR")){ $ext='ADA'; }
        if(empty($ext) && strcmp(strtoupper($rsItem_det->fields['ingredient']), "TEMUKUT")){ $ext='ADA'; }
    ?>    
        <tr>
            <td><?=$bil;?>.</td>
            <td><?php print $rsItem_det->fields['name'];?></td>
            <td><?php print $negara;?></td>
            <td><?php print $kategori;?></td>
            <!--<td><?php print $rsItem_det->fields['store_addr'];?></td>-->
        </tr>
    <?php $rsItem_det->movenext(); } ?>    
    </tbody>
</table>
</div>
<?php } else if($ty=='P'){ ?>
<table class="table" width="100%" cellpadding="5" cellspacing="0" border="1">
    <thead>
        <tr style="background-color: #ccc;font-size: 13px;">
            <th width="5%">Bil</th>
            <th width="30%">Jenis Makanan Haiwan atau Bahan Tambahan Makanan Haiwan</th>
            <th width="35%">Kegunaan (tempatan/ eksport)</th>
            <th width="30%">Pembekal</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    // $conn->debug=true;
    //$rsItemA = $conn->query("SELECT A.*, C.descr FROM `producer_item` A, appli B, ref C  
        //WHERE A.appli_id=B.id AND A.prod_type=C.code AND A.applicant_id=".tosql($applicant));

	$sqlItem = "SELECT A.* FROM `producer_item` A LEFT JOIN appli C ON A.appli_id = C.id  
    	LEFT JOIN cert Z ON C.id = Z.appli_id 
    	WHERE A.`appli_id`=C.`id` AND A.`applicant_id`='{$rsData->fields['applicant_id']}' 
	AND C.`appli_sts` IN('AP','PM') AND A.`check_sts`='P' AND `cert_sts`='Y' AND Z.`id` <='{$id_mohon}' GROUP BY A.id";

    	$rsItemA = $conn->query($sqlItem);

	
    $bilr=0;
    if(!$rsItemA->EOF){ 
    while(!$rsItemA->EOF){ $bilr++; 
        $codes = strtoupper($rsItemA->fields['id']);
        $bahan = $conn->query("SELECT supplier_name FROM `producer_item_raw` WHERE item_id='{$codes}' GROUP BY supplier_name");
        ?>    
        <tr bgcolor="#fff">
            <td><?=$bilr;?>.</td>
            <td><?php print $rsItemA->fields['food_type'];?></td>
            <td>
            <?php
                $usage = $rsItemA->fields['usage']; $exp_to = $rsItemA->fields['exp_to'];
                //print $usage;
                if($usage=='T'){ print 'Tempatan'; }
                else if($usage=='E'){ print 'Eksport'; }
                else if($usage=='T,E'){ print 'Tempatan & Eksport'; }
                // $rsCountry = $conn->query("SELECT * FROM country WHERE country_code IN ($exp_to)"); 
                $p = (explode(",",$exp_to));
                //print count($p);
                for($i=0;$i<count($p);$i++){
                    print "<br>-".dlookup("country","country_name","country_code=".tosql($p[$i]));
                }
            ?>    
            </td>
            <td>
                <?php if(!$bahan->EOF){ 
                    print '<table width="100%" celpadding="2" celspacing="0">';
                        // <tr><td width="50%"><b>Nama Pembekal</b></td><td width="50%"><b>Bahan Mentah</b></td></tr>';
                    while(!$bahan->EOF){
                        print '<tr><td>'.$bahan->fields['supplier_name'].'</td></tr>';
                        $bahan->movenext();
                    }
                    print '</table>';
                } 
                ?>
            </td>
        </tr>
    <?php $rsItemA->movenext(); } ?>
    <?php } ?>    
    </tbody>
</table>
<?php } else if($ty=='S'){ ?>
<table class="table" width="100%" cellpadding="5" cellspacing="0" border="1">
    <thead>
        <tr style="background-color: #ccc;font-size: 13px;">
            <th width="5%">Bil</th>
            <th width="30%">Jenis Makanan Haiwan atau Bahan Tambahan Makanan Haiwan</th>
            <th width="35%">Kegunaan (tempatan/ eksport)</th>
            <th width="30%">Pembekal</th>
        </tr>
    </thead>
    <?php 
    // $conn->debug=true;
    //$rsItemA = $conn->query("SELECT A.* FROM `seller_item` A, appli B   
        //WHERE A.appli_id=B.id AND A.applicant_id=".tosql($applicant));

$sqlItem = "SELECT A.id AS ID_ITEM, A.name, A.usage, A.exp_to FROM seller_item A LEFT JOIN appli B ON A.appli_id = B.id INNER JOIN cert C ON C.appli_id=B.id
    WHERE B.applicant_id=".tosql($applicant)." AND B.appli_sts IN('AP','PM')";
$sqlItem .= " AND A.cert_sts='Y' AND A.check_sts='P' ";
$sqlItem .= " GROUP BY ID_ITEM ORDER BY ID_ITEM ASC"; 

$rsItemA = $conn->query($sqlItem);

    $bilr=0;
    if(!$rsItemA->EOF){ 
    while(!$rsItemA->EOF){ $bilr++; 
        $codes = strtoupper($rsItemA->fields['id']);
        // $cat = dlookup("ref","descr","cat='item_cat' AND code=".tosql($rsItemA->fields['item_cat']));
        // $bahan = $conn->query("SELECT * FROM `producer_item_raw` WHERE item_id='{$codes}'");

	if(!empty($rsItemA->fields['supplier_name'])){ 
		$disp_pembekal = $rsItemA->fields['supplier_name'];
	} else { 
		$ada = dlookup("seller_item_supplier","distri_name","item_id=".tosql($rsItemA->fields['ID_ITEM']));

		if($ada){
			$disp_pembekal = $ada;
		} else {
			$disp_pembekal = $pembekal; 
		}

		
	}

    ?>    
    <tbody>
        <tr bgcolor="#fff">
            <td><?=$bilr;?>.</td>
            <td><?php print $rsItemA->fields['name'];?></td>
            <td>
            <?php
                $usage = $rsItemA->fields['usage']; $exp_to = $rsItemA->fields['exp_to'];
                //print $usage;
                if($usage=='T'){ print 'Tempatan'; }
                else if($usage=='E'){ print 'Eksport'; }
                else if($usage=='T,E'){ print 'Tempatan & Eksport'; }
                // $rsCountry = $conn->query("SELECT * FROM country WHERE country_code IN ($exp_to)"); 
                $p = (explode(",",$exp_to));
                // print $exp_to;
                if(!empty($exp_to)){
                    print "<br>";
                    for($i=0;$i<count($p);$i++){
                        if($i!=0){ print ", "; } 
                        print dlookup("country","country_name","country_code=".tosql($p[$i]));
                    }
                }
            ?>    
                
            </td>
            <td><?php print $disp_pembekal;?></td>
        </tr>
    <?php $rsItemA->movenext(); } ?>
    <?php } ?>    
    </tbody>
</table>

<?php } ?>
</body>
