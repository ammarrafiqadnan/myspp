<?php 
    //$conn->debug=true; 
    $m=isset($_REQUEST["m"])?$_REQUEST["m"]:"";
    $order_by=isset($_REQUEST["order_by"])?$_REQUEST["order_by"]:"";
    $sort=isset($_REQUEST["sort"])?$_REQUEST["sort"]:"";
    $tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
    $tkh_akhir=isset($_REQUEST["tkh_akhir"])?$_REQUEST["tkh_akhir"]:"";
    $skim=isset($_REQUEST["skim"])?$_REQUEST["skim"]:"";
    $turutan=isset($_REQUEST["turutan"])?$_REQUEST["turutan"]:"";
    $negeri=isset($_REQUEST["negeri"])?$_REQUEST["negeri"]:"";
    $status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";
    $carian=isset($_REQUEST["carian"])?$_REQUEST["carian"]:"";

    $actual_link =  str_replace("&m=1","",$actual_link);	
    $_SESSION['SESSADM_BACKLINK']=$actual_link;
    if($m==1){ $_SESSION['SESSADM_NEGERI']=''; }	
    
    if(empty($negeri) && !empty($_SESSION['SESSADM_NEGERI'])){
	   $negeri=$_SESSION['SESSADM_NEGERI'];
    } else {
    	if($negeri!='-'){ $_SESSION['SESSADM_NEGERI']=$negeri; }
    	else { $negeri=''; }
    }

    $hrefs = 'index.php?data='.base64_encode('pemohon/senarai_pemohon;Pengurusan;Senarai Pemohon;;;;');

    $link = '&tkh_mula='.$tkh_mula.'&tkh_akhir='.$tkh_akhir.'&skim='.$skim.'&turutan='.$turutan.'&negeri='.$negeri.'&status='.$status.'&carian='.$carian;

    function do_search($href, $fieldname, $sort){
        $sorturl = $href."&order_by=".$fieldname."&sort=".$sort;
        return $sorturl;
    }



    $sqlT = dlookup("$schema2.`kawalan_tempoh_akaun`","tempoh","kod=1");
    $year = "-".$sqlT." year";
	//print $year;
    $dby = date("Y-m-d", strtotime($year));
    $currYear = date("Y", strtotime(now()));
    
     //print $dby;
    
   //$conn->debug=true;
    if($status==3){ // PANGGGILAN TEMUDUGA

        $sql = "SELECT A.id_pemohon,A.nama_penuh, A.ICNo,A.d_cipta,A.d_kemaskini,A.pengakuan, A.status_pemohon  
        FROM $schema2.calon A, $schema2.senarai_panggilan_temuduga C, $schema2.panggilan_temuduga D, $schema2.calon_jawatan_dipohon E
        WHERE A.ICNo=C.noKP AND A.id_pemohon=E.id_pemohon AND (A.d_kemaskini >=".tosql($dby)." OR A.d_cipta >=".tosql($dby).") ";
        $sql .= " AND A.pengakuan='Y' AND C.kod_panggilan_temuduga=D.kod  AND C.is_deleted=0";

    } else if($status==4){ // TKEPUTUSAN TEMUDUGA

	   if(empty($turutan)){
        	$sql = "SELECT A.id_pemohon,A.nama_penuh, A.ICNo,A.d_cipta,A.d_kemaskini,A.pengakuan, A.status_pemohon  
        	FROM $schema2.calon A, $schema2.senarai_keputusan_temuduga C, $schema2.keputusan_temuduga D, $schema2.calon_jawatan_dipohon E
        	WHERE A.d_kemaskini IS NOT NULL AND (A.d_kemaskini >=".tosql($dby)." OR A.d_cipta >=".tosql($dby).") AND A.ICNo=C.noKP AND A.id_pemohon=E.id_pemohon";
        	$sql .= " AND A.pengakuan='Y' AND C.kod_keputusan_temuduga=D.kod AND C.is_deleted=0";
	   } else {
		$sql = "SELECT A.id_pemohon,A.nama_penuh, A.ICNo,A.d_cipta,A.d_kemaskini,A.pengakuan, A.status_pemohon 
        	FROM $schema2.calon A, $schema2.senarai_keputusan_temuduga C, $schema2.keputusan_temuduga D, $schema2.calon_jawatan_dipohon E
        	WHERE A.d_kemaskini IS NOT NULL AND (A.d_kemaskini >=".tosql($dby)." OR A.d_cipta >=".tosql($dby).") AND A.ICNo=C.noKP AND A.id_pemohon=E.id_pemohon";
        	$sql .= " AND A.pengakuan='Y' AND C.kod_keputusan_temuduga=D.kod AND C.is_deleted=0";		
	   }

    } else { 

    	if(empty($turutan) && empty($skim)){
    		//$conn->debug=true;
    		if(!empty($dby)){
    			$sql = "SELECT A.id_pemohon,A.nama_penuh, A.ICNo, A.d_cipta,A.d_kemaskini,A.pengakuan,A.status_pemohon, A.negeri 
				FROM $schema2.calon A WHERE A.id_pemohon IS NOT NULL";
    		} else { 
				$sql = "SELECT A.id_pemohon,A.nama_penuh, A.ICNo,A.d_cipta,A.d_kemaskini,A.pengakuan,A.status_pemohon, A.negeri 
				FROM $schema2.calon A WHERE A.id_pemohon IS NOT NULL ";
    		}

    	} else {

    		if(!empty($dby)){
    			$sql = "SELECT A.id_pemohon,A.nama_penuh, A.ICNo,A.d_cipta,A.d_kemaskini,A.pengakuan,A.status_pemohon, A.negeri 
    			FROM $schema2.calon A, $schema2.calon_jawatan_dipohon C WHERE C.id_pemohon=A.id_pemohon";
    		} else {
    			$sql = "SELECT A.id_pemohon,A.nama_penuh, A.ICNo,A.d_cipta,A.d_kemaskini,A.pengakuan,A.status_pemohon, A.negeri 
    			FROM $schema2.calon A, $schema2.calon_jawatan_dipohon C WHERE C.id_pemohon=A.id_pemohon";
    		}
    	}

        if(!empty($status)){
            if($status == 1){
                //$sql .= " AND A.pengakuan='Y' AND A.status_pemohon='Y'";
		        $sql .= " AND A.pengakuan='Y'";
                if(!empty($tkh_mula)){
                    if(!empty($tkh_akhir)){
                        $sql .= " AND date(A.tarikh_akuan) BETWEEN ".tosql($tkh_mula)." AND ".tosql($tkh_akhir)."";
                    } else {
                        $sql .= " AND date(A.tarikh_akuan) LIKE ".tosql($tkh_mula)."";
                    }
                } else {
                        $sql .= " AND (year(A.d_cipta) LIKE ".tosql($currYear)." OR year(A.d_kemaskini) LIKE ".tosql($currYear).")";
                }

            } else if($status == 2){
                $sql .= " AND A.pengakuan IS NULL AND A.status_pemohon IS NULL";
                if(!empty($tkh_mula)){
                    if(!empty($tkh_akhir)){
                        $sql .= " AND (date(A.d_cipta) BETWEEN ".tosql($tkh_mula)." AND ".tosql($tkh_akhir)." OR date(A.d_kemaskini) BETWEEN ".tosql($tkh_mula)." AND ".tosql($tkh_akhir).")";
                    } else {
                        $sql .= " AND date(A.d_cipta) LIKE ".tosql($tkh_mula)."";
                    }
                } else {
                        $sql .= " AND (year(A.d_cipta) LIKE ".tosql($currYear)." OR year(A.d_kemaskini) LIKE ".tosql($currYear).")";
                }
            }
        } else {
            //$sql .= " AND (A.pengakuan IS NULL OR A.pengakuan='Y')";
        }
    }

    if(!empty($skim)){
    	if($status<=2){
            	$sql .= " AND C.kod_jawatan=".tosql($skim);
        	} else {
            	$sql .= " AND E.kod_jawatan=".tosql($skim);
    	}
    }

    if(!empty($turutan)){
    	if($status<=2){
    	        $sql .= " AND C.seq_no=".tosql($turutan);
        	} else {
            	$sql .= " AND E.seq_no=".tosql($turutan);
    	}
    }

   
    if(!empty($negeri)){
        //$sql .= " AND B.KOD_NEGERI=".tosql($negeri);
        $sql .= " AND A.negeri=".tosql($negeri);
    }

    if(!empty($carian)){
        $sql .= " AND ((A.nama_penuh  LIKE '%".$carian."%') OR (A.ICNo  LIKE '%".$carian."%'))";
    }

    $sql .= " GROUP BY A.ICNo ORDER BY A.nama_penuh ASC";

     $rs = $conn->query($sql);
