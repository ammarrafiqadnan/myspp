<?
	/********************************************** 
	 *** Function to display date as DD/MM/YYYY ***
	 **********************************************/
	function DisplayDate($dtmDate){
		$year = substr($dtmDate, 0, 4); // returns YYYY
		$month = substr($dtmDate, 5, 2); // returns MM
		$day = substr($dtmDate, 8, 2); // returns DD
		if($day == '00' || $day == ''){
			$dtmDate = '';
		}else{			
			$dtmDate = $day."/".$month."/".$year;
		}
		return $dtmDate;
	}
	
	/********************************************************* 
	 *** Function to convert date to database (YYYY-MM-DD) ***
	 *********************************************************/
	function DBDate($dtmDate){
		if($dtmDate == ''){
			$dtmDate = '';
		}else{
			$year = substr($dtmDate, 6, 4); // returns YYYY
			$month = substr($dtmDate, 3, 2); // returns MM
			$day = substr($dtmDate, 0, 2); // returns DD
			$dtmDate = $year."-".$month."-".$day;
		}
		return $dtmDate;
	}

	function DisplayTime($dtmTime){
		$dtmDate = substr($dtmTime, 0, 8); // returns YYYY
		if($dtmDate == '00:00:00'){
			$dtmDate = '';
		}else{			
			$dtmDate = $dtmDate;
		}
		return $dtmDate;
	}
	
	
	function DisplayMasa($dtmTime){
		$dtmDate = substr($dtmTime, 11, 17); // returns YYYY
		if($dtmDate == '00:00:00'){
			$dtmDate = '';
		}else{			
			$dtmDate = $dtmDate;
		}
		return $dtmDate;
	}
	
// Displaye TIME
   // contoh 12:02:12
	function Displayhh($dtmTime){
		$hh = substr($dtmTime, 0, 2); // returns YYYY
		if($hh == '00' || $hh == ''){
			$dtmTime = '';
		}else{			
			$dtmTime = $hh;
		}
		return $dtmTime;
	}	


	function Displaymm($dtmTime){
		$mm = substr($dtmTime, 3, 2); // returns YYYY
		if($mm == '00' || $mm == ''){
			$dtmTime = '';
		}else{			
			$dtmTime = $mm;
		}
		return $dtmTime;
	}
	
		
	function Displayss($dtmTime){
		$ss = substr($dtmTime, 6, 2); // returns YYYY
		if($ss == '00' || $ss == ''){
			$dtmTime = '';
		}else{			
			$dtmTime = $ss;
		}
		return $dtmTime;
	}	

	/********************************************** 
	 *** Function to display mm ***
	 **********************************************/
	function Displaymonth($dtmDate){
	//	$year = substr($dtmDate, 0, 4); // returns YYYY
		$month = substr($dtmDate, 3, 2); // returns MM
		//$day = substr($dtmDate, 8, 2); // returns DD
			$dtmDate = $month;
		return $dtmDate;
	}

	/********************************************** 
	 *** Function to display year ***
	       ex1 = 12/11/2006
		   ex2 = 02/04/2005
	 **********************************************/
	function Displayyear($dtmDate){
		$year = substr($dtmDate, 6, 4); // returns YYYY
	//	$month = substr($dtmDate, 5, 2); // returns MM
		//$day = substr($dtmDate, 8, 2); // returns DD
			$dtmDate = $year;
		return $dtmDate;
	}

function  titleCase($string)  { 
        $len=strlen($string); 
        $i=0; 
        $last= ""; 
        $new= ""; 
        $string=strtoupper($string); 
        while  ($i<$len): 
                $char=substr($string,$i,1); 
                if  (ereg( "[A-Z]",$last)): 
                        $new.=strtolower($char); 
                else: 
                        $new.=strtoupper($char); 
                endif; 
                $last=$char; 
                $i++; 
        endwhile; 
        return($new); 
}; 
?> 

