<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<script>
    function do_page(href){
        // alert('sini');
        var carian = $('#carian').val();
        var status2 = $('#status2').val();

        //window.location.href = href+'&status2='+status2+'&carian='+carian;
   	document.myspp.action = href;
     	document.myspp.target='_self';
	document.myspp.submit();
        
        // return sorturl;
    }

function do_add(){
	var kluster = $('#kluster').val();
	var matapelajaran = $('#matapelajaran').val();
	var bidang = $('#bidang').val();

	if(kluster.trim() == '' ){
		alert_msg('Sila pilih maklumat kluster.');
		$('#kluster').focus(); return true;
	} else if(matapelajaran.trim() == '' ){
		alert_msg('Sila pilih maklumat mata pelajaran.');
		$('#matapelajaran').focus(); return true;
	} else if(bidang.trim() == '' ){
		alert_msg('Sila pilih maklumat bidang.');
		$('#bidang').focus(); return true;
	} else {
		document.getElementById("tambah").click();
	}
}
</script>

<?php
// $conn->debug=true;
$status2=isset($_REQUEST["status2"])?$_REQUEST["status2"]:"";
$kluster=isset($_REQUEST["kluster"])?$_REQUEST["kluster"]:"";
$matapelajaran=isset($_REQUEST["matapelajaran"])?$_REQUEST["matapelajaran"]:"";
$bidang=isset($_REQUEST["bidang"])?$_REQUEST["bidang"]:"";
$carian=isset($_REQUEST["carian"])?$_REQUEST["carian"]:"";

$hrefs = 'index.php?data='.base64_encode('pengurusan/kod_kluster/padanan_pengkhususan_kluster;Padanan Kluster;Padanan Pengkhususan Kluster Dan Mata Pelajaran;ALL;;;');
$href_myspp = "modal_form.php?win=".base64_encode('pengurusan/kod_kluster/padanan_pengkhususan_kluster_form.php;');

?>

<div class="box" style="background-color:#F2F2F2">

    <div class="box-body">
    <input type="hidden" name="id" value="" />
    <div class="x_panel">
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
        <div class="panel-actions">
        <!--<a href="#" class="fa fa-caret-down"></a>
        <a href="#" class="fa fa-times"></a>-->
        </div>
        <h6 class="panel-title"><font color="#000000"><b>Senarai Maklumat Kluster & Mata Pelajaran</b></font></h6> 
    </header>
    </div>
    </div>            
    <br /> 
<?php //$conn->debug=true;?>
    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row">
	<?php $rsKluster = $conn->query("SELECT * FROM $schema1.`ref_kluster_main` WHERE is_deleted=0 AND status=0"); ?>
            <label for="nama" class="col-sm-2 control-label">Kluster:</label>
            <div class="col-sm-10">
                <select name="kluster" id="kluster" class="form-control" onchange="do_page('<?=$hrefs;?>')">
                    <option value="">Sila pilih kluster</option>
		    <?php while(!$rsKluster->EOF){ ?>
                    <option value="<?=$rsKluster->fields['kod'];?>" <?php if($rsKluster->fields['kod']==$kluster){ print 'selected'; } ?>><?=$rsKluster->fields['diskripsi'];?></option>
		    <?php $rsKluster->movenext(); } ?>
                </select>
            </div>
	</div>
    </div>
    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row">
	<?php $rsMP = $conn->query("SELECT * FROM $schema1.`ref_kluster` WHERE is_deleted=0 AND status=0 AND kmain LIKE '%".$kluster."%' ORDER BY diskripsi"); ?>
            <label for="nama" class="col-sm-2 control-label">Mata Pelajaran:</label>
            <div class="col-sm-10">
                <select name="matapelajaran" id="matapelajaran" class="form-control" onchange="do_page('<?=$hrefs;?>')">
                    <option value="">Sila pilih mata pelajaran</option>
		    <?php while(!$rsMP->EOF){ ?>
                    <option value="<?=$rsMP->fields['kod'];?>" <?php if($matapelajaran== $rsMP->fields['kod']){ print 'selected'; } ?>><?=$rsMP->fields['diskripsi'];?></option>
		    <?php $rsMP->movenext(); } ?>
                </select>
            </div>
	</div>
    </div>

    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row">
	<?php 
