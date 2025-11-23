function alert_msg_html(msg){
    swal({
        title: 'Makluman',
        type: 'info',
        html: '<pre style="color:red;text-align:left">' + msg + '</pre>',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok',
        reverseButtons: true
    });     
}
function do_keluar(){
	swal({
		title: 'Adakah anda pasti untuk keluar?',
		//text: "You won't be able to revert this!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Teruskan',
		cancelButtonText: 'Tidak, Batal!',
		reverseButtons: true
	}).then(function () {
		$.ajax({
			url:'include/logout_menu.php', //&datas='+datas,
			type:'POST',
			//dataType: 'json',
			beforeSend: function () {
				$('.btn-primary').attr("disabled","disabled");
				$('.modal-body').css('opacity', '.5');
			},
			data: $("form").serialize(),
			//data: datas,
			success: function(data){
				console.log(data);
				//alert(data);
				/*if(data=='OK'){
					swal({
					  title: 'Berjaya',
					  text: 'Maklumat telah keluar daripada sistem',
					  type: 'success',
					  confirmButtonClass: "btn-success",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					}).then(function () {*/
						reload = window.location; 
						window.location = reload;
				//	});
				//}
			}
			//data: datas
		});
	});		
}

function do_hapus(URL){
    swal({
        title: 'Adakah anda pasti untuk menghapuskan data ini?',
        //text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Teruskan',
        cancelButtonText: 'Tidak, Batal!',
        reverseButtons: true
    }).then(function(e) {
        // e.preventDefault();
        $.ajax({
            url:URL,
            type:'POST',
            //dataType: 'json',
            beforeSend: function () {
                $('.btn-primary').attr("disabled","disabled");
                $('.modal-body').css('opacity', '.5');
            },
            data: $("form").serialize(),
            //data: datas,
            success: function(data){
                console.log(data);
                // alert(data);
                if(data=='OK'){
                    swal({
                      title: 'Berjaya',
                      text: 'Maklumat telah berjaya dihapuskan',
                      type: 'success',
                      confirmButtonClass: "btn-success",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    }).then(function () {
                        reload = window.location; 
                        window.location = reload;
                    });
                } else if(data=='ERR'){
                    swal({
                      title: 'Amaran',
                      text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya dihapuskan.',
                      type: 'error',
                      confirmButtonClass: "btn-warning",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    });
                }
            }
            //data: datas
        });
    });     
}

function localJsonpCallback(json) {
  if (!json.Error) {
    //$('#resultForm').submit();
  } else {
    //$('#loading').hide();
    //$('#userForm').show();
    alert(json.Message);
  }
}

