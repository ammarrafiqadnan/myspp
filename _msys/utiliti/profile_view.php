<?php
session_start();
include '../connection/common.php';
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
//$conn->debug=true;
$staff=$_SESSION['SESSADM_UID'];
$sql = "SELECT * FROM _ref_status_ip WHERE status_id NOT IN (SELECT menu_id FROM _tbl_user_menu WHERE staff_id='{$staff}')";
$rsData = $conn->query($sql);
while(!$rsData->EOF){
	
	$status_id = $rsData->fields['status_id']; //."<br>";
	if(!empty($status_id)){
		$conn->execute("INSERT INTO _tbl_user_menu(menu_id, staff_id, menu_stat) VALUE('{$status_id}', '{$staff}', 0)");
	}
	$rsData->movenext();

}
?>
<script language="javascript" type="text/javascript">
function do_tukar(muid, menu_id, stat){
	//alert(muid);
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	$.ajax({
		url:'utiliti/profile_view_sql.php?uid='+staff+'&muid='+muid+'&menu_id='+menu_id+'&stat='+stat, //&datas='+datas,
		type:'POST',
		//dataType: 'json',
		data: $("form").serialize(),
		success: function(data){
			console.log(data);
		}
	});
}
function do_close(){
	reload = parent.location; 
	parent.location = reload;
}
</script>
<div class="col-md-12">
    <section class="panel panel-featured panel-featured-info">
        <header class="panel-heading"  style="height:50px;background: -webkit-linear-gradient(top, #00ced1 43%,#ffffff 100%);">
            <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="Tutup paparan">
            <img src="images/close-button.png" width="30" height="30" title="Tutup paparan" />
            </button>-->
            <button type="button" class="close" title="Tutup paparan" onclick="do_close()">
            <img src="images/close-button.png" width="30" height="30" title="Tutup paparan" />
            </button>
            <h6 class="panel-title"><font color="#000000" size="3"><b>Kemaskini Paparan Muka Hadapan Sistem</b></font></h6>
        </header>
        <div class="panel-body">
        
            <input type="hidden" name="staff" id="staff" value="<?=$rsData->fields['staff'];?>">
            <div class="col-md-12">
            
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-3 control-label">ID Pengguna : </label>
                        <div class="col-sm-3">
                            <input type="text" name="username" id="username" class="form-control" placeholder="ID Pengguna" disabled="disabled" 
                            value="<?php print $_SESSION['SESSADM_USERID'];?>">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-3 control-label"><font color="#FF0000">*</font>Nama Penuh : </label>
                        <div class="col-sm-8">
                            <input type="text" name="nama" id="nama" class="form-control" readonly="readonly" 
                            value="<?php print $_SESSION['SESSADM_UNAME'];?>">
                        </div>
                    </div>
                </div>
     
     			<?php 
				$conn->debug=true;
				$rsd = $conn->query("SELECT * FROM _tbl_user_menu A, _ref_status_ip B WHERE A.menu_id=B.status_id AND A.staff_id='{$staff}'"); ?>
                <div class="form-group">
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" 
                    	cellspacing="0" width="100%">
	                    <thead>
						<tr style="background-color:#CCC">
							<th width="5%">Bil.</th>
							<th width="60%" align="center">Tajuk Dashboard</th>
							<th width="35%" align="center">Status Paparan</th>
	               		</tr>
                        </thead>
						<tbody>
						<?php while(!$rsd->EOF){ $bil++; 
							$didm = $rsd->fields['menu_uid'];
							$idm = $rsd->fields['menu_id'];
							$stat = $rsd->fields['menu_stat'];
						?>
                        	<tr>
                            	<td><?=$bil;?></td>
                                <td><?php print $rsd->fields['status_nama'];?></td>
                                <td>
                                	<input type="radio" name="<?=$bil;?>" id="<?=$bil;?>" onclick="do_tukar('<?=$didm;?>', '<?=$idm;?>', 1)" 
                                    <?php if($stat==1){ print 'checked="checked"'; }?>/> Ya
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                	<input type="radio" name="<?=$bil;?>" id="<?=$bil;?>"  onclick="do_tukar('<?=$didm;?>', '<?=$idm;?>', 0)"  
                                    <?php if($stat==0){ print 'checked="checked"'; }?>/> Tidak
                                </td>
                            </tr>
                        <?php $rsd->movenext(); } ?>
						</tbody>
                	</table>
				</div>
				<div align="right"><button type="button" class="btn btn-default"title="Tutup paparan" onclick="do_close()">Tutup</button>
            </div>
        </div>     
    </section>
</div> 