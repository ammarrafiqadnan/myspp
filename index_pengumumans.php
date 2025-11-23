<?php include 'connection/common.php'; ?>
<style>
	@import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400');
 .bg, .button-baru {
	 position: absolute;
	 width: 100px;
	 height: 30px;
	 border-radius: 30%;
}
 .bg {
	 animation: pulse 1.2s ease infinite;
	 background: #ff3466;
}
 .button-baru {
	color: #ffffff;
	 display: flex;
	 justify-content: center;
	 align-items: center;
	 position: absolute;
	 z-index: 99;
	 border: none;
	 background: #e30038;
	 background-size: 18px;
	 cursor: pointer;
	 outline: none;
}
 .button-baru a {
	 position: absolute;
	 color: #fff;
	 font-size: 17px;
}
 @keyframes pulse {
	 0% {
		 transform: scale(1, 1);
	}
	 50% {
		 opacity: 0.3;
	}
	 100% {
		 transform: scale(1.5);
		 opacity: 0;
	}
}
 
</style>
<!-- Pengumuman -->
<section class="bg-light py-3 px-0" style="background-image: url('uploads_doc/bg-pemenang.jpg');">
    <div class="container-xxl px-2">
        <div class="row align-items-center justify-content-center text-center">
            <?php 
                //$conn->debug=true;
                //$rsANN = $conn->query("SELECT *, DATEDIFF(CURDATE(), tarikh_mula) AS date_difference FROM $schema2.hebahan_makluman WHERE `status`=0 AND is_deleted=0 AND jenis=1 ORDER BY tarikh_mula DESC"); 

                $now = date('Y-m-d', strtotime(now()));

                $rsANN = $conn->query("SELECT *, DATEDIFF(CURDATE(), tarikh_mula) AS date_difference FROM $schema2.hebahan_makluman WHERE tarikh_mula <=" .tosql($now)." AND tarikh_tamat >=".tosql($now)." AND `status`=0 AND is_deleted=0 AND jenis=1 ORDER BY tarikh_mula DESC"); 
            ?> 
		
             <div class="col-lg-7 col-xs-12 col-md-6" style="min-height: 300px;">
		<div class="card" style="box-shadow: 10px 10px 5px lightblue;">
		<div class="card-body">
                <h1 class="mb-3">Pengumuman</h1>
                <ul class="list-group mx-2 scrollClass border border-primary border-2" style="min-height: 240px">
                    <?php
                    $bil = 0;
                    while(!$rsANN->EOF){ $bil++;
                        $idAnn=$rsANN->fields['kod'];

			//print $rsANN->fields['date_difference'];
                    ?>
                    <li class="list-group-item" style="text-align: left;cursor:pointer;">
			<?php if($rsANN->fields['date_difference']<=10){ ?>
				<div class="bg"></div>
  				<div class="button-baru"> <b>Baharu </b></div><br>
			<?php } ?>
			<div style="padding-top:10px;">
			<small style="color: red;"><?=displayDate($rsANN->fields['tarikh_mula']);?></small></div>
			<label class="card-subtitle link-info" style="text-decoration: none; font-size: 1em;cursor: pointer;" onclick="open_pengumuman('ANN','<?=$idAnn;?>')"><?=$bil;?>. <?php print $rsANN->fields['tajuk'];?>
</label>
			<!--<a style="text-decoration: auto" href="hebahan_maklumat_form.php?id=<?=$rsANN->fields['kod'];?>&pages=view_pengumuman" target="_blank"><?=$bil;?>. <?php print $rsANN->fields['tajuk'];?>
                    	</a>-->
		    </li>
                    <?php $rsANN->movenext(); } ?>

                </ul>
		</div>
            </div>
            </div>
            <div class="col-lg-5 col-md-12 p-0">
                
                <div class="row p-0 m-2 d-flex justify-content-center align-items-stretch">
                    
                  <!--  <div class="menubutton p-2 shadow">
                      <a href="https://semakan.spp.gov.my/semakan/jadual_temuduga_view.php">
                            <div>
                                <i class="fa-solid fa-scale-balanced fa-5x my-2 img-fluid" style="color: #00c6db"></i>
                                <div><h6><font style="color: 0px 10px 5px lightblue;">SEMAKAN PANGGILAN TEMU DUGA</font></h6></div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="menubutton p-2 shadow">
                      	<a href="https://semakan.spp.gov.my/semakan/keputusan_temuduga_view.php">
                            <div>
                                <i class="fa-solid fa-users fa-5x my-2 img-fluid" style="color: #00c6db"></i>
                                <div><h6><font style="color: 0px 10px 5px lightblue;">SEMAKAN KEPUTUSAN TEMU DUGA</font></h6></div>
                            </div>
                        </a>
                    </div>-->
                    
         
                  <div class="menubutton p-2 shadow">
                        <a href="https://semakan.spp.gov.my/semakanV2/" target="_blank">
                            <div>
                                <i class="fa-solid fa-users fa-5x my-2 img-fluid" style="color: #00c6db"></i>
                                <div><h6><font style="color: 0px 10px 5px lightblue;">SEMAKAN ATAS TALIAN</font></h6></div>
                            </div>
                        </a>
                    </div>

                    
                    <div class="menubutton p-2 shadow">
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSfMBRQ-vPXUgr4laz0x6eoM-LOOJOodT4eaYMWV8y3xuHGIRw/viewform" target="_blank">
                            <div>
                                <i class="fa-solid fa-file-pen fa-5x my-2 img-fluid" style="color: #00c6db"></i>
                                <div><h6>KAJIAN KEPUASAN PENGGUNA</h6></div>
                            </div>
                        </a>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</section>