function do_daftar(URL){
	//alert('sini');
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	var emel = $('#emel_daftar').val();
    var keselamatan = $('#keselamatan_daftar').val();
    var NONO = $('#NONOD').val();
    var nama = $('#nama_daftar').val();
    var nokp = $('#nokp_daftar').val();

    //alert("dd");
    // var testMail = 'testmail@fakemail.com';
    var check_email = '[a-zA-Z0-9]{0,}([.]?[a-zA-Z0-9]{1,})[@](gmail.com|hotmail.com|yahoo.com|ymail.com|gmail.com.my)';
    var patt = new RegExp(check_email);
    var result = patt.test(emel);
    var msg = '';

    if(emel.trim() == '' ){
        msg = msg+'\n- Sila masukkan alamat e-mel anda.';
        $("#emel_daftar").css("border-color","#f00");
    }
    if(nama.trim() == '' ){
        msg = msg+'\n- Sila masukkan nama anda.';
        $("#nama_daftar").css("border-color","#f00");
    }
    if(nokp.trim() == '' ){
        msg = msg+'\n- Sila masukkan nombor kad pengenalan anda.';
        $("#nokp_daftar").css("border-color","#f00");
    }
    if(keselamatan.trim() == '' ){
        msg = msg+'\n- Sila masukkan maklumat kod keselamatan.';
        $("#keselamatan_daftar").css("border-color","#f00");
    }
    if(!result){
        msg = msg+'\n- Alamat E-mel tidak dibenarkan.\nHanya e-mel (gmail.com @ hotmail.com @ yahoo.com \n@ ymail.com) sahaja yang dibenarkan.';
        $("#emel_daftar").css("border-color","#f00");
    }

    var daftar='';
    if(msg.trim() !=''){ 
        alert_msg_html(msg);
    } else { 
	daftar='OK';
    }

    if(daftar=='OK'){
	var urls = URL+"&ed="+emel+"&na="+nama+"&kp="+nokp;
	//alert(urls);
        if(keselamatan==NONO){
            $.ajax({
                url:urls,
                type:'POST',
                //dataType: 'json',
                beforeSend: function () {
                    $('.btn-primary').attr("disabled","disabled");
                    $('.modal-body').css('opacity', '.5');
                },
                data: $("form").serialize(),
                //data: datas,
                success: function(data){
                    console.log(data);
                     //alert(data);
                    if(data=='OK'){
			swal({
                          title: 'Berjaya',
                          text: 'Pra-Pendaftaran telah berjaya. Sila semak e-mel (folder Inbox/SPAM) anda untuk mengaktifkan akaun pendaftaran',
                          type: 'success',
                          confirmButtonClass: "btn-success",
                          confirmButtonText: "Ok",
                          showConfirmButton: true,
                        }).then(function () {
                            reload = window.location; 
                            window.location = reload;
                        });
                    } else if(data=='ADAS'){
			swal({
                          title: 'Makluman',
			  text: 'Bagi pemohon jawatan Pegawai Perkhidmatan Pendidikan (PPP) Gred DG41'+ 
			  'yang telah mendaftar jawatan sebelum atau pada 21 April 2023, tidak perlu mendaftar akaun baharu sehingga diberitahu kelak.',
			  type: 'info',
			  confirmButtonClass: "btn-info",
			  confirmButtonText: "Ok",
			  showConfirmButton: true,
                        //}).then(function () {
                        	//reload = window.location; 
                        	//window.location = reload;
                    	});

                    } else if(data=='ADA'){
			swal({
                          title: 'Amaran',
                          text: 'Alamat e-mel yang dimasukkan telah didaftarkan di dalam sistem MySPP.',
                          type: 'error',
                          confirmButtonClass: "btn-warning",
                          confirmButtonText: "Ok",
                          showConfirmButton: true,
                        //}).then(function () {
                        	//reload = window.location; 
                        	//window.location = reload;
                    	});

                    } else if(data=='ERR'){
			swal({
                          title: 'Amaran',
                          text: 'Maaf permohonan tidak berjaya. Sila salurkan pertanyaan atau aduan kepada Hotline mySPP/SISPAA-SPP',
                          type: 'error',
                          confirmButtonClass: "btn-warning",
                          confirmButtonText: "Ok",
                          showConfirmButton: true,
                        //}).then(function () {
                        	//reload = window.location; 
                        	//window.location = reload;
                    	});

                    } else if(data=='JPN'){
			swal({
                          title: 'Amaran',
                          text: 'Maaf permohonan tidak berjaya. Sila salurkan pertanyaan atau aduan kepada Hotline mySPP/SISPAA-SPP',
                          type: 'error',
                          confirmButtonClass: "btn-warning",
                          confirmButtonText: "Ok",
                          showConfirmButton: true,
			  //position: "top",  
                        //}).then(function () {
                        	//reload = window.location; 
                        	//window.location = reload;
                    	});

                    } else if(data=='DDAF'){
			swal({
                          title: 'Amaran',
                          text: 'Maaf permohonan tidak berjaya. Maklumat telah didaftarkan.',
                          type: 'error',
                          confirmButtonClass: "btn-warning",
                          confirmButtonText: "Ok",
                          showConfirmButton: true,
			  //position: "top",  
                        //}).then(function () {
                        	//reload = window.location; 
                        	//window.location = reload;
                    	});

                    } else if(data=='EMELX'){
			swal({
                          title: 'Amaran',
                          text: 'Maaf permohonan tidak berjaya. Emel telah didaftarkan.',
                          type: 'error',
                          confirmButtonClass: "btn-warning",
                          confirmButtonText: "Ok",
                          showConfirmButton: true,
			  //position: "top",  
                        //}).then(function () {
                        	//reload = window.location; 
                        	//window.location = reload;
                    	});

                    } else if(data=='ICADA'){
                        swal({
                          title: 'Amaran',
                          text: 'Maaf permohonan tidak berjaya. No. Kad Pengenalan anda telah didaftarkan menggunakan email berbeza.',
                          type: 'error',
                          confirmButtonClass: "btn-warning",
                          confirmButtonText: "Ok",
                          showConfirmButton: true,
			  //position: "top",  
                        //}).then(function () {
                        	//reload = window.location; 
                        	//window.location = reload;
                    	});

                    } else if(data=='XLIMIT'){
                        swal({
                          title: 'Amaran',
                          text: 'Maaf permohonan tidak berjaya. Anda telah membuat pendaftaran lebih daripada 3 kali. Sila cuba semula dalam tempoh selepas 24 jam.',
                          type: 'error',
                          confirmButtonClass: "btn-warning",
                          confirmButtonText: "Ok",
                          showConfirmButton: true,
			  //position: "top",  
                        //}).then(function () {
                        	//reload = window.location; 
                        	//window.location = reload;
                    	});

                    } else if(data=='XOK'){
			//alert('Maaf! No K/P atau nama tidak tepat. Sila masukkan No K/P dan nama seperti yang tertera di Kad Pengenalan.');
                        swal({
                          title: 'Amaran',
                          text: 'Maaf! No K/P atau nama tidak tepat. Sila masukkan No K/P dan nama seperti yang tertera di Kad Pengenalan.',
                          type: 'error',
                          confirmButtonClass: "btn-warning",
                          confirmButtonText: "Ok",
                          showConfirmButton: true,
                        //}).then(function () {
                        	//reload = window.location; 
                        	//window.location = reload;
                    	});

                    }

		}	
                //data: datas
            });
        } else {
            swal({
              title: 'Amaran',
              text: 'Kod keselamatan tidak sama.',
              type: 'error',
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Ok",
              showConfirmButton: true,
            }).then(function () {
                document.myspp.keselamatan.value='';
                $('#keselamatan').focus(); return false;
            });
        }
    }
}

