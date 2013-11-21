<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
					<div class="post">
						<div class="postTop">
							<p><?php echo $o->cause_death?></p>
						</div>
						<div class="postMid">
							<ul>
								<li>Profile: <span class="postblue"><?php echo $o->name ?></span></li>
								<li>Location: <span class="postblue"><?php echo ucwords($o->location) ?> (<?php echo ucwords($o->region)?>)</span></li>
								<li>RIP: <span class="postblue"><?php echo $o->dob_y . " - " . $o->dod_y?></span></li>
								<li>Hours/Week: <span class="postblue"><?php echo ($o->hourswasted)/(($o->dod_y - $o->dob_y + 1)*52)?></span></li>
							</ul>
						</div>
					</div> 
						<div class="postBottom">
							<table>
								<tr>
									<td width="350px">
										<div>
											<span id="<?php echo $o->oid; ?>">
												<a href="javascript:void(0);" onClick="vote('1', '<?php echo $o->oid; ?>')">Mourn the Dead (<?php echo $o->positive;?>)</a> | 
												<a href="javascript:void(0);" onClick="vote('2', '<?php echo $o->oid; ?>')">You Dug Your Own Grave (<?php echo $o->negative;?>)</a>
											</span>
<?php
											echo ' | ' . anchor('post/view/' . $o->oid, 'Comment', 'title="Add comment"');
?>
										</div>
<?php 
											if (empty($o->nickname) || ($o->nickname == '0'))
											{	
												$nickname = "Anonymous";
											} else {
												$nickname = $o->nickname;
											}
?>
										<div class="postby">
											Posted by: <?echo $nickname?> at <?echo date("g:i a F j, Y", $o->time)?>
										</div> 
									</td>
									<td>		
										<a class="share_button" target="_blank" href="http://www.facebook.com/sharer.php?u=http://www.profilegraveyard.com/post/view/<?php echo $o->oid;?>">Share</a></td>
									<td>
<?php
											if ($this->ion_auth->is_admin())
											{
												echo anchor('PGadmin/moderate/' . $o->oid, 'Moderate');
											}else{
?>
										<div id="fb-root"></div>
										<div class="fb-like" data-href="<?php echo site_url('post/view/' . $o->oid)?>" data-send="false" data-layout="button_count" data-width="75px" data-show-faces="false"></div>
<?php
											}
?>
									</td>
									
								</tr>
							</table>
						</div>