$sqlb = "SELECT * FROM $schema1.`ref_bidang` WHERE is_deleted=0 AND status=0";
if(!empty($matapelajaran)){ $sqlb .= " AND kod_mpelajaran=".tosql($matapelajaran); } 
$rsBidang = $conn->query($sqlb); 
?>
            <label for="nama" class="col-sm-2 control-label">Bidang / Mata Pelajaran:</label>
            <div class="col-sm-10">
                <select name="bidang" id="bidang" class="form-control" onchange="do_page('<?=$hrefs;?>')">
                    <option value="">Sila pilih Bidang / Mata Pelajaran</option>
		    <?php while(!$rsBidang->EOF){ ?>
                    <option value="<?=$rsBidang->fields['kod'];?>" <?php if($bidang == $rsBidang->fields['kod']){ print 'selected'; } ?>><?=$rsBidang->fields['diskripsi'];?></option>
		    <?php $rsBidang->movenext(); } ?>
                </select>
            </div>
	</div>
    </div>
    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row">
        <label for="nama" class="col-sm-2 control-label">Status:</label>
            <div class="col-sm-2">
                <select name="status2" id="status2" class="form-control" onchange="do_page('<?=$hrefs;?>')">
                    <option value="">Sila pilih status</option>
                    <option value="0" <?php if($status2 == 0){ print 'selected'; } ?>>Aktif</option>
                    <option value="1" <?php if($status2 == 1){ print 'selected'; } ?>>Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-1">
                <label for="">Carian: </label>
            </div>
            <div class="col-md-3" style="background-color:#F2F2F2">
                <input type="text" id="carian"  name="carian" value="<?=$carian;?>" class="form-control" placeholder="Kod/Kluster">
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2">
                <button type="button" class="btn btn-info" onclick="do_page('<?=$hrefs;?>')">
                    <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                </button>
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2">
		<button type="button" class="btn btn-primary" onclick="do_add()">
                    <i class="fa fa-plus"></i> Tambah Maklumat
                </button>

                <a href="<?=$href_myspp;?>&kluster=<?=$kluster;?>&mp=<?=$matapelajaran;?>&bidang=<?=$bidang;?>&id_kmp=<?=$id_kmp;?>"id="tambah"  
			data-toggle="modal" data-target="#myModal" data-backdrop="" <?=$disabled_btn;?> title="Kemaskini Maklumat Kluster Dan Pengkhususan">
                </a>

       
	    </div>
        </div>   
    </div>
    
    <br>
    <?php
        //$conn->debug=true;
	$cond='';
        if($status2 != ''){ $cond.= " AND A.`status`=".$status2; }
        if(!empty($kluster)){ $cond.= " AND A.`kod_kluster`=".tosql($kluster); }
        if(!empty($matapelajaran)){ $cond.= " AND A.`kod_mpelajaran`=".tosql($matapelajaran); }
        if(!empty($bidang)){ $cond.= " AND A.`kod_bidang`=".tosql($bidang); }
        //if(!empty($carian)){ $cond.= " AND ((kod LIKE '%".$carian."%') OR (diskripsi LIKE '%".$carian."%'))"; }

	if(empty($carian)){
        	$sql = "SELECT * FROM $schema1.`ref_padanan_kluster` A WHERE A.is_deleted=0 ".$cond." GROUP BY A.`kod_kluster`, A.`kod_mpelajaran`, A.`kod_bidang`"; 
        	//$sSQL1 = "SELECT COUNT(*) as total FROM $schema1.`ref_padanan_kluster` WHERE is_deleted=0 ".$cond." GROUP BY `kod_kluster`, `kod_mpelajaran`, `kod_bidang`";
	} else {
        	$sql = "SELECT * FROM $schema1.`ref_padanan_kluster` A, $schema1.`padanan_institusi_pengkhususan` B 
		WHERE A.kod_pengkhususan=B.kod AND A.is_deleted=0 ".$cond;
	        $sql .= " AND ((B.kod_institusi LIKE '%".$carian."%') OR (B.kod_pengkhususan LIKE '%".$carian."%'))";
		$sql .= " GROUP BY A.`kod_kluster`, A.`kod_mpelajaran`, A.`kod_bidang`"; 
		$sql ="SELECT A.* 
			FROM $schema1.`ref_padanan_kluster` A, $schema1.`ref_pengkhususan` B, $schema1.`padanan_institusi_pengkhususan` C, $schema1.`ref_institusi` D 
		        WHERE A.`kod_pengkhususan`=B.`kod` AND C.`kod_pengkhususan`=B.`kod` AND C.`kod_institusi`=D.`KOD` AND A.`is_deleted`=0 AND B.is_deleted=0 "; 
		$sql .= $cond;	
		//AND AND A.`kod_kluster`=".tosql($kluster). " AND A.`kod_mpelajaran`=".tosql($matapelajaran)." AND A.`kod_bidang`=".tosql($bidang);
	        $sql .= " AND (C.kod_institusi LIKE '%".$carian."%' OR C.kod_pengkhususan LIKE '%".$carian."%' OR B.DISKRIPSI LIKE '%".$carian."%' OR D.`DISKRIPSI` LIKE '%".$carian."%')";
		$sql .= " GROUP BY A.`kod_kluster`, A.`kod_mpelajaran`, A.`kod_bidang`"; 
	}
	//$conn->debug=true;
        include '../include/list_head.php';
        include '../include/page_list.php';
    ?>
    <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                <th width="15%"><font color="#000000"><div align="center">Kluster</div></font></th>
                <th width="10%"><font color="#000000"><div align="center">Mata Pelajaran</div></font></th>
                <th width="10%"><font color="#000000"><div align="center">Bidang</div></font></th>
                <th width="45%"><font color="#000000"><div align="center">Pengkhususan</div></font></th>
                <th width="10%"><font color="#000000"><div align="center">Status</div></font></th>
                <th width="5%"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
            <?php 
                $cnt = 0;
			    $bil = 0; 
                while(!$rs->EOF){ $bil2=0; 
                    $bil = $cnt + ($PageNo-1)*$PageSize; 
		    $id_kmp = $rs->fields['id'];
                    $kluster = $rs->fields['kod_kluster'];
                    $mp = $rs->fields['kod_mpelajaran'];
                    $bidang = $rs->fields['kod_bidang'];
                    /*$rsC = $conn->query("SELECT B.kod, B.DISKRIPSI FROM $schema1.`ref_padanan_kluster` A, $schema1.`ref_pengkhususan` B 
				        WHERE A.kod_pengkhususan=B.kod AND A.is_deleted=0 AND A.kod_kluster=".tosql($rs->fields['kod_kluster'])." 
				        AND A.kod_mpelajaran=".tosql($rs->fields['kod_mpelajaran'])." AND A.kod_bidang=".tosql($rs->fields['kod_bidang']));*/
	                //$conn->debug=true; 
		   $rsC = $conn->query("SELECT A.`id` AS id_klu, B.*  
			FROM $schema1.`ref_padanan_kluster` A, $schema1.`padanan_institusi_pengkhususan` B 
		        WHERE A.`kod_pengkhususan`=B.`kod` AND A.`is_deleted`=0 AND A.`kod_kluster`=".tosql($kluster)." 
			AND A.is_deleted=0 AND A.`kod_mpelajaran`=".tosql($mp)." AND A.`kod_bidang`=".tosql($bidang));

        			//$cnt = $rsC->fields['JUM'];
        			$disp_kluster = dlookup("$schema1.`ref_kluster_main`","diskripsi","kod=".tosql($rs->fields['kod_kluster']));
        			$disp_mpelajaran = dlookup("$schema1.`ref_kluster`","diskripsi","kod=".tosql($rs->fields['kod_mpelajaran']));
        			$disp_bidang = dlookup("$schema1.`ref_bidang`","diskripsi","kod=".tosql($rs->fields['kod_bidang']));
        			//$disp_kluster = dlookup("$schema1.`ref_kluster_main`","diskripsi","kod=".tosql($rs->fields['id_kluster']));
	
                    $conn->debug=false; 
		    	

		?>
                <tr>
                    <td align="center"><?=++$bil;?></td>
                    <td align="center"><?=$disp_kluster;?></td>
                    <td align="center"><?php print $disp_mpelajaran;?></td>
                    <td align="center"><?php print $disp_bidang;?></td>
                    <td><?php $jbil=0;
			if(!$rsC->EOF){
				print '<table width="100%" cellpadding="5" cellspacing="0" border="0">';
				while(!$rsC->EOF){ $jbil++;
					$nama_ins = dlookup("$schema1.ref_institusi","DISKRIPSI","KOD=".tosql($rsC->fields['kod_institusi']));
					$nama_subj = dlookup("$schema1.ref_pengkhususan","DISKRIPSI","kod=".tosql($rsC->fields['kod_pengkhususan']));
					$nama_ins = str_replace(strtoupper($carian),'<font color="red"><b>'.strtoupper($carian).'</b></font>',$nama_ins);
					$institusi = str_replace(strtoupper($carian),'<font color="red"><b>'.strtoupper($carian).'</b></font>',$rsC->fields['kod_institusi']);
					$kod_khusus = str_replace(strtoupper($carian),'<font color="red"><b>'.strtoupper($carian).'</b></font>',$rsC->fields['kod_pengkhususan']);
					$subjek = str_replace(strtoupper($carian),'<font color="red"><b>'.strtoupper($carian).'</b></font>',$nama_subj);
					
					print '<tr><td width="5%" valign="top">'.$jbil.' -</td><td width="95%">'.$institusi.":".$nama_ins."<br>".$kod_khusus.":".$subjek.'</td></tr>';
					//if($jbil==1){ print $jbil." - ".$rsC->fields['DISKRIPSI']; }
					//else { print "<br>".$jbil." - ".$rsC->fields['DISKRIPSI']; }	
					$rsC->movenext(); 
				}
				print '</table>';
			}
		    ?></td>
                    
                    <td align="center">
                        <?php 
                            if($rs->fields['status'] == 0){
                                print '<button class="btn-success badge">Aktif</button>';
                            } else {
                                print '<button class="btn-danger badge">Tidak Aktif</button>';
                            }
                        ?>
                    </td>
                    <td align="center">
                        <a href="<?=$href_myspp;?>&kluster=<?=$kluster;?>&mp=<?=$mp;?>&bidang=<?=$bidang;?>&id_kmp=<?=$id_kmp;?>" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#myModal" data-backdrop="" <?=$disabled_btn;?> title="Kemaskini Maklumat Kluster Dan Pengkhususan"><i class="fa fa-edit"></i>
                        </a>
                        <!--<button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=KLUSTER&pro=HAPUS&kod=<?=$rs->fields['kod'];?>')">
				<span style="cursor:pointer;color:red" title="Hapus maklumat kluster"><i class="fa fa-trash-o" style="color: #FFFFFF;"></i></span>
			</button>-->
                    </td>
                </tr>
            <?php 
            $cnt = $cnt + 1;
            $rs->movenext(); } ?>
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        <?php 
            $href_f=$actual_link."&table_search=".$table_search;
            include 'include/list_footer.php'; 
        ?>  
    </div>

    <div class="box-body">
        <a class="btn btn-md btn-success" href="index.php?data=<?php print base64_encode('pengurusan/parameter;Pengurusan;Parameter;ALL;;;'); ?>">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

           