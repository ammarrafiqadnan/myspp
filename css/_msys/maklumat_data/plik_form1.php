<div class="col-md-12">
            
            <div class="form-group">
              <div class="row">
                <label for="plik_nama" class="col-sm-2 control-label"><b>NAMA <font color="#FF0000">*</font> : </b></label>
                <div class="col-sm-10">
                	<input type="text" name="plik_nama" id="plik_nama" class="form-control" value="<?php print $rs->fields['plik_nama'];?>" <?=$read_only;?>>
                </div>
              </div>
            </div>

			<?php $rsNEGARA = $conn->query("SELECT * FROM `_ref_negara` WHERE 1"); ?>
            <div class="form-group">
              <div class="row">
                <label for="plik_pasport" class="col-sm-2 control-label"><b>NO. PASSPORT <font color="#FF0000">*</font> : </b></label>
                <div class="col-sm-3">
                   <input type="text" name="plik_pasport" id="plik_pasport" class="form-control" value="<?php print $rs->fields['plik_pasport'];?>" readonly <?//=$read_only;?>>
                </div>
                <label for="plik_warga" class="col-sm-1 control-label"></label>
                <label for="plik_warga" class="col-sm-2 control-label"><b>WARGANEGARA <font color="#FF0000">*</font> : </b></label>
                <div class="col-sm-3">
					<select name="plik_warga" id="plik_warga" class="form-control" <?=$read_only;?>>
						<option value="">Sila pilih Negara</option>
						<?php while(!$rsNEGARA->EOF){ ?>
						<option value="<?php print $rsNEGARA->fields['fldcountry_id'];?>" <?php if($rsNEGARA->fields['fldcountry_id']==$rs->fields['plik_warga']){ print 'selected'; }
						?>><?php print strtoupper($rsNEGARA->fields['fldcountry']);?></option>
						<?php $rsNEGARA->movenext(); } ?>
					</select>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <label for="plik_tlahir" class="col-sm-2 control-label"><b>TARIKH LAHIR <font color="#FF0000">*</font> : </b></label>
                <div class="col-sm-3">
                   <input type="date" name="plik_tlahir" id="plik_tlahir" class="form-control" value="<?php print $rs->fields['plik_tlahir'];?>" <?=$read_only;?>>
                </div>
                <label for="plik_notel" class="col-sm-1 control-label"></label>
                <label for="plik_notel" class="col-sm-2 control-label"><b>NO. TELEFON <font color="#FF0000">*</font> : </b></label>
                <div class="col-sm-3">
                   <input type="text" name="plik_notel" id="plik_notel" class="form-control" value="<?php print $rs->fields['plik_notel'];?>" <?=$read_only;?>>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <label for="tkh_mula" class="col-sm-2 control-label"><b>TARIKH MULA : </b></label>
                <div class="col-sm-3">
					<input type="date" name="tkh_mula_det" id="tkh_mula_det"  class="form-control" value="<?php print $rsData->fields['tkh_mula'];?>" readonly/>
				</div>
                <label for="agensi_nama" class="col-sm-1 control-label"></label>
                <label for="agensi_nama" class="col-sm-2 control-label"><div align="left"><b>HINGGA </b></div></label>
                <div class="col-sm-3">
					<input type="date" name="tkh_tamat_det" id="tkh_tamat_det"  class="form-control" value="<?php print $rsData->fields['tkh_tamat'];?>" readonly/>
				</div>
              </div>
            </div>


            <div class="form-group">
              <div class="row">
                <label for="plik_catatan" class="col-sm-2 control-label"><b>CATATAN : </b></label>
                <div class="col-sm-10">
 					<textarea rows="3" name="plik_catatan" id="plik_catatan" class="form-control"><?php print $rs->fields['plik_catatan'];?></textarea>
               </div>
              </div>
            </div>
    	

            <div class="form-group">
              <div class="row">
                <label for="plik_status" class="col-sm-2 control-label"><b>STATUS REKOD <font color="#FF0000">*</font> : </b></label>
                <div class="col-sm-3">
                    <select class="form-control" name="plik_status" id="plik_status" required="required">
                        <option value="0"<?php if($rs->fields['plik_status']==0){ print 'selected';}?>>Rekod Aktif</option>
                        <option value="1"<?php if($rs->fields['plik_status']==1){ print 'selected';}?>>Rekod Tidak Aktif</option>
                    </select>
                </div>
                <!--<div class="col-sm-2">&nbsp;</div>
                <div class="col-md-4">
                <?php if(empty($parent_id) && empty($rsk->fields['parent_id'])){ ?>
                    <input type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" 
                    data-size="mini" style="margin-top:-10px" name="parent"   
                    <?php if($rsk->fields['parent']==1){ print ' checked '; }?>/> 
                    &nbsp;&nbsp;<span style="padding-top:20px;margin-top:10px;text-align:center">DATA TAMBAHAN</span>
                <?php } ?>
                </div>-->
               </div>
            </div>
    
            <div class="modal-footer" style="padding:0px;">
              <?php if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ ?>
                <button type="button" class="btn btn-primary mt-sm mb-sm" onclick="do_save()"><i class="fa fa-save"></i> Simpan</button>

                <?php if(!empty($id)){ ?>&nbsp;
                    <a id="simpan" href="maklumat_data/plik_form_detail.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal" data-backdrop="" style="font-family: Arial;">
                        <button type="button" class="btn btn-info mt-sm mb-sm" title="Tambah Maklumat Pas Lawatan Ikhtisas">
                        <i class="fa fa-save"></i> Tambah Maklumat Pas Lawatan</button>
                    </a>

                <?php } ?>
              <?php } ?>
                &nbsp;
                <button type="button" class="btn btn-default" onclick="do_page('index.php?data=<?php print base64_encode('maklumat_data/plik_list;DATA;Maklumat Pemegang Pas Lawatan Ikhtisas;;;;'); ?>')">
                  <i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>

                <input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
                <input type="hidden" name="proses" value="<?php print $proses;?>" />
                <div style="height: 10px">&nbsp;</div>
            </div>


        </div>

        <?php 
			// $conn->debug=true;
			$sql = "SELECT * FROM `tbl_plik_detail` WHERE is_deleted=0 AND plik_id='{$id}' ORDER BY tkh_tamat DESC"; 
			$kbil=0; $tbil=0;
			$rs = $conn->query($sql);
            ?>    
            <div class="box-body" style="background-color:#F2F2F2">
              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead  style="background-color:rgb(38, 167, 228)">
                  <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                  <th width="20%"><font color="#000000"><div align="center">Nama Madrasah/Sekolah</div></font></th>
                  <th width="20%"><font color="#000000"><div align="center">Alamat</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">No. Telefon<br>/ No. Faks</div></font></th>
                  <th width="20%"><font color="#000000"><div align="center">Nama Penganjur<br>/Jawatan</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Tarikh</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Status</div></font></th>
                  <th width="5%"><font color="#000000"><div align="center">Tindakan</div></font></th>
                </thead>
                <tbody>
            <?php 
				$cnt = 1; 
				$bil = $StartRec;
				while(!$rs->EOF){ $kbil++; $tbil++;
					$bil = $cnt + ($PageNo-1)*$PageSize;
					$plik_detid = $rs->fields['plik_detid'];
					if($rs->fields['tkh_tamat']<date("Y-m-d")){ $status = '<font color="red">Tamat</font>'; } else { $status = 'Aktif'; }
					if($rs->fields['jenis']=='B'){ $jenis='(Permohonan Baharu)'; }
					else if($rs->fields['jenis']=='L'){ $jenis='(Permohonan Lanjutan)'; }
					else { $jenis=''; }
					// $data = $conn->query("SELECT `nama_sekolah`, `tkh_mula`, `tkh_tamat` FROM `tbl_plik_detail` WHERE plik_id='{$plik_id}' ORDER BY tkh_mula DESC");
					// $hrefs = "index.php?data=". base64_encode('maklumat_data/plik_form;DATA;Maklumat Pemegang Pas Lawatan Ikhtisas;;;'.$plik_id);
          if($rs->fields['status']==0){ $status = 'Aktif'; }
          else if($rs->fields['status']==2){ $status = 'Pembatalan Pas'; }
          else if($rs->fields['status']==3){ $status = 'Berhenti'; }
          else if($rs->fields['status']==4){ $status = 'Pengantungan Sementara'; }
				?>
				  <tr>
					  <td align="center"><?=$bil;?></td>
					  <td align="left"><?php print $rs->fields['nama_sekolah'];?></td>
					  <td align="left"><?php print nl2br($rs->fields['alamat']);?></td>
					  <td align="center"><?php print $rs->fields['notel'];?><br>/<br><?php print $rs->fields['nofaks'];?></td>
					  <td align="center"><?php print $rs->fields['nama_penganjur'];?><br><br>(<?php print $rs->fields['jawatan'];?>)</td>
					  <td align="center"><?php print DisplayDate($rs->fields['tkh_mula']);?><br>-<br><?php print DisplayDate($rs->fields['tkh_tamat']);?></td>
					  <td align="center">
					  	<b><?php print $status;?></b><br><?=$jenis;?>

					  </td>
					  <td align="center">
              <?php if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ ?>
  					  	<?php if($rs->fields['status']==0 || $rs->fields['status']==4) { ?>
    						  <a href="maklumat_data/plik_form_detail.php?id=<?=$id;?>&ids=<?=$plik_detid;?>" data-toggle="modal" data-target="#myModal" 
    							title="Tambah Maklumat Pas Lawatan Ikhtisas" class="fa" data-backdrop="">
    							<label class="btn btn-sm btn-success">
    								<i class="fa fa-edit" style="color:white;"></i>
    							</label></a>
    							<br><br>
  						<?php } ?>	
  						<button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('maklumat_data/sql_maklumat_data.php?frm=PLIK_DET&pro=DEL&ID=<?=$plik_detid;?>')">
  							<span style="cursor:pointer;color:red" title="Hapus Maklumat Pas Lawatan Ikhtisas">
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
