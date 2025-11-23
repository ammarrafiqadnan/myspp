
<?php
$JFORM='LIST';
$icon_green='<img src="images/icon_green.png" width="27px" height="27px">';
$icon_yellow='<img src="images/icon_yellow.png" width="27px" height="27px">';
$icon_red='<img src="images/icon_red.png" width="27px" height="27px">';
$tkh=date("Y-m-d");
$upd_btn='';
//$conn->debug=true;
$rs_tkh = $conn->query("SELECT * FROM tbl_mymonitor_setup WHERE '{$tkh}' BETWEEN mymonitor_startdt AND mymonitor_enddt");
if(!$rs_tkh->EOF){
	$upd_btn='OK';
}
//$conn->debug=false;

$carian=isset($_REQUEST["carian"])?$_REQUEST["carian"]:"";
$list_status=isset($_REQUEST["list_status"])?$_REQUEST["list_status"]:"";
if($list_status=='-'){ $list_status='-'; $_SESSION["SS_status"]=''; } 
else { 
	if(empty($list_status)){ $list_status = $_SESSION["SS_status"]; }
	else { $_SESSION["SS_status"] = $list_status; }
}
//$conn->debug=true;
$dt = date("Y-m-d");
$sql = "UPDATE `tbl_plik_detail` SET `status`=1 WHERE `tkh_tamat`<'{$dt}' AND `status`=0 AND `is_deleted`=0 ";
$conn->query($sql);
?>

<input type="hidden" id="vals" name="vals" value=""  />
		<div class="box" style="background-color:#F2F2F2">

            <div class="box-body">
				<div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#000000"><b><?=$menu;?></b></font></h6> 
					</header>
				</div>
            </div>            
			
            
            <div class="form-group">
                
                <!--<div class="col-md-2" style="background-color:#F2F2F2">
                    <img src="images/printButton.png" title="Cetak" style="cursor:pointer" width="25" height="25" onclick="do_print('PRN')" />&nbsp;
                    <img src="images/icon_office_excel.gif" title="Salin ke EXCEL" style="cursor:pointer" width="25" height="25" onclick="do_print('EXCEL')" />&nbsp;
                    <img src="images/icon_office_word.gif" title="Salin ke MS Word" style="cursor:pointer" width="25" height="25" onclick="do_print('WORD')" />&nbsp;
                </div>-->
            </div> 
			<?php 
			// $conn->debug=true;
			$sql = "SELECT A.*, B.`fldcountry` FROM `tbl_plik` A, `_ref_negara` B WHERE A.`plik_warga`=B.`fldcountry_id` AND A.`is_deleted`=0 "; 
			if(!empty($carian)){ $sql .= " AND (A.plik_nama LIKE '%{$carian}%' OR A.plik_pasport LIKE '%{$carian}%')"; }
			if(!empty($list_status) && $list_status<>"-"){ 
				if($list_status=='A'){ $sql .= " AND A.plik_status='0'"; }
				else { $sql .= " AND A.plik_status='{$list_status}'"; }
			}
			$sql .= " ORDER BY A.`plik_nama` DESC";
			$rs = $conn->query($sql);
            ?>    
            <div class="box-body" style="background-color:#F2F2F2">
              <table width="100%" cellpadding="5" cellspacing="0" border="1">
                <thead  style="background-color:rgb(38, 167, 228)">
                  <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                  <th width="25%"><font color="#000000"><div align="center">Nama</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">No. pasport</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Warganegara</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">No. Tel</div></font></th>
                  <th width="25%"><font color="#000000"><div align="center">Lokasi</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Tarikh</div></font></th>
                  <th width="5%"><font color="#000000"><div align="center">Status</div></font></th>
                </thead>
                <tbody>
            <?php 
				$cnt = 1; //$conn->debug=true;
				$bil = $StartRec;
				while(!$rs->EOF){ $kbil++; $tbil++;
					$bil = $cnt + ($PageNo-1)*$PageSize;
					$plik_id = $rs->fields['plik_id'];
					$data = $conn->query("SELECT `nama_sekolah`, `tkh_mula`, `tkh_tamat` FROM `tbl_plik_detail` WHERE plik_id='{$plik_id}' AND is_deleted=0 ORDER BY tkh_tamat DESC");
					$hrefs = "index.php?data=". base64_encode('maklumat_data/plik_form;DATA;Maklumat Pemegang Pas Lawatan Ikhtisas;;;'.$plik_id);
					// if($data->fields['tkh_tamat']<date("Y-m-d")){ 
					// 	$tarikh = '<font style="color:red">'.DisplayDate($data->fields['tkh_mula']).'-<br>'.DisplayDate($data->fields['tkh_tamat']).'&nbsp;&nbsp;</font>';
					// } else {
					// 	$tarikh = DisplayDate($data->fields['tkh_mula']).'-<br>'.DisplayDate($data->fields['tkh_tamat'])."&nbsp;&nbsp;";
					// }

					$status='';
					$rss = $conn->query("SELECT `status` FROM `tbl_plik_detail` WHERE `plik_id`='{$plik_id}' AND `is_deleted`=0 ORDER BY `tkh_tamat` DESC");
					if(!$rss->EOF){ $rss->fields['status'];
						if($rss->fields['status']=='1'){ 
							$status = '<font color="black">Sijil Tamat Tempoh</font>';
							$tarikh = '<font style="color:red">'.DisplayDate($data->fields['tkh_mula']).'-<br>'.DisplayDate($data->fields['tkh_tamat']).'&nbsp;&nbsp;</font>'; 
						} else if($rss->fields['status']=='2'){ 
							$status = '<font color="red">Dibatalkan</font>'; 
							$tarikh = '<font style="color:red">'.DisplayDate($data->fields['tkh_mula']).'-<br>'.DisplayDate($data->fields['tkh_tamat']).'&nbsp;&nbsp;</font>';
						} else if($rss->fields['status']=='3'){ 
							$status = '<font color="red">Berhenti</font>'; 
							$tarikh = '<font style="color:red">'.DisplayDate($data->fields['tkh_mula']).'-<br>'.DisplayDate($data->fields['tkh_tamat']).'&nbsp;&nbsp;</font>';
						} else if($rss->fields['status']=='4'){ 
							$status = '<font color="red">Gantung Sementara</font>'; 
							$tarikh = '<font style="color:red">'.DisplayDate($data->fields['tkh_mula']).'-<br>'.DisplayDate($data->fields['tkh_tamat']).'&nbsp;&nbsp;</font>';
						} else { 
							$status = '<font color="green">Sijil Aktif</font>'; 
							$tarikh = DisplayDate($data->fields['tkh_mula']).'-<br>'.DisplayDate($data->fields['tkh_tamat'])."&nbsp;&nbsp;";
						}
					} else { 
						$status = '<font color="red">Tiada Sijil</font>';
					}

				?>
				  <tr>
					  <td align="center"><?=$bil;?></td>
					  <td align="left"><?php print $rs->fields['plik_nama'];?><br /></td>
					  <td align="center"><?php print $rs->fields['plik_pasport'];?></td>
					  <td align="center"><?php print $rs->fields['fldcountry'];?></td>
					  <td align="center"><?php print $rs->fields['plik_notel'];?></td>
					  <td align="center"><?php print $data->fields['nama_sekolah'];?></td>
					  <td align="center"><?php print $tarikh;?></td>
					  <td align="center"><?php print $status; ?></td>
				  </tr>
				<?php 
					$cnt = $cnt + 1;
					$bil = $bil + 1;
					$rs->movenext();
			}
			
			?>
                </tbody>
              </table>
            </div>
		</div>
<!-- DataTables -->
          