function do_register(URL){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var emel = $('#emel').val();
    var ICNo = $('#ICNo').val();
    var nama = $('#nama').val();
    var notel = $('#notel').val();
    var pass1 = $('#pass1').val();
    var pass2 = $('#pass2').val();
    var keselamatan = $('#keselamatan_daftar').val();
    var NONO = $('#NONO').val();
    var msg = '';

    var uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
     var lowercase = "abcdefghijklmnopqrstuvwxyz";
     var digits = "0123456789";
     var splChars ="!@#$%&*()";
     //var ucaseFlag = contains(password1, uppercase);
     //var lcaseFlag = contains(password1, lowercase);
     //var digitsFlag = contains(password1, digits);
     //var splCharsFlag = contains(password1, splChars);

    //alert("dd");
    if(emel.trim() == '' ){
        msg = msg+'- Sila masukkan alamat e-mel anda.';
        $("#emel").css("border-color","#f00");
    } 
    if(ICNo.trim() == '' ){
        msg = msg+'\n- Sila masukkan maklumat No. Kad Pengenalan anda.';
        $("#ICNo").css("border-color","#f00");
    }
    if(nama.trim() == '' ){
        msg = msg+'\n- Sila masukkan maklumat nama anda.';
        $("#nama").css("border-color","#f00");
    }
    if(notel.trim() == '' ){
        msg = msg+'\n- Sila masukkan maklumat no. telefon bimbit anda.';
        $("#notel").css("border-color","#f00");
    } 
    if(pass1.trim() == '' ){
        msg = msg+'\n- Sila masukkan maklumat kata laluan.';
        $("#pass1").css("border-color","#f00");
    }
    if(pass2.trim() == '' ){
        msg = msg+'\n- Sila masukkan maklumat ulang kata laluan.';
        $("#pass2").css("border-color","#f00");
    }
    if(pass1!=pass2){
        msg = msg+'\n- Maklumat kata laluan tidak sama. Sila masukkan semula.';
        document.myspp.pass1.value='';
        document.myspp.pass2.value='';
        $("#pass1").css("border-color","#f00");
    }
    if(keselamatan.trim() == '' ){
        msg = msg+'\n- Sila masukkan maklumat kod keselamatan.';
        $("#keselamatan").css("border-color","#f00");
    } else {
        if(keselamatan!=NONO){
            msg = msg+'\n- Kod keselamatan yang dimasukkan tidak sepadan.';
            $("#keselamatan").css("border-color","#f00");
        }
    }

    if(msg.trim() !=''){ 
        alert_msg_html(msg);
    } else { 
        
        $.ajax({
            url:URL,
            type:'POST',
            //dataType: 'json',
            beforeSend: function () {
                $('.btn-primary').attr("disabled","disabled");
                $('.modal-body').css('opacity', '.5');
            },
            data: $("form").serialize(),
            //data: datas,
            success: function(data){
                console.log(data);
                // alert(data);
                if(data=='OK'){
                    swal({
                      title: 'Berjaya',
                      text: 'Maklumat telah berjaya didaftarkan. Sila semak e-mel anda untuk pengesahan pendaftaran',
                      type: 'success',
                      confirmButtonClass: "btn-success",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    }).then(function () {
                        // reload = window.location; 
                        // window.location = reload;
                        window.href = "index.php";
                    });
                // } else if(data=='ADA'){
                //     swal({
                //       title: 'Amaran',
                //       text: 'Alamat e-mel yang dimasukkan telah didaftarkan di dalam sistem MySPP.',
                //       type: 'error',
                //       confirmButtonClass: "btn-warning",
                //       confirmButtonText: "Ok",
                //       showConfirmButton: true,
                //     });
                } else if(data=='ERR'){
                    swal({
                      title: 'Amaran',
                      text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya didaftarkan.',
                      type: 'error',
                      confirmButtonClass: "btn-warning",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    });
                }
            }
            //data: datas
        });
    }
}

