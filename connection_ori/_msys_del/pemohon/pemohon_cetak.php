<?php 
    $order_by=isset($_REQUEST["order_by"])?$_REQUEST["order_by"]:"";
    $sort=isset($_REQUEST["sort"])?$_REQUEST["sort"]:"";
    $tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
    $tkh_akhir=isset($_REQUEST["tkh_akhir"])?$_REQUEST["tkh_akhir"]:"";
    $skim=isset($_REQUEST["skim"])?$_REQUEST["skim"]:"";
    $turutan=isset($_REQUEST["turutan"])?$_REQUEST["turutan"]:"";
    $negeri=isset($_REQUEST["negeri"])?$_REQUEST["negeri"]:"";
    $status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";
    $carian=isset($_REQUEST["carian"])?$_REQUEST["carian"]:"";

    $hrefs = 'index.php?data='.base64_encode('pemohon/senarai_pemohon;Pentadbiran;Senarai Pemohon;;;;');

    function do_search($href, $fieldname, $sort){
        $sorturl = $href."&order_by=".$fieldname."&sort=".$sort;
        return $sorturl;
    }
    
    // $conn->debug=true;
    $sql = "SELECT A.id_pemohon,A.nama_penuh, A.ICNo,A.d_cipta,A.d_kemaskini,A.pengakuan, B.diskripsi2 FROM $schema2.calon A, $schema2.ref_negeri B WHERE A.negeri=B.kod";

    if(!empty($tkh_mula)){
        $sql .= " AND A.d_cipta LIKE '%".$tkh_mula."%'";
    }

    if(!empty($tkh_akhir)){
        $sql .= " AND A.d_kemaskini LIKE '%".$tkh_akhir."%'";
    }

    if(!empty($negeri)){
        $sql .= " AND B.kod=".tosql($negeri);
    }

    if(!empty($status)){
        if($status == 1){
            $sql .= " AND A.pengakuan='Y'";
        } else if($status == 2){
            $sql .= " AND A.pengakuan IS NULL";
        }
        
    }

    if(!empty($carian)){
        $sql .= " AND ((A.nama_penuh  LIKE '%".$carian."%') OR (A.ICNo  LIKE '%".$carian."%'))";
    }

    if(!empty($sort)){
        if($order_by == 'namaPemohon'){
            if($sort == 'up'){
                $sql .= " ORDER BY A.nama_penuh ASC";
            } else if($sort == 'down'){
                $sql .= " ORDER BY A.nama_penuh DESC";
            }
        } 
        
        if($order_by == 'noKP'){
            if($sort == 'up'){
                $sql .= " ORDER BY A.ICNo ASC";
            } else if($sort == 'down'){
                $sql .= " ORDER BY A.ICNo DESC";
            }
        }

        if($order_by == 'negeri'){
            if($sort == 'up'){
                $sql .= " ORDER BY B.diskripsi2 ASC";
            } else if($sort == 'down'){
                $sql .= " ORDER BY B.diskripsi2 DESC";
            }
        }

        if($order_by == 'status'){
            if($sort == 'up'){
                $sql .= " ORDER BY A.pengakuan ASC";
            } else if($sort == 'down'){
                $sql .= " ORDER BY A.pengakuan DESC";
            }
        }
    } else {
        $sql .= " ORDER BY A.nama_penuh ASC";
    }

    // $strSQL=$sql. " LIMIT 10";
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
                        <div align="center">Nama Pemohon/Daftar/Kemaskini
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
                <th width="20%"><font color="#000000"><div align="center">Skim Jawatan</div></font></th>
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
                            <?=$rs->fields['nama_penuh']?> <br><br>
                            Daftar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?=DisplayDate($rs->fields['d_cipta']);  print '&nbsp;&nbsp;('.DisplayMasa($rs->fields['d_cipta']).')';?><br>
                            Kemas Kini : <?=DisplayDate($rs->fields['d_kemaskini']);  print '&nbsp;&nbsp;('.DisplayMasa($rs->fields['d_kemaskini']).')';?>
                        </td>
                        <td align="center"><?=$rs->fields['ICNo']?></td>
                        <td align="center"><?=$rs->fields['diskripsi2']?></td>
                        <td>
                            <?php  while(!$rsJawatan->EOF){ 
                                print ++$bil2.'. '.$rsJawatan->fields['DISKRIPSI'].'<br>';
                            $rsJawatan->movenext(); } ?>
                        </td>
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

          