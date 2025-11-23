<?php //include '../connection/common.php'; ?>

<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<script>
    function sortorder(href){
        // alert('sini');
        
        var dt_kemaskini = $('#dt_kemaskini').val();
        var jantina = $('#jantina').val();
        var umur1 = $('#umur1').val();
        var umur2 = $('#umur2').val();
        // var bangsa = $('#bangsa').val();
        var oku = $('#oku').val();
        var tentera = $('#tentera').val();
        var zon = $('#zon').val();
        var negeri = $('#negeri').val();
        var pusat_temuduga = $('#pusat_temuduga').val();
        var peringkat_kelulusan = $('#peringkat_kelulusan').val();
        var univ = $('#univ').val();
        var pengkhususan = $('#pengkhususan').val();
        var kluster = $('#kluster').val();
        var cgpa1 = $('#cgpa1').val();
        var cgpa2 = $('#cgpa2').val();
        var skim = $('#skim').val();
        var status = $('#status').val();


        window.location.href = href+"&dt_kemaskini="+dt_kemaskini+"&jantina="+jantina+'&umur1='+umur1+'&umur2='+umur2+'&oku='+oku+'&tentera='+tentera+'&zon='+zon+'&negeri='+negeri+'&pusat_temuduga='+pusat_temuduga+'&peringkat_kelulusan='+peringkat_kelulusan+'&univ='+univ+'&pengkhususan='+pengkhususan+'&kluster='+kluster+'&cgpa1='+cgpa1+'&cgpa2='+cgpa2+'&skim='+skim+'&status='+status;
        
        
        // return sorturl;
    }

    function get_negeri(zon){
        // alert(state);
        var sel="#negeri";
        $.ajax({
            url:'include/get_negeri.php?zon='+zon,
            type: 'POST',
            data: {zon:zon},
            dataType: 'json',
            success:function(response){
                
                var len = response.length;
                
                $(sel).empty();
                for( var i = 0; i<len; i++){
                    var kod = response[i]['kod'];
                    var diskripsi2 = response[i]['diskripsi2'];
                    $(sel).append("<option value='"+kod+"'>"+diskripsi2+"</option>");
                    // console.log(kod);
                }
            }
            //data: datas
        });
        
    }

    function get_univ(kod){
	var sel="#univ";
	$.ajax({
		url: '../include/get_universiti.php?kod='+kod,
		type: 'post',
		data: {kod:kod},
		dataType: 'json',
		success:function(data){
			var len = data.length;
			console.log(len);
			$(sel).empty();
			$('#pengkhususan').empty();
			for( var i = 0; i<len; i++){
				var id = data[i]['id'];
				var name = data[i]['name'];
				$(sel).append("<option value='"+id+"'>"+name+"</option>");
			}
			$('#pengkhususan').append("<option value=''>Sila pilih</option>");
		}
	});
}

function get_pengkhususan(kod){
	var peringkat_kelulusan = $('#peringkat_kelulusan').val();
	var sel="#pengkhususan";
	$.ajax({
		url: '../include/get_pengkhususan.php?kod='+kod+'&peringkat1='+peringkat_kelulusan,
		type: 'post',
		data: {kod:kod},
		dataType: 'json',
		success:function(response){
			var len = response.length;
			$(sel).empty();
			for( var i = 0; i<len; i++){
				var id = response[i]['id'];
				var name = response[i]['name'];
				$(sel).append("<option value='"+id+"'>"+name+"</option>");
			}
		}
	});
}

</script>
  <!-- Select2 -->
