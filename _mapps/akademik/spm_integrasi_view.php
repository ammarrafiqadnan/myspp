<?php
$data_api = $_POST['data_api'];
$akg = $_POST['akg'];
$tahun = $_POST['tahun'];
?>    
<hr>
<div style="background: #f9f9f9; padding: 20px; border: 1px solid #b7bdc0; border-radius: 8px;">
    <!-- <h5 style="color:#2980b9; font-weight:bold;"><i class="fa fa-check-square-o"></i> Keputusan Sahih (Integrasi)</h5> -->
    
    <table class="table table-clean">
        <thead>
            <tr>
                <th>MATAPELAJARAN</th>
                <th class="text-center">GRED</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data_api as $item): ?>
                <tr>
                    <td><b><?=strtoupper($item['nama_sistem']);?></b></td>
                    <td class="text-center"><b style="color:dark;"><?=$item['gred'];?></b></td>
                    
                    <input type="hidden" name="mp_1[]" value="<?=$item['kod_sistem'];?>">
                    <input type="hidden" name="gred_1[]" value="<?=$item['gred'];?>">
                    
                    <input type="hidden" name="mp_old[]" value="<?=$item['kod_sistem'];?>">
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <input type="hidden" name="mp_old[]" value=""> </div>

<style>
    .text-integrasi { font-weight: bold; font-size: 14px; color: #333; }
    .table-clean td { border-top: 1px solid #eee !important; padding: 12px 8px !important; }
</style>