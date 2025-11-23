
<?php
// $conn->debug=true;
$JFORM='LIST';
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");
?>


        <div class="box" style="background-color:#F2F2F2">
            <b>Senarai Keputusan Temuduga</b>

            <?php
                //$conn->debug=true;
                $sql = "SELECT * FROM $schema2.`senarai_keputusam_temuduga` WHERE kod IS NOT NULL AND is_deleted=0"; 
                if(!empty($carian)){
                    $sql .= " AND (nama_penuh LIKE '%".$carian."%' OR noKP LIKE '%".$carian."%' OR skim_jawatan LIKE '%".$carian."%' OR no_pemerolehan LIKE '%".$carian."%')";
                }

                $rs = $conn->query($sql);
            ?>

            <div class="box-body" style="background-color:#F2F2F2">
                <table width="100%" cellpadding="5" cellspacing="0" border="1">
                    <thead  style="background-color:rgb(209 29 29)">
                        <th width="10%"><font color="#000000"><div align="center">No. Pemerolehan</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Nama</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">No. K/P</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Skim Jawatan</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Tarikh/ Masa</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Tempat</div></font></th>

                    </thead>
                    <tbody>
                
                    <?php 
                        while(!$rs->EOF){ 
                            $id = $rs->fields['kod'];

                            $id_pemohon = dlookup($schema2.'.myid','id_pemohon','ICNo='.$rs->fields['noKP']);
                            
                    ?>
                        <tr>
                            <td align="center"><?=$rs->fields['no_pemerolehan'];?></td>
                            <td align="center"><?=$rs->fields['nama_penuh'];?></td>
                            <td align="center"><?='&nbsp;'.$rs->fields['noKP'];?></td>
                            <td align="center"><?=$rs->fields['skim_jawatan'];?></td>
                            <td align="center"><?=date('d-m-Y',strtotime($rs->fields['tarikh'])).'<br>'.date('h:i A',strtotime($rs->fields['masa']));?></td>
                            <td align="center"><?=$rs->fields['tempat'];?></td>
                        </tr>
                    <?php 
                        $rs->movenext(); } 
                    ?>
                    </tbody>
                </table>
            </div>
		</div> 