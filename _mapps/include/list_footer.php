<div class="box-footer clearfix" align="center">
  <ul class="pagination pagination-sm no-margin pull-center">
        <?php
			//Print First & Previous Link is necessary
			if($CounterStart != 1){
				$PrevStart = $CounterStart - 1;
				print "<li><a onclick=do_pages('$href_f&PageNo=1') style='cursor:pointer'>Pertama </a>: </li>";
				print "<li><a onclick=do_pages('$href_f&PageNo=$PrevStart') style='cursor:pointer'>Sebelum Ini </a></li>";
			}
			//print " [ ";
			$c = 0;
			
			//Print Page No
			for($c=$CounterStart;$c<=$CounterEnd;$c++){
				if($c < $MaxPage){
					if($c == $PageNo){
						if($c % $PageSize == 0){
							print "<li><a><b><font color=#FF0000>$c</font></b></a></li>";
						}else{
							print "<li><a><b><font color=#FF0000>$c</font></b></a></li>";
						}
					}elseif($c % $PageSize == 0){
						?><li><a onclick="do_pages('<?php print $href_f?>&PageNo=<?php print $c?>')" style="cursor:pointer"><?php print $c?></a></li><?php
					}else{
						?><li><a onclick="do_pages('<?php print $href_f?>&PageNo=<?php print $c?>')" style="cursor:pointer"><?php print $c?></a></li><?php
					}//END IF
				}else{
					if($PageNo == $MaxPage){
						print "<li><a><b><font color=#FF0000>$c</font></b></a></li>";
						break;
					}else{
						?><li><a  onclick="do_pages('<?php print $href_f?>&PageNo=<?php print $c?>')" style="cursor:pointer"><?php print $c?></a></li><?php
						break;
					}//END IF
				}//END IF
			}//FOR
			
			//print " ] ";
			
			if($CounterEnd < $MaxPage){
				$NextPage = $CounterEnd + 1;
				print "<li><a onclick=do_pages('$href_f&PageNo=$NextPage') style='cursor:pointer'>Seterusnya</a>";
			}
			
			//Print Last link if necessary
			if($CounterEnd < $MaxPage){
				$LastRec = $RecordCount % $PageSize;
					if($LastRec == 0){
					$LastStartRecord = $RecordCount - $PageSize;
				} else{
					$LastStartRecord = $RecordCount - $LastRec;
				}
				//print " : ";
				print "<li><a onclick=do_pages('$href_f&PageNo=$MaxPage') style='cursor:pointer'>Terakhir</a></li>";
			}
		?>
              </ul>
            </div>