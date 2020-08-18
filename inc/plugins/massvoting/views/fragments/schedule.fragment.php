<?php if (!defined('APP_VERSION')) die("Yo, what's up?"); ?>

<?php
    $Settings = Plugins\MassVoting\settings();
    $payment_id = $Settings->get("data.payment_id");
    if (!isset($payment_id)) {
        $Settings->set("data.license", "invalid")
                 ->save();
    }
    $license = $Settings->get("data.license");

    if ($license == "valid") {
        $is_license_valid = true;
    } else {
        $is_license_valid = false;
    }
?>


 
<div class="skeleton skeleton--full" id="story-viewer-pro-schedule">
    <div class="clearfix">
        <aside class="skeleton-aside hide-on-medium-and-down">
            <?php
                $form_action = APPURL."/e/".$idname."?aid=".$Account->get("id")."&ref=schedule";
                include PLUGINS_PATH . "/" . $idname ."/views/fragments/aside-search-form.fragment.php";
            ?>

            <div class="js-search-results">
                <div class="aside-list js-loadmore-content" data-loadmore-id="1"></div>
            </div>

            <div class="loadmore pt-20 none">
                <a class="fluid button button--light-outline js-loadmore-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?php echo APPURL."/e/".$idname."?aid=".$Account->get("id")."&ref=schedule"; ?>">
                    <span class="icon sli sli-refresh"></span>
                    <?php echo __("Load More"); ?>
                </a>
            </div>
        </aside>

        <section class="skeleton-content">
            <form class="js-hypervote-schedule-form"
                  action="<?php echo APPURL."/e/".$idname."/".$Account->get("id"); ?>"
                  method="POST">

                <input type="hidden" name="action" value="save">
               <?php 
                    $notice = $Settings->get("data.temporary_notice.$lang");
                    if (!$is_license_valid): 
                ?>
              
                    <span class="license-notice">
                        <span class="mdi mdi-alert-circle-outline"></span>    
                        <?= __("Please enter your license key in Module Settings.") ?>
                    </span>
                <?php elseif ($Settings->get("data.is_temporary_notice") && isset($lang) && !empty($notice)): ?>
                        <span class="temporary-notice">
                            <?= $notice ?>
                        </span> 
                <?php endif ?>
                
                <?php ($Settings->get("data.is_temporary_pause") && (!$admin)) ? $is_maintenance = true : $is_maintenance = false ?>

                <div class="section-header back-button-wh none">
                    <a href="<?php echo APPURL."/e/".$idname."/"; ?>">
            			<span class="mdi mdi-reply"></span><?php echo __("Back"); ?>
            		</a>
                </div>

                <div class="section-header clearfix">
                    <h2 class="section-title">
                        <?php echo "@" . htmlchars($Account->get("username")); ?>
                        <?php if ($Account->get("login_required")): ?>
                            <small class="color-danger ml-15">
                                <span class="mdi mdi-information"></span>
                                <?php echo __("Re-login required!"); ?>
                            </small>
                        <?php endif; ?>
                    </h2>
                </div>

                <div class="svp-tab-heads pb-15 clearfix">
                    <a href="<?php echo APPURL."/e/".$idname."/".$Account->get("id"); ?>" class="active"><?php echo __("Settings"); ?></a>
                    <a href="<?php echo APPURL."/e/".$idname."/".$Account->get("id")."/log"; ?>"><?php echo __("Activity Log"); ?></a>
                    <a href="<?php echo APPURL."/e/".$idname."/".$Account->get("id")."/stats"; ?>"><?php echo __("Stats"); ?></a>
                </div>

                <div class="section-content">
                    <div class="form-result mb-25" style="display: none;"></div>

                    <div class="clearfix">
                        <div class="col s12 m10 l8" >
                            <div class="mb-5 clearfix">
							
												
                                <label class="inline-block mr-30 mb-15 tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large"  title="<?= __("People's Post Liker Targetting option.")?>"	>
                                    <input class="radio" name='type' type="radio" value="people_getliker" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?> checked>
									
                                    <span>
									
                                        <span class="icon"></span>
									
                                        <?php echo __("People's Post Liker"); ?>
                                    </span>
                                </label>
								
                           
                                <label class="inline-block mr-30 mb-15 tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large"  title="<?= __("People's Followers Targetting option.")?>">
                                    <input class="radio" name='type' type="radio" value="people_follower" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                    <span>
                                        <span class="icon"></span>
                                        <?php echo __("People Follower"); ?>
                                    </span>
                                </label>
								 <label class="inline-block mr-30 mb-15 tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large"  title="<?= __("Hashtags Targetting option.")?>">
                                    <input class="radio" name='type' type="radio" value="hashtag" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                    <span>
                                        <span class="icon"></span>
                                        #<?= __("Hashtags") ?>
                                    </span>
                                </label>
								 <label class="inline-block mr-30 mb-15 tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large"  title="<?= __("People's Followings Targetting option.")?>">
                                    <input class="radio" name='type' type="radio"  value="people_following" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
									  <span>
                                        <span class="icon"></span>
                                        <?= __("People's Following") ?>
                                    </span>
                                </label>
								
 
                                <label class="inline-block mr-30 mb-15 tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large"  title="<?= __("Location Targetting option.")?>">
								
                                    <input class="radio" name='type' type="radio" value="location"  <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                    <span>
                                        <span class="icon"></span>
                                        <?= __("Places") ?>
										
									
                                </label>
								 <label class="inline-block mr-30 mb-15 tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large"  title="<?= __("Explore section Targetting option.")?>">
                                    <input class="radio" name='type' type="radio" value="explore"  <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                    <span>
                                        <span class="icon"></span>
                                        <?= __("Explore") ?>
                                    </span>
                                </label>
								<label class="inline-block mr-30 mb-15 tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("People's hashtag posts liker Targetting option.")?>">
                                    <input class="radio" name='type' type="radio" value="hashtag_liker"  <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                    <span>
                                        <span class="icon"></span>
                                        <?= __("Hashtag Likers") ?>
                                    </span>
                                </label>
								<label class="inline-block mr-30 mb-15 tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("People's location posts liker Targetting option.")?>">
                                    <input class="radio" name='type' type="radio" value="location_liker"  <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                    <span>
                                        <span class="icon"></span>
                                        <?= __("Location Likers") ?>
                                    </span>
                                </label>
								
                            </div>

                            <div class="clearfix mb-20 pos-r">
                                <div class="col s12 m4 l4 mt-10 mr-10 tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large"  title="<?= __("Bulk Target List Import")?>">
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#target-list-popup" class="fluid button button--light-outline target-list-button">
                                        <?php echo __("Targets list"); ?>
										
                                    </a>
                                </div>
                                <div class="col s12 m4 l4 mt-10 mr-10 tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large"  title="<?= __("Bulk Target List clean")?>">
                                    <a href="javascript:void(0)" class="fluid button button--light-outline target-list-button js-remove-all-targets">
                                        <?php echo __("Clear targets"); ?>
                                    </a>
                                </div>
                                <div class="col s12 m4 l4 mt-10 mr-10 tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large"  title="<?= __("Copy Target List")?>">
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#copy-targets-popup" class="fluid button button--light-outline target-list-button">
                                        <?php echo __("Copy targets"); ?>
                                    </a>
                                </div>
                            </div>

                            <div class="clearfix mb-20 pos-r">
                                <label class="form-label"><?php echo __('Search'); ?></label>
                                <input class="input rightpad js-input-search" name="search"  type="text" value=""
                                       data-url="<?php echo APPURL."/e/".$idname."/".$Account->get("id"); ?>" <?php echo $is_license_valid ? "" : "disabled"; ?>>
                                <span class="field-icon--right pe-none none js-search-loading-icon">
                                    <img src="<?php echo APPURL."/assets/img/round-loading.svg"; ?>" alt="Loading icon">
                                </span>
                            </div>

                            <div class="tags clearfix mt-20 mb-20">
                                <?php
                                    $targets = $Schedule->isAvailable()
                                             ? json_decode($Schedule->get("target"))
                                             : [];
                                    $icons = [
                                        "people_getliker" => "mdi mdi-instagram",
                                        "people_follower" => "mdi mdi-instagram",
										"people_following" => "mdi mdi-instagram",
                                        "hashtag" => "mdi mdi-pound",
										 "hashtag_liker" => "mdi mdi-pound",
                                        "location" => "mdi mdi-map-marker",
										 "location_liker" => "mdi mdi-map-marker",
										"explore" => "mdi mdi-compass"
                                    ];
                                ?>
                                <?php foreach ($targets as $t): ?>
                                    <span class="tag pull-left"
                                          data-type="<?php echo htmlchars($t->type); ?>"
                                          data-id="<?php echo htmlchars($t->id); ?>"
                                          data-value="<?php echo htmlchars($t->value); ?>"
                                          style="margin: 0px 2px 3px 0px;">

                                          <?php if (isset($icons[$t->type])): ?>
                                              <span class="<?php echo $icons[$t->type]; ?>"></span>
                                          <?php endif; ?>

                                          <?php echo htmlchars($t->value); ?>

                                          <?php if ($t->type == "people_follower"): ?>
                                            <?php echo __(" (follower)"); ?>
                                          <?php endif; ?>
										   <?php if ($t->type == "people_getliker"): ?>
                                            <?php echo __(" (liker)"); ?>
                                          <?php endif; ?>
										   <?php if ($t->type == "people_following"): ?>
                                            <?php echo __(" (following)"); ?>
                                          <?php endif; ?>
										  <?php if ($t->type == "hashtag"): ?>
                                            <?= __(" (hashtag)") ?>
                                          <?php endif ?> 
										   <?php if ($t->type == "hashtag_liker"): ?>
                                            <?= __(" (hashtagliker)") ?>
                                          <?php endif ?> 
										  <?php if ($t->type == "location"): ?> 
                                          <?php echo __(" (location)"); ?> 
                                          <?php endif; ?>
										   <?php if ($t->type == "location_liker"): ?> 
                                          <?php echo __(" (locationliker)"); ?> 
                                          <?php endif; ?>
										  <?php if ($t->type == "explore"): ?> 
                                          <?php echo __(" (explore)"); ?> 
                                          <?php endif; ?>



                                          <span class="mdi mdi-close remove"></span>
                                      </span>
                                          <?php endforeach; ?>
                            </div>
                              
                            <div class="clearfix mb-20">
                                <?php
                                    $targets_count = count($targets);
                                ?>
                                <?php if ($targets_count > 0): ?>
                                    <label><?php echo __("You added:") . " " . $targets_count . " " . __("target(s).") ?></label>
                                <?php endif; ?>
                            </div>
                           <div class="row mb-20">
                            <div class="col">
                              
                                                
                           
                                    <input class="renewtop button tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Save defined targets.")?>"  type="submit" value="<?php echo __("Save Targets"); ?>" <?php echo $is_license_valid ? "" : "disabled"; ?>>
                            
                            </div>
                            </div>
                            <div class="clearfix mb-20">
                                <div class="col s12 mb-20">
                                	<?php
                                        $payment_id = $Settings->get("data.payment_id");
                                        if (!isset($payment_id)) {
                                            $Settings->set("data.license", "invalid")
                                                     ->save();
                                        }

                                        $maximum_speed = $Settings->get("data.maximum_speed") ? $Settings->get("data.maximum_speed") : "maximum";
                                        $speed = $Schedule->get("speed") ? $Schedule->get("speed") : "400000";

                                        $package_modules = $User->get("settings.modules");
                                        $is_high_speed_enabled = in_array("Hypervote-high-speed", $package_modules) ? true : false;

                                        if ($is_high_speed_enabled && $maximum_speed == "maximum") {
                                            $max_index = 800000;
                                        } elseif ($maximum_speed == "maximum") {
                                            $max_index = 400000;
                                        } else {
                                            $max_index = $maximum_speed;
                                        }
        							?>
									<br>
									  <br />
									   <?php $package_modules = $User->get("settings.modules"); ?> 
                                    <label class="form-label"><?php echo __("Active Services"); ?></label>
                                    <div class="clearfix mb-20">
									<br>
									  <br />
									
                                    <?php if (!($Settings->get("data.mass_poll_votes"))): ?>
									
                                        <?php $q_ipa = $Schedule->get("is_poll_active"); ?>
                                        <label>
                                            <input type="checkbox"
                                                    class="checkbox"
													
                                                    name="is_poll_active"
                                                    value="1"
                                                    <?php echo $q_ipa ? "checked" : ""; ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?php echo __('Poll Votes'); ?>
												<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Stories Poll Vote Option.")?>">?</button>
										
                                                
                                            </span>
                                        </label>
										
                                    <?php else: ?>
									
                                    <input type="checkbox" style="display:none" value="0" name="is_poll_active" />
                                    <?php endif; ?>
									
									<br>
										<br>
                                        <?php if (!($Settings->get("data.question_answers"))): ?>
                                            <?php $q_iqa = $Schedule->get("is_question_active"); ?>
                                        <label>
                                            <input type="checkbox"
                                                    class="checkbox"
                                                    name="is_question_active"
                                                    value="1"
                                                    <?php echo $q_iqa ? "checked" : ""; ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?php echo __('Question Answers'); ?>
													<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Stories Question&Answer Vote Option.")?>">?</button>
                                            </span>
                                        </label>
                                    <?php else: ?>
									
                                    <input type="checkbox" style="display:none" value="0" name="is_count_active" />
                                    <?php endif; ?>
									<br>
										<br>
									
									 <?php if (!($Settings->get("data.countdown"))): ?>
                                            <?php $q_iqa = $Schedule->get("is_count_active"); ?>
                                        <label>
                                            <input type="checkbox"
                                                    class="checkbox"
                                                    name="is_count_active"
                                                    value="1"
                                                    <?php echo $q_iqa ? "checked" : ""; ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?php echo __('Story Countdown'); ?>
													<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Stories Countdown Follow Option.")?>">?</button>
                                            </span>
                                        </label>
                                    <?php else: ?>
                                    <input type="checkbox" style="display:none" value="0" name="is_count_active" />
                                    <?php endif; ?>
                                      <br>
									  <br />
                                    <?php if (!($Settings->get("data.mass_slide_points"))): ?>
                                        <?php $q_isp = $Schedule->get("is_slider_active"); ?>
                                        <label>
                                            <input type="checkbox"
                                                    class="checkbox"
                                                    name="is_slider_active"
                                                    value="1"
                                                    <?php echo $q_isp ? "checked" : ""; ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?php echo __('Slider Points'); ?>
												<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Stories Slide Poll Vote Option.")?>">?</button>
                                            </span>
                                        </label>
                                        <?php else: ?>
                                    <input type="checkbox" style="display:none" value="0" name="is_slider_active" />
                                    <?php endif; ?>
									<br>
										<br>

                                        <?php if (!($Settings->get("data.mass_quiz_answers"))):?>
                                            <?php $q_miqp = $Schedule->get("is_quiz_active"); ?>
                                        <label>
                                            <input type="checkbox"
                                                    class="checkbox"
                                                    name="is_quiz_active"
                                                    value="1"
                                                    <?php echo $q_miqp ? "checked" : ""; ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?php echo __('Quiz Answers'); ?>
												<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Stories Quiz Vote Option.")?>">?</button>
                                            </span>
                                        </label>
                                        <?php else: ?>
                                    <input type="checkbox" style="display:none" value="0" name="is_quiz_active" />
                                    <?php endif; ?>
									<br>
										<br>
										
                                          <label for="poll_speed" class="form-label"><?php echo __("Poll Vote Speed"); ?></label>
										
                                        <select class="input" id="poll_speed" name="poll_speed" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
										 <option value="100" <?php echo $Schedule->get('data.poll_speed') == "100" ? "selected" : ""; ?>><?php echo __("100 vote/Day"); ?></option>
										  <option value="200" <?php echo $Schedule->get('data.poll_speed') == "200" ? "selected" : ""; ?>><?php echo __("200 vote/Day"); ?></option>
										   <option value="300" <?php echo $Schedule->get('data.poll_speed') == "300" ? "selected" : ""; ?>><?php echo __("300 Stories/Day"); ?></option>
										  <option value="400" <?php echo $Schedule->get('data.poll_speed') == "400" ? "selected" : ""; ?>><?php echo __("400 vote/Day"); ?></option>
                                            <option value="500" <?php echo $Schedule->get('data.poll_speed') == "500" ? "selected" : ""; ?>><?php echo __("500 vote/Day"); ?></option>
											 <option value="750" <?php echo $Schedule->get('data.poll_speed') == "750" ? "selected" : ""; ?>><?php echo __("750 vote/Day"); ?></option>
                                            <option value="1000" <?php echo $Schedule->get('data.poll_speed') == "1000" ? "selected" : ""; ?>><?php echo __("1000 vote/Day"); ?></option>
                                            <option value="1500" <?php echo $Schedule->get('data.poll_speed') == "1500" ? "selected" : ""; ?>><?php echo __("1500 vote/Day"); ?></option>
											   <option value="2000" <?php echo $Schedule->get('data.poll_speed') == "2000" ? "selected" : ""; ?>><?php echo __("2000 vote/Day"); ?></option>
											    <option value="2500" <?php echo $Schedule->get('data.poll_speed') == "2500" ? "selected" : ""; ?>><?php echo __("2500 vote/Day"); ?></option>
												 <option value="3000" <?php echo $Schedule->get('data.poll_speed') == "3000" ? "selected" : ""; ?>><?php echo __("3000 vote/Day"); ?></option>
												  <option value="5000" <?php echo $Schedule->get('data.poll_speed') == "5000" ? "selected" : ""; ?>><?php echo __("5000 vote/Day"); ?></option>
												   <option value="10000" <?php echo $Schedule->get('data.poll_speed') == "10000" ? "selected" : ""; ?>><?php echo __("10000 vote/Day"); ?></option>
												    <option value="50000" <?php echo $Schedule->get('data.poll_speed') == "500000" ? "selected" : ""; ?>><?php echo __("50000 vote/Day"); ?></option>
													 <option value="100000" <?php echo $Schedule->get('data.poll_speed') == "100000" ? "selected" : ""; ?>><?php echo __("100000 vote/Day"); ?></option>
                                        </select>
										
                                        
										</br> 
                                       <label for="slide_poll_speed" class="form-label"><?php echo __("Slide Poll Vote Speed"); ?></label>
										
                                        <select class="input" id="slide_poll_speed" name="slide_poll_speed" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
										 <option value="100" <?php echo $Schedule->get('data.slide_poll_speed') == "100" ? "selected" : ""; ?>><?php echo __("100 vote/Day"); ?></option>
										  <option value="200" <?php echo $Schedule->get('data.slide_poll_speed') == "200" ? "selected" : ""; ?>><?php echo __("200 vote/Day"); ?></option>
										   <option value="300" <?php echo $Schedule->get('data.slide_poll_speed') == "300" ? "selected" : ""; ?>><?php echo __("300 Stories/Day"); ?></option>
										  <option value="400" <?php echo $Schedule->get('data.slide_poll_speed') == "400" ? "selected" : ""; ?>><?php echo __("400 vote/Day"); ?></option>
                                            <option value="500" <?php echo $Schedule->get('data.slide_poll_speed') == "500" ? "selected" : ""; ?>><?php echo __("500 vote/Day"); ?></option>
											 <option value="750" <?php echo $Schedule->get('data.slide_poll_speed') == "750" ? "selected" : ""; ?>><?php echo __("750 vote/Day"); ?></option>
                                            <option value="1000" <?php echo $Schedule->get('data.slide_poll_speed') == "1000" ? "selected" : ""; ?>><?php echo __("1000 vote/Day"); ?></option>
                                            <option value="1500" <?php echo $Schedule->get('data.slide_poll_speed') == "1500" ? "selected" : ""; ?>><?php echo __("1500 vote/Day"); ?></option>
											   <option value="2000" <?php echo $Schedule->get('data.slide_poll_speed') == "2000" ? "selected" : ""; ?>><?php echo __("2000 vote/Day"); ?></option>
											    <option value="2500" <?php echo $Schedule->get('data.slide_poll_speed') == "2500" ? "selected" : ""; ?>><?php echo __("2500 vote/Day"); ?></option>
												 <option value="3000" <?php echo $Schedule->get('data.slide_poll_speed') == "3000" ? "selected" : ""; ?>><?php echo __("3000 vote/Day"); ?></option>
												  <option value="5000" <?php echo $Schedule->get('data.slide_poll_speed') == "5000" ? "selected" : ""; ?>><?php echo __("5000 vote/Day"); ?></option>
												   <option value="10000" <?php echo $Schedule->get('data.slide_poll_speed') == "10000" ? "selected" : ""; ?>><?php echo __("10000 vote/Day"); ?></option>
												    <option value="50000" <?php echo $Schedule->get('data.slide_poll_speed') == "500000" ? "selected" : ""; ?>><?php echo __("50000 vote/Day"); ?></option>
													 <option value="100000" <?php echo $Schedule->get('data.slide_poll_speed') == "100000" ? "selected" : ""; ?>><?php echo __("100000 vote/Day"); ?></option>
                                        </select>
										
                                        
										</br> 
                                     <label for="quiz_speed" class="form-label"><?php echo __("Quiz Vote Speed"); ?></label>
										
                                        <select class="input" id="quiz_speed" name="quiz_speed" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
										 <option value="1000" <?php echo $Schedule->get('data.quiz_speed') == "100" ? "selected" : ""; ?>><?php echo __("100 vote/Day"); ?></option>
										  <option value="2000" <?php echo $Schedule->get('data.quiz_speed') == "200" ? "selected" : ""; ?>><?php echo __("200 vote/Day"); ?></option>
										   <option value="3000" <?php echo $Schedule->get('data.quiz_speed') == "300" ? "selected" : ""; ?>><?php echo __("300 Stories/Day"); ?></option>
										  <option value="400" <?php echo $Schedule->get('data.quiz_speed') == "400" ? "selected" : ""; ?>><?php echo __("400 vote/Day"); ?></option>
                                            <option value="500" <?php echo $Schedule->get('data.quiz_speed') == "500" ? "selected" : ""; ?>><?php echo __("500 vote/Day"); ?></option>
											 <option value="750" <?php echo $Schedule->get('data.quiz_speed') == "750" ? "selected" : ""; ?>><?php echo __("750 vote/Day"); ?></option>
                                            <option value="1000" <?php echo $Schedule->get('data.quiz_speed') == "1000" ? "selected" : ""; ?>><?php echo __("1000 vote/Day"); ?></option>
                                            <option value="1500" <?php echo $Schedule->get('data.quiz_speed') == "1500" ? "selected" : ""; ?>><?php echo __("1500 vote/Day"); ?></option>
											   <option value="2000" <?php echo $Schedule->get('data.quiz_speed') == "2000" ? "selected" : ""; ?>><?php echo __("2000 vote/Day"); ?></option>
											    <option value="2500" <?php echo $Schedule->get('data.quiz_speed') == "2500" ? "selected" : ""; ?>><?php echo __("2500 vote/Day"); ?></option>
												 <option value="3000" <?php echo $Schedule->get('data.quiz_speed') == "3000" ? "selected" : ""; ?>><?php echo __("3000 vote/Day"); ?></option>
												  <option value="5000" <?php echo $Schedule->get('data.quiz_speed') == "5000" ? "selected" : ""; ?>><?php echo __("5000 vote/Day"); ?></option>
												   <option value="10000" <?php echo $Schedule->get('data.quiz_speed') == "10000" ? "selected" : ""; ?>><?php echo __("10000 vote/Day"); ?></option>
												    <option value="50000" <?php echo $Schedule->get('data.quiz_speed') == "500000" ? "selected" : ""; ?>><?php echo __("50000 vote/Day"); ?></option>
													 <option value="100000" <?php echo $Schedule->get('data.quiz_speed') == "100000" ? "selected" : ""; ?>><?php echo __("100000 vote/Day"); ?></option>
                                        </select>
										
                                        
										</br> 
										<label for="question_speed" class="form-label"><?php echo __("Question Vote Speed"); ?></label>
										
                                        <select class="input" id="question_speed" name="question_speed" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
										 <option value="100" <?php echo $Schedule->get('data.question_speed') == "100" ? "selected" : ""; ?>><?php echo __("100 vote/Day"); ?></option>
										  <option value="200" <?php echo $Schedule->get('data.question_speed') == "200" ? "selected" : ""; ?>><?php echo __("200 vote/Day"); ?></option>
										   <option value="300" <?php echo $Schedule->get('data.question_speed') == "300" ? "selected" : ""; ?>><?php echo __("300 Stories/Day"); ?></option>
										  <option value="400" <?php echo $Schedule->get('data.question_speed') == "400" ? "selected" : ""; ?>><?php echo __("400 vote/Day"); ?></option>
                                            <option value="500" <?php echo $Schedule->get('data.question_speed') == "500" ? "selected" : ""; ?>><?php echo __("500 vote/Day"); ?></option>
											 <option value="750" <?php echo $Schedule->get('data.question_speed') == "750" ? "selected" : ""; ?>><?php echo __("750 vote/Day"); ?></option>
                                            <option value="1000" <?php echo $Schedule->get('data.question_speed') == "1000" ? "selected" : ""; ?>><?php echo __("1000 vote/Day"); ?></option>
                                            <option value="1500" <?php echo $Schedule->get('data.question_speed') == "1500" ? "selected" : ""; ?>><?php echo __("1500 vote/Day"); ?></option>
											   <option value="2000" <?php echo $Schedule->get('data.question_speed') == "2000" ? "selected" : ""; ?>><?php echo __("2000 vote/Day"); ?></option>
											    <option value="2500" <?php echo $Schedule->get('data.question_speed') == "2500" ? "selected" : ""; ?>><?php echo __("2500 vote/Day"); ?></option>
												 <option value="3000" <?php echo $Schedule->get('data.question_speed') == "3000" ? "selected" : ""; ?>><?php echo __("3000 vote/Day"); ?></option>
												  <option value="5000" <?php echo $Schedule->get('data.question_speed') == "5000" ? "selected" : ""; ?>><?php echo __("5000 vote/Day"); ?></option>
												   <option value="10000" <?php echo $Schedule->get('data.question_speed') == "10000" ? "selected" : ""; ?>><?php echo __("10000 vote/Day"); ?></option>
												    <option value="50000" <?php echo $Schedule->get('data.question_speed') == "500000" ? "selected" : ""; ?>><?php echo __("50000 vote/Day"); ?></option>
													 <option value="100000" <?php echo $Schedule->get('data.question_speed') == "100000" ? "selected" : ""; ?>><?php echo __("100000 vote/Day"); ?></option>
                                        </select>
										
                                        
										</br> 
										<label for="countdown_speed" class="form-label"><?php echo __("Countdown Vote Speed"); ?></label>
										
                                        <select class="input" id="countdown_speed" name="countdown_speed" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
										 <option value="100" <?php echo $Schedule->get('data.countdown_speed') == "100" ? "selected" : ""; ?>><?php echo __("100 vote/Day"); ?></option>
										  <option value="200" <?php echo $Schedule->get('data.countdown_speed') == "200" ? "selected" : ""; ?>><?php echo __("200 vote/Day"); ?></option>
										   <option value="300" <?php echo $Schedule->get('data.countdown_speed') == "300" ? "selected" : ""; ?>><?php echo __("300 Stories/Day"); ?></option>
										  <option value="400" <?php echo $Schedule->get('data.countdown_speed') == "400" ? "selected" : ""; ?>><?php echo __("400 vote/Day"); ?></option>
                                            <option value="500" <?php echo $Schedule->get('data.countdown_speed') == "500" ? "selected" : ""; ?>><?php echo __("500 vote/Day"); ?></option>
											 <option value="750" <?php echo $Schedule->get('data.countdown_speed') == "750" ? "selected" : ""; ?>><?php echo __("750 vote/Day"); ?></option>
                                            <option value="1000" <?php echo $Schedule->get('data.countdown_speed') == "1000" ? "selected" : ""; ?>><?php echo __("1000 vote/Day"); ?></option>
                                            <option value="1500" <?php echo $Schedule->get('data.countdown_speed') == "1500" ? "selected" : ""; ?>><?php echo __("1500 vote/Day"); ?></option>
											   <option value="2000" <?php echo $Schedule->get('data.countdown_speed') == "2000" ? "selected" : ""; ?>><?php echo __("2000 vote/Day"); ?></option>
											    <option value="2500" <?php echo $Schedule->get('data.countdown_speed') == "2500" ? "selected" : ""; ?>><?php echo __("2500 vote/Day"); ?></option>
												 <option value="3000" <?php echo $Schedule->get('data.countdown_speed') == "3000" ? "selected" : ""; ?>><?php echo __("3000 vote/Day"); ?></option>
												  <option value="5000" <?php echo $Schedule->get('data.countdown_speed') == "5000" ? "selected" : ""; ?>><?php echo __("5000 vote/Day"); ?></option>
												   <option value="10000" <?php echo $Schedule->get('data.countdown_speed') == "10000" ? "selected" : ""; ?>><?php echo __("10000 vote/Day"); ?></option>
												    <option value="50000" <?php echo $Schedule->get('data.countdown_speed') == "500000" ? "selected" : ""; ?>><?php echo __("50000 vote/Day"); ?></option>
													 <option value="100000" <?php echo $Schedule->get('data.countdown_speed') == "100000" ? "selected" : ""; ?>><?php echo __("100000 vote/Day"); ?></option>
                                        </select>
										
                                        
										</br> 
										<br>
										<br>
									 <?php $q_mv2 = $Schedule->get("data.is_masslookingv2"); ?>
                                        <label>
                                            <input type="checkbox"
                                                    class="checkbox"
                                                    name="is-masslooking-v2"
                                                    value="true"
                                                    <?php echo  $q_mv2 ? "checked" : ""; ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?php echo __('Masslooking V2'); ?>
												<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Mass Stories View Option (Algorithm 2).")?>">?</button>
                                            </span>
                                        </label>
                                           
                                       
                                     
										<br>
										<br>
										
										<label for="masslookingv2_speed" class="form-label"><?php echo __("MasslookingV2 Speed"); ?></label>
										
                                        <select class="input" id="masslookingv2_speed" name="masslookingv2_speed" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
										 <option value="1000" <?php echo $Schedule->get('data.masslookingv2_speed') == "1000" ? "selected" : ""; ?>><?php echo __("1000 Stories/Day"); ?></option>
										  <option value="2000" <?php echo $Schedule->get('data.masslookingv2_speed') == "2000" ? "selected" : ""; ?>><?php echo __("2000 Stories/Day"); ?></option>
										   <option value="3000" <?php echo $Schedule->get('data.masslookingv2_speed') == "3000" ? "selected" : ""; ?>><?php echo __("3000 Stories/Day"); ?></option>
										  <option value="4000" <?php echo $Schedule->get('data.masslookingv2_speed') == "4000" ? "selected" : ""; ?>><?php echo __("4000 Stories/Day"); ?></option>
                                            <option value="5000" <?php echo $Schedule->get('data.masslookingv2_speed') == "5000" ? "selected" : ""; ?>><?php echo __("5000 Stories/Day"); ?></option>
											 <option value="7500" <?php echo $Schedule->get('data.masslookingv2_speed') == "7500" ? "selected" : ""; ?>><?php echo __("7500 Stories/Day"); ?></option>
                                            <option value="10000" <?php echo $Schedule->get('data.masslookingv2_speed') == "10000" ? "selected" : ""; ?>><?php echo __("10000 Stories/Day"); ?></option>
                                            <option value="15000" <?php echo $Schedule->get('data.masslookingv2_speed') == "15000" ? "selected" : ""; ?>><?php echo __("15000 Stories/Day"); ?></option>
											   <option value="20000" <?php echo $Schedule->get('data.masslookingv2_speed') == "20000" ? "selected" : ""; ?>><?php echo __("20000 Stories/Day"); ?></option>
											    <option value="25000" <?php echo $Schedule->get('data.masslookingv2_speed') == "25000" ? "selected" : ""; ?>><?php echo __("25000 Stories/Day"); ?></option>
												 <option value="30000" <?php echo $Schedule->get('data.masslookingv2_speed') == "30000" ? "selected" : ""; ?>><?php echo __("30000 Stories/Day"); ?></option>
												  <option value="50000" <?php echo $Schedule->get('data.masslookingv2_speed') == "50000" ? "selected" : ""; ?>><?php echo __("50000 Stories/Day"); ?></option>
												   <option value="100000" <?php echo $Schedule->get('data.masslookingv2_speed') == "100000" ? "selected" : ""; ?>><?php echo __("100000 Stories/Day"); ?></option>
												    <option value="500000" <?php echo $Schedule->get('data.masslookingv2_speed') == "500000" ? "selected" : ""; ?>><?php echo __("500000 Stories/Day"); ?></option>
													 <option value="800000" <?php echo $Schedule->get('data.masslookingv2_speed') == "800000" ? "selected" : ""; ?>><?php echo __("800000 Stories/Day"); ?></option>
                                        </select>
										
                                        
										</br>
										
                                    <label class="form-label mb-20"><?= __("Like & Follow & Comment Setting") ?></label>
								
                                    <ul class="field-tips mb-20">
                                        <li><?= __("Each account has a different limit and trust score, so high speed for this actions can trigger 24 hours action block (feedback required).") ?></li>
                                    </ul>
									<?php 
                                                $likes_per_user = $Schedule->get("data.likes_per_user") ? $Schedule->get("data.likes_per_user") : 1; 
                                                $likes_speed = $Schedule->get("data.likes_speed") ? $Schedule->get("data.likes_speed") : 100;
												 $comment_per_user = $Schedule->get("data.comment_per_user") ? $Schedule->get("data.comment_per_user") : 1; 
                                                $comment_speed = $Schedule->get("data.comment_speed") ? $Schedule->get("data.comment_speed") : 100;
												 $comment_like_speed = $Schedule->get("data.comment_like_speed") ? $Schedule->get("data.comment_like_speed") : 100;
                                            ?>
											 <div class="clearfix">
                                                <div class="col s12 m6 l6 mb-5">
                                                    <label class="form-label mt-5 mb-0">
                                                        <input type="checkbox" 
                                                                class="checkbox" 
                                                                name="c-likes" 
                                                                value="1"
                                                                <?= $Schedule->get("data.is_c_likes") ? "checked" : "" ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                                        <span>
                                                            <span class="icon unchecked">
                                                                <span class="mdi mdi-check"></span>
                                                            </span>
                                                            <?= __('Comment Like') ?>
																<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Targetted source comment like option.")?>">?</button>
                                                        </span>
                                                    </label>
													
													<br>
                                                 	  <ul class="field-tips mb-10">
                                                        <li><?= __("How many comment like Per day?") ?></li>
                                                    </ul>
										
                                        <select class="input" id="comment-likes-speed" name="comment-likes-speed" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <option value="100" <?php echo $Schedule->get('data.comment_likes_speed') == "100" ? "selected" : ""; ?>><?php echo __("100 Comment Like/Day"); ?></option>
                                             <option value="500" <?php echo $Schedule->get('data.comment_likes_speed') == "500" ? "selected" : ""; ?>><?php echo __("500 Comment Like/Day"); ?></option>
                                                <option value="1000" <?php echo $Schedule->get('data.comment_likes_speed') == "1000" ? "selected" : ""; ?>><?php echo __("1000 Comment Like/Day"); ?></option>
											      <option value="2000" <?php echo $Schedule->get('data.comment_likes_speed') == "2000" ? "selected" : ""; ?>><?php echo __("2000 Comment Like/Day"); ?></option>
											       <option value="5000" <?php echo $Schedule->get('data.comment_likes_speed') == "5000" ? "selected" : ""; ?>><?php echo __("5000 Comment Like/Day"); ?></option>
												    <option value="10000" <?php echo $Schedule->get('data.comment_likes_speed') == "10000" ? "selected" : ""; ?>><?php echo __("10000 Comment Like/Day"); ?></option>
                                        </select>
										
                                        
										</br>
                                                 
                                                  
                                                </div>
												 
												
                                                 </div>
                                            </div>
											<div class="clearfix">
                                                                       
												<div class="clearfix">
                                    <div class="mb-15">
                                        <label>
                                            <input type="checkbox" 
                                                    class="checkbox" 
                                                    name="likes" 
                                                    value="1"
                                                    <?= $Schedule->get("data.is_likes") ? "checked" : "" ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?= __('Like') ?>
													<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Targetted source post like option.")?>">?</button>
                                            </span>
                                        </label>
										
                                            
											 
											
                                        <div class="clearfix js-likes-settings">
                                            <div class="clearfix">
                                                <div class="col s12 m6 l6 mb-5">
                                                    <ul class="field-tips mb-10">
                                                        <li><?= __("How many post like Per user?") ?></li>
                                                    </ul>
                                                    <select name="likes-per-user" class="input">
                                                        <?php for ($i=1; $i<=30; $i++): ?>
                                                            <option value="<?= $i ?>" <?= $i == $likes_per_user ? "selected" : "" ?>><?= n__("%s post", "%s posts", $i, $i) ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                    <label class="form-label mt-10 mb-0">
                                                        <input type="checkbox" 
                                                            class="checkbox" 
                                                            name="likes-timeline" 
                                                            value="1"
                                                            <?= $Schedule->get("data.is_likes_timeline") ? "checked" : "" ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                                        <span>
                                                            <span class="icon unchecked">
                                                                <span class="mdi mdi-check"></span>
                                                            </span>
                                                            <?= __("Like timeline posts") ?>
																<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Your timeline post like option..")?>">?</button>
                                                        </span>
                                                    </label>
                                                   
                                                 
                                                  
                                                </div>
												 
												
                                                <div class="col s12 s-last m6 m-last l6 l-last mb-5">
                                                    <ul class="field-tips mb-10">
                                                        <li><?= __("Like Speed") ?></li>
                                                    </ul>
                                                    <select name="likes-speed" class="input">
                                                        <?php for ($i=10; $i<=3000; $i=$i+10): ?>
                                                            <option value="<?= $i ?>" <?= $i == $likes_speed ? "selected" : "" ?>><?= n__("%s like per day", "%s likes per day", $i, $i) ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="clearfix mb-20">
                                        <label>
                                            <input type="checkbox" 
                                                    class="checkbox" 
                                                    name="follow" 
                                                    value="1"
                                                    <?= $Schedule->get("data.is_follow") ? "checked" : "" ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?= __('Follow') ?>
													<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Targetted source follow option.")?>">?</button>
                                            </span>
                                        </label>
                                        <div class="clearfix js-follow-settings">
                                            <?php
                                                $follow_speed = $Schedule->get("data.follow_speed") ? $Schedule->get("data.follow_speed") : 50;
                                                $mute_type = $Schedule->get("data.mute_type") ? $Schedule->get("data.mute_type") : "none";
                                            ?>
                                            <div class="col s12 m6 l6">
                                                <ul class="field-tips mb-10">
                                                    <li><?= __("Speed") ?></li>
                                                </ul>
                                                <select name="follow-speed" class="input">
                                                    <?php for ($i=5; $i<=1000; $i=$i+5): ?>
                                                        <option value="<?= $i ?>" <?= $i == $follow_speed ? "selected" : "" ?>><?= n__("%s follow per day", "%s follows per day", $i, $i) ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="col s12 s-last m6 m-last l6 l-last">
                                                <ul class="field-tips mb-10">
                                                    <li><?= __("Do you want to mute user stories, post or all?") ?></li>
                                                </ul>
                                                <select name="mute-type" class="input">
                                                    <option value="none" <?= "none" == $mute_type ? "selected" : "" ?>><?= __("None") ?></option>
                                                    <option value="all" <?= "all" == $mute_type ? "selected" : "" ?>><?= __("All") ?></option>
                                                    <option value="story" <?= "story" == $mute_type ? "selected" : "" ?>><?= __("Only Stories") ?></option>
                                                    <option value="post" <?= "post" == $mute_type ? "selected" : "" ?>><?= __("Only Posts") ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									 <div class="clearfix mb-20">
                                        <label>
                                            <input type="checkbox" 
                                                    class="checkbox" 
                                                    name="unfollow" 
                                                    value="1"
                                                    <?= $Schedule->get("data.is_unfollow") ? "checked" : "" ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?= __('Unfollow') ?>
													<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Unfollow who not follow you.")?>">?</button>
                                            </span>
                                        </label>
                                        <div class="clearfix js-unfollow-settings">
                                            <?php
                                                $unfollow_speed = $Schedule->get("data.unfollow_speed") ? $Schedule->get("data.unfollow_speed") : 50;
                                                $unfollow_interval = $Schedule->get("data.unfollow_interval") ? $Schedule->get("data.unfollow_interval") : 7;
                                            ?>
                                            <div class="col s12 m6 l6">
                                                <ul class="field-tips mb-10">
                                                    <li><?= __("Speed") ?></li>
                                                </ul>
                                                <select name="unfollow-speed" class="input">
                                                    <?php for ($i=5; $i<=1000; $i=$i+5): ?>
                                                        <option value="<?= $i ?>" <?= $i == $unfollow_speed ? "selected" : "" ?>><?= n__("%s unfollow per day", "%s unfollows per day", $i, $i) ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="col s12 s-last m6 m-last l6 l-last">
                                                <ul class="field-tips mb-10">
                                                    <li><?= __("Unfollow interval") ?></li>
                                                </ul>
                                                <select name="unfollow-interval" class="input">
                                                    <?php for ($i=1; $i<=180; $i++): ?>
                                                        <option value="<?= $i ?>" <?= $i == $unfollow_interval ? "selected" : "" ?>><?= n__("%s day", "%s days", $i, $i) ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									
                                    <div class="clearfix mb-20">
                                        <label>
                                            <input type="checkbox" 
                                                    class="checkbox" 
                                                    name="comments" 
                                                    value="1"
                                                    <?= $Schedule->get("data.is_comments") ? "checked" : "" ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?= __('Comments') ?>
													<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Targetted source post comment option.")?>">?</button>
                                            </span>
                                        </label>
                                        <div class="clearfix js-comments-settings">
                                            <?php
                                                $comment_speed = $Schedule->get("data.comment_speed") ? $Schedule->get("data.comment_speed") : 50;
                                                $comment_per_user = $Schedule->get("data.comment_per_user") ? $Schedule->get("data.comment_per_user") : 1; 
                                            ?>
                                            <div class="col s12 m6 l6">
                                                <ul class="field-tips mb-10">
                                                    <li><?= __("Speed") ?></li>
                                                </ul>
                                                <select name="comments-speed" class="input">
                                                    <?php for ($i=5; $i<=1000; $i=$i+5): ?>
                                                        <option value="<?= $i ?>" <?= $i == $comment_speed ? "selected" : "" ?>><?= n__("%s comment per day", "%s comment  per day", $i, $i) ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
											<br>
											<br>
											<br>
											  <div class="col s12 m6 l6">
											    <ul class="field-tips mb-10">
                                                        <li><?= __("How many post comment Per user?") ?></li>
                                                     </ul>
                                                    <select name="comments-per-user" class="input">
                                                        <?php for ($i=1; $i<=30; $i++): ?>
                                                            <option value="<?= $i ?>" <?= $i == $comment_per_user ? "selected" : "" ?>><?= n__("%s post", "%s posts", $i, $i) ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                            </div>
