<?php 
// $conn->debug=true;
$rsFAQ = $conn->query("SELECT * FROM $schema2.faq WHERE `status`=0 AND is_deleted=0"); ?>    
    
    <section id="intro" class="bg-white big-banner" style="min-height: 630px;">
        
        <div class="container pt-5" style="opacity: 0.9;">
            
            <div class="card p-5 text-md-left">
                <h1 class="card-title text-center">Soalan Lazim</h1>
		<div class="card" style="background-color: #e3e6e8;">
			<p style="padding-left: 10px; text-align: justify;">
				<b>Penafian : </b><br>
				Tiada bahagian daripada terbitan ini boleh diterbitkan semula atau ditukarkan ke dalam sebarang bentuk, sama ada dengan cara elektronik, gambar dan sebagainya tanpa kebenaran serta sebelum mendapat izin bertulis daripada Suruhanjaya Perkhidmatan Pendidikan (SPP).
			</p>
		</div>
		<div><p></p></div>

                <ul class="list-group list-group-flush align-items-stretch">
                    <?php $i=0;
			while(!$rsFAQ->EOF){ ?>
                    <li class="list-group-item">
                        <h5><?php print ++$i.'. SOALAN : '.$rsFAQ->fields['tajuk'];?></h5>
                        <!--<h6><?php //print 'JAWAPAN : '.nl2br(trim($rsFAQ->fields['keterangan']));?></h6>-->
			<p><?php print 'JAWAPAN : '.$rsFAQ->fields['keterangan'];?></p>

                    </li>
                    <?php $rsFAQ->movenext(); } ?>
                </ul>                
            </div>
            
        </div>
    </section>
    
