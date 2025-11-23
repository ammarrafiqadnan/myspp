<!-- <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet"> -->
<?php include '../../../connection/common.php'; ?>
<script>
    function selecctall(source) {
        var kluster = $('#kluster').val();
        
        if(document.getElementById("selectAll").checked == true){
            $(".chkPembetulan").attr("checked", "true");

            $.ajax({
                url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_KLUSTER_BIDANG&pro=SAVE_ALL&check=yes&kluster='+kluster,
                type:'POST',
                data: $("form").serialize(),
                success: function(data){
                },
            });
        } else {
            $(".chkPembetulan").attr("checked", "false");

            $.ajax({
                url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_KLUSTER_BIDANG&pro=SAVE_ALL&check=no&kluster='+kluster,
                type:'POST',
                data: $("form").serialize(),
                success: function(data){
                },
            });
        }
    }

    function do_check(kod_bidang){
        var kluster = $('#kluster').val();
        var kategori = $('#kategori').val();
        
        const checkboxes = document.querySelectorAll(`input[name="checkPembetulan"]:checked`);
        let values = [];
        checkboxes.forEach((checkbox) => {
            values.push(checkbox.value);
        });

        if(values == ''){
            chks = 'false';
        } else {
            chks = 'true';
        }
        $.ajax({
            url: 'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_KLUSTER_BIDANG&pro=SAVE&kluster='+kluster+'&chk='+chks+'&kod_bidang='+kod_bidang,
            type:'POST',
            //dataType: 'json',
            data: $("form").serialize(),
            //data: datas,
            success: function(data){
            },
        });
    } 

</script>
<?php
$JFORM='LIST';
$kluster=strtoupper(isset($_REQUEST["kluster"])?$_REQUEST["kluster"]:"");

// $conn->debug=true;
$sql3 = "SELECT A.*, B.diskripsi, B.kod FROM $schema1.`padanan_kluster_bidang` A, $schema1.`ref_bidang` B WHERE A.`kod_bidang`=B.`kod` AND A.`status`=0";

if(!empty($kluster)){
    $sql3 .= " AND A.kod_kluster=".tosql($kluster);
}

$rsKluster = $conn->query($sql3);


$klusterList=''; $bilb=0;
while(!$rsKluster->EOF){
    if($bilb==0){ $klusterList=$rsKluster->fields['kod_bidang']; }
    else { $klusterList.="', '".$rsKluster->fields['kod_bidang']; }
    $bilb++;
    $rsKluster->movenext();
}

$sql = "SELECT * FROM $schema1.`ref_bidang` WHERE `status`=0 AND is_deleted=0";
if(!empty($klusterList)){
    $sql .= " AND KOD NOT IN('{$klusterList}')";
}
    $rsKlusterUncheck = $conn->query($sql);
?>

		<div class="box" style="background-color:#F2F2F2">

            <div class="box-body">
                <input type="hidden" name="id" value="" />
                <div class="x_panel">
                <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
                    <div class="panel-actions">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
                    </div>
                    <h6 class="panel-title"><font color="#000000"><b>Senarai Bidang</b></font></h6> 
                </header>
                </div>
            </div>    
            <br /> 
            <input type="hidden" name="kluster" id="kluster" value="<?=$kluster;?>">

            <!-- <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <label for="">Peringkat akademik: </label>
                    </div>
                    <div class="col-md-4">
                        <?php 
                            $sql = "SELECT * FROM $schema1.`ref_peringkat_akademik` WHERE is_deleted=0";
                            $rsPeringkat = $conn->query($sql);
                        ?>
                        <select name="kluster" id="kluster" class="form-control">
                            <option value="">Sila pilih peringkat akademik</option>
                            <?php while(!$rsPeringkat->EOF){ $code = $rsPeringkat->fields['kod']; ?>    
                                <option value="<?=$code;?>"><?php print $rsPeringkat->fields['diskripsi'];?></option>
                            <?php $rsPeringkat->movenext(); } ?>
                        </select>
                    </div> 
                </div>   
            </div>         
            <br>-->
                <div class="box-body" style="background-color:#F2F2F2; padding: 15px;">
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead  style="background-color:rgb(38, 167, 228)">
                            <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                            <th width="15%"><font color="#000000"><div align="center">Bidang</div></font></th>
                            <th width="10%"><font color="#000000"><div align="center">Papar <br>Pilih semua <input type="checkbox" id="selectAll" onchange="selecctall(this)"></div></font></th>
                        </thead>
                        <tbody>
                        <?php 
                            $bil = 0; 
                            while(!$rsKlusterUncheck->EOF){ ?>
                            <tr>
                                <td align="center"><?=++$bil;?></td>
                                <td><?=$rsKlusterUncheck->fields['diskripsi'];?></td>
                                <td align="center">
                                    <input class="chkPembetulan" type="checkbox" 
                                    onchange="do_check('<?=$rsKlusterUncheck->fields['kod'];?>')" id="checkPembetulan" name="checkPembetulan">
                                </td>
                            </tr>
                        <?php $rsKlusterUncheck->movenext(); } ?>
                        </tbody>
                    </table>

                    <div class="modal-footer" style="padding:0px;">
						<button type="button" class="btn btn-default" onclick="do_close()"><i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>
					</div>
                </div>

                
		</div>
     </div>
  </div>  
  
  <script>
    function do_close(){
        reload = window.location; 
        window.location = reload;
    }
</script>

          