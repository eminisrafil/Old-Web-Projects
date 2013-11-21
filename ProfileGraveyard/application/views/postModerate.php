<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
					<div class="post">

						<div class="postTop">
							<ul>
								<li>Profile: <span class="postblue"><?php echo $o->name ?></span></li>
								<li>Location: <span class="postblue"><?php echo ucwords($o->location) ?> (<?php echo ucwords($o->region)?>)</span></li>
								<li>RIP: <span class="postblue"><?php echo $o->dob_y . " - " . $o->dod_y?></span></li>
								<li>Hours/Week: <span class="postblue"><?php echo ($o->hourswasted)/(($o->dod_y - $o->dob_y + 1)*52)?></span></li>
							</ul>
						</div>

						<div class="postMid">
							<span class="left" style="width: 90px;">Obituary:</span>
							<span class="left postBody"><?php echo $o->cause_death?></span>
						</div>
					</div>