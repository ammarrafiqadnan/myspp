	function Check(){
		var strNo;
		var intNo=0;
		
	     if(document.myFORM.elements['chbCheck[]'].length > 1){
			for(i=0;i<document.myFORM.elements['chbCheck[]'].length;i++){
				if(document.myFORM.elements['chbCheck[]'](i).checked == true){
					intNo = intNo + 1;
				}
			}
			if(document.myFORM.elements['chbCheck[]'].length == intNo){
				document.myFORM.chbCheckAll.checked = true;  
			}else{
				document.myFORM.chbCheckAll.checked = false;
			}
		}else{
			if(document.myFORM.elements['chbCheck[]'].checked == true){
				document.myFORM.chbCheckAll.checked = true;  
			}else{
				document.myFORM.chbCheckAll.checked = false;
			}
		}
	}


	function CheckAll(){
		//If there is no record
		intCount = document.myFORM.hdnCounter.value - 0;
		if(intCount == 0){
			alert('Tiada rekod untuk dihapuskan.');
			document.myFORM.chbCheckAll.checked = false;
			return false;
		}
		
		if (document.myFORM.chbCheckAll.checked == true){
			if(document.myFORM.elements['chbCheck[]'].length > 1){
				for(i=0;i<document.myFORM.elements['chbCheck[]'].length;i++){
					document.myFORM.elements['chbCheck[]'](i).checked = true;
				} 
			}else{
				document.myFORM.elements['chbCheck[]'].checked = true;
			}
		}else{
			if(document.myFORM.elements['chbCheck[]'].length > 1){
				for(i=0;i<document.myFORM.elements['chbCheck[]'].length;i++){
					document.myFORM.elements['chbCheck[]'](i).checked = false;
				} 
			}else{
				document.myFORM.elements['chbCheck[]'].checked = false;
			}
		}  
	}

