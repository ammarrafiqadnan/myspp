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
