
    <script>
        function sortorder(href, val, fieldname){
            // alert('sini');
            var carian = $('#carian').val();

            window.location.href = href+"&carian="+carian;
            
            
            // return sorturl;
        }
    </script>

    <?php
        // $conn->debug=true;
        $JFORM='LIST';
        $carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");

        $hrefs = 'index.php?pages=semakan';
    ?>
    
    <section id="intro" class="bg-white big-banner" style="min-height: 630px;">
        <div class="container pt-5" style="opacity: 0.9;">
            
            
            
            <div class="row d-flex justify-content-center align-items-center">
                
                <div class="col-lg-12">
                    <div class="card">
                        <div class="text-center py-3">
                            <h3>Semakan Permohonan</h3>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="box-body" style="">
                                <div class="row" align="center">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">
                                        <label for="">No. Kad Pengenalan : </label>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" id="carian" name="carian" value="<?=$carian;?>" class="form-control" placeholder="Nama/No. KP">
                                    </div>
                                    <div class="col-md-2"  align="right">
                                        <button type="button" class="btn btn-primary" onclick="sortorder('<?=$hrefs;?>',this.value)" style="width:100%">
                                            <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Semak</font>
                                        </button>
                                    </div>
                                </div> 
                                <br><br>
                                <div class="row">
                                <?php
                                    $now = date('Y-m-d', strtotime(now()));
                                    
                                    //keputusan temuduga
                                    $sql = "SELECT * FROM $schema2.`senarai_keputusan_temuduga` A, $schema2.keputusan_temuduga B WHERE A.kod IS NOT NULL AND A.is_deleted=0 AND B.kod=A.kod_keputusan_temuduga AND B.is_deleted=0 AND B.tarikh_mula <=" .tosql($now)." AND B.tarikh_tamat >=".tosql($now); 
                                    $sql .= " AND (A.noKP LIKE '%".$carian."%')";
                                    
                                    $rs = $conn->query($sql);

                                    $sql4 = "SELECT COUNT(*) as total FROM $schema2.`calon` WHERE ICNo=".$carian." AND pengakuan='Y'"; 
                                    $rs4 = $conn->query($sql4);
                                ?>
                                <?php 
                                    if(!empty($carian)){
                                        if($rs4->fields['total'] != 0) {
                                            if(!$rs->EOF){
                                                while(!$rs->EOF){ 
                                                    if($rs->fields['status'] == '50' || $rs->fields['status'] == '53'){ //berjaya/contract ?>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label for="nama" class="col-sm-2 control-label"><b>Nama<div style="float:right">:</div></b></label>
                                                                    <div class="col-sm-10"><?=$rs->fields['nama_penuh']; ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label for="nama" class="col-sm-2 control-label"><b>No. Kad Pengenalan<div style="float:right">:</div></b></label>
                                                                    <div class="col-sm-10"><?=$rs->fields['noKP']; ?></div>
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label for="nama" class="col-sm-2 control-label"><b>Jawatan<div style="float:right">:</div></b></label>
                                                                    <div class="col-sm-10"><?=$rs->fields['skim_jawatan']; ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label for="nama" class="col-sm-2 control-label"><b>Tarikh Temu Duga<div style="float:right">:</div></b></label>
                                                                    <div class="col-sm-10"><?=date('d/m/Y', strtotime($rs->fields['tarikh'])); ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label for="nama" class="col-sm-2 control-label"><b>Keputusan Temu Duga<div style="float:right">:</div></b></label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-sm-12" style="text-align: justify;">
                                                                        <br>
                                                                        Tahniah! Anda telah berjaya. Tarikh lapor diri dan penempatan akan dimaklumkan oleh Kementerian/Jabatan Berkenaan. <br>
                                                                        <b> Kementerian/Jabatan : KEMENTERIAN PENGAJIAN TINGGI, BAHAGIAN PENGURUSAN SUMBER MANUSIA ARAS 15, NO.2, MENARA 2 JALAN P5/6, PRESINT 5 </b> <br><br>
                                                                        Sila klik di <a href="">sini</a> untuk mencetak Surat Tawaran dan Pakej Setuju Terima Tawaran (PSTT). <br><br>

                                                                        <b style="color: red;">PERINGATAN:</b><br><br>

                                                                        1.	Pihak Kementerian akan mengemukakan surat penempatan bertugas dan akan menghubungi calon (sekiranya perlu). <br>
                                                                        2.	Calon hendaklah mencetak SURAT TAWARAN dan PSTT dengan segera kerana makluman keputusan ini akan dipaparkan selama enam (6) minggu sahaja mulai dari tarikh pengumuman ini dikeluarkan. <br>
                                                                        3.	Calon mestilah mengemukakan <b> Borang Permohonan Pemeriksaan Perubatan Untuk Pelantikan Ke Dalam Perkhidmatan Awam </b> yang telah dilengkapkan oleh Pengamal Perubatan Berdaftar kepada Ketua Jabatan untuk tindakan selanjutnya. <br>
                                                                        4.	Sebarang pertanyaan atau pindaan kepada maklumat boleh menghubungi SPP seperti berikut: <br><br>

                                                                        Ibu Pejabat: <a href="">guru@spp.gov.my / bukanguru@spp.gov.my</a><br><br>

                                                                        Urus Setia SPP Sarawak: <a href="">pengambilan.sarawak@spp.gov.my
                                                                        <br><br>

                                                                        Urus Setia SPP Sabah: <a href="">uscsabah@spp.gov.my</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } else if($rs->fields['status'] == '54') { //simpanan ?>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label for="nama" class="col-sm-2 control-label"><b>Nama<div style="float:right">:</div></b></label>
                                                                    <div class="col-sm-10"><?=$rs->fields['nama_penuh']; ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label for="nama" class="col-sm-2 control-label"><b>No. Kad Pengenalan<div style="float:right">:</div></b></label>
                                                                    <div class="col-sm-10"><?=$rs->fields['noKP']; ?></div>
                                                                </div>
                                                            </div>
                                                            <br><br>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                                    <thead  style="background-color:rgb(38, 167, 228)">
                                                                        <th width="10%"><font color="#000000"><div align="center">Kod Skim</div></font></th>
                                                                        <th width="35%"><font color="#000000"><div align="center">Jawatan</div></font></th>
                                                                        <th width="15%"><font color="#000000"><div align="center">Tarikh Temu Duga</div></font></th>
                                                                        <th width="40%"><font color="#000000"><div align="center">Keputusan Temu Duga</div></font></th>

                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td align="center"><?=$rs->fields['kod_skim'];?></td>
                                                                            <td align="center"><?=$rs->fields['skim_jawatan'];?></td>
                                                                            <td align="center">
                                                                                <?=date('d/m/Y',strtotime($rs->fields['tarikh']));?>
                                                                            </td>
                                                                            <td style="text-align: justify;">
                                                                                <b>Anda telah dikategorikan sebagai calon simpanan sehingga 21/11/2023.</b><br><br> 

                                                                                <b style="color: red;">PERINGATAN:</b> <br>
                                                                                1. Keputusan temu duga ini hanya akan dipaparkan selama <b>enam (6) minggu</b> daripada tarikh paparan di Portal SPP.
                                                                                <br><br>
                                                                                2. Sebarang <b>PINDAAN</b> pada surat pemberitahuan tersebut perlu diselesaikan dalam tempoh <b>enam (6) minggu</b> daripada tarikh paparan di Portal SPP.
                                                                                <br><br>
                                                                                3. Tuan/Puan adalah bertanggungjawab untuk menyimpan sendiri <b>SALINAN</b> surat pemberitahuan. SPP tidak akan memaparkan/mengeluarkan surat tersebut <b>SELEPAS</b> tempoh <b>enam (6) minggu</b> daripada tarikh paparan di Portal SPP <b>berakhir</b>. <br>
                                                                                Sila klik SURAT PEMBERITAHUAN untuk tujuan cetakan.

                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    <?php } else if($rs->fields['status'] == '57') { //gagal ?>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label for="nama" class="col-sm-2 control-label"><b>Nama<div style="float:right">:</div></b></label>
                                                                    <div class="col-sm-10"><?=$rs->fields['nama_penuh']; ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label for="nama" class="col-sm-2 control-label"><b>No. Kad Pengenalan<div style="float:right">:</div></b></label>
                                                                    <div class="col-sm-10"><?=$rs->fields['noKP']; ?></div>
                                                                </div>
                                                            </div>
                                                            <br><br>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                                    <thead  style="background-color:rgb(38, 167, 228)">
                                                                        <th width="10%"><font color="#000000"><div align="center">Kod Skim</div></font></th>
                                                                        <th width="35%"><font color="#000000"><div align="center">Jawatan</div></font></th>
                                                                        <th width="15%"><font color="#000000"><div align="center">Tarikh Temu Duga</div></font></th>
                                                                        <th width="40%"><font color="#000000"><div align="center">Keputusan Temu Duga</div></font></th>

                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td align="center"><?=$rs->fields['kod_skim'];?></td>
                                                                            <td align="center"><?=$rs->fields['skim_jawatan'];?></td>
                                                                            <td align="center">
                                                                                <?=date('d/m/Y',strtotime($rs->fields['tarikh']));?>
                                                                            </td>
                                                                            <td style="text-align: justify;">
                                                                                <b>Maaf. Anda tidak Berjaya di dalam urusan temu duga ini.</b> 
                                                                                <br><br>
                                                                                <b style="color: red;">PERINGATAN:</b><br>
                                                                                1. Keputusan temu duga ini hanya akan dipaparkan selama <b>enam (6) minggu</b> daripada tarikh paparan di Portal SPP.


                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    <?php } else if($rs->fields['status'] == '75') { //tertakluk ?>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label for="nama" class="col-sm-2 control-label"><b>Nama<div style="float:right">:</div></b></label>
                                                                    <div class="col-sm-10"><?=$rs->fields['nama_penuh']; ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label for="nama" class="col-sm-2 control-label"><b>No. Kad Pengenalan<div style="float:right">:</div></b></label>
                                                                    <div class="col-sm-10"><?=$rs->fields['noKP']; ?></div>
                                                                </div>
                                                            </div>
                                                            <br><br>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                                    <thead  style="background-color:rgb(38, 167, 228)">
                                                                        <th width="10%"><font color="#000000"><div align="center">Kod Skim</div></font></th>
                                                                        <th width="35%"><font color="#000000"><div align="center">Jawatan</div></font></th>
                                                                        <th width="15%"><font color="#000000"><div align="center">Tarikh Temu Duga</div></font></th>
                                                                        <th width="40%"><font color="#000000"><div align="center">Keputusan Temu Duga</div></font></th>

                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td align="center"><?=$rs->fields['kod_skim'];?></td>
                                                                            <td align="center"><?=$rs->fields['skim_jawatan'];?></td>
                                                                            <td align="center">
                                                                                <?=date('d/m/Y',strtotime($rs->fields['tarikh']));?>
                                                                            </td>
                                                                            <td style="text-align: justify;">
                                                                                <b>Tertakluk kepada Kelulusan Mesyuarat Suruhanjaya.</b> 
                                                                                <br><br>
                                                                                <b style="color: red;">PERINGATAN:</b><br>
                                                                                1. Keputusan temu duga ini hanya akan dipaparkan selama <b>enam (6) minggu</b> daripada tarikh paparan di Portal SPP.


                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                               <?php }
                                               $rs->movenext(); }
                                            
                                            } else {
                                                print '<h4><b>Maaf! Permohonan anda tidak berjaya.</b></h4>';
                                            }
                                        } else {
                                            print '<h4><b>Maaf! Maklumat anda tiada dalam urusan ini.</b></h4>';
                                        }
                                    }   ?>
                                </div>

                            </div> 

                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </section>
    
    
    
