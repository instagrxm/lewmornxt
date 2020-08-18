<?php if ( ! defined( 'APP_VERSION' ) ) {
	die( "Yo, what's up?" );} ?>

<div class="skeleton skeleton--full" id="story-stats">
	<div class="clearfix">
		<aside class="skeleton-aside hide-on-medium-and-down">
			<?php
				$form_action = APPURL . '/e/' . $idname;
				require PLUGINS_PATH . '/' . $idname . '/views/fragments/aside-search-form.fragment.php';
			?>

			<div class="js-search-results">
				<div class="aside-list js-loadmore-content" data-loadmore-id="1"></div>
			</div>

			<div class="loadmore pt-20 mb-20 none">
				<a class="fluid button button--light-outline js-loadmore-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?php echo APPURL . '/e/' . $idname . '?aid=' . $Account->get( 'id' ) . '&ref=stats'; ?>">
					<span class="icon sli sli-refresh"></span>
					<?php echo __( 'Load More' ); ?>
				</a>
			</div>
		</aside>

		<section class="skeleton-content">
			<div class="section-header back-button-wh none">
				<a href="<?php echo APPURL . '/e/' . $idname . '/'; ?>">
					<span class="mdi mdi-reply"></span><?php echo __( 'Back' ); ?>
				</a>
			</div>

			<div class="section-header clearfix">
				<h2 class="section-title">
					<?php echo '@' . htmlchars( $Account->get( 'username' ) ); ?>
					<?php if ( $Account->get( 'login_required' ) ) : ?>
						<small class="color-danger ml-15">
							<span class="mdi mdi-information"></span>
							<?php echo __( 'Re-login required!' ); ?>
						</small>
					<?php endif ?>
				</h2>
			</div>

			<div class="svp-tab-heads pb-15 clearfix">
				<a href="<?php echo APPURL . '/e/' . $idname . '/' . $Account->get( 'id' ); ?>"><?php echo __( 'Settings' ); ?></a>
				<a href="<?php echo APPURL . '/e/' . $idname . '/' . $Account->get( 'id' ) . '/log'; ?>"><?php echo __( 'Activity Log' ); ?></a>
				<a href="<?php echo APPURL . '/e/' . $idname . '/' . $Account->get( 'id' ) . '/stats'; ?>" class="active"><?php echo __( 'Stats' ); ?></a>
			</div>

			<div class="section-content">
				<div class="col s12 m6 l8 mb-10">
					<?php if ( ! empty( $Schedule->get( 'data.estimated_speed' ) ) ) : ?>
						<div class="clearfix mb-20 pos-r">
							<label class="svp-stats-title mb-10"><?php echo __( 'Perfomance' ); ?></label>
								<span class="clearfix">
									<span class="svp-stats-main-target">
										<span class="svp-stats-main-icon mdi mdi-speedometer"></span>
										<span class="svp-stats-main-target-text">
											<?php echo __( 'Estimated speed (react/day)' ); ?>
										</span>
									</span>
									<span class="svp-stats-main-count">
										<?php echo ( htmlchars( $Schedule->get( 'data.estimated_speed' ) ) ); ?>
									</span>
								</span>
						</div>
					<?php endif ?>
					<div class="clearfix mb-20 pos-r">
						<label class="svp-stats-title mb-10"><?php echo __( 'Today' ); ?><span class="fz-12 color-mid ml-10" style="line-height: 20px;"><?php echo __( '(reaction)' ); ?></span></label>
						<?php $Account->get( 'id' ); ?>
						<?php if ( $TodayStats->getTotalCount() > 0 ) : ?>
							<?php
								$icons        = [
									'people_getliker' => 'mdi mdi-instagram',
									'people_follower' => 'mdi mdi-instagram',
									 "hashtag" => "mdi mdi-pound",
                                    "location" => "mdi mdi-map-marker"
								];
								$today_views  = 0;
								$target_index = 0;
								?>
							<?php
							foreach ( $Today as $tds ) :
								$target_index += 1;
								?>
								<span class="clearfix">
									<span class="svp-stats-main-target">
									<?php if ( isset( $icons[ $tds->get( 'type' ) ] ) ) : ?>
											<span class="svp-stats-main-index"><?php echo htmlchars( $target_index ); ?></span>
											<span class="svp-stats-main-icon <?php echo $icons[ $tds->get( 'type' ) ]; ?>"></span>
										<?php endif ?>
										<span class="svp-stats-main-target-text">
										<?php
											$type = $tds->get( 'type' );
										if ( $type = 'people_getliker' ) {
											$type_text = __( ' ' );
										} elseif ( $type = 'people_follower' ) {
											$type_text = __( 'follower' );
										} elseif ( $type = 'hashtag' ) {
											$type_text = __( 'hashtag' );
										} elseif ( $type = 'location' ) {
											$type_text = __( 'location' );
										} else {
											$type_text = '';
										}

											$username = $tds->get( 'target' );
										
										 if ("location" == $tds->get("type")) {
                                                    $target_value = $tds->get("data.id") ? $tds->get("data.id") : "";
                                                } else {
                                                    $target_value = $tds->get("target");
                                                }
                                                $target_value = $tds->get("target");
                                                $target_text = $tds->get("target");
                                                $type = strval($type);
                                                if ("hashtag" == $tds->get("type")) {
                                                    if (strlen($tds->get("target")) > 40) {
                                                        $target_text = mb_substr($tds->get("target"), 0, 40) . '...';
                                                    }
                                                } else {
                                                    if (strlen($tds->get("target")) > 25) {
                                                        $target_text = mb_substr($tds->get("target"), 0, 25) . '...';
                                                    }
                                                }
										?>
											
											 <?php if ("hashtag" == $tds->get("type")): ?>
                                                <a class="color-black" href="https://instagram.com/explore/tags/<?= htmlchars($target_value) ?>" target="_blank"><?= $target_text ?></a>
                                            <?php elseif ("location" == $tds->get("type") && !empty($tds->get("data.id"))): ?> 
                                                <a class="color-black" href="https://instagram.com/explore/locations/<?= htmlchars($tds->get("data.id")) ?>" target="_blank"><?= $target_text ?></a>
                                            <?php elseif ("location" == $tds->get("type")): ?> 
                                                <?= htmlchars($tds->get("data.id")) ?><?= $target_text ?>
                                            <?php else: ?> 
                                                <a class="color-black" href="https://instagram.com/<?= htmlchars($target_value) ?>" target="_blank"><?= $target_text ?></a><small class="color-mid"><?= $type_text ?></small>
                                            <?php endif ?>
										</span>
									</span>
									<span class="svp-stats-main-count">
										<?php echo htmlchars( number_format( $tds->get( 'view_count' ), 0, '.', ' ' ) ); ?>
										<?php
										$view_count  = $tds->get( 'view_count' );
										$today_views = $today_views + $view_count;
										?>
									</span>
								</span>
							<?php endforeach ?>
							<span class="clearfix">
								<span class="svp-stats-main-count svp-stats-main-count-total">
									<?php echo htmlchars( number_format( $today_views, 0, '.', ' ' ) ); ?>
								</span>
								<span class="svp-stats-main-target">
										<span class="svp-stats-main-target-text svp-stats-main-count-total-h">
											<?php echo __( 'Total ' ); ?>
										</span>
								</span>
							</span>
						<?php else : ?>
							<?php echo __( 'There is no stats at the moment.' ); ?>
						<?php endif ?>
					</div>
				</div>
				<div class="clearfix col s12 m6 l8 mb-10">
					<div class="clearfix mb-20 pos-r">
						<label class="svp-stats-title mb-10"><?php echo __( 'This week Actions' ); ?><span class="fz-12 color-mid ml-10" style="line-height: 20px;"><?php echo __( '(actions/day)' ); ?></span></label>
						<div class="chart-container pos-r stories-weekly-stats">
							<div class="ct-chart ct-golden-section" id="chart-views"></div>
						</div>
					</div>
					
				</div>
			</div>
		</section>
	</div>
</div>
