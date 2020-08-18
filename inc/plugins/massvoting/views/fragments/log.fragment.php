<?php if (!defined('APP_VERSION')) die("Yo, what's up?"); ?>

<div class="skeleton skeleton--full">
    <div class="clearfix">
        <aside class="skeleton-aside hide-on-medium-and-down">
            <?php
                $form_action = APPURL . "/e/" . $idname;
                include PLUGINS_PATH . "/" . $idname ."/views/fragments/aside-search-form.fragment.php";
            ?>

            <div class="js-search-results">
                <div class="aside-list js-loadmore-content" data-loadmore-id="1"></div>
            </div>

            <div class="loadmore pt-20 mb-20 none">
                <a class="fluid button button--light-outline js-loadmore-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?= APPURL."/e/".$idname."?aid=".$Account->get("id")."&ref=log" ?>">
                    <span class="icon sli sli-refresh"></span>
                    <?= __("Load More") ?>
                </a>
            </div>
        </aside>

        <section class="skeleton-content">
            <div class="section-header back-button-wh none">
                <a href="<?= APPURL."/e/".$idname."/" ?>">
            	    <span class="mdi mdi-reply"></span><?= __("Back") ?>
                </a>
            </div>

            <div class="section-header clearfix">
                <h2 class="section-title">
                    <?= "@" . htmlchars($Account->get("username")) ?>
                    <?php if ($Account->get("login_required")): ?>
                        <small class="color-danger ml-15">
                            <span class="mdi mdi-information"></span>
                            <?= __("Re-login required!") ?>
                        </small>
                    <?php endif ?>
                </h2>
            </div>

            <div class="svp-tab-heads pb-15 clearfix">
                <a href="<?= APPURL."/e/".$idname."/".$Account->get("id") ?>"><?= __("Settings") ?></a>
                <a href="<?= APPURL."/e/".$idname."/".$Account->get("id")."/log" ?>" class="active"><?= __("Activity Log") ?></a>
                <a href="<?= APPURL."/e/".$idname."/".$Account->get("id")."/stats" ?>"><?= __("Stats") ?></a>
            </div>

            <?php if ($ActivityLog->getTotalCount() > 0): ?>
                <div class="svp-log-list js-loadmore-content" data-loadmore-id="2">
                    <?php if ($ActivityLog->getPage() == 1 && $Schedule->get("is_active")): ?>
                        <?php
                            $nextdate = new \Moment\Moment($Schedule->get("schedule_date"), date_default_timezone_get());
                            $nextdate->setTimezone($AuthUser->get("preferences.timezone"));

                            $diff = $nextdate->fromNow();
                            $nexttime = $nextdate->format($AuthUser->get("preferences.timeformat") == "12" ? "h:iA (d.m.Y)" : "H:i (d.m.Y)");
                        ?>
                        <?php if ($diff->getDirection() == "future"): ?>
                            <div class="svp-next-schedule">
                                <?= __("Next schedule will be at %s", $nexttime) ?>
                            </div>
                        <?php elseif (abs($diff->getSeconds()) < 60): ?>
                            <div class="svp-next-schedule">
                                <?= __("Massvoting scheduled...") ?>
                            </div>
                        <?php else: ?>
                            <div class="svp-next-schedule">
                                <?= __("Massvoting in progress...") ?>
                            </div>
                        <?php endif ?>
                    <?php endif ?>

                    <?php foreach ($Logs as $l): ?>
                        <div class="svp-log-list-item <?= $l->get("status") ?>">
                            <div class="clearfix">
                                <span class="circle">
                                    <?php if ($l->get("status") == "success"): ?>
                                        <?php
                                            $img = $l->get("data.viewed.media_thumb");
                                            $story_react_img = $l->get("data.react.media_thumb");
                                        ?>
                                        <?php if ($img): ?>
                                            <span class="img" style="<?= $img ? "background-image: url('".htmlchars($img)."');" : "" ?>"></span>
                                        <?php elseif ($story_react_img): ?>
                                            <span class="img" style="<?= $story_react_img ? "background-image: url('".htmlchars($story_react_img)."');" : "" ?>"></span>
                                        <?php elseif ($l->get("data.collected.followers_count") || $l->get("data.collected.next_followers_count")): ?>
                                            <span class="text log-followers"></span>
                                        <?php elseif ($l->get("data.collected.following_count") || $l->get("data.collected.next_following_count")): ?>
                                            <span class="text log-following"></span>
                                        <?php else: ?>
                                            <span class="text log-notice"></span>
                                        <?php endif ?>
                                      <?php else: ?>
                                        <?php
                                            $media_thumb = $l->get("data.media_thumb");
                                        ?>
                                        <?php if ($media_thumb): ?>
                                            <span class="img" style="<?= $media_thumb? "background-image: url('".htmlchars($media_thumb)."');" : "" ?>"></span>
                                        <?php else: ?>
                                            <span class="text log-notice"></span>    
                                        <?php endif ?>   
                                    <?php endif ?>
                                </span>
                                 
                                <div class="inner clearfix">
                                    <?php
                                        $date = new \Moment\Moment($l->get("date"), date_default_timezone_get());
                                        $date->setTimezone($AuthUser->get("preferences.timezone"));
										  $count_1 = $l->get("data.debug.votePollStory") ? $l->get("data.debug.votePollStory") : null;
                                        $count_2 = $l->get("data.debug.voteSliderStory") ? $l->get("data.debug.voteSliderStory") : null;
                                        $count_3 = $l->get("data.debug.voteQuizStory") ? $l->get("data.debug.voteQuizStory") : null;
                                        $count_4 = $l->get("data.debug.answerStoryQuestion") ? $l->get("data.debug.answerStoryQuestion") : null;
										  $count_5 = $l->get("data.debug.countdowncounter") ? $l->get("data.debug.countdowncounter") : null;
										  $count_6 = $l->get("data.viewed.total_stories_count") ? $l->get("data.viewed.total_stories_count") : null;
										   $count_7 = $l->get("data.viewed.total_stories_count_v2") ? $l->get("data.viewed.total_stories_count_v2") : null;
										    $count_9 = $l->get("data.debug.like_counter") ? $l->get("data.debug.like_counter") : null;
                                        $count_10 = $l->get("data.debug.c_like_counter") ? $l->get("data.debug.c_like_counter") : null;
                                        $count_11 = $l->get("data.debug.follow_counter") ? $l->get("data.debug.follow_counter") : null;
										 $count_12 = $l->get("data.debug.unfollow_counter") ? $l->get("data.debug.unfollow_counter") : null;
										 $count_13 = $l->get("data.debug.comment_counter") ? $l->get("data.debug.comment_counter") : null;
										  $count_14 = $l->get("data.debug.mention_counter") ? $l->get("data.debug.mention_counter") : null;
                                         $like_status = $l->get("data.debug.like_status") ?  $l->get("data.debug.like_status") : null;
                                        $mute_status = $l->get("data.debug.mute_status") ?  $l->get("data.debug.mute_status") : null;
                                        $c_like_status = $l->get("data.debug.c_like_status") ?  $l->get("data.debug.c_like_status") : null;
                                        $follow_status = $l->get("data.debug.follow_status") ?  $l->get("data.debug.follow_status") : null;
										  $unfollow_status = $l->get("data.debug.unfollow_status") ?  $l->get("data.debug.unfollow_status") : null;

                                        $fulldate = $date->format($AuthUser->get("preferences.dateformat")) . " "
                                                . $date->format($AuthUser->get("preferences.timeformat") == "12" ? "h:iA" : "H:i");
                                    ?>

                                    <div class="action">
                                        <?php if ($l->get("status") == "success"): ?>
                                            <?php if ($l->get("data.viewed.stories_count")): ?>
                                                    <?php
                                                        $stories_count = htmlchars($l->get("data.viewed.stories_count"));
                                                        echo __("20 stories marked as seen", [
                                                            "{stories_count}" => $stories_count
                                                        ]);
                                                    ?>
                                             
                                                <?php if ($l->get("data.viewed.total_stories_count")): ?>
                                                    <div class="error-details">
                                                        <?php
                                                            $total_count = htmlchars($l->get("data.viewed.total_stories_count"));
                                                            echo __("Total: {count} stories seen.", [
                                                                "{count}" => $total_count
                                                            ]);
                                                        ?>
                                                    </div>
                                                <?php endif ?>
                                            <?php endif ?>
											 
											
                                            <?php if ($l->get("data.viewed.stories_count_v2")): ?>
                                                    <?php
                                                        $stories_count2 = htmlchars($l->get("data.viewed.stories_count_v2"));
                                                        echo __("{stories_count} stories marked as seen", [
                                                            "{stories_count}" => $stories_count2
                                                        ]);
                                                    ?>
                                             
                                                <?php if ($l->get("data.viewed.total_stories_count_v2")): ?>
                                                    <div class="error-details">
                                                        <?php
                                                            $total_count2 = htmlchars($l->get("data.viewed.total_stories_count_v2"));
                                                            echo __("Total: {count} stories seen.", [
                                                                "{count}" => $total_count2
                                                            ]);
                                                        ?>
                                                    </div>
                                                <?php endif ?>
                                            <?php endif ?>
                                           
											 <?php if ($l->get("data.react.mention_count")): ?>
                                                    <?php
                                                        $mentioncount1 = htmlchars($l->get("data.react.mention_count"));
                                                        echo __("{mention_count} People Mentioned on bio.", [
                                                            "{mention_count}" => $mentioncount1
                                                        ]);
                                                    ?>
                                             
                                                <?php if ($l->get("data.debug.mention_counter")): ?>
                                                    <div class="error-details">
                                                        <?php
                                                            $total_mention = htmlchars($l->get("data.debug.mention_counter"));
                                                            echo __("Total: {count} Peoples Mentioned on bio..", [
                                                                "{count}" => $total_mention
                                                            ]);
                                                        ?>
                                                    </div>
                                                <?php endif ?>
                                            <?php endif ?>

                                            <?php if ($l->get("data.react")): ?>
                                                <?php if ($l->get("data.react.is_poll")): ?>
                                                    <?php
                                                        $question_text = htmlchars($l->get("data.react.poll.question_text"));
                                                        $vote_text = htmlchars($l->get("data.react.poll.vote_text"));
                                                        $status = $l->get('status');
                                                        if($status == 'error') {
                                                            echo $question_text;
                                                        } else {
                                                            if (!empty($question_text)) {
                                                                echo __("Answered '{vote}' to poll with question '{question_text}'.", [
                                                                    "{question_text}" => $question_text,
                                                                    "{vote}" => $vote_text,
                                                                ]);
                                                            } else {
                                                                echo __("Answered '{vote}' to poll.", [
                                                                    "{vote}" => $vote_text,
                                                                ]);
                                                            }
                                                        }

                                                    ?>
													 
                                                <?php elseif ($l->get("data.react.is_slider")): ?>
                                                    <?php
                                                        $question_text = htmlchars($l->get("data.react.slider.question_text"));
                                                        $vote_value = htmlchars($l->get("data.react.slider.vote_value"));

                                                        $status = $l->get('status');
                                                        if($status == 'error') {
                                                            echo $question_text;
                                                        } else {
                                                            if (!empty($question_text)) {
                                                                echo __("Answered {vote}% to slide poll with question '{question_text}'.", [
                                                                    "{question_text}" => $question_text,
                                                                    "{vote}" => $vote_value,
                                                                ]);
                                                            } else {
                                                                echo __("Answered {vote}% to slide poll.", [
                                                                    "{vote}" => $vote_value,
                                                                ]);
                                                            }
                                                        }
                                                    ?>
													 
                                                <?php elseif ($l->get("data.react.is_question")): ?>
                                                    <?php
                                                        $question_text = htmlchars($l->get("data.react.question.question_text"));
                                                        $vote_text = htmlchars($l->get("data.react.question.vote_text"));
                                                        $status = $l->get('status');
                                                        if($status == 'error') {
                                                            echo $question_text;
                                                        } else {
                                                            if (!empty($question_text)) {
                                                                echo __("Answered '{vote}' to question '{question_text}'.", [
                                                                    "{question_text}" => $question_text,
                                                                    "{vote}" => $vote_text,
                                                                ]);
                                                            } else {
                                                                echo __("Answered '{vote}' to question.", [
                                                                    "{vote}" => $vote_text,
                                                                ]);
                                                            }
                                                        }


                                                    ?>
												 
                                                <?php elseif ($l->get("data.react.is_quiz")): ?>
                                                    <?php
                                                        $question_text = htmlchars($l->get("data.react.quiz.question_text"));
                                                        $vote_text = htmlchars($l->get("data.react.quiz.vote_text"));

                                                        $status = $l->get('status');
                                                        if($status == 'error') {
                                                            echo $question_text;
                                                        } else {
                                                            if (!empty($question_text)) {
                                                                echo __("Answered '{vote}' to quiz '{question_text}'.", [
                                                                    "{question_text}" => $question_text,
                                                                    "{vote}" => $vote_text,
                                                                ]);
                                                            } else {
                                                                echo __("Answered '{vote}' to quiz.", [
                                                                    "{vote}" => $vote_text,
                                                                ]);
                                                            }

                                                        }
                                                    ?>
                                                  
												 <?php elseif ($l->get("data.react.is_countdown")): ?>
                                                    <?php
                                                        $question_text = htmlchars($l->get("data.react.quiz.question_text"));
                                                        $vote_text = htmlchars($l->get("data.react.countdown.vote_text"));

                                                        $status = $l->get('status');
                                                        if($status == 'error') {
                                                            echo $question_text;
                                                        } else {
                                                            if (!empty($question_text)) {
                                                                echo __("Followed Countdown '{vote}'.", [
                                                                    "{question_text}" => $question_text,
                                                                    "{vote}" => $vote_text,
                                                                ]);
                                                            } else {
                                                                 echo __("Followed '{vote}' Countdown.", [
                                                                    "{vote}" => $vote_text,
                                                                ]);
                                                            }

                                                        }
                                                    ?>
													
													  <?php elseif ($l->get("data.react.is_like")): ?>
                                                    <?php
                                                        $media_owner = $l->get("data.react.media_owner");
                                                        $like_loop_counter = $l->get("data.react.like_loop_counter");
                                                        $like_source = $l->get("data.react.like_source");
                                                        $is_c_like_done = $l->get("data.react.is_c_like_done");
                                                        $c_liked_post_code = $l->get("data.react.c_liked_post_code");
                                                        if ($is_c_like_done && !empty($c_liked_post_code)) {
                                                            if ($like_source) {
                                                                echo __("Liked last {count} post(s) and {last_post} comment from {user}'s profile feed.", [
                                                                    "{user}" => '<a href="https://instagram.com/' . htmlchars($media_owner) . '" target="_blank">' . "@" . htmlchars($media_owner ) . '</a>',
                                                                    "{count}" => $like_loop_counter,
                                                                    "{last_post}" => '<a href="https://instagram.com/p/' . htmlchars($c_liked_post_code) . '" target="_blank">' . __("last post") . '</a>'
                                                                ]);
                                                            } else {
                                                                echo __("Liked last {count} post(s) and {last_post} comment from self timeline.", [
                                                                    "{count}" => $like_loop_counter,
                                                                    "{last_post}" => '<a href="https://instagram.com/p/' . htmlchars($c_liked_post_code) . '" target="_blank">' . __("last post") . '</a>'
                                                                ]);
                                                            }
                                                        } else {
                                                            if ($like_source) {
                                                                echo __("Liked last {count} post(s) from {user}'s profile feed.", [
                                                                    "{user}" => '<a href="https://instagram.com/' . htmlchars($media_owner) . '" target="_blank">' . "@" . htmlchars($media_owner ) . '</a>',
                                                                    "{count}" => $like_loop_counter
                                                                ]);
                                                            } else {
                                                                echo __("Liked last {count} post(s) from self timeline.", [
                                                                    "{count}" => $like_loop_counter
                                                                ]);
                                                            }
                                                        }
                                                    ?> 
													
                                                <?php elseif ($l->get("data.react.is_follow")): ?>
                                                    <?php
                                                        $f_username = $l->get("data.react.followed_user");
                                                        $mute_type = $l->get("data.debug.mute_type");
                                                        echo __("Followed {username}'s profile.", [
                                                            "{username}" => '<a href="https://instagram.com/' . htmlchars($f_username) . '" target="_blank">' . "@" . htmlchars($f_username) . '</a>'
                                                        ]);
                                                        if ($mute_type == "all") {
                                                            echo " " . __("User stories and posts muted.");
                                                        } elseif ($mute_type == "post") {
                                                            echo " " . __("User posts muted.");
                                                        } elseif ($mute_type == "story") {
                                                            echo " " . __("User stories muted.");
                                                        }
                                                    ?> 
													 <?php elseif ($l->get("data.react.is_comment_like")): ?>
                                                     <?php
													 
                                                        $c_liked_post_code = $l->get("data.react.c_liked_post_code");
													  
                                                        $comm_username = $l->get("data.react.media_owner");
                                                      
                                                        echo __("Comment liked {username}'s {post}.", [
                                                            "{username}" => '<a href="https://instagram.com/' . htmlchars($comm_username) . '" target="_blank">' . "@" . htmlchars($comm_username) . '</a>',
															"{post}" => '<a href="https://instagram.com/p/' . htmlchars($c_liked_post_code) . '" target="_blank">' . __("posts") . '</a>'
															
                                                        ]);
                                                      
                                                    ?> 
                                                       
                                                   
                                                 <?php elseif ($l->get("data.react.is_comment")): ?>
                                                    <?php
													   $comment_post_code = $l->get("data.react.comment_post_code");
                                                        $comm_username = $l->get("data.react.media_owner");
                                                        $comment_text = $l->get("data.react.commentText");
                                                        echo __("Commented {username}'s {post}.", [
                                                            "{username}" => '<a href="https://instagram.com/' . htmlchars($comm_username) . '" target="_blank">' . "@" . htmlchars($comm_username) . '</a>',
															"{post}" => '<a href="https://instagram.com/p/' . htmlchars($comment_post_code) . '" target="_blank">' . __("posts") . '</a>'
															
                                                        ]);
                                                      
                                                    ?> 
                                                 <?php elseif ($l->get("data.react.is_unfollow")): ?>
                                                    <?php
                                                        $uf_username = $l->get("data.react.unfollowed_user");
                                                        echo __("Unfollowed {username}'s profile.", [
                                                            "{username}" => '<a href="https://instagram.com/' . htmlchars($uf_username) . '" target="_blank">' . "@" . htmlchars($uf_username) . '</a>'
                                                        ]);
                                                    ?> 
                                             <?php endif ?>
                                                <?php if ($l->get("data.react.total_count")): ?>
                                                        <div class="error-details">
                                                            <?php
                                                                $total_count = htmlchars($l->get("data.react.total_count"));
                                                                echo __("Total: {count} actions.", [
                                                                    "{count}" => $total_count
                                                                ]);
                                                            ?>
                                                       </div>
                                             <?php endif ?>
                                            <?php endif ?>
                                        <?php else: ?>
                                            <?php if ($l->get("data.error.msg")): ?>
                                                <div class="error-msg">
                                                    <?= __($l->get("data.error.msg")) ?>
                                                </div>
                                            <?php endif ?>
                                            <?php if ($l->get("data.error.details")): ?>
                                                <div class="error-details"><?= __($l->get("data.error.details")) ?></div>
                                            <?php endif ?>
                                        <?php endif ?>
                                    </div>
									  <?php if ($l->get("data.pid")): ?>
                                        <a class="meta">
                                            <span class="icon mdi mdi-account-convert"></span>
                                            <?= __("PID: ") . htmlchars($l->get("data.pid")) . " · " ?>
                                            <span class="date" title="<?= $fulldate ?>"><?= $date->format($AuthUser->get("preferences.timeformat") == "12" ? "h:iA" : "H:i:s") ?></span>
                                            <?php if ($count_1): ?>
                                                <?= " · " . __('Polls') . ": " . $count_1 ?>
                                            <?php endif ?>
                                            <?php if ($count_2): ?>
                                                <?= " · " . __('Slider Polls') . ": " . $count_2 ?>
                                            <?php endif ?>
                                            <?php if ($count_3): ?>
                                                <?= " · " . __('Quiz') . ": " . $count_3 ?>
                                            <?php endif ?>
                                            <?php if ($count_4): ?>
                                                <?= " · " . __('Question&Answers') . ": " . $count_4 ?>
                                            <?php endif ?>
                                            <?php if ($count_5): ?>
                                                <?= " · " . __('Countdown') . ": " . $count_5 ?>
                                            <?php endif ?>
											<?php if ($count_6): ?>
                                                <?= " · " . __('Masslooking V1') . ": " . $count_6 ?>
                                            <?php endif ?>
											<?php if ($count_7): ?>
                                                <?= " · " . __('Masslooking V2') . ": " . $count_7 ?>
                                            <?php endif ?>
											<?php if ($count_9): ?>
                                                <?= " · " . __('Likes') . ": " . number_format($count_9, 0, '.', ' ') ?>
                                            <?php endif ?>
                                            <?php if ($count_10): ?>
                                                <?= " · " . __('Comment likes') . ": " . number_format($count_10, 0, '.', ' ') ?>
                                            <?php endif ?>
                                            <?php if ($count_11): ?>
                                                <?= " · " . __('Follows') . ": " . number_format($count_11, 0, '.', ' ') ?>
                                            <?php endif ?>
											
											  <?php if ($count_12): ?>
                                                <?= " · " . __('Unfollows') . ": " . number_format($count_12, 0, '.', ' ') ?>
                                            <?php endif ?>
											<?php if ($count_13): ?>
                                                <?= " · " . __('Comments') . ": " . number_format($count_13, 0, '.', ' ') ?>
                                            <?php endif ?>
											<?php if ($count_14): ?>
                                                <?= " · " . __('Bio Mention') . ": " . number_format($count_14, 0, '.', ' ') ?>
                                            <?php endif ?>
                                        </a>
                                    <?php endif ?>

                                    
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="svp-amount-of-action">
                    <?= __("Total %s notes in logs.", $ActivityLog->getTotalCount()) ?>
                </div>

                <?php if($ActivityLog->getPage() < $ActivityLog->getPageCount()): ?>
                    <div class="loadmore mt-20 mb-20">
                        <?php
                            $url = parse_url($_SERVER["REQUEST_URI"]);
                            $path = $url["path"];
                            if(isset($url["query"])){
                                $qs = parse_str($url["query"], $qsarray);
                                unset($qsarray["page"]);

                                $url = $path."?".(count($qsarray) > 0 ? http_build_query($qsarray)."&" : "")."page=";
                            }else{
                                $url = $path."?page=";
                            }
                        ?>
                        <a class="fluid button button--light-outline js-loadmore-btn" data-loadmore-id="2" href="<?= $url.($ActivityLog->getPage()+1) ?>">
                            <span class="icon sli sli-refresh"></span>
                            <?= __("Load More") ?>
                        </a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="no-data">
                    <p><?= __("Activity log for %s is empty.",
                    "<a href='https://www.instagram.com/".htmlchars($Account->get("username"))."' target='_blank'>@".htmlchars($Account->get("username"))."</a>") ?></p>
                </div>
            <?php endif ?>
        </section>
    </div>
</div>