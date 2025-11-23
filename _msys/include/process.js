function do_submit(strFileName,target){
	//alert(strFileName);
	document.form2.target=target;
	document.form2.action = strFileName;
	document.form2.submit();      
}

function do_simpan(strFileName,target){
	//alert(strFileName);
	document.frm.target=target;
	document.frm.action = strFileName;
	document.frm.submit();      
}
