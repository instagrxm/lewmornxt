<?php if (!defined('APP_VERSION')) die("Yo, what's up?"); ?>

<div class='skeleton' id="account">
    <form class="js-ajax-form"
          action="<?= APPURL . "/e/" . $idname . "/settings" ?>"
          method="POST">
        <input type="hidden" name="action" value="save">

        <div class="container-1200">
            <div class="row clearfix">
                <div class="form-result">
                </div>

                <div class="col s12 m8 l4 box-list-item mb-20">
                    <section class="section">
                        <div class="section-header clearfix">
                            <h2 class="section-title"><?= __("Settings") ?></h2>
                        </div>

                        <div class="section-content border-after">
                            <div class="mb-10 clearfix">
                                <div class="col s12 m12 l12">
                                    <label class="form-label"><?= __("Maximum speed") ?></label>

                                    <select name="maximum-speed" class="input">
                                        <?php
                                            $s = $Settings->get("data.maximum_speed");
                                        ?>
                                            <option value="maximum" <?= "maximum" == $s ? "selected" : "" ?>>
                                                <?= __("Maximum") ?>
                                            </option>
                                        <?php for ($i=10000; $i<=800000; $i=($i+10000)): ?>
                                            <option value="<?= $i ?>" <?= $i == $s ? "selected" : "" ?>>
                                                <?php $f_number = number_format($i, 0, '.', ' '); ?>
                                                <?= __("%s react/day", $f_number) ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>

                            <ul class="field-tips">
                                <li><?= __("These values indicates maximum amount of the story views per day. They are not exact values. Depending on the server overload and delays between the requests, actual number of the view requests might be less than these values.") ?></li>
                                <li><?= __("Developers are not responsible for any issues related to the Instagram accounts.") ?></li>
                            </ul>
                        </div>

                        <div class="section-header clearfix">
                            <h2 class="section-title"><?= __("Extra Settings") ?></h2>
                        </div>

                        <div class="section-content border-after">
                            <div class="mb-10">
                                <label>
                                    <input type="checkbox"
                                           class="checkbox"
                                           name="hide_pause_settings"
                                           value="1"
                                           <?= $Settings->get("data.hide_pause_settings") ? "checked" : "" ?>>
                                    <span>
                                        <span class="icon unchecked">
                                            <span class="mdi mdi-check"></span>
                                        </span>
                                        <?= __('Hide pause settings on schedule page') ?>
                                    </span>
                                </label>
                                <label>
                                    <input type="checkbox"
                                           class="checkbox"
                                           name="mass_story_view"
                                           value="1"
                                           <?= $Settings->get("data.mass_story_view") ? "checked" : "" ?>>
                                    <span>
                                        <span class="icon unchecked">
                                            <span class="mdi mdi-check"></span>
                                        </span>
                                        <?= __('Hide Mass Story View on schedule page') ?>
                                    </span>
                                </label>
                                <label>
                                    <input type="checkbox"
                                           class="checkbox"
                                           name="question_answers"
                                           value="1"
                                           <?= $Settings->get("data.question_answers") ? "checked" : "" ?>>
                                    <span>
                                        <span class="icon unchecked">
                                            <span class="mdi mdi-check"></span>
                                        </span>
                                        <?= __('Hide Mass Question Answers on schedule page') ?>
                                    </span>
                                </label>
                                <label>
                                    <input type="checkbox"
                                           class="checkbox"
                                           name="mass_poll_votes"
                                           value="1"
                                           <?= $Settings->get("data.mass_poll_votes") ? "checked" : "" ?>>
                                    <span>
                                        <span class="icon unchecked">
                                            <span class="mdi mdi-check"></span>
                                        </span>
                                        <?= __('Hide Mass Poll Votes on schedule page') ?>
                                    </span>
                                </label>
                                <label>
                                    <input type="checkbox"
                                           class="checkbox"
                                           name="mass_slide_points"
                                           value="1"
                                           <?= $Settings->get("data.mass_slide_points") ? "checked" : "" ?>>
                                    <span>
                                        <span class="icon unchecked">
                                            <span class="mdi mdi-check"></span>
                                        </span>
                                        <?= __('Hide Mass Slider Points on schedule page') ?>
                                    </span>
                                </label>
                                <label>
                                    <input type="checkbox"
                                           class="checkbox"
                                           name="mass_quiz_answers"
                                           value="1"
                                           <?= $Settings->get("data.mass_quiz_answers") ? "checked" : "" ?>>
                                    <span>
                                        <span class="icon unchecked">
                                            <span class="mdi mdi-check"></span>
                                        </span>
                                        <?= __('Hide Mass Quiz Answers on schedule page') ?>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="section-content border-after">
                            <div class="mb-10 clearfix">
                                <div class="col s12 m12 l12">
                                    <?php $license_key = $Settings->get("data.license_key"); ?>
                                    <label class="form-label"><?= __("License Key") ?></label>
                                    <input class="input rightpad license-key" name="license-key" id="license-key" type="text" maxlength="50" placeholder="<?= __("Enter the key") ?>" value="<?= htmlchars($license_key) ?>">
                                </div>
                            </div>

                            <ul class="field-tips">
                                <?php 
                                    $license = $Settings->get("data.license"); 
                                    if ($license != "valid"):
                                ?>
                                    <li><?= __("Please type a valid license key, which you can find in your %s.", "<a href='https://hypervoter.com/' target='_blank'>Hypervoter Dashboard</a>") ?></li>
                                <?php else: ?>
                                    <?php if ($Settings->get("data.item_name")): ?>
                                        <li><?= __("Product name: ") ?><?= htmlchars($Settings->get("data.item_name")) ?></li>
                                    <?php endif; ?>
                                    <?php if ($Settings->get("data.expires") && $Settings->get("data.license") == "valid"): ?>
                                        <li class="color-green"><?= __("License expire: ") ?><?= htmlchars($Settings->get("data.expires")) ?></li>
                                    <?php endif; ?>
                                    <?php if ($Settings->get("data.payment_id")): ?>
                                        <li><?= __("Payment ID: ") ?><?= htmlchars($Settings->get("data.payment_id")) ?></li>
                                    <?php endif; ?>
                                    <?php if ($Settings->get("data.customer_name")): ?>
                                        <li><?= __("Customer name: ") ?><?= htmlchars($Settings->get("data.customer_name")) ?></li>
                                    <?php endif; ?>
                                    <?php if ($Settings->get("data.customer_email")): ?>
                                        <li><?= __("Customer email: ") ?><?= htmlchars($Settings->get("data.customer_email")) ?></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
						<div class="section-header clearfix">
                            <h2 class="section-title"><?= __("Telegram Notifications") ?></h2>
                        </div>

                        <div class="section-content border-after">
                            <?php 
                                $telegram_username = $Settings->get("data.telegram_username"); 
                                $telegram_access_token = $Settings->get("data.telegram_access_token");
                            ?>
                            <label class="form-label"><?= __("Telegram Bot Settings") ?></label>
                            <input class="input telegram-username" name="telegram-username" id="telegram-username" type="text" maxlength="100" placeholder="<?= __("Enter the bot username") ?>" value="<?= htmlchars($telegram_username) ?>">
                            <input class="input telegram-access-token mt-5" name="telegram-access-token" id="telegram-access-token" type="text" maxlength="100" placeholder="<?= __("Enter the bot access token") ?>" value="<?= htmlchars($telegram_access_token) ?>">
                            <ul class="field-tips">
                                <li><?= __("To create a Telegram Bot find user named as %s and type <b>/start</b>.", "<a href='https://t.me/botfather' target='_blank'>@BotFather</a>") ?></li>
                                <li><?= __("Create a bot with <b>/newbot</b> or use existing one with <b>/mybots</b> command.") ?></li>
                                <li><?= __("You can set bot name, description, picture and etc. More details in Telegram in %s.", "<a href='https://t.me/botfather' target='_blank'>@BotFather</a>") ?></li>
                            </ul>
                        </div>

                        <?php 
                            foreach (\Config::get("applangs") as $al): 
                            $langcode = $al["code"];
                            $langname = $al["name"];
                            $telegram_subscription = $Settings->get("data.telegram_subscription_template.$langcode");
                            $telegram_subscription = json_decode($telegram_subscription);
                            if (empty($telegram_subscription)) {
                                $telegram_subscription = "Hi {{firstname}},\n\nMassvoting reports for <a href=\"http://instagram.com/{{account_username}}\">@{{account_username}}</a> enabled.\n\nHave a good day!\nTeam of <a href=\"{{siteurl}}\">{{sitename}}</a>.";
                                $telegram_subscription = json_decode(json_encode($telegram_subscription));
                            }
                            $telegram_analytics = $Settings->get("data.telegram_analytics_template.$langcode");
                            $telegram_analytics = json_decode($telegram_analytics);
                            if (empty($telegram_analytics)) {
                                $telegram_analytics = "Massvoting report for <a href=\"http://instagram.com/{{account_username}}\">@{{account_username}}</a>\n\nCurrent estimated speed: {{speed_value}} react/day\n\nVoted polls: {{polls_count}}\nVoted polls_sliders: {{polls_sliders_count}}\nVoted quizzes: {{quizzes_count}}\nAnswered questions: {{answers_count}}\nFollowed countdowns: {{countdowns_count}}\nMasslooking: {{masslooking}}\nMasslookingv2: {{masslookingv2}}\n\nTotal analyzed users count is {{total_analyzed_users}}.\n\nHave a good day!\nTeam of <a href=\"{{siteurl}}\">{{sitename}}</a>.";
                                $telegram_analytics = json_decode(json_encode($telegram_analytics));
                            }
                            $telegram_error = $Settings->get("data.telegram_error_template.$langcode");
                            $telegram_error = json_decode($telegram_error);
                            if (empty($telegram_error)) {
                                $telegram_error = "🤔 Oops... {{firstname}},\n\nWe detected an error at massvoting process for <a href=\"http://instagram.com/{{account_username}}\">@{{account_username}}</a>.\n\nReason: {{error_title}}\nResponse: {{error_response}}\n\nPlease login to your dashboard of <a href=\"{{siteurl}}\">{{sitename}}</a> to fix this error.\n\nSincerely,\nTeam of <a href=\"{{siteurl}}\">{{sitename}}</a>.";
                                $telegram_error = json_decode(json_encode($telegram_error));
                            }
                        ?>
                        <div class="section-content border-after">
                            <label class="form-label"><?= __('Telegram Subscription Notice Template (%s)', $langname) ?></label>
                            <textarea
                                rows="12"
                                class="input"
                                maxlength ="4096"
                                name="telegram-subscription-template-<?= $langname ?>"
                                placeholder="<?= __("Enter the notice text") ?>"><?= htmlchars($telegram_subscription) ?></textarea>
                            <ul class="field-tips">
                                <li><?= __("Telegram HTML-style, spintax and emoji supported") ?></li>
                                <li><?= __("You can use following variables:") ?></li>
                                <div class="mt-5"><strong>{{sitename}}</strong><?= " " . __("Nextpost sitename") ?></div>
                                <div class="mt-5"><strong>{{siteurl}}</strong><?= " " . __("Nextpost website url") ?></div>
                                <div class="mt-5"><strong>{{firstname}}</strong><?= " " . __("Nextpost firstname") ?></div>
                                <div class="mt-5"><strong>{{lastname}}</strong><?= " " . __("Nextpost lastname") ?></div>  
                                <div class="mt-5"><strong>{{account_username}}</strong><?= " " . __("Instagram-account username without @") ?></div>
                            </ul>
                        </div>
                        <div class="section-content border-after">
                            <label class="form-label"><?= __('Telegram Analytics Notice Template (%s)', $langname) ?></label>
                            <textarea
                                rows="12"
                                class="input"
                                maxlength ="4096"
                                name="telegram-analytics-template-<?= $langname ?>"
                                placeholder="<?= __("Enter the notice text") ?>"><?= htmlchars($telegram_analytics) ?></textarea>
                            <ul class="field-tips">
                                <li><?= __("Telegram HTML-style, spintax and emoji supported") ?></li>
                                <li><?= __("You can use following variables:") ?></li>
                                <div class="mt-5"><strong>{{sitename}}</strong><?= " " . __("Nextpost sitename") ?></div>
                                <div class="mt-5"><strong>{{siteurl}}</strong><?= " " . __("Nextpost website url") ?></div>
                                <div class="mt-5"><strong>{{firstname}}</strong><?= " " . __("Nextpost firstname") ?></div>
                                <div class="mt-5"><strong>{{lastname}}</strong><?= " " . __("Nextpost lastname") ?></div>  
                                <div class="mt-5"><strong>{{account_username}}</strong><?= " " . __("Instagram-account username") ?></div>
                                <div class="mt-5"><strong>{{polls_count}}</strong><?= " " . __("Reacted polls count") ?></div>
                                <div class="mt-5"><strong>{{polls_sliders_count}}</strong><?= " " . __("Reacted polls sliders count") ?></div>
                                <div class="mt-5"><strong>{{quizzes_count}}</strong><?= " " . __("Reacted quizes count") ?></div>
                                <div class="mt-5"><strong>{{answers_count}}</strong><?= " " . __("Answered questions count") ?></div>
                                <div class="mt-5"><strong>{{countdowns_count}}</strong><?= " " . __("Followed countdown count.") ?></div>
                                <div class="mt-5"><strong>{{masslooking}}</strong><?= " " . __("Masslooking") ?></div>
								 <div class="mt-5"><strong>{{masslookingv2}}</strong><?= " " . __("Masslookingv2") ?></div>
								   <div class="mt-5"><strong>{{likes_count}}</strong><?= " " . __("Likes count") ?></div>
                                <div class="mt-5"><strong>{{comments_likes_count}}</strong><?= " " . __("Comments likes count") ?></div>
                                <div class="mt-5"><strong>{{follows_count}}</strong><?= " " . __("Follows count") ?></div>
                                <div class="mt-5"><strong>{{unfollows_count}}</strong><?= " " . __("Unfollows count") ?></div>
								 <div class="mt-5"><strong>{{comment_count}}</strong><?= " " . __("Comment count") ?></div>
                                <div class="mt-5"><strong>{{speed_value}}</strong><?= " " . __("Esimated speed value") ?></div>
                                <div class="mt-5"><strong>{{total_analyzed_users}}</strong><?= " " . __("Total analyzed users") ?></div>
                            </ul>
                        </div>
                        <div class="section-content border-after">
                            <label class="form-label"><?= __('Telegram Error Notice Template (%s)', $langname) ?></label>
                            <textarea
                                rows="7"
                                class="input"
                                maxlength ="4096"
                                name="telegram-error-template-<?= $langname ?>"
                                placeholder="<?= __("Enter the notice text") ?>"><?= htmlchars($telegram_error) ?></textarea>
                            <ul class="field-tips">
                                <li><?= __("Telegram HTML-style, spintax and emoji supported") ?></li>
                                <li><?= __("You can use following variables:") ?></li>
                                <div class="mt-5"><strong>{{error_title}}</strong><?= " " . __("Error title") ?></div>
                                <div class="mt-5"><strong>{{error_response}}</strong><?= " " . __("Error response") ?></div>
                                <div class="mt-5"><strong>{{sitename}}</strong><?= " " . __("Nextpost sitename") ?></div>
                                <div class="mt-5"><strong>{{siteurl}}</strong><?= " " . __("Nextpost website url") ?></div>
                                <div class="mt-5"><strong>{{firstname}}</strong><?= " " . __("Nextpost firstname") ?></div>
                                <div class="mt-5"><strong>{{lastname}}</strong><?= " " . __("Nextpost lastname") ?></div>  
                                <div class="mt-5"><strong>{{account_username}}</strong><?= " " . __("Instagram-account username") ?></div>
                                <div class="mt-5"><strong>{{polls_count}}</strong><?= " " . __("Reacted polls count") ?></div>
                                <div class="mt-5"><strong>{{polls_sliders_count}}</strong><?= " " . __("Reacted polls sliders count") ?></div>
                                <div class="mt-5"><strong>{{quizzes_count}}</strong><?= " " . __("Reacted quizes count") ?></div>
                                <div class="mt-5"><strong>{{answers_count}}</strong><?= " " . __("Answered questions count") ?></div>
                                <div class="mt-5"><strong>{{countdowns_count}}</strong><?= " " . __("Followed countdown count.") ?></div>
                                <div class="mt-5"><strong>{{masslooking}}</strong><?= " " . __("Masslooking") ?></div>
								 <div class="mt-5"><strong>{{masslookingv2}}</strong><?= " " . __("Masslookingv2") ?></div>
								   <div class="mt-5"><strong>{{likes_count}}</strong><?= " " . __("Likes count") ?></div>
                                <div class="mt-5"><strong>{{comments_likes_count}}</strong><?= " " . __("Comments likes count") ?></div>
                                <div class="mt-5"><strong>{{follows_count}}</strong><?= " " . __("Follows count") ?></div>
                                  <div class="mt-5"><strong>{{unfollows_count}}</strong><?= " " . __("Unfollows count") ?></div>
								 <div class="mt-5"><strong>{{comment_count}}</strong><?= " " . __("Comment count") ?></div>
                                <div class="mt-5"><strong>{{speed_value}}</strong><?= " " . __("Esimated speed value") ?></div>
                                <div class="mt-5"><strong>{{total_analyzed_users}}</strong><?= " " . __("Total analyzed users") ?></div>
                            </ul>
                        </div>
                        <?php endforeach; ?>
                          <div class="section-header clearfix">
                            <h2 class="section-title"><?= __("Maintenance Settings") ?></h2>
                        </div>

                        <div class="section-content">
                            <div class="mb-10">
                                <label>
                                    <input type="checkbox" 
                                           class="checkbox" 
                                           name="is-temporary-pause" 
                                           value="1" 
                                           <?= $Settings->get("data.is_temporary_pause") ? "checked" : "" ?>>
                                    <span>
                                        <span class="icon unchecked">
                                            <span class="mdi mdi-check"></span>
                                        </span>
                                        <?= __('Temporary pause all actions and disable module functionality') ?>
                                    </span>
                                </label>
                            </div>
                            <div class="mb-20">
                                <label>
                                    <input type="checkbox" 
                                           class="checkbox" 
                                           name="is-temporary-notice" 
                                           value="1" 
                                           <?= $Settings->get("data.is_temporary_notice") ? "checked" : "" ?>>
                                    <span>
                                        <span class="icon unchecked">
                                            <span class="mdi mdi-check"></span>
                                        </span>
                                        <?= __('Show temporary notice to all users') ?>
                                    </span>
                                </label>
                            </div>
                            <?php 
                                foreach (\Config::get("applangs") as $al): 
                                $langcode = $al["code"];
                                $langname = $al["name"];
                            ?>
                            <div class="mb-20">
                                <label class="form-label"><?= __('Temporary message (%s)', $langname) ?></label>
                                <textarea
                                    rows="7"
                                    class="input"
                                    name="temporary-notice-<?= $langname ?>"
                                    placeholder="<?= __("Enter the value") ?>"><?= htmlchars($Settings->get("data.temporary_notice.$langcode")) ?></textarea>
                            </div>
                            <script>
                                CKEDITOR.replace('temporary-notice-<?= $langname ?>');
                            </script>
                            <?php endforeach; ?>
                        </div>
                        <input class="fluid button button--footer" type="submit" value="<?= __("Save") ?>">
                    </section>
                </div>

                <div class="col s12 m8 l8 mr-0 hypervote-section box-list-item mb-20">
                    <section class="section">
                        <div class="section-header clearfix">
                            <h2 class="section-title"><?= __("Task Manager") ?></h2>


                            <a class="mdi mdi-reload button small button--light-outline js-hypervote-bulk-restart" data-url="<?= APPURL."/e/".$idname."/settings" ?>">
                                <?= __('Bulk restart'); ?>
                            </a>
                        </div>
						
                        <div class="section-content hypervote-overflow">
                            <?php
                                use dgr\nohup\Process;

                                require_once PLUGINS_PATH."/".$idname."/vendor/autoload.php";

                                $active_task = "<span class='status color-green'><span class='mdi mdi-circle mr-2'></span>" . __('Active') . "</span>";
                                $deactive_task = "<span class='status'><span class='mdi mdi-circle-outline mr-2'></span>" . __('Deactive') . "</span>";
                                $invalid_task = "<span class='status color-red'><span class='mdi mdi-circle-outline mr-2'></span>" . __('Invalid') . "</span>";
                                $scheduled_task = "<span class='status'><span class='mdi mdi-clock mr-2'></span>" . __('Scheduled') . "</span>";
                                $paused_task = "<span class='status'><span class='mdi mdi-clock mr-2'></span>" . __('Paused') . "</span>";
                            ?>
                            <?php if ($Schedules->getTotalCount() > 0): ?>
                                <style>table thead td, table tbody td {padding: 10px 25px !important;}</style>

                                <table class="datatable-hypervote mb-0" id="dataTableHypervote">

                                    <thead>
                                        <tr>
                                            <td class="tm-hypervote-id"><?=__('ID'); ?></td>
                                            <td class="tm-hypervote-account"><?=__('Account'); ?></td>
                                            <td class="tm-hypervote-task"><?=__('Task'); ?></td>
                                            <td class="tm-hypervote-pid"><?=__('PID'); ?></td>
                                            <td class="tm-hypervote-last-action"><?=__('Last Action'); ?></td>
                                            <td class="tm-hypervote-action"><?=__('Actions'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody class="js-loadmore-content" data-loadmore-id="1">
                                        <?php foreach ($Schedules->getDataAs($Schedule) as $sc): ?>
                                            <?php
                                                $Account = \Controller::model("Account", $sc->get("account_id"));
                                                $pid_status = $deactive_task;
                                                if ($sc->get("is_active") && !$sc->get("is_running") && !$sc->get("is_executed") && $sc->get("schedule_date") > date("Y-m-d H:i:s", time() + 60)) {
                                                    $pid_status = $paused_task;
                                                } elseif ($sc->get("is_active") && !$sc->get("is_running") && !$sc->get("is_executed")) {
                                                    $pid_status = $scheduled_task;
                                                }
                                                $pid = $sc->get("process_id");
                                                if ($pid) {
                                                    $process = Process::loadFromPid($pid);
                                                    if ($process->isRunning()) {
                                                        $pid_status = $active_task;
                                                    } else {
                                                        $pid_status = $invalid_task;
                                                    }
                                                }

                                                // Get Last Log Data
                                                $LL_D = null;
                                                $LL_D_F = null;
                                                if (isset($LL_Ds[$sc->get("account_id")])) {
                                                    $LL_D = new \Moment\Moment($LL_Ds[$sc->get("account_id")], date_default_timezone_get());
                                                    $LL_D->setTimezone($AuthUser->get("preferences.timezone"));
                                                    $LL_D_F = $LL_D->format($AuthUser->get("preferences.timeformat") == "12" ? "h:i:sA d.m.Y" : "H:i:s d.m.Y");
                                                    $LL_D = $LL_D->format($AuthUser->get("preferences.timeformat") == "12" ? "h:i:sA" : "H:i:s");
                                                }
                                            ?>
                                            <tr>
                                                <td class="tm-hypervote-id"><?= htmlchars($sc->get("account_id")); ?></td>
                                                <td class="tm-hypervote-account"><?= "<a href='https://instagram.com/" . $Account->get("username") . "' target='_blank'>@" . htmlchars($Account->get("username")); ?></a></td>
                                                <td class="tm-hypervote-task" data-id="<?= htmlchars($sc->get("account_id")); ?>">
                                                    <?php if ($sc->get("is_active")): ?>
                                                        <?php if ($sc->get("data.estimated_speed")): ?>
                                                            <span class="tooltip tippy color-green"
                                                                data-position="top"
                                                                data-size="small"
                                                                title="<?= __('Estimated speed (react/day):') . " " . htmlchars($sc->get("data.estimated_speed")); ?>">
                                                            <?= $active_task ?>
                                                        <?php else: ?>
                                                            <?= $active_task ?>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <?= $deactive_task ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="tm-hypervote-pid" data-id="<?= htmlchars($sc->get("account_id")); ?>">
                                                    <?php if ($sc->get("process_id")): ?>
                                                        <span class="tooltip tippy color-green"
                                                            data-position="top"
                                                            data-size="small"
                                                            title="<?= __('Process ID: ') . htmlchars($sc->get("process_id")); ?>">
                                                            <?= $pid_status ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <?= $pid_status ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="tm-hypervote-last-action">
                                                    <span class="tooltip tippy"
                                                            data-position="top"
                                                            data-size="small"
                                                            title="<?= $LL_D_F ? $LL_D_F : __('Not set') ?>">
                                                    <?= $LL_D ? $LL_D : "" ?>
                                                    </span>
                                                </td>
                                                <td class="tm-hypervote-action">
                                                    <a class="button small button--light-outline js-hypervote-restart" data-id="<?= htmlchars($sc->get("account_id")); ?>" data-url="<?= APPURL."/e/".$idname."/settings" ?>">
                                                        <?= __('Restart'); ?>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="no-data-hypervote">
                                    <p class="pb-20"><?= __("You are not schedule any hypervote task.") ?></p>
                                    <a class="small button" href="<?= APPURL."/e/" . $idname . "/" ?>">
                                        <span class="mdi mdi-cellphone-iphone"></span>
                                        <?= __("Setup Hypervote Tasks") ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="section-content pt-0 pb-0">
                            <?php if ($Schedules->getPage() < $Schedules->getPageCount() && $Schedules->getTotalCount() > 0): ?>
                                <div class="loadmore mt-25 mb-25">
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
                                    <a class="fluid button button--light-outline js-loadmore-btn js-loadmore-btn-task-manager" data-loadmore-id="1" href="<?= $url.($Schedules->getPage()+1) ?>">
                                        <span class="icon sli sli-refresh"></span>
                                        <?= __("Load More") ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="section-content server-info">
                            <?php
                                echo '<b>PHP version:</b> ' . phpversion() . '</br>';

                                echo '<b>Server usage:</b></br>';
                                echo $server_info[1] . '</br>';
                                echo $server_info[2] . '</br>';
                                echo $server_info[3] . '</br>';
                                echo $server_info[4];
                            ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </form>
</div>