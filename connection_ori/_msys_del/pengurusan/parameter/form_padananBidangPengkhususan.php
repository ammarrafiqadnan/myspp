<!-- <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet"> -->
<?php include '../../../connection/common.php'; ?>
<script>
    function selecctall(source) {
        // var bidang_kod = $("#bidang_kod").val();
        var bidang_kod = $('#bidang_kod').val();


        // alert(kategori);
        if(document.getElementById("selectAll").checked == true){
            $(".chkPembetulan").attr("checked", "true");

            $.ajax({
                url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_BIDANG_PENGKHUSUSAN&pro=SAVE_ALL&check=yes&peringkatKelulusan='+peringkatKelulusan,
                type:'POST',
                data: $("form").serialize(),
                success: function(data){
                },
            });
        } else {
            // alert('sini2');
            // document.getElementById("chkPembetulan").checked = false;
            // document.getElementById("checkPembetulan").checked = false;
            // $("#test").attr("checked", false);
            // $(".testing").checked = false;
            $(".chkPembetulan").attr("checked", "false");

            $.ajax({
                url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_BIDANG_PENGKHUSUSAN&pro=SAVE_ALL&check=no&peringkatKelulusan='+peringkatKelulusan,
                type:'POST',
                data: $("form").serialize(),
                success: function(data){
                },
            });
        }
    }

    function do_check(kod_pengkhususan){
        var bidang_kod = $('#bidang_kod').val();
        var kategori = $('#kategori').val();
        var peringkatKelulusan = $('#peringkatKelulusan').val();
        
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
            url: 'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_BIDANG_PENGKHUSUSAN&pro=SAVE&bidang_kod='+bidang_kod+'&chk='+chks+'&kod_pengkhususan='+kod_pengkhususan,
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
$bidang_kod=strtoupper(isset($_REQUEST["bidang_kod"])?$_REQUEST["bidang_kod"]:"");
$kategori=strtoupper(isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"");
$peringkatKelulusan=strtoupper(isset($_REQUEST["peringkatKelulusan"])?$_REQUEST["peringkatKelulusan"]:"");
// print 'aaaaaaaa'.$kategori;

//$conn->debug=true;
$sql3 = "SELECT A.*, B.DISKRIPSI FROM $schema1.PADANAN_BIDANG_PENGKHUSUSAN A, $schema1.`ref_pengkhususan` B WHERE A.kod_pengkhususan=B.kod AND A.status=0 AND B.`STATUS`=0 AND B.is_deleted=0";

    if(!empty($bidang_kod)){
        $sql3 .= " AND A.kod_bidang=".tosql($bidang_kod);
    }

$rsbidang = $conn->query($sql3);


$bidangList=''; $bilb=0;
while(!$rsbidang->EOF){
    if($bilb==0){ $bidangList=$rsbidang->fields['kod_pengkhususan']; }
    else { $bidangList.="', '".$rsbidang->fields['kod_pengkhususan']; }
    $bilb++;
    $rsbidang->movenext();
}

$sql = "SELECT * FROM $schema1.`ref_pengkhususan` WHERE `STATUS`=0 AND is_deleted=0";
if(!empty($bidangList)){
    $sql .= " AND kod NOT IN('{$bidangList}')";
}
    $rsbidangUncheck = $conn->query($sql);
?>

		<div class="box" style="background-color:#F2F2F2">

            <div class="box-body">
                <input type="hidden" name="id" value="" />
                <div class="x_panel">
                <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
                    <div class="panel-actions">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
                    </div>
                    <h6 class="panel-title"><font color="#000000"><b>Senarai Pengkhususan
                    </b></font></h6> 
                </header>
                </div>
            </div>    
            <br /> 
            <input type="hidden" name="bidang_kod" id="bidang_kod" value="<?=$bidang_kod;?>">
            
                <div class="box-body" style="background-color:#F2F2F2; padding: 15px;">
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead  style="background-color:rgb(38, 167, 228)">
                            <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                            <th width="15%"><font color="#000000"><div align="center">Pengkhususan</div></font></th>
                            <th width="10%"><font color="#000000"><div align="center">Papar <br>Pilih semua <input type="checkbox" id="selectAll" onchange="selecctall(this)"></div></font></th>
                        </thead>
                        <tbody>
                        <?php 
                            $bil = 0; 
                            while(!$rsbidangUncheck->EOF){ ?>
                            <tr>
                                <td align="center"><?=++$bil;?></td>
                                <td><?=$rsbidangUncheck->fields['DISKRIPSI'];?></td>
                                <td align="center">
                                    <input class="chkPembetulan" type="checkbox" 
                                    onchange="do_check('<?=$rsbidangUncheck->fields['kod'];?>')" id="checkPembetulan" name="checkPembetulan">
                                </td>
                            </tr>
                        <?php $rsbidangUncheck->movenext(); } ?>
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

          