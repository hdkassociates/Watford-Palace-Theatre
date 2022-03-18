<?php
				$filtercontent = filter_input(INPUT_GET,"content",FILTER_SANITIZE_STRING);
				$subnav = '';
				$subsections = '';

//
// This setup is pure PHP, and reloads the page for every sub link.
// We could potentially not remove the actual content of the hidden subs, and add javascript for hide/unhide.
// That would require to add an ID on each subnav link to target the correct content box for each nav link
//
// Note: the page reload is very visible in Firefox, while in Chrome it looks as if there is no page reload at all.
//

				$subsectionsraw = get_field('content_sub_sections');
				if($subsectionsraw){
					$ssi = 0;
					foreach($subsectionsraw as $ss){
						$ssi++;
						$sstitle = $ssname = $sscontent = '';
						$sstitle = $ss['content_sub_section_title'];
						if($sstitle != ''){
							$ssname = strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '', $sstitle)));
						}
						$sscontentblocks = $ss['content_blocks'];
						if($sscontentblocks){
							foreach($sscontentblocks as $cb){
								$layout = $cb['acf_fc_layout'];
								if($layout == 'regular_text'){
									$sscontent .= $cb['text'];
								}elseif($layout == 'larger_text'){
									$sscontent .= '<div class="larger">'.$cb['text'].'</div>';
								}elseif($layout == 'sub_heading'){
									$heading = $cb['sub_heading'];
									if($heading){
										$sscontent .= '<'.$cb['heading_level'].'>'.$heading.'</'.$cb['heading_level'].'>';
									}
								}elseif($layout == 'video'){
									$video = '';
									$vidtype = $cb['type_of_video'];
									if($vidtype == 'youtube'){
										$vidcode = $cb['youtube_video_code'];
										if($vidcode){
											$video = '<iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/'.$vidcode.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
										}
									}elseif($vidtype == 'vimeo'){
										$vidcode = $cb['vimeo_video_code'];
										if($vidcode){
											$video = '<iframe src="https://player.vimeo.com/video/'.$vidcode.'?color=ffffff" width="640" height="480" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
										}
									}
									if($video){
										$sscontent .= '<div class="videowrap"><div class="videobox">';
										$sscontent .= $video;
										$sscontent .= '</div></div>';
									}

								}elseif($layout == 'embed'){
									$embedcode = $cb['embed_code'];
									if($embedcode){
										$sscontent .= '<div class="embed3rdparty">';
										$sscontent .= $embedcode;
										$sscontent .= '</div>';
									}

								}elseif($layout == 'downloads'){
									$downloads = $cb['downloads'];
									if($downloads){
										$dli=0;
										$dls = '';
										foreach($downloads as $dl){
											$fileurl = $dl['downloadable_file']['url'];
											if($fileurl){
												$dli++;
												$filetitle = $dl['download_title'];
												if(!$filetitle){
													$filetitle = $dl['file']['title'];
												}
												$dls .= '<li><span class="dltitle">'.$filetitle.'</span><a href="'.$fileurl.'" download>Download</a></li>';
											}
										}
										if($dli == 1){
											$sscontent .= '<ul class="downloads dlone">'.$dls.'</ul>';
										}elseif($dli > 1){
											$sscontent .= '<ul class="downloads dllist">'.$dls.'</ul>';
										}
									}
								}elseif($layout == 'dropdowns'){
									$dropdowns = $cb['dropdowns'];
									if($dropdowns){
										$dds = '';
										foreach($dropdowns as $dd){
											$ddtitle = $dd['dropdown_title'];
											$ddcontent = $dd['dropdown_content'];
											if($ddtitle OR $ddcontent){
												$dds .= '<div class="dd">';
												$dds .= '<h4 class="ddt">'.$ddtitle.'</h4>';
												$dds .= '<div class="ddin">'.$ddcontent.'</div>';
												$dds .= '</div>';
											}
										}
										if($dds != ''){
											$sscontent .= '<div class="dropdowns">'.$dds.'</div>';
										}
									}
								}elseif($layout == 'buttons'){
									$buttons = $cb['buttons'];
									if($buttons){
										$sscontent .= '<p class="button">';
										foreach($buttons as $button){
											$bw = $button['button_width'];
											$bs = $button['button_style'];
											$bt = $button['button_link_type'];
											if($bt == 'int'){
												$blink = get_the_permalink($button['button_link_to_page']->ID);
											}elseif($bt == 'ext'){
												$blink = $button['button_link_url'].'" target="_blank';
											}elseif($bt == 'mailto'){
												$blink = 'mailto:'.$button['button_link_mailto'].'" target="_blank';
											}elseif($bt == 'dl'){
												$blink = $button['button_link_to_file'].'" download="download';
											}
											$btext = $button['button_text'];
											if($btext){
												$sscontent .= '<a class="buttonwidth'.$bw.' button'.$bs.'" href="'.$blink.'">'.$btext.'</a>';
											}
										}
										$sscontent .= '</p>';
									}
								}elseif($layout == 'space'){
									$space = $cb['space'];
									if($space == 'space'){
										$sscontent .= '<div class="spacer"> </div>';
									}elseif($space == 'sep'){
										$sscontent .= '<div class="separator"> </div>';
									}

								}elseif($layout == 'spektrix_members_link'){
									$members_id = $cb['membership_type'];
									$sscontent .= '<spektrix-memberships custom-domain="tickets.watfordpalacetheatre.co.uk" client-name="watfordpalace" membership-id="'.$members_id.'">
									<button data-submit-membership class="buttonstyle1">Buy Now</button>
										<label for="autorenew">
   										<input type="checkbox" name="autorenew" data-set-autorenew>Autorenew?
										</label>
									<div class="success" data-success-container style="display: none;">Membership added to <a href="/basket">basket</a></div>
									<div class="fail"  data-fail-container style="display: none;">Something went wrong. Please try again</div>
									</spektrix-memberships>';

								}elseif($layout == 'spektrix_donate_button'){
									$show_donate = $cb['display_donate_button'];
									$minimum = $cb['minimum_amount'];
									$maximum = $cb['maximum_amount'];
									$step = $cb['increments'];
									if($show_donate){
										$sscontent .='<spektrix-donate custom-domain="tickets.watfordpalacetheatre.co.uk" client-name="watfordpalace" fund-id="201AGBHDRLQHNHPHKKMPKLGPMDRDTDMVL">
										<div>
											   <div id="donate-area">
												   <div id="amount">£
													   <span id="amountlabel" class="amountlabel" data-display-donation-amount>0</span>
												   </div>
											   </div>
											   <div id="slider-box">
												   <input id="slider" id="slider" type="range" min="'.$minimum.'" max="'.$maximum.'" step="'.$step.'" value="0" data-custom-donation-input>
												   <button class="buttonstyle1" data-submit-donation>DONATE</button>
											   </div>
											   <div id="donate-button">
											   </div>
										   </div>
										   <div class="success" data-success-container style="display: none;">Thank you! Donation added to <a href="/basket">basket</a></div>
										   <div class="fail" data-fail-container style="display: none;">Something went wrong. Please try again</div>
										   <script>
											   var amountLabel = document.getElementById("amountlabel");
											   var slider = document.getElementById("slider");
											   slider.addEventListener("input", function () {
												   amountLabel.innerHTML=slider.value;
											   })
										   </script>
									   </spektrix-donate>';
									}

								}else{
									$sscontent .= $cb;
								}
							}
						}

						if($post->post_type == 'post'){
							// we do not hide subsections on News posts, as they do not have more than one
							$class = 'current';
						}else{
							if($filtercontent == '' AND $ssi == 1){
								$class = 'current';
							}elseif($filtercontent == $ssname){
								$class = 'current';
							}else{
								$class = 'hiddensub';
							}
							if($sstitle){
								$subnav .= '<li class="'.$class.'"><a href="?content='.$ssname.'">'.$sstitle.'</a></li>';
							}
						}
						$subsections .= '<div class="subsection '.$class.'" id="subs'.$ssname.'">'.$sscontent.'</div>';
					}
				}


				if($subnav != ''){
					$subnav = '<ul class="contentsubnav">'.$subnav.'</ul>';
				}else{
					$subnav = '<div class="subnavspace"></div>';
				}

				if($subsections){
					echo $subnav;
					echo '<div class="subsections">';
					echo $subsections;
					echo '</div><!-- subsections -->';
				}

