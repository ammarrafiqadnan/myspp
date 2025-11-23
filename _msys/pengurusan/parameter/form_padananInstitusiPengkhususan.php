<!-- <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet"> -->
<?php include '../../../connection/common.php'; ?>
<script>
    function selecctall(source) {
        // var institusi_kod = $("#institusi_kod").val();
        var institusi_kod = $('#institusi_kod').val();
        var kategori = $('#kategori').val();
        var peringkatKelulusan = $('#peringkatKelulusan').val();


        // alert(kategori);
        if(document.getElementById("selectAll").checked == true){
            $(".chkPembetulan").attr("checked", "true");

            $.ajax({
                url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_INSTITUSI_PENGKHUSUSAN&pro=SAVE_ALL&check=yes&institusi_kod='+institusi_kod+'&kategori='+kategori+'&peringkatKelulusan='+peringkatKelulusan,
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
                url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_INSTITUSI_PENGKHUSUSAN&pro=SAVE_ALL&check=no&institusi_kod='+institusi_kod+'&kategori='+kategori+'&peringkatKelulusan='+peringkatKelulusan,
                type:'POST',
                data: $("form").serialize(),
                success: function(data){
                },
            });
        }
    }

    function do_check(kod_pengkhususan){
        var institusi_kod = $('#institusi_kod').val();
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
            url: 'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_INSTITUSI_PENGKHUSUSAN&pro=SAVE&institusi_kod='+institusi_kod+'&chk='+chks+'&kod_pengkhususan='+kod_pengkhususan+'&kategori='+kategori+'&peringkatKelulusan='+peringkatKelulusan,
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
$institusi_kod=strtoupper(isset($_REQUEST["institusi_kod"])?$_REQUEST["institusi_kod"]:"");
$kategori=strtoupper(isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"");
$peringkatKelulusan=strtoupper(isset($_REQUEST["peringkatKelulusan"])?$_REQUEST["peringkatKelulusan"]:"");
// print 'aaaaaaaa'.$kategori;

$conn->debug=true;
$sql3 = "SELECT A.*, B.DISKRIPSI FROM $schema1.padanan_institusi_pengkhususan A, $schema1.`ref_pengkhususan` B 
WHERE A.kod_pengkhususan=B.kod AND A.status=0 AND B.`STATUS`=0 AND B.is_deleted=0";

    if(!empty($institusi_kod)){
        $sql3 .= " AND A.kod_institusi=".tosql($institusi_kod);
    }

    if(!empty($peringkatKelulusan)){
        $sql3 .= " AND A.peringkat_kelulusan=".tosql($peringkatKelulusan);
    }

    if($kategori == 'IKHTISAS'){
	$tajuk = " IKHTISAS";
        $sql3 .= " AND A.kategori=1";
    } else if($kategori == 'BUKANIKHTISAS'){
	$tajuk = " BUKAN IKHTISAS";
        $sql3 .= " AND A.kategori=2";
    }

$rsInstitusi = $conn->query($sql3);


$institusiList=''; $bilb=0;
while(!$rsInstitusi->EOF){
    if($bilb==0){ $institusiList=$rsInstitusi->fields['kod_pengkhususan']; }
    else { $institusiList.="', '".$rsInstitusi->fields['kod_pengkhususan']; }
    $bilb++;
    $rsInstitusi->movenext();
}

$sql = "SELECT * FROM $schema1.`ref_pengkhususan` WHERE `STATUS`=0 AND is_deleted=0";
if(!empty($institusiList)){
    $sql .= " AND kod NOT IN('{$institusiList}')";
}
    $rsInstitusiUncheck = $conn->query($sql);
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
                        <?php if($kategori == 'IKHTISAS'){ print 'Ikhtisas'; } else { print 'Bukan Iktisas';} ?>
                    </b></font></h6> 
                </header>
                </div>
            </div>    
            <br /> 
            <input type="hidden" name="institusi_kod" id="institusi_kod" value="<?=$institusi_kod;?>">
            <input type="hidden" name="kategori" id="kategori" value="<?=$kategori;?>">
            <input type="hidden" name="peringkatKelulusan" id="peringkatKelulusan" value="<?=$peringkatKelulusan;?>">


            
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
                                    onchange="do_check('<?=$rsInstitusiUncheck->fields['kod'];?>')" id="checkPembetulan" name="checkPembetulan">
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

          