function do_lupa(URL){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var emel = $('#emel').val();
    var ICNo = $('#ICNo').val();
    var keselamatan = $('#keselamatan_lupa').val();
    var NONO2 = $('#NONO2').val();
    var msg = '';
    //alert("dd");
    if(emel.trim() == '' ){
        msg = msg+'- Sila masukkan alamat e-mel anda.';
        $("#emel").css("border-color","#f00");
    } 
    if(ICNo.trim() == '' ){
        msg = msg+'\n- Sila masukkan maklumat No. Kad Pengenalan anda.';
        $("#ICNo").css("border-color","#f00");
    }
    if(keselamatan.trim() == '' ){
        msg = msg+'\n- Sila masukkan maklumat kod keselamatan.';
        $("#keselamatan").css("border-color","#f00");
    } else {
        if(keselamatan!=NONO2){
            msg = msg+'\n- Kod keselamatan yang dimasukkan tidak sepadan.';
            $("#keselamatan_lupa").css("border-color","#f00");
        }
    }

    if(msg.trim() !=''){ 
        alert_msg_html(msg);
    } else { 
        $.ajax({
            url:URL,
            type:'POST',
            //dataType: 'json',
            beforeSend: function () {
                $('.btn-primary').attr("disabled","disabled");
                $('.modal-body').css('opacity', '.5');
            },
            data: $("form").serialize(),
            //data: datas,
            success: function(data){
                //console.log(data);
                //alert(data);
                if(data=='OK'){
                    swal({
                      title: 'Berjaya',
                      text: 'Permohonan lupa kata laluan berjaya. Sila semak e-mel anda untuk kemaskini kata laluan',
                      type: 'success',
                      confirmButtonClass: "btn-success",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    }).then(function () {
                        reload = window.location; 
                        window.location = reload;
                        // window.href = "index.php";
                    });
                 } else if(data=='EMEL'){
			swal({
				title: 'Makluman',
				text: 'Alamat emel yang anda masukkan tidak sama dengan alamat emel yang didaftarkan.',
				type: 'info',
				confirmButtonClass: "btn-info",
				confirmButtonText: "Ok",
				showConfirmButton: true,
			});
		} else if(data=='ERR'){
                    swal({
                      title: 'Amaran',
                      text: 'Terdapat ralat sistem.\nMaklumat lupa kata laluan tidak berjaya diproses.',
                      type: 'error',
                      confirmButtonClass: "btn-warning",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    });
                }
            }
            //data: datas
        });
    }
}