<link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<?php
$JFORM='LIST';
$dt_kemaskini=isset($_REQUEST["dt_kemaskini"])?$_REQUEST["dt_kemaskini"]:"";
$jantina=isset($_REQUEST["jantina"])?$_REQUEST["jantina"]:"";
$umur1=isset($_REQUEST["umur1"])?$_REQUEST["umur1"]:"";
$umur2=isset($_REQUEST["umur2"])?$_REQUEST["umur2"]:"";
// $bangsa=strtoupper(isset($_REQUEST["bangsa"])?$_REQUEST["bangsa"]:"");
$oku=strtoupper(isset($_REQUEST["oku"])?$_REQUEST["oku"]:"");
$tentera=strtoupper(isset($_REQUEST["tentera"])?$_REQUEST["tentera"]:"");
$zon=strtoupper(isset($_REQUEST["zon"])?$_REQUEST["zon"]:"");
$negeri=strtoupper(isset($_REQUEST["negeri"])?$_REQUEST["negeri"]:"");
$pusat_temuduga=strtoupper(isset($_REQUEST["pusat_temuduga"])?$_REQUEST["pusat_temuduga"]:"");
$peringkat_kelulusan=strtoupper(isset($_REQUEST["peringkat_kelulusan"])?$_REQUEST["peringkat_kelulusan"]:"");
$univ=strtoupper(isset($_REQUEST["univ"])?$_REQUEST["univ"]:"");
$pengkhususan=strtoupper(isset($_REQUEST["pengkhususan"])?$_REQUEST["pengkhususan"]:"");
$kluster=strtoupper(isset($_REQUEST["kluster"])?$_REQUEST["kluster"]:"");
$cgpa1=strtoupper(isset($_REQUEST["cgpa1"])?$_REQUEST["cgpa1"]:"");
$cgpa2=strtoupper(isset($_REQUEST["cgpa2"])?$_REQUEST["cgpa2"]:"");
$skim=strtoupper(isset($_REQUEST["skim"])?$_REQUEST["skim"]:"");
$status=strtoupper(isset($_REQUEST["status"])?$_REQUEST["status"]:"");

$hrefs = 'index.php?data='.base64_encode('laporan/keseluruhan_data;Laporan;Laporan Keseluruhan Data;ALL;;;');
//$conn->debug=true;

if((empty($pusat_temuduga)) || (empty($peringkat_kelulusan)) || (empty($univ)) || (empty($skim))){
	$sql = "SELECT COUNT(*) as total FROM $schema2.`calon` A WHERE A.ICNo IS NOT NULL"; 
} else if(!empty($pusat_temuduga)){
	$sql = "SELECT COUNT(*) as total FROM $schema2.`calon` A, $schema2.`calon_pusat_temuduga` B, $schema1.`ref_pusat_temuduga` C  WHERE A.ICNo IS NOT NULL AND A.id_pemohon=B.id_pemohon AND B.pusat_temuduga=C.kod";
	$sql .= " AND B.pusat_temuduga=".tosql($pusat_temuduga);
} else if(!empty($peringkat_kelulusan) || !empty($univ) || !empty($pengkhususan) || !empty($cgpa1) || !empty($cgpa2) || (!empty($skim))){
	//if(!empty($skim)){

		$sql = "SELECT COUNT(*) as total FROM $schema2.`calon` A, $schema2.`calon_ipt` B, $schema2.`calon_jawatan_dipohon` C  WHERE A.ICNo IS NOT NULL AND A.id_pemohon=B.id_pemohon AND B.id_pemohon=C.id_pemohon";
	//} else { 
		//$sql = "SELECT COUNT(*) as total FROM $schema2.`calon` A, $schema2.`calon_ipt` B  WHERE A.ICNo IS NOT NULL AND A.id_pemohon=B.id_pemohon";
	//}
	
	
	if(!empty($peringkat_kelulusan)){
		$sql .= " AND B.peringkat=".tosql($peringkat_kelulusan);
	}

	if(!empty($univ)){
		$sql .= " AND B.inst_keluar_sijil=".tosql($univ);
	}

	if(!empty($pengkhususan)){
		$sql .= " AND B.pengkhususan=".tosql($pengkhususan);
	}

	if(!empty($cgpa1) && !empty($cgpa2)){
		$sql .= " AND B.cgpa BETWEEN ".$cgpa1." AND ".$cgpa2;
	} else if(!empty($cgpa1)){
		$sql .= " AND B.cgpa=".tosql($cgpa1);
	} else if(!empty($cgpa2)){
		$sql .= " AND B.cgpa=".tosql($cgpa2);
	}

	
	
	if(!empty($skim)){
		$sql .= " AND C.kod_jawatan=".tosql($skim);
	}


} else {
	$sql = "SELECT COUNT(*) as total FROM $schema2.`calon` A WHERE A.ICNo IS NOT NULL"; 
}



