
<?php if( !isset($gid)): ?>
 <div class="col-xs-6 col-sm-3 " id="sidebar" role="navigation">
<?php endif; ?>
 
	<div class="sidebar-nav" style="border-right:1px dotted #ccc">
	 
	<ul class="well nav">
		<li>My Inbox <span class="label label-default pull-right" style="font-size:12px;">Total</span> <span class="label label-primary pull-right" style="font-size:12px;">Unread</span></li>
		<?php  
			
			$inbox = $this->inboxes; 
			foreach(  $this->my_inbox as $row ){
				$innerli = '';
				$total_inbox = 0;	
					$cat = $this->categories[$row]; 
					foreach( $cat as $key=>$val ){
						$unread = @($this->categories_count[$row][$key]['unread']);
						$total = @($this->categories_count[$row][$key]['total']);
						$badge = ($total > 0)?'<span class="label label-default pull-right" style="font-size:12px;">'.$total.'</span> <span class="label label-primary pull-right" style="font-size:12px;">'.$unread.'</span>':''; 
						//$innerli .= '<li class="list-group-item" data-maillink="'.$row.','.$key.','.$val.'"> <a href="inbox/category/'.$key.'"> '.$val.' </a> '.$badge.'</li> ';
						//$innerli .= '<li class="list-group-item" onclick="app.getMailContent('.$row.', '.$key.', \''.$val.'\')"> <a href="javascript:app.getMailContent('.$row.', '.$key.', \''.$val.'\')"> '.$val.' </a> '.$badge.'</li> ';
						$innerli .= '<li class="list-group-item" onclick="app.getMailContent('.$row.', '.$key.', \''.$val.'\')"> <a href="javascript:void(0)" style="z-index: -100"> '.$val.' </a> '.$badge.'</li> ';
						
						$total_inbox += $unread;
					}
 					
					echo '<li><a href="#collapse'.$row.'" data-toggle="collapse" data-parent="#accordion" >'.$inbox[$row].' <span class="badge" style="background-color: #5BC0DE;">'.$total_inbox.'</span></a>';
				
					if( isset($gid) ){
						$collapse = ($gid==$row)?'in':'collapse';
					}else $collapse = 'collapse in';
					
					echo '<div id="collapse'.$row.'" class="'.$collapse.' " style="font-size: 11px; margin-left: 5px">							 
							<ul class="list-group ">';
					echo 	$innerli;	 
					echo	'</ul>							 
						</div>
				 </li>';
			}
		
		?> 
 
		<li>Sidebar</li>
		<li><a href="#">Archive</a></li>		
	</ul> 
	 
	</div><!--/.well -->
<?php if( !isset($gid)): ?>	
</div><!--/span-->
<?php endif; ?>