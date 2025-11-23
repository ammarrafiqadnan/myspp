<link rel="stylesheet" href="../script/myscript.css" type="text/css">
<Script Language="JavaScript" src="../script/checkAll.js"></Script>
<Script Language="JavaScript">
	function f_Add(strFileName){
		document.frm.action = strFileName;
		document.frm.target = "_self";
		document.frm.submit();
		
	}

    function do_Submit(strFileName){
    	document.frm.target="_self";
        document.frm.action = strFileName;
        document.frm.submit();      
    }
		
	function do_delete(ids){
		if (confirm("Pasti Ingin Hapuskan Data?")) {
			f_Delete(ids);
			//document.frm.submit();
		} else {
			close();
		}																																																												
	}

	function f_Delete(strFileName){
		e = document.frm;
		count = 0;
		for(c=0;c<e.elements.length;c++){
			if(e.elements[c].checked){
				count++;
			}
		}
		//alert(count)
		if (count==0){
			alert("Sila pilih rekod untuk dihapuskan.")
		}else{
			//alert(strFileName);
			document.frm.action = strFileName;
			//document.frm.target = "_blank";
			document.frm.submit();
		}
	}

	function do_select(ids){
		if (confirm("Pasti ingin memasukan data yang telah dipilih ini?")) {
			f_select(ids);
			//document.frm.submit();
		} else {
			close();
		}																																																												
	}

	function f_select(strFileName){
		e = document.frm;
		count = 0;
		for(c=0;c<e.elements.length;c++){
			if(e.elements[c].checked){
				count++;
			}
		}
		//alert(count)
		if (count==0){
			alert("Sila pilih rekod.")
		}else{
			//alert(strFileName);
			document.frm.action = strFileName;
			//document.frm.target = "_blank";
			document.frm.submit();
		}
	}

	function do_cetak(ids){
			if (confirm("Pasti Ingin Membuat cetakan?")) {
				f_cetak(ids);
				//document.frm.submit();
			} else {
				close();
			}																																																												
	}
	
	function f_cetak(strFileName){
		e = document.frm;
		count = 0;
		for(c=0;c<e.elements.length;c++){
			if(e.elements[c].checked){
				count++;
			}
		}
		//alert(count)
		if (count==0){
			alert("Sila pilih rekod untuk dicetak.")
		}else{
			alert(strFileName);
			document.frm.action = strFileName;
			document.frm.target = "_blank";
			document.frm.submit();
		}
	}

</Script>
<Script Language="JavaScript">
	function f_page(strFileName){
		document.frm.action = strFileName;
		document.frm.target = "_self";
		document.frm.submit();
	}
</script>
