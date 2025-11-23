<?php @session_start();
if(file_exists('connection/common.php')){  
include_once('connection/common.php');
} else {
include_once('../connection/common.php');
}
$id = $_SESSION['SESS_DATAID'];
?>
<script type="text/javascript">
function do_delete2(url){
    // alert("ss");
 	swal({
    title: 'Adakah anda pasti untuk menghapuskan data ini?',
    //text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Teruskan',
    cancelButtonText: 'Tidak, Batal!',
    reverseButtons: true
  }).then(function(e) {
    $.ajax({
      url:url,
      type:'POST',
      //dataType: 'json',
      data: $("form").serialize(),
      //data: datas,
      success: function(data){
      	if(data=='OK'){
          swal({
            title: 'Berjaya',
            text: 'Maklumat telah berjaya dihapuskan',
            type: 'success',
            confirmButtonClass: "btn-success",
            confirmButtonText: "Ok",
            showConfirmButton: true,
          }).then(function () {
              $("#Section2").load('maklumat_data/pass_form2.php');
          });
        } else if(data=='ERR'){
          swal({
            title: 'Amaran',
            text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya dikemaskini.',
            type: 'error',
            confirmButtonClass: "btn-warning",
            confirmButtonText: "Ok",
            showConfirmButton: true,
          });
        }
      }
    });
  });
}	
</script>
<div class="modal-footer" style="padding:0px;">
    <?php if(!empty($id)){ ?>
      <!-- <button type="button" class="btn btn-info mt-sm mb-sm" title="Tambah Maklumat"> -->
      	<!-- <i class="fa fa-save"></i> Tambah Maklumat</button>
        <a href="maklumat_data/pass_form_info.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal" data-backdrop="" style="font-family: Arial;"></a> -->
        <?php if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ ?>
	        <a href="maklumat_data/pass_form_info.php?id=<?=$id;?>&ids=<?=$id_det;?>" data-toggle="modal" data-target="#myModal" 
						title="Kemaskini maklumat tambahan/pemantauan" class="fa" data-backdrop="">
						<label class="btn btn-success"><i class="fa fa-plus-o" style="color:white;font-family: Arial;"> Tambah Maklumat</i></label>
					</a>
				<?php } ?>
				
				<button type="button" class="btn btn-default mt-sm mb-sm" 
            onclick="do_page('index.php?data=<?php print base64_encode('maklumat_data/pass_list;DATA;Maklumat Pemegang Surat Kebenaran Sembelihan;;;;'); ?>')">
            <i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>

    <?php } ?>
</div>
<?php 
			// $conn->debug=true;
			$sql = "SELECT * FROM `tbl_penyembelih_info` WHERE is_deleted=0 AND `penyembelih_id`='{$id}' ORDER BY info_tarikh DESC"; 
			$kbil=0; $tbil=0;
			$rs = $conn->query($sql);
            ?>    
            <div class="box-body" style="background-color:#F2F2F2">
              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead  style="background-color:rgb(38, 167, 228)">
                  <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Tarikh</div></font></th>
                  <th width="20%"><font color="#000000"><div align="center">Perkara</div></font></th>
                  <th width="55%"><font color="#000000"><div align="center">Kenyataan</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Tindakan</div></font></th>
                </thead>
                <tbody>
            <?php 
				$cnt = 1; 
				$bil = $StartRec;
				while(!$rs->EOF){ $kbil++; $tbil++;
					$bil = $cnt + ($PageNo-1)*$PageSize;
					$id_det = $rs->fields['id_pdetail'];
					if($rs->fields['info_jenis']=='P'){ $perkara = '<font color="red">Pemantauan</font>'; } else { $perkara = 'Makluman'; }
					// $data = $conn->query("SELECT `nama_sekolah`, `tkh_mula`, `tkh_tamat` FROM `tbl_plik_detail` WHERE plik_id='{$plik_id}' ORDER BY tkh_mula DESC");
					// $hrefs = "index.php?data=". base64_encode('maklumat_data/plik_form;DATA;Maklumat Pemegang Pas Lawatan Ikhtisas;;;'.$plik_id);
				?>
				  <tr>
					  <td align="center"><?=$bil;?></td>
					  <td align="center"><?php print DisplayDate($rs->fields['info_tarikh']);?></td>
					  <td align="left"><?php print $perkara;?></td>
					  <td align="left"><?php print $rs->fields['info_kenyataan'];?></td>
					  <td align="center">
					  	<?php if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ ?>	
					  		<a href="maklumat_data/pass_form_info.php?id=<?=$id;?>&id_det=<?=$id_det;?>" data-toggle="modal" data-target="#myModal" 
									title="Kemaskini maklumat tambahan/pemantauan" class="fa" data-backdrop="static">
									<label class="btn btn-sm btn-success">
										<i class="fa fa-edit" style="color:white;"></i>
									</label></a>
								&nbsp;
								<button type="button" class="btn btn-sm btn-danger" onclick="do_delete2('maklumat_data/sql_maklumat_data.php?frm=PASS_INFO&pro=DEL&id_det=<?=$id_det;?>')">
									<span style="cursor:pointer;color:red" title="Hapus Maklumat Kad Tauliah">
										<i class="fa fa-trash-o" style="color: #FFFFFF;"></i>
									</span>
								</button>
							<?php } ?>
            </td>
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