if(!empty($dt_kemaskini)){
    $sql .= " AND (date(A.d_kemaskini) LIKE '%".$dt_kemaskini."%')";
}

if(!empty($jantina)){
    $sql .= " AND A.jantina=".tosql($jantina);
}


if(!empty($status)){
    if($status == 1){
	$sql .= " AND A.pengakuan='Y'";

    } else if($status == 2){
	$sql .= " AND A.pengakuan IS NULL AND A.status_pemohon IS NULL";
    }
}


if(!empty($zon)){
    if($zon == 1){
        $sql .= " AND A.negeri IN('09','02','07','08')";
    } else if($zon == 2){
        $sql .= " AND A.negeri IN('05','04','01')";
    }  else if($zon == 3){
        $sql .= " AND A.negeri IN('10','14','16')";
    } else if($zon == 4){
        $sql .= " AND A.negeri IN('06','11','03')";
    } else if($zon == 5){
        $sql .= " AND A.negeri IN('12','13','15')";
    }
    
}

if(!empty($umur1) && !empty($umur2)){
	$sql .= " AND year(NOW())-year(A.dob)=".tosql($umur1). " BETWEEN year(NOW())-year(A.dob)=".tosql($umur2);
} else if(!empty($umur1)){
	$sql .= " AND year(NOW())-year(A.dob)=".tosql($umur1);
} else if(!empty($umur2)){
	$sql .= " AND year(NOW())-year(A.dob)=".tosql($umur2);
}


if(!empty($negeri)){
    $sql .= " AND A.negeri=".tosql($negeri);
}



// if(!empty($carian)){
//     $sql .= " AND (A.tajuk  LIKE '%".$carian."%')";
// }
$rs = $conn->query($sql);
// $conn->debug=false;