?>

<div class="box" style="background-color:#F2F2F2">
    <b>Maklumat Senarai Pemohon</b>
    <div class="box-body" style="background-color:#F2F2F2">
        <table width="100%" cellpadding="5" cellspacing="0" border="1">
            <thead  style="background-color:rgb(209 29 29)">
                <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                <th width="28%" id="namaPemohon" name="namaPemohon">
                    <font color="#000000">
                        <div align="center">Nama Pemohon
                        </div>
                    </font>
                </th>
		<th width="28%" id="namaPemohon" name="namaPemohon">
                    <font color="#000000">
                        <div align="center">Daftar
                        </div>
                    </font>
                </th>
		<th width="28%" id="namaPemohon" name="namaPemohon">
                    <font color="#000000">
                        <div align="center">Kemaskini
                        </div>
                    </font>
                </th>

                <th width="18%">
                    <font color="#000000">
                        <div align="center">No. Kad Pengenalan
                        </div>
                    </font>
                </th>
                <th width="10%">
                    <font color="#000000">
                        <div align="center">Negeri
                        </div>
                    </font>
                </th>
                <th width="20%"><font color="#000000"><div align="center">Skim Pilihan 1</div></font></th>
		<th width="20%"><font color="#000000"><div align="center">Skim Pilihan 2</div></font></th>
		<th width="20%"><font color="#000000"><div align="center">Skim Pilihan 3</div></font></th>
                <th width="9%">
                    <font color="#000000">
                        <div align="center">Status 
                    </font>
                </th>
            </thead>
            <tbody>
        
            <?php 
			    $bil = 0; 
                
                
                while(!$rs->EOF){ $bil2=0; ?>	
                    <?php 
                        // $conn->debug=true;
                        $sql = "SELECT C.DISKRIPSI, C.KOD, A.id_pemohon, A.kod_jawatan FROM $schema2.calon_jawatan_dipohon A, $schema1.ref_skim C  WHERE A.kod_jawatan=C.KOD AND A.id_pemohon=".tosql($rs->fields['id_pemohon']);

                        if(!empty($skim)){
                            $sql .= " AND C.KOD=".tosql($skim);
                        }
                    
                        if(!empty($turutan)){
                            $sql .= " AND A.seq_no=".tosql($turutan);
                        }

                        $sql .= " ORDER BY A.seq_no ASC";

                        $rsJawatan = $conn->query($sql);
                    ?>
                    <tr>
                        <td align="center"><?=++$bil;?></td>
                        <td align="left">
                            <?=$rs->fields['nama_penuh']?>
                        </td>
			<td align="left">
                            <?=DisplayDate($rs->fields['d_cipta']);  print '&nbsp;&nbsp;('.DisplayMasa($rs->fields['d_cipta']).')';?>
                        </td>
			<td align="left">
                            <?=DisplayDate($rs->fields['d_kemaskini']);  print '&nbsp;&nbsp;('.DisplayMasa($rs->fields['d_kemaskini']).')';?>
                        </td>

                        <td align="center"><?php print '&nbsp;'.$rs->fields['ICNo']?></td>
                        <td align="center"><?php print dlookup("$schema1.ref_negeri","NEGERI","KOD_NEGERI=".tosql($rs->fields['negeri']));?></td>
			<?php  $bilj=0; while(!$rsJawatan->EOF){ ?>
                        <td> 
                                <?php print $rsJawatan->fields['DISKRIPSI']; ?>
                        </td>
			<?php $rsJawatan->movenext(); $bilj++; } ?>
			<?php 
				if($bilj==1){ print '<td></td><td></td>'; }
				else if($bilj==2){ print '<td></td>'; }
			?>
                        <td align="center">
                            <?php if($rs->fields['pengakuan'] == 'Y'){ ?>
                                <button class="btn-success badge">Hantar</button>
                            <?php } else { ?>
                                <button class="btn-warning badge">Draf</button>
                            <?php } ?>
                        </td>
                    </tr>
                <?php 
                $rs->movenext(); } ?>
            </tbody>
        </table>
    </div>
</div>   

          