<br>
											<br>
											<br>
											<div class="clearfix  mb-20">
									
                                            <div class="tabheads clearfix">
											
                                               
                                            </div>

                                              <div class="tabcontents">
                                                <div class="active pos-r" data-tab="1">
                                                      <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													   
                                        <div class="arp-caption-input input"
										
                                        data-placeholder="<?php echo __("Comment Text (comment per line.)") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.comment_text"))) : ""; ?></div> 
                                                </div>
                                       
										  

                                                   
                                                </div>
                                            </div>
                                      
                                        </div>
                                    </div>
									
                                  
									
										<br>
										<br>
										 <?php $q_bluebadge = $Schedule->get("data.is_masslookingv2_verified"); ?>
                                        <label>
                                            <input type="checkbox"
                                                    class="checkbox"
                                                    name="blue-badge"
                                                    value="true"
                                                    <?php echo  $q_bluebadge ? "checked" : ""; ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?php echo __('Blue Badge (Verified Acc.)'); ?>
													<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Verified & Blue badge accounts special speed option. This setting is risky for standard accounts.")?>">?</button>
                                            </span>
                                        </label>
                                           <br>
										<br>
                                       
										  
										
                                        <?php if (!($Settings->get("data.mass_story_view"))): ?>
                                            <?php $q_mssv = $Schedule->get("is_mass_story_view_active"); ?>
                                            <label>
                                                <input type="checkbox"
                                                        class="checkbox"
                                                        name="is_mass_story_view_active"
                                                        value="1"
                                                        <?php echo $q_mssv ? "checked" : ""; ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                                <span>
                                                    <span class="icon unchecked">
                                                        <span class="mdi mdi-check"></span>
                                                    </span>
                                                    <?php echo __('Masslooking V1'); ?>
														<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Targetted peoples mass stories view option.(Algorithm 1).")?>">?</button>
                                                </span>
                                            </label>
										

                                            <?php if ($Schedule->get("is_mass_story_view_active")): ?>
                                           
                                           
                                            <?php endif; ?>
                                            <?php else: ?>
                                            <input type="checkbox" style="display:none" value="0" name="is_mass_story_view_active" />
                                            <?php endif; ?>
                                        </div>
										<br>
										<br>
										 <?php  $q_langdetect = $Schedule->get("data.multilang_enable"); ?>
                                        <label>
                                            <input type="checkbox"
                                                    class="checkbox"
                                                    name="langdetect"
                                                    value="true"
                                                    <?php echo  $q_langdetect ? "checked" : ""; ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?php echo __('Multi Language & AI Language Detection'); ?>
													<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("This option detect peoples stories question language and send same answer with his language.")?>">?</button>
                                            </span>
                                        </label>
                                           
                                        </div>
										<br>
										<br>
									<div class="tabs mb-20 ">
									
                                            <div class="tabheads clearfix">
											
											<a  class="active" href="javascript:void(0)" style="width: 10%; border-bottom: none;" data-tab="1"><?= __("Default") ?></a>
                                                <a href="javascript:void(0)" style="width: 10%; border-bottom: none;" data-tab="2"><?= __("English") ?></a>
                                                <a href="javascript:void(0)" style="width:10%; border-bottom: none;" data-tab="3"><?= __("Arabic") ?></a>
												<a href="javascript:void(0)" style="width: 10%; border-bottom: none;" data-tab="4"><?= __("German") ?></a>
                                                <a href="javascript:void(0)" style="width: 10%; border-bottom: none;" data-tab="5"><?= __("French") ?></a>
												<a href="javascript:void(0)" style="width: 10%; border-bottom: none;" data-tab="6"><?= __("Turkish") ?></a>
												<a href="javascript:void(0)" style="width: 10%; border-bottom: none;" data-tab="7"><?= __("Hindi") ?></a>
												<a href="javascript:void(0)" style="width: 15%; border-bottom: none;" data-tab="8"><?= __("Indonesian") ?></a>
												<a href="javascript:void(0)" style="width: 10%; border-bottom: none;" data-tab="9"><?= __("Russian") ?></a>
												<a href="javascript:void(0)" style="width: 10%; border-bottom: none;" data-tab="10"><?= __("Italian") ?></a>
												<a href="javascript:void(0)" style="width: 15%; border-bottom: none;" data-tab="11"><?= __("Spanish") ?></a>
												<a href="javascript:void(0)" style="width: 15%; border-bottom: none;" data-tab="12"><?= __("Portuguese") ?></a>
												<a href="javascript:void(0)" style="width: 15%; border-bottom: none;" data-tab="13"><?= __("Iranian") ?></a>
												<a href="javascript:void(0)" style="width: 10%; border-bottom: none;" data-tab="14"><?= __("Dutch") ?></a>
												<a href="javascript:void(0)" style="width: 10%; border-bottom: none;" data-tab="15"><?= __("Brasil") ?></a>
												<a href="javascript:void(0)" style="width: 10%; border-bottom: none;" data-tab="16"><?= __("Japan") ?></a>
												<a href="javascript:void(0)" style="width: 15%; border-bottom: none;" data-tab="17"><?= __("Chinese") ?></a>
                                            </div>

                                            <div class="tabcontents">
                                                <div class="active pos-r" data-tab="1">
                                                      <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													   
                                        <div class="arp-caption-input input"
										
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("answers_pk"))) : ""; ?></div> 
                                                </div>

                                                <div class="pos-r" data-tab="2">
                                                     <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													
                                        <div class="arp-caption-input input"
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.en"))) : ""; ?> </div>
                                                </div>
												 <div class="pos-r" data-tab="3">
                                                     <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													
                                        <div class="arp-caption-input input"
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.ar"))) : ""; ?> </div>  
                                                </div>
												 <div class="pos-r" data-tab="4">
                                                     <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													
                                        <div class="arp-caption-input input"
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.de"))) : ""; ?> </div>
                                                </div>
												 <div class="pos-r" data-tab="5">
                                                     <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													
                                        <div class="arp-caption-input input"
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.fr"))) : ""; ?> </div>
                                                </div>
												 <div class="pos-r" data-tab="6">
                                                     <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													
                                        <div class="arp-caption-input input"
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.tr"))) : ""; ?> </div>
                                                </div>
												 <div class="pos-r" data-tab="7">
                                                     <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													
                                        <div class="arp-caption-input input"
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.ind"))) : ""; ?> </div>
                                                </div>
												 <div class="pos-r" data-tab="8">
                                                     <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													
                                        <div class="arp-caption-input input"
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.id"))) : ""; ?> </div>
                                                </div>
												 <div class="pos-r" data-tab="9">
                                                     <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													
                                        <div class="arp-caption-input input"
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.ru"))) : ""; ?> </div>
                                                </div>
												 <div class="pos-r" data-tab="10">
                                                     <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													
                                        <div class="arp-caption-input input"
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.it"))) : ""; ?> </div>
                                                </div>
												 <div class="pos-r" data-tab="11">
                                                     <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													
                                        <div class="arp-caption-input input"
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.es"))) : ""; ?> </div>
                                                </div>
												 <div class="pos-r" data-tab="12">
                                                     <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													
                                        <div class="arp-caption-input input"
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.pt"))) : ""; ?> </div>
                                                </div>
												 <div class="pos-r" data-tab="13">
                                                     <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													
                                        <div class="arp-caption-input input"
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.ir"))) : ""; ?> </div>
                                                </div>
												 <div class="pos-r" data-tab="14">
                                                     <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													
                                        <div class="arp-caption-input input"
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.nl"))) : ""; ?> </div>
                                                </div>
												 <div class="pos-r" data-tab="15">
                                                     <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													
                                        <div class="arp-caption-input input"
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.br"))) : ""; ?> </div>
                                                </div>
												 <div class="pos-r" data-tab="16">
                                                     <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													
                                        <div class="arp-caption-input input"
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.jp"))) : ""; ?> </div>
										  </div>
										 <div class="pos-r" data-tab="17">
                                                     <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
													
                                        <div class="arp-caption-input input"
                                        data-placeholder="<?php echo __("Answers for questions. One answer per line") ?>"
                                        contenteditable="true"><?php echo $Schedule->isAvailable() ? htmlchars($Emojione->shortnameToUnicode($Schedule->get("data.cn"))) : ""; ?> </div>
										  

                                                   
                                                </div>
                                            </div>
                                        </div>
										
								
                                        <label class="range"><?php echo __("Slider Points Min/Max"); ?></label>
											<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Slide Poll vote slide point option, you can set 0 to 100 point range.")?>">?</button>
                                        <div class="clearfix mb20" style="margin-bottom:30px!important;">
                                        <div class="col s12 m4 l4">
                                            <select class="input" name="slider_min" <?php echo $is_license_valid ? "" : "disabled"; ?>>
                                                <?php for ($i=0; $i<=100; $i++): ?>
                                                    <option value="<?php echo $i; ?>" <?php echo $Schedule->get('slider_min') == $i ? "selected" : ""; ?>>
                                                        <?php echo $i;?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <div class="col s12 m4 l4">
                                            <select class="input" name="slider_max" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                                <?php for ($i=0; $i<=100; $i++): ?>
                                                    <option value="<?php echo $i; ?>" <?php echo $Schedule->get('slider_max') == $i ? "selected" : ""; ?>>
                                                        <?php echo $i;?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        </div>
										<label for="poll_answer_option" class="form-label"><?php echo __("Poll Answer Option"); ?><button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Poll Vote answer option. correct vote is select correct vote, first option select left vote, second option is select right option. .")?>">  ?</button></label>
											
										
                                        <select class="input" id="poll_answer_option" name="poll_answer_option" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <option value="R" <?php echo $Schedule->get('poll_answer_option') == "R" ? "selected" : ""; ?>><?php echo __("Select Correct Vote"); ?></option>
                                            <option value="0" <?php echo $Schedule->get('poll_answer_option') == "0" ? "selected" : ""; ?>><?php echo __("First Option"); ?></option>
                                            <option value="1" <?php echo $Schedule->get('poll_answer_option') == "1" ? "selected" : ""; ?>><?php echo __("Second Option"); ?></option>
                                        </select>
										
                                        
										</br>
										 <div class="clearfix mb-20">
										  <label class="form-label"><?php echo __("Active Filters"); ?></label>
                                    <div class="clearfix mb-20">
                                    </br>
									  
									
                                        <?php $q_ig1 = $Schedule->get("same_people_story_ignore"); ?>
                                        <label>
                                            <input type="checkbox"
                                                    class="checkbox"
                                                    name="same_people_story_ignore"
                                                    value="1"
                                                    <?php echo  $q_ig1 ? "checked" : ""; ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?php echo __('Same People Story Ignore'); ?>
												<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Make action for an a people one time.")?>">  ?</button>
                                            </span>
                                        </label>
										<br>
										<br>
										 <?php $q_ig2 = $Schedule->get("follow_request_ignore"); ?>
                                        <label>
                                            <input type="checkbox"
                                                    class="checkbox"
                                                    name="follow_request_ignore"
                                                    value="1"
                                                    <?php echo  $q_ig2 ? "checked" : ""; ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?php echo __('Ignore Follow Requested People'); ?>
												<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Ignore Follow request sent people stories..")?>">  ?</button>
                                            </span>
                                        </label>
										<br>
										<br>
										 <?php $q_ig3 = $Schedule->get("following_ignore"); ?>
										<label>
                                            <input type="checkbox"
                                                    class="checkbox"
                                                    name="following_ignore"
                                                    value="1"
                                                    <?php echo  $q_ig3 ? "checked" : ""; ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?php echo __('Ignore Following People'); ?>
												<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Ignore your already following people stories..")?>">  ?</button>
                                            </span>
                                        </label>
										<br>
										<br>
										
										 <?php $q_ig4 = $Schedule->get("follower_ignore"); ?>
										<label>
                                            <input type="checkbox"
                                                    class="checkbox"
                                                    name="follower_ignore"
                                                    value="1"
                                                    <?php echo  $q_ig4 ? "checked" : ""; ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?php echo __('Ignore Follower People'); ?>
												<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Ignore your follower people stories.")?>">  ?</button>
                                            </span>
                                        </label>
                                   </br>
								   </br>
								   </br>
								   <?php $q_ig5 = $Schedule->get("advanced_log"); ?>
										<label>
                                            <input type="checkbox"
                                                    class="checkbox"
                                                    name="advanced_log"
                                                    value="1"
                                                    <?php echo  $q_ig5 ? "checked" : ""; ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?php echo __('Advanced Log System'); ?>
												<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Detailed Log system on Log Page.")?>">  ?</button>
                                            </span>
                                        </label>
										</br>
								   </br>
								  
								   
								    
                                    <label class="form-label"><?php echo __("Stories Parsing Speed") ?><button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Stories collect and parsing speed per day..")?>">  ?</button></label>

                                    <?php if ($maximum_speed == "maximum"): ?>
                                        <select class="input" name="speed" <?php echo $is_license_valid ? "" : "disabled" ?>>
                                            <option value="maximum" <?php echo $speed == "maximum" ? "selected" : "" ?>><?php echo __("Maximum"); ?></option>
                                            <?php for ($i=10000; $i<=$max_index; $i=($i+10000)): ?>
                                                <option value="<?php echo $i; ?>" <?php echo $speed == $i ? "selected" : "" ?>>
                                                    <?php $f_number = number_format($i, 0, '.', ' '); ?>
                                                    <?php echo __("%s stories/day", $f_number); ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    <?php elseif ($maximum_speed == 10000): ?>
                                        <select class="input" name="speed" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                                <option value="<?php echo $maximum_speed ?>" <?php echo $speed == $maximum_speed ? "selected" : ""; ?>>
                                                    <?php $f_number = number_format($maximum_speed, 0, '.', ' '); ?>
                                                    <?php echo __("%s stories/day", $f_number); ?>
                                                </option>
                                        </select>
                                    <?php else: ?>
                                        <select class="input" name="speed" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <?php for ($i=10000; $i<=$max_index; $i=($i+10000)): ?>
                                                <option value="<?php echo $i; ?>" <?php echo $speed == $i ? "selected" : "" ?>>
                                                    <?php $f_number = number_format($i, 0, '.', ' '); ?>
                                                    <?php echo __("%s react/day", $f_number); ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                            <?php endif; ?>

                                    <?php if (($speed == "maximum") || ($speed > 400000)): ?>
                                        <ul class="field-tips">
                                            <li><?php echo __("When you are using the maximum speed you may exceed the hypervote limits faster than usual."); ?></li>
                                            <?php $value = "<strong>" . __("%s react/day", number_format(400000, 0, '.', ' '))  . "</strong>"; ?>
                                            <li><?php echo __("We recommend using as speed value %s", $value); ?></li>
                                            <li><?php echo __("If you are using another type of automation, we recommend to you also reducing hypervote speed."); ?></li>
                                        </ul>
                                    <?php endif; ?>
                                </div>

                                <?php if (!in_array("massvoting-settings-u-telegram-disable", $package_modules)): ?>
                            <?php 
                                $telegram_username = $Settings->get("data.telegram_username") ? $Settings->get("data.telegram_username") : null;
                                $telegram_access_token = $Settings->get("data.telegram_access_token") ? $Settings->get("data.telegram_access_token") : null;
                                if (!empty($telegram_username) && !empty($telegram_access_token)): 
                            ?>
                                <div class="clearfix mb-20">
                                    <div class="col s12 m6 l6">
                                        <label class="form-label mb-20"><?= __("Telegram Notifications (optional)") ?></label>
                                        <label>
                                            <input type="checkbox" 
                                                    class="checkbox" 
                                                    name="is-telegram-analytics" 
                                                    value="1"
                                                    <?= $Schedule->get("data.is_telegram_analytics") ? "checked" : "" ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                            <span>
                                                <span class="icon unchecked">
                                                    <span class="mdi mdi-check"></span>
                                                </span>
                                                <?= __("Enable analytics reports") ?>
												<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Activate telegram bot system for analytics.")?>">  ?</button>
                                            </span>
                                        </label>
										<br>
										 <label class="form-label mb-5">
                                                <input type="checkbox" 
                                                        class="checkbox" 
                                                        name="is-telegram-errors" 
                                                        value="1"
                                                        <?= $Schedule->get("data.is_telegram_errors") ? "checked" : "" ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                                <span>
                                                    <span class="icon unchecked">
                                                        <span class="mdi mdi-check"></span>
                                                    </span>
                                                    <?= __("Enable error reports") ?>
													<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Activate telegram bot system for errors.")?>">  ?</button>
                                                </span>
                                            </label>
                                        <div class="js-telegram-notifications">
                                            <ul class="field-tips mb-10">
                                                <li><?= __("Go to Telegram and find our bot named as %s", "<a href='https://t.me/" . $Settings->get("data.telegram_username") . "' target='_blank'>" . "@" . $Settings->get("data.telegram_username") . "</a>") ?></li>
                                                <li><?= __("Start a chat with our bot and type <b>/start</b>") ?></li>
                                                <li><?= __("Find in Telegram bot named as %s", "<a href='https://t.me/userinfobot' target='_blank'>" . "@userinfobot" . "</a>") ?></li>
                                                <li><?= __("Start a chat with that bot and type <b>/start</b>. In response you will receive your <b>chat ID</b>.") ?></li>
                                                <li><?= __("Enter this <b>chat ID</b> in the field placed below:") ?></li>
                                            </ul>
                                            <input class="input tg-chat-id mb-10" name="tg-chat-id" id="tg-chat-id" type="number" maxlength="5" placeholder="<?= __("Enter the chat ID") ?>" value="<?= htmlchars($Schedule->get("data.tg_chat_id")) ?>">  
                                           
                                            <ul class="field-tips mb-10">
                                                <li><?= __("Notifications sending interval") ?></li>
                                            </ul>
                                            <?php $delay_telegram = $Schedule->get("data.delay_telegram") ? $Schedule->get("data.delay_telegram") : 21600; ?>
                                            <select name="delay-telegram" class="input">
                                                <?php for ($i=5; $i<=55; $i=$i+5): ?>
                                                    <option value="<?= $i*60 ?>" <?= $i*60 == $delay_telegram ? "selected" : "" ?>><?= n__("%s minute", "%s minutes", $i, $i) ?></option>
                                                <?php endfor; ?>
                                                <?php for ($i=1; $i<=23; $i++): ?>
                                                    <option value="<?= $i*3600 ?>" <?= $i*3600 == $delay_telegram ? "selected" : "" ?>><?= n__("%s hour", "%s hours", $i, $i) ?></option>
                                                <?php endfor; ?>
                                                <?php for ($i=1; $i<=30; $i++): ?>
                                                    <option value="<?= $i*86400 ?>" <?= $i*86400 == $delay_telegram ? "selected" : "" ?>><?= n__("%s day", "%s days", $i, $i) ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                            <?php endif ?>


                            <?php if (!($Settings->get("data.hide_pause_settings"))): ?>
                                <div class="clearfix mb-20">
                                    <div class="col s12 m6 l6">
                                        <div class="mb-20">
                                            <label>
                                                <input type="checkbox"
                                                    class="checkbox"
                                                    name="daily-pause"
                                                    value="1"
                                                    <?php echo $Schedule->get("daily_pause") ? "checked" : ""; ?> <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                                <span>
                                                    <span class="icon unchecked">
                                                        <span class="mdi mdi-check"></span>
                                                    </span>
                                                    <?php echo __('Pause Massvoting everyday'); ?> ...
													<button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Stop Massvoting process every choiced time interval.")?>">  ?</button>
                                                </span>
                                            </label>
                                        </div>

                                        <div class="clearfix mb-20 js-daily-pause-range">
                                            <?php $timeformat = $AuthUser->get("preferences.timeformat") == "12" ? 12 : 24; ?>

                                            <div class="col s6 m6 l6">
                                                <label class="form-label"><?php echo __("From"); ?></label>

                                                <?php
                                                    $from = new \DateTime(date("Y-m-d")." ".$Schedule->get("daily_pause_from"));
                                                    $from->setTimezone(new \DateTimeZone($AuthUser->get("preferences.timezone")));
                                                    $from = $from->format("H:i");
                                                ?>

                                                <select class="input" name="daily-pause-from">
                                                    <?php for ($i=0; $i<=23; $i++): ?>
                                                        <?php $time = str_pad($i, 2, "0", STR_PAD_LEFT).":00"; ?>
                                                        <option value="<?php echo $time; ?>" <?php echo $from == $time ? "selected" : ""; ?>>
                                                            <?php echo $timeformat == 24 ? $time : date("h:iA", strtotime(date("Y-m-d")." ".$time)); ?>
                                                        </option>

                                                        <?php $time = str_pad($i, 2, "0", STR_PAD_LEFT).":30"; ?>
                                                        <option value="<?php echo $time; ?>" <?php echo $from == $time ? "selected" : ""; ?>>
                                                            <?php echo $timeformat == 24 ? $time : date("h:iA", strtotime(date("Y-m-d")." ".$time)); ?>
                                                        </option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>

                                            <div class="col s6 s-last m6 m-last l6 l-last">
                                                <label class="form-label"><?php echo __("To"); ?></label>

                                                <?php
                                                    $to = new \DateTime(date("Y-m-d")." ".$Schedule->get("daily_pause_to"));
                                                    $to->setTimezone(new \DateTimeZone($AuthUser->get("preferences.timezone")));
                                                    $to = $to->format("H:i");
                                                ?>

                                                <select class="input" name="daily-pause-to">
                                                    <?php for ($i=0; $i<=23; $i++): ?>
                                                        <?php $time = str_pad($i, 2, "0", STR_PAD_LEFT).":00"; ?>
                                                        <option value="<?php echo $time; ?>" <?php echo $to == $time ? "selected" : ""; ?>>
                                                            <?php echo $timeformat == 24 ? $time : date("h:iA", strtotime(date("Y-m-d")." ".$time)); ?>
                                                        </option>

                                                        <?php $time = str_pad($i, 2, "0", STR_PAD_LEFT).":30"; ?>
                                                        <option value="<?php echo $time; ?>" <?php echo $to == $time ? "selected" : ""; ?>>
                                                            <?php echo $timeformat == 24 ? $time : date("h:iA", strtotime(date("Y-m-d")." ".$time)); ?>
                                                        </option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                    <?php endif; ?>

                            <div class="clearfix">
                                <div class="col s12 m6 l6">
                                    <label class="form-label"><?php echo __("Status"); ?><button class="test tooltip tippy" data-toggle="tooltip" data-position="top"
                                                            data-size="large" title="<?= __("Activate or deactivate massvoting process.")?>">  ?</button></label>

                                    <select class="input" name="is_active" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                        <option value="0" <?php echo $Schedule->get("is_active") == 0 ? "selected" : ""; ?>><?php echo __("Deactive"); ?></option>
                                        <option value="1" <?php echo $Schedule->get("is_active") == 1 ? "selected" : ""; ?>><?php echo __("Active"); ?></option>
                                    </select>
                                </div>

                                <div class="col s12 m6 m-last l6 l-last mb-20">
                                    <label class="form-label">&nbsp;</label>
                                    <input class="fluid button" type="submit" value="<?php echo __("Save"); ?>" <?= $is_license_valid ? ($is_maintenance ? "disabled" : "") : "disabled" ?>>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div id="target-list-popup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="target-list-popup" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">

                        <div class="modal-header modal-header-hr">
                            <h2 class="modal-title section-title"><?php echo __("Insert targets list"); ?></h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span class="mdi mdi-close-circle"></span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="modal-content-body">
                                <div class="clearfix mb-10">
                                    <div class="pos-r">
                                        <textarea class="target-list caption-input input"
                                                  name="target-list"
                                                  id="target-list"
                                                  maxlength="5000"
                                                  spellcheck="true"
                                                  placeholder="<?php echo __("Usernames or links, every target from new string..."); ?>"></textarea>
                                    </div>
                                </div>

                                <ul class="field-tips">
                                    <li><?php echo __("Enter only valid Instagram usernames or Instagram profile links"); ?></li>
                                    <li><?php echo __("Every parameter from a new string"); ?></li>
                                </ul>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="col s12 m6 l6 target-list-mb mr-0">
                                <a class="js-hypervote-target-list tg-l-button fluid button"
                                data-id="<?php echo $Account->get("id"); ?>"
                                data-url="<?php echo APPURL."/e/".$idname."/".$Account->get("id"); ?>"
                                <?php echo $is_license_valid ? "" : "disabled"; ?>
                                href="javascript:void(0)">
                                    <?php echo __("Insert"); ?>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div id="copy-targets-popup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="copy-targets-popup" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">

                        <div class="modal-header modal-header-hr">
                            <h2 class="modal-title section-title"><?php echo __("Targets") ?></h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span class="mdi mdi-close-circle"></span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="modal-content-body">
                                <div class="clearfix mb-10">
                                    <div class="pos-r">
                                        <textarea class="target-list caption-input input"
                                                  name="target-list"
                                                  id="target-list"
                                                  maxlength="5000"
                                                    spellcheck="false"><?php foreach ($targets as $index => $t): ?><?php echo "\n" . $t->value; ?><?php endforeach; ?></textarea>
                                    </div>
                                </div>

                                <ul class="field-tips">
                                    <li><?php echo __("Here you can see usernames of targets added to this task.") ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