//print $umur1;
?>
<div class="box" style="background-color:#F2F2F2">

    <div class="box-body">
        <input type="hidden" name="id" value="" />
        <div class="x_panel">
            <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
                <h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
            </header>
        </div>
    </div>  
   
   <br>
    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-md-2">
                <label for="">Tarikh Kemas kini : </label>
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" id="dt_kemaskini"  name="dt_kemaskini" value="<?=$dt_kemaskini;?>">
            </div> 
            <div class="col-md-1">
                <label for="">Jantina : </label>
            </div>
            <div class="col-md-2">
                <select name="jantina" id="jantina" class="form-control">
                    <option value="">Sila pilih</option>
                    <option value="L" <?php if($jantina == 'L'){ print 'selected'; }?>>Lelaki</option>
                    <option value="P" <?php if($jantina == 'P'){ print 'selected'; }?>>Perempuan</option>
                </select>
            </div> 
            <div class="col-md-1">
            </div>
            <div class="col-md-1">
                <label for="">Umur : </label>
            </div>
            <div class="col-md-1">
                <input type="text" class="form-control" name="umur1" id="umur1" value="<?=$umur1;?>"> 
            </div> 
            <div class="col-md-1">
                <small>hingga</small>
                
            </div> 
            <div class="col-md-1">
                <input type="text" class="form-control" name="umur2" id="umur2" value="<?=$umur2;?>">
            </div> 
        </div>   
    </div> 

    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-md-2">
                <label for="">Zon : </label>
            </div>
            <div class="col-md-2">
                <select name="zon" id="zon" class="form-control select2" onchange="get_negeri(this.value)">
                    <option value="">Sila pilih</option>
                    <option value="1" <?php if($zon == 1){ print 'selected'; }?>>Utara</option>
                    <option value="2" <?php if($zon == 2){ print 'selected'; }?>>Selatan</option>
                    <option value="3" <?php if($zon == 3){ print 'selected'; }?>>Tengah</option>
                    <option value="4" <?php if($zon == 4){ print 'selected'; }?>>Timur</option>
                    <option value="5" <?php if($zon == 5){ print 'selected'; }?>>SQL</option>
                </select>
            </div> 
            <div class="col-md-1">
                <label for="">Negeri : </label>
            </div>
            <div class="col-md-7">
                <?php
                    $sql3 = "SELECT * FROM $schema1.`ref_negeri` WHERE `status`=0 GROUP BY KOD_NEGERI";
                    $rsState = $conn->query($sql3);

                    $neg = (explode(",",$negeri));
                ?>
                <select name="negeri" id="negeri" class="select2bs4 form-control" multiple="multiple">
                    <option value="">Sila pilih</option>
                    <!-- <?php while(!$rsState->EOF){ $state_code = $rsState->fields['kod']; ?>    
                        <option value="<?=$state_code;?>"  <?php if($state_code == $negeri){ print 'selected'; }?>><?php print $rsState->fields['diskripsi2'];?></option>
                    <?php $rsState->movenext(); } ?> -->

                    <?php $rsState->movefirst();
                        while(!$rsState->EOF){ 
                            print '<option value="'.$rsState->fields['KOD_NEGERI'].'"';
                            if(in_array($rsState->fields['KOD_NEGERI'], $neg)){ print 'selected'; }
                            print '>'.$rsState->fields['NEGERI'].'</option>';

                            $rsState->movenext();
                        }  
                    ?>
                </select>
            </div> 
        </div>   
    </div> 

    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-md-2">
                <label for="">Pusat Temu Duga : </label>
            </div>
            <div class="col-md-4">
                <?php
                    $sql3 = "SELECT * FROM $schema1.`ref_pusat_temuduga` WHERE jenis_pusat=0 AND sah_yt='Y' AND is_deleted=0 AND status=0 ORDER BY `ref_pusat_temuduga`.`neg_kod` ASC";
                    $rspusatTemuduga = $conn->query($sql3);
                ?>
                <select name="pusat_temuduga" id="pusat_temuduga" class="form-control select2">
                    <option value="">Sila pilih</option>
                    <?php while(!$rspusatTemuduga->EOF){ $pusatTemuduga_code = $rspusatTemuduga->fields['kod']; ?>    
                        <option value="<?=$pusatTemuduga_code;?>" <?php if($pusatTemuduga_code == $pusat_temuduga){ print 'selected'; }?>><?php print $rspusatTemuduga->fields['diskripsi'];?></option>
                    <?php $rspusatTemuduga->movenext(); } ?>
                </select>
            </div> 
            <div class="col-md-2">
                <label for="">Peringkat Kelulusan : </label>
            </div>
            <div class="col-md-4">
                <?php
                    $sql3 = "SELECT * FROM $schema1.`ref_peringkat_kelulusan` WHERE `status`=0 AND is_deleted=0";
                    $rsperingkatKelulusan = $conn->query($sql3);
                ?>
                <select name="peringkat_kelulusan" id="peringkat_kelulusan" class="form-control select2" onchange="get_univ(this.value)">
                    <option value="">Sila pilih</option>
                    <?php while(!$rsperingkatKelulusan->EOF){ $peringkatKelulusan_code = $rsperingkatKelulusan->fields['kod']; ?>    
                        <option value="<?=$peringkatKelulusan_code;?>" <?php if($peringkatKelulusan_code == $peringkat_kelulusan){ print 'selected'; }?>><?php print $rsperingkatKelulusan->fields['diskripsi'];?></option>
                    <?php $rsperingkatKelulusan->movenext(); } ?>
                </select>
            </div> 
        </div>   
    </div> 

    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-md-2">
                <label for="">Institusi : </label>
            </div>
            <div class="col-md-4">
                <?php
                    $sql3 = "SELECT * FROM $schema1.`ref_institusi` WHERE `status`=0";
                    $rsinstitusi = $conn->query($sql3);
                ?>
                <select name="univ" id="univ" class="form-control select2" onchange="get_pengkhususan(this.value)">
                    <option value="">Sila pilih</option>
                    <?php while(!$rsinstitusi->EOF){ $institusi_code = $rsinstitusi->fields['KOD']; ?>    
                        <option value="<?=$institusi_code;?>" <?php if($institusi_code == $univ){ print 'selected'; }?>><?php print $rsinstitusi->fields['DISKRIPSI'];?></option>
                    <?php $rsinstitusi->movenext(); } ?>
                </select>
            </div> 
            
            <div class="col-md-2">
                <label for="">Kluster : </label>
            </div>
            <div class="col-md-4">
                <?php
                    $sql3 = "SELECT * FROM $schema1.`ref_kluster` WHERE `status`=0";
                    $rskluster = $conn->query($sql3);
                ?>
                <select name="kluster" id="kluster" class="form-control select2">
                    <option value="">Sila pilih</option>
                    <?php while(!$rskluster->EOF){ $kluster_code = $rskluster->fields['kod']; ?>    
                        <option value="<?=$kluster_code;?>" <?php if($kluster_code == $kluster){ print 'selected'; }?>><?php print $rskluster->fields['diskripsi'];?></option>
                    <?php $rskluster->movenext(); } ?>
                </select>
            </div>
            
        </div>  
            
    </div> 
	
    <?php 
				//$conn->debug=true;
				$peringkats = $peringkat_kelulusan;
				$query ="SELECT A.`kod`, B.`DISKRIPSI` FROM $schema1.`padanan_institusi_pengkhususan` A, $schema1.`ref_pengkhususan` B 
				WHERE A.`kod_pengkhususan`=B.`kod` AND A.`kod_institusi`=".tosql($univ)." 
				AND A.status=0 AND B.STATUS=0 AND B.is_deleted=0 ";  
				if($peringkats == '1' || $peringkats == '3' || $peringkats == '5'){
					$query .= " AND A.kategori=1";
					if($peringkats == '1'){
						$query .= " AND A.peringkat_kelulusan=1";
					} else if($peringkats == '3'){
						$query .= " AND A.peringkat_kelulusan=2";
					}  else if($peringkats == '5'){
						$query .= " AND A.peringkat_kelulusan=3";
					}
				} else if($peringkats == '2' || $peringkats == '4' || $peringkats == '6' || $peringkats == '7'){
					$query .= " AND A.kategori=2";

					if($peringkats == '2'){
						$query .= " AND A.peringkat_kelulusan=1";
					} else if($peringkats == '4'){
						$query .= " AND A.peringkat_kelulusan=2";
					}  else if($peringkats == '6'){
						$query .= " AND A.peringkat_kelulusan=3";
					}  else if($peringkats == '7'){
						$query .= " AND A.peringkat_kelulusan=4";
					}
				}
				$query .= " ORDER BY B.`DISKRIPSI`";
				//print $query;
				$rsKhusus = $conn->query($query);
			?>

    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-md-2">
                <label for="">Nama Sijil : </label>
            </div>
            <div class="col-md-4">
		<select name="pengkhususan" id="pengkhususan" class="form-control select2 pengkhususan" style="width: 100%;" aria-hidden="true">
							<option value="">Sila pilih </option>
							<?php while(!$rsKhusus->EOF){ ?>
							<option value="<?=$rsKhusus->fields['kod'];?>" <?php if($pengkhususan==$rsKhusus->fields['kod']){ print 'selected'; }?>><?php print $rsKhusus->fields['DISKRIPSI'];?></option>	
							<?php $rsKhusus->movenext(); } ?>
						</select>

            </div>  
            <div class="col-md-2">
                <label for="">CGPA : </label>
            </div>
            <div class="col-md-1">
                <input type="text" class="form-control" name="cgpa1" id="cgpa1" value="<?=$cgpa1;?>" placeholder="0.00"> 
            </div> 
            <div class="col-md-1">
                <small>hingga</small>
                
            </div> 
            <div class="col-md-1">
                <input type="text" class="form-control" name="cgpa2" id="cgpa2" value="<?=$cgpa2;?>" placeholder="0.00">
            </div> 
        </div>   
    </div> 
    
    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-md-2">
                <label for="">Jenis Skim: </label>
            </div>
            <div class="col-md-4">
                <?php
                    // $conn->debug=true;
                    $sql2 = "SELECT DISKRIPSI, KOD FROM $schema1.`ref_skim` WHERE is_deleted=0 AND `STATUS`=0";
                    $rsSkim = $conn->query($sql2);
                ?>

                <select name="skim" id="skim" class="form-control select2">
                    <option value="">Sila pilih</option>
                    <?php while(!$rsSkim->EOF){ $skim_code = $rsSkim->fields['KOD']; ?>    
                        <option value="<?=$skim_code;?>" <?php if($skim_code == $skim){ print 'selected'; }?>><?php print $rsSkim->fields['DISKRIPSI'];?></option>
                    <?php $rsSkim->movenext(); } ?>
                </select>
            </div> 
            <div class="col-md-2">
                <label for="">Status Permohonan: </label>
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2">
                <select name="status" id="status" class="form-control select2">
                    <option value="">Sila pilih</option>
                    <option value="1" <?php if($status == 1){ print 'selected'; }?>>Hantar</option>
                    <option value="2" <?php if($status == 2){ print 'selected'; }?>>Draf</option>
                </select>
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2">
                <button type="button" class="btn btn-primary" onclick="sortorder('<?=$hrefs;?>')">
                    <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                </button>
            </div>
        </div>   
    </div> 
    <br><br>

    

	<div class="col-md-12" style="background-color:#F2F2F2">
	<div class="row" style="padding-bottom: 10px;">

        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="35%"><font color="#000000"><div align="center">Jumlah</div></font></th>
                <th width="10%" class="d-print-none"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
                <tr>
                    <td align="center"><?=$rs->fields['total'];?></td>
                    <td align="center" class="d-print-none">
                        <a href="index.php?data=<?php print base64_encode('laporan/detail_keseluruhan_data;Laporan;Laporan Detail Keseluruhan Data;ALL;;;'); ?>&dt_kemaskini=<?=$dt_kemaskini?>&jantina=<?=$jantina?>&umur1=<?=$umur1?>&umur2=<?=$umur2?>&bangsa=<?=$bangsa?>&oku=<?=$oku?>&tentera=<?=$tentera?>&zon=<?=$zon?>&negeri=<?=$negeri?>&pusat_temuduga=<?=$pusat_temuduga?>&peringkat_kelulusan=<?=$peringkat_kelulusan?>&univ=<?=$univ?>&pengkhususan=<?=$pengkhususan?>&kluster=<?=$kluster?>&cgpa1=<?=$cgpa1?>&cgpa2=<?=$cgpa2?>&skim=<?=$skim?>&status=<?=$status?>">
                            <button type="button" class="btn btn-sm btn-success">
                                <span style="cursor:pointer;color:red" title="Maklumat Terperinci Pemohon">
                                    <i class="fa fa-search" style="color: #FFFFFF;"></i>
                                </span>
                            </button>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
	</div>
    </div>
</div>   

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            maximumSelectionLength: 25,

            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                maximumSelected: function (e) {
                    var t = "PERHATIAN ! Telah Mencapai Had Maksimum Negeri";
                    // + e.maximum + " item";
                    e.maximum != 1;
                    return t;
                    // return t + ' - Upgrade Now and Select More';
                }
            }
            
        });
    });
</script>
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/select2/js/select2.full.min.js"></script>

          