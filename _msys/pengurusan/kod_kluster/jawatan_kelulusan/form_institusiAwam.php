<!-- <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet"> -->
<?php include '../../../connection/common.php'; ?>
<script>
    function selecctall(source) {
        // var peringkat2 = $("#peringkat2").val();
        var peringkat2 = $('#peringkat2').val();
        var kategori = $('#kategori').val();

        // alert(kategori);
        if(document.getElementById("selectAll").checked == true){
            $(".chkPembetulan").attr("checked", "true");

            $.ajax({
                url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_PERINGKATKELULUSAN_INSTITUSI&pro=SAVE_ALL&check=yes&peringkat2='+peringkat2+'&kategori='+kategori,
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
                url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_PERINGKATKELULUSAN_INSTITUSI&pro=SAVE_ALL&check=no&peringkat2='+peringkat2+'&kategori='+kategori,
                type:'POST',
                data: $("form").serialize(),
                success: function(data){
                },
            });
        }
    }

    function do_check(kod_institusi){
        var peringkat2 = $('#peringkat2').val();
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
            url: 'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_PERINGKATKELULUSAN_INSTITUSI&pro=SAVE&peringkat2='+peringkat2+'&chk='+chks+'&kod_institusi='+kod_institusi+'&kategori='+kategori,
            type:'POST',
            //dataType: 'json',
            data: $("form").serialize(),
            //data: datas,
            success: function(data){
            },
        });
    } 

    function do_carianCK(url){
        var cariPK = $('#cariPK').val();
        var urls2 = url+'&cariPK='+cariPK;

        alert(urls2);

        $('.modal-content').load(urls2,function(){
            $('#modal-content').modal({show:true});
        });
    }

</script>
<?php
$JFORM='LIST';
$peringkat2=strtoupper(isset($_REQUEST["peringkat2"])?$_REQUEST["peringkat2"]:"");
$kategori=strtoupper(isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"");
$cariPK=strtoupper(isset($_REQUEST["cariPK"])?$_REQUEST["cariPK"]:"");

// $conn->debug=true;
$sql3 = "SELECT A.*, B.DISKRIPSI, B.KATEGORI, B.KOD FROM $schema1.`padanan_peringkatkelulusan_institusi` A, $schema1.`ref_institusi` B WHERE A.`kod_institusi`=B.`KOD` AND A.`status`=0 AND B.`NEGARA`='130' AND B.`SAH_YT`='Y' AND B.`KATEGORI`='A'";

if(!empty($peringkat2)){
    $sql3 .= " AND A.kod_peringkat_kelulusan=".tosql($peringkat2);
}

if(!empty($cariPK)){
    $sql3 .= " AND B.DISKRIPSI  LIKE '%".$cariPK."%'";
}

$rsInstitusi = $conn->query($sql3);


$institusiList=''; $bilb=0;
while(!$rsInstitusi->EOF){
    if($bilb==0){ $institusiList=$rsInstitusi->fields['kod_institusi']; }
    else { $institusiList.="', '".$rsInstitusi->fields['kod_institusi']; }
    $bilb++;
    $rsInstitusi->movenext();
}

$sql = "SELECT * FROM $schema1.`ref_institusi` WHERE `NEGARA`='130' AND SAH_YT='Y' AND KATEGORI='A'";
if(!empty($institusiList)){
    $sql .= " AND KOD NOT IN('{$institusiList}')";
}
    $rsInstitusiUncheck = $conn->query($sql);
?>

		<div id="modalPK" class="box" style="background-color:#F2F2F2">

            <div class="box-body">
                <div class="x_panel">
                <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
                    <div class="panel-actions">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
                    </div>
                    <h6 class="panel-title"><font color="#000000"><b>Senarai Institusi Awam</b></font></h6> 
                </header>
                </div>
            </div>    
            <br /> 
            <input type="hidden" name="peringkat2" id="peringkat2" value="<?=$peringkat2;?>">
            <input type="hidden" name="kategori" id="kategori" value="<?=$kategori;?>">
            <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <label for="">Carian: </label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="cariPK" name="cariPK">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-md" onclick="do_carianCK('pengurusan/jawatan_kelulusan/form_institusiAwam.php?peringkat2=<?=$peringkat2;?>&kategori=awam')">Carian</button>
                    </div> 
                </div>   
            </div>         
            <br>
            <!-- <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <label for="">Peringkat Kelulusan: </label>
                    </div>
                    <div class="col-md-4">
                        <?php 
                            $sql = "SELECT * FROM $schema1.`ref_peringkat_kelulusan` WHERE is_deleted=0";
                            $rsPeringkat = $conn->query($sql);
                        ?>
                        <select name="peringkat2" id="peringkat2" class="form-control">
                            <option value="">Sila pilih peringkat kelulusan</option>
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
                            <th width="15%"><font color="#000000"><div align="center">Jawatan</div></font></th>
                            <th width="10%"><font color="#000000"><div align="center">Papar <br>Pilih semua <input type="checkbox" id="selectAll" onchange="selecctall(this)"></div></font></th>
                        </thead>
                        <tbody>
                        <?php 
                            $bil = 0; 
                            while(!$rsInstitusiUncheck->EOF){ ?>
                            <tr>
                                <td align="center"><?=++$bil;?></td>
                                <td><?=$rsInstitusiUncheck->fields['DISKRIPSI'];?></td>
                                <td align="center">
                                    <input class="chkPembetulan" type="checkbox" 
                                    onchange="do_check('<?=$rsInstitusiUncheck->fields['KOD'];?>')" id="checkPembetulan" name="checkPembetulan">
                                </td>
                            </tr>
                        <?php $rsInstitusiUncheck->movenext(); } ?>
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

          