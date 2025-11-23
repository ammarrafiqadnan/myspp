<?php
$JFORM='LIST';
$tkh=date("Y-m-d");
$upd_btn='';
//$conn->debug=true;

//$conn->debug=false;
$dt = date("Y-m-d");
$sql = "UPDATE `tbl_penyembelih_detail` SET `status`=1 WHERE `tarikh_sah_akhir`<'{$dt}' AND `status`=0 AND `is_deleted`=0 ";

$carian=isset($_REQUEST["carian"])?$_REQUEST["carian"]:"";
if($list_status=='-'){ $list_status=''; $_SESSION["SS_status"]=''; } 
else { 
	if(!empty($list_status)){ $_SESSION["SS_status"] = $list_status; }
	else { $list_status = $_SESSION["SS_status"]; }
}
//$conn->debug=true;
?>

<input type="hidden" id="vals" name="vals" value=""  />
		         

			<?php 
			// $conn->debug=true;
			// $rss = $conn->query("SELECT `status` FROM `tbl_penyembelih_detail` WHERE `id_penyembelih`='{$id}' AND `is_deleted`=0 ORDER BY `tarikh_sah_akhir` DESC");

			$sql = "SELECT * FROM `tbl_penyembelih` WHERE is_deleted=0 "; 
			if(!empty($carian)){ $sql .= " AND (nama LIKE '%{$carian}%' OR no_pengenalan LIKE '%{$carian}%')"; }
			if(!empty($list_status) && $list_status<>"-"){ 
				if($list_status=='A'){ $sql .= " AND status='0'"; }
				else { $sql .= " AND status='{$list_status}'"; }
			}
			$sql .= " ORDER BY `nama` DESC";
			$kbil=0; $tbil=0;
            ?>    
			<?php include_once 'include/list_head.php'; ?>
            <?php include_once 'include/page_list.php'; ?>
            <div class="box-body" style="background-color:#F2F2F2">
              <table width="100%" cellpadding="5" cellspacing="0" border="1">
                <thead  style="background-color:rgb(38, 167, 228)">
                  <th width="3%"><font color="#000000"><div align="center">Bil</div></font></th>
                  <th width="25%"><font color="#000000"><div align="center">Nama</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">No. Pengenalan</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Warganegara</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">No. Tel</div></font></th>
                  <th width="25%"><font color="#000000"><div align="center">Majikan</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Tarikh</div></font></th>
                  <th width="7%"><font color="#000000"><div align="center">Status</div></font></th>
                </thead>
                <tbody>
            <?php 
            	$conn->debug=false;
				$cnt = 1; 
				$bil = $StartRec;
				while(!$rs->EOF){ $kbil++; $tbil++;
					$bil = $cnt + ($PageNo-1)*$PageSize;
					$id = $rs->fields['id'];
					$data = $conn->query("SELECT `majikan_nama`, `tarikh_sah_mula`, `tarikh_sah_akhir` FROM `tbl_penyembelih_detail` WHERE id_penyembelih='{$id}' ORDER BY `tarikh_sah_mula` DESC");
					$hrefs = "index.php?data=". base64_encode('maklumat_data/pass_form;DATA;Maklumat Pemegang Surat Kebenaran Sembelihan;;;'.$id);

					$status=''; $tarikh='';
					$rss = $conn->query("SELECT `status` FROM `tbl_penyembelih_detail` WHERE `id_penyembelih`='{$id}' AND `is_deleted`=0 ORDER BY `tarikh_sah_akhir` DESC");
					if(!$rss->EOF){ $rss->fields['status'];
						if($rss->fields['status']=='1'){ 
							$status = '<font color="black">Sijil Tamat Tempoh</font>';
							$tarikh = '<font style="color:red">'.DisplayDate($data->fields['tarikh_sah_mula']).' -<br>'.DisplayDate($data->fields['tarikh_sah_akhir']).'&nbsp;&nbsp;</font>'; 
						} else if($rss->fields['status']=='2'){ 
							$status = '<font color="red">Dibatalkan</font>'; 
							$tarikh = '<font style="color:red">'.DisplayDate($data->fields['tarikh_sah_mula']).' -<br>'.DisplayDate($data->fields['tarikh_sah_akhir']).'&nbsp;&nbsp;</font>';
						} else if($rss->fields['status']=='3'){ 
							$status = '<font color="red">Berhenti</font>'; 
							$tarikh = '<font style="color:red">'.DisplayDate($data->fields['tarikh_sah_mula']).' -<br>'.DisplayDate($data->fields['tarikh_sah_akhir']).'&nbsp;&nbsp;</font>';
						} else if($rss->fields['status']=='4'){ 
							$status = '<font color="red">Gantung Sementara</font>'; 
							$tarikh = '<font style="color:red">'.DisplayDate($data->fields['tarikh_sah_mula']).' -<br>'.DisplayDate($data->fields['tarikh_sah_akhir']).'&nbsp;&nbsp;</font>';
						} else { 
							$status = '<font color="green">Sijil Aktif</font>'; 
							$tarikh = DisplayDate($data->fields['tarikh_sah_mula']).' -<br>'.DisplayDate($data->fields['tarikh_sah_akhir'])."&nbsp;&nbsp;";
						}
					} else { 
						$status = '<font color="red">Tiada Sijil</font>';
					}
				?>
				  <tr>
					  <td align="center" valign="top"><?=$bil;?>.</td>
					  <td align="left" valign="top"><?php print $rs->fields['nama'];?><br /></td>
					  <td align="center" valign="top"><?php print $rs->fields['no_pengenalan'];?></td>
					  <td align="center" valign="top"><?php print $rs->fields['fldcountry'];?></td>
					  <td align="center" valign="top"><?php print $rs->fields['no_tel'];?></td>
					  <td align="center" valign="top"><?php print $data->fields['majikan_nama'];?></td>
					  <td align="center" valign="top">
					  	<?php print DisplayDate($data->fields['tarikh_sah_mula']);?> -<br><?php print DisplayDate($data->fields['tarikh_sah_akhir']);?>&nbsp;&nbsp;
					  </td>
					  <td align="center" valign="top"><?php print $status; ?></td>
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
		<?php 
        $url = explode("&",$actual_link);
        $href_f=$url[0]."&table_search=".$table_search; ?>
        <?php include 'include/list_footer.php'; ?>  
     </div>
<!-- DataTables -->
          