function do_page(url){
	document.myspp.action=url;
	document.myspp.target='_self';
	document.myspp.submit();
}

function do_cetak(url){
	document.myspp.action=url;
	document.myspp.target='_blank';
	document.myspp.submit();
}

function do_log(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var userid = $('#userid').val();
    var katalaluan = $('#katalaluan').val();
    if(userid.trim() == '' ){
        alert('Sila masukkan ID Pengguna anda.');
        $('#userid').focus(); //return false;
    } else if(katalaluan.trim() == '' ){
        alert('Sila masukkan kata laluan anda.');
        $('#katalaluan').focus(); return false;
    } else {
        $.ajax({
            //url:'_mapps/biodata/log_masuk_sql.php?pro=CHK&userid='+userid+'&katalaluan='+katalaluan, //&datas='+datas,
            url:'_mapps/biodata/log_masuk_sql.php?pro=CHK', //&datas='+datas,
            type:'POST',
            //dataType: 'json',
            beforeSend: function () {
            //$('.btn-primary').attr("disabled","disabled");
                $('.dispmodal').css('opacity', '.5');
            },
            data: $("form").serialize(),
            //data: datas,
            success: function(data){
                // console.log(data);
                // alert(data);
                if(data == 'OK'){
                // $("#myModal").modal();
                    // swal({
                    //     title: 'Berjaya',
                    //     text: 'Berjaya log masuk.',
                    //     type: 'success',
                    //     confirmButtonClass: "btn-success",
                    //     confirmButtonText: "Ok",
                    //     showConfirmButton: true,
                    // }).then(function () {
                    // reload = window.location; 
                    // window.location = reload;
                        // window.location.href = "_mapps/index.php";
                    // });

                    swal({
                      title: 'Berjaya',
                      text: 'Berjaya log masuk.',
                      type: 'success',
                      confirmButtonClass: "btn-success",
                      confirmButtonText: "Ok",
                      showConfirmButton: false,
                      timer: 2000
                    }).then(
                      function () {},
                      // handling the promise rejection
                      function (dismiss) {
                        if (dismiss === 'timer') {
                          // console.log('I was closed by the timer');
                          window.location.href = "_mapps/index.php";
                        }
                      }
                    )


                } else if(data=='XADA' || data=='ERR'){
                    swal({
                        title: 'Amaran',
                        text: 'ID Pengguna atau Katalaluan anda salah. Sila cuba lagi.',
                        type: 'error',
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Ok",
                        showConfirmButton: true,
                    });
                } else if(data=='XSTAT'){
                    swal({
                        title: 'Amaran',
                        text: 'Maklumat anda tiada dalam pendaftaran sistem.\nAdakah anda pengguna yang sah.',
                        type: 'error',
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Ok",
                        showConfirmButton: true,
                    });
                }
            }
        });
    }
}

function do_semakan(URL){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var emel = $('#emel').val();
    var ICNo = $('#ICNo').val();
    var keselamatan = $('#keselamatan').val();
    var NONO = $('#NONO').val();
    var msg = '';
    //alert("dd");
    if(emel.trim() == '' ){
        msg = msg+'- Sila masukkan alamat e-mel anda.';
        $("#emel").css("border-color","#f00");
    } 
    if(ICNo.trim() == '' ){
        msg = msg+'\n- Sila masukkan maklumat No. Kad Pengenalan anda.';
        $("#ICNo").css("border-color","#f00");
    }
    if(keselamatan.trim() == '' ){
        msg = msg+'\n- Sila masukkan maklumat kod keselamatan.';
        $("#keselamatan").css("border-color","#f00");
    } else {
        if(keselamatan!=NONO){
            msg = msg+'\n- Kod keselamatan yang dimasukkan tidak sepadan.';
            $("#keselamatan_lupa").css("border-color","#f00");
        }
    }

    if(msg.trim() !=''){ 
        alert_msg_html(msg);
    } else { 
        do_page(URL);
    }
}

