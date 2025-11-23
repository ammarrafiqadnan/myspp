<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<?php include '../../../connection/common.php'; ?>
<script>
    function do_cari(href, peringkat2){
        // alert('sini');
        var cari = $('#carian').val();
        //alert(peringkat2);
        //window.location.href = href+"&peringkat2="+peringkat2+"&carian="+cari;
        if (peringkat2 != 3) {
            //alert('bukan 3');
            window.location.href = href+"&peringkat2="+peringkat2+"&carian="+cari;
        }else{
             window.location.href = "index.php?data=cGVuZ3VydXNhbi9wYXJhbWV0ZXIvc2VuYXJhaV9ha2FkZW1pa19zdm07UGVudGFkYmlyYW47UGFyYW1ldGVyO1BhZGFuYW4gUGVyaW5na2F0IEFrYWRlbWlrIERhbiBTa2ltOzs7";
            //window.location.href = href+"&peringkat2="+peringkat2+"&carian="+cari;
       }
    }
</script>


<script>
    function selecctall(source) {
        // var peringkat2 = $("#peringkat2").val();
        var peringkat2 = $('#peringkat2').val();
        
        if(document.getElementById("selectAll").checked == true){
            $(".chkPembetulan").attr("checked", "true");

            $.ajax({
                url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_PERINGKATAKADEMIK_SKIM&pro=SAVE_ALL&check=yes&peringkat2='+peringkat2,
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
                url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_PERINGKATAKADEMIK_SKIM&pro=SAVE_SVM&check=no&peringkat2='+peringkat2,
                type:'POST',
                data: $("form").serialize(),
                success: function(data){
                },
            });
        }
    }

    var check = function(){
        if(condition){
            // run when condition is met
        }
        else {
            setTimeout(check, 1000); // check again in a second
        }
    }

    function do_check(kod_skim,kod){
        var peringkat2 = $('#peringkat2').val();
        var kategori = $('#kategori').val();
        var kod = kod;
        //$('#kod').val();
        //console.log(kod_skim);
        //console.log(kod_skim);
        //console.log(kategori);
        
        const checkboxes = document.querySelectorAll(`input[name="checkPembetulan"]:checked`);
        let values = [];
        checkboxes.forEach((checkbox) => {
            values.push(checkbox.value);
        });

        if(values == ''){
            chks = 'false';
        } else {
            chks = 'true';
            //console.log('hhhhhhhhhhhh');
        }
        url= 'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_PERINGKATAKADEMIK_SKIM&pro=SAVE_SVM&peringkat2='+peringkat2+'&chk='+chks+'&kod_skim='+kod_skim+'&kod='+kod;
        console.log(url);
        $.ajax({
            //url: 'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_PERINGKATAKADEMIK_SKIM&pro=SAVE&peringkat2='+peringkat2+'&chk='+chks+'&kod_skim='+kod_skim+'&kod_svm2='+kod_svm2,
            url: 'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_PERINGKATAKADEMIK_SKIM&pro=SAVE_SVM&peringkat2='+peringkat2+'&chk='+chks+'&kod_skim='+kod_skim+'&kod='+kod,
            type:'POST',
            //dataType: 'json',
            data: $("form").serialize(),
            //data: datas,
            success: function(data){
                alert('Skim SVM telah dikemaskini.');
            },
        });
    } 

</script>

<?php
//kod SVM from URL
$kod=$_GET['kod'];

$JFORM='LIST';
$peringkat2=strtoupper(isset($_REQUEST["peringkat2"])?$_REQUEST["peringkat2"]:"");

//$conn->debug=true;
$sql3 = "SELECT A.*, B.DISKRIPSI, B.KOD FROM $schema1.`padanan_peringkatakademik_skim` A, $schema1.`ref_skim` B WHERE A.`kod_skim`=B.`KOD` AND A.`status`=0";

if(!empty($peringkat2)){
    $sql3 .= " AND A.kod_peringkat_akademik=".tosql($peringkat2);
}

$rsInstitusi = $conn->query($sql3);
//print $rsInstitusi;


$institusiList=''; $bilb=0;
while(!$rsInstitusi->EOF){
    if($bilb==0){ $institusiList=$rsInstitusi->fields['kod_skim']; }
    else { $institusiList.="', '".$rsInstitusi->fields['kod_skim']; }
    $bilb++;
    $rsInstitusi->movenext();
}

$sql = "SELECT * FROM $schema1.`ref_skim` 
        WHERE `STATUS`=0 
        AND is_deleted=0
        and kod not in (
        select kod_skim from $schema1.padanan_peringkatakademik_skim where kod_peringkat_akademik='$peringkat2' and kod_svm='$kod' and status=0
        )";
if(!empty($institusiList)){
    //$sql .= " AND KOD NOT IN('{$institusiList}')";
}
//print $sql;
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
                    <h6 class="panel-title"><font color="#000000"><b>Senarai Jawatan SVM </b></font></h6> 
                </header>
                </div>
            </div>    
            <br /> 
            <input type="hidden" name="peringkat2" id="peringkat2" value="<?=$peringkat2;?>">
            <input type="hidden" name="kategori" id="kategori" value="<?=$kategori;?>">

            

            <!-- <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <label for="">Peringkat akademik: </label>
                    </div>
                    <div class="col-md-4">
                        <?php 
                            $sql = "SELECT * FROM $schema1.`ref_kursus_svm` WHERE is_deleted=0";
                            $rsPeringkat = $conn->query($sql);
                        ?>
                        <select name="peringkat2" id="peringkat2" class="form-control">
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
                            <th width="15%"><font color="#000000"><div align="center">Jawatan</div></font></th>
                            <th width="10%"><font color="#000000"><div align="center">Papar</div></font></th>
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
                                    onclick="do_check('<?=$rsInstitusiUncheck->fields['KOD'];?>','<?=$kod;?>')" id="checkPembetulan" name="checkPembetulan">
                                </td>
                            </tr>
                        <?php $rsInstitusiUncheck->movenext(); } ?>
                        </tbody>
                    </table>

                    <div class="modal-footer" style="padding:0px;">
						<button type="button" class="btn btn-default" onclick="do_close()"><i class="fa fa-spinner" style="margin:0px;"></i> Tutup</button>
					</div>
                    
                </div>
                <div class="box-body">
       
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