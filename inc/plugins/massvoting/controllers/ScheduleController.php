<?php
namespace Plugins\MassVoting;
use dgr\nohup\Process;
require_once PLUGINS_PATH . '/' . IDNAME . '/vendor/autoload.php';
// Disable direct access
if ( ! defined( 'APP_VERSION' ) ) {
	die( "Yo, what's up?" );
}
/**
 * Schedule Controller
 *
 * @version 1.7
 * @author Nextpost.tech (https://nextpost.tech)
 *
 */
class ScheduleController extends \Controller {
	/**
	 * idname of the plugin for internal use
	 */
	const IDNAME = 'massvoting';
	/**
	 * Process
	 */
	public function process() {
		 $AuthUser = $this->getVariable( 'AuthUser' );
		$Route     = $this->getVariable( 'Route' );
		$this->setVariable( 'idname', self::IDNAME );
		// Auth
		if ( ! $AuthUser ) {
			header( 'Location: ' . APPURL . '/login' );
			exit;
		} elseif ( $AuthUser->isExpired() ) {
			header( 'Location: ' . APPURL . '/expired' );
			exit;
		}
		$user_modules = $AuthUser->get( 'settings.modules' );
		if ( ! is_array( $user_modules ) || ! in_array( self::IDNAME, $user_modules ) ) {
			// Module is not accessible to this user
			header( 'Location: ' . APPURL . '/post' );
			exit;
		}
		// Get Account
		$Account = \Controller::model( 'Account', $Route->params->id );
		if ( ! $Account->isAvailable() ||
			$Account->get( 'user_id' ) != $AuthUser->get( 'id' ) ) {
			header( 'Location: ' . APPURL . '/e/' . self::IDNAME );
			exit;
		}
		$this->setVariable( 'Account', $Account );
		// Get Schedule
		require_once PLUGINS_PATH . '/' . $this->getVariable( 'idname' ) . '/models/ScheduleModel.php';
		$Schedule = new ScheduleModel(
			[
				'account_id' => $Account->get( 'id' ),
				'user_id'    => $Account->get( 'user_id' ),
			]
		);
		$this->setVariable( 'Schedule', $Schedule );
		// Get User
		$User = \Controller::model( 'User', $Account->get( 'user_id' ) );
		if ( ! $User->isAvailable() ) {
			header( 'Location: ' . APPURL . '/login' );
			exit;
		}
		$this->setVariable( 'User', $User );
		if ( \Input::request( 'action' ) == 'search' ) {
			$this->search();
		} elseif ( \Input::post( 'action' ) == 'save' ) {
			$this->save();
		} elseif ( \Input::post( 'action' ) == 'insert-targets' ) {
			$this->define_targets();
		}
		$this->view( PLUGINS_PATH . '/' . $this->getVariable( 'idname' ) . '/views/schedule.php', null );
	}
	/**
	 * Search hashtags, people, locations
	 * @return mixed
	 */
	private function search() {
		 $this->resp->result = 0;
		$AuthUser            = $this->getVariable( 'AuthUser' );
		$Account             = $this->getVariable( 'Account' );
		$query = \Input::request( 'q' );
		if ( ! $query ) {
			$this->resp->msg = __( 'Missing some of required data.' );
			$this->jsonecho();
		}
		$type = \Input::request( 'type' );
		if ( ! in_array( $type, [ 'people_follower', 'people_getliker', 'hashtag', 'location', 'explore', 'hashtag_liker', 'location_liker', 'people_following' ] ) ) {
			$this->resp->msg = __( 'Invalid parameter' );
			$this->jsonecho();
		}
		// Quick Search - Start
		if ( function_exists( '\Plugins\QuickSourceSearch\getSourceData' ) ) {
			$resp = \Plugins\QuickSourceSearch\getSourceData( $query, $type );
			if ( $resp ) {
				$this->resp->items  = $resp;
				$this->resp->result = 1;
				$this->jsonecho();
				exit;
			}
		}
		// Quick Search - End;
		// Login
		try {
			$Instagram = \InstagramController::login( $Account );
		} catch ( \InstagramAPI\Exception\NetworkException $e ) {
			$this->resp->msg = __( "We couldn't connect to Instagram. Please try again in few seconds." );
			$this->jsonecho();
		} catch ( \InstagramAPI\Exception\EmptyResponseException $e ) {
			$this->resp->msg = __( 'Instagram send us empty response. Please try again in few seconds.' );
			$this->jsonecho();
		} catch ( \Exception $e ) {
			$this->resp->msg = $e->getMessage();
			$this->jsonecho();
		}
		$this->resp->items = [];
		
		if ($type == "explore") {
            $cluster = [
                [
                    "id" => "explore_all:0",
                    "name" => __("Default page")
                ],[
                    "id" => "shopping:0",
                    "name" => __("Shop")
                ],[
                    "id" => "hashtag_inspired:1",
                    "name" => __("Animals")
                ],[
                    "id" => "hashtag_inspired:2",
                    "name" => __("Art")
                ],[
                    "id" => "hashtag_inspired:3",
                    "name" => __("Beauty")
                ],[
                    "id" => "hashtag_inspired:5",
                    "name" => __("Decor")
                ],[
                    "id" => "hashtag_inspired:11",
                    "name" => __("Music")
                ],[
                    "id" => "hashtag_inspired:15",
                    "name" => __("Sports")
                ],[
                    "id" => "hashtag_inspired:18",
                    "name" => __("Architecture")
                ],[
                    "id" => "hashtag_inspired:19",
                    "name" => __("Auto")
                ],[
                    "id" => "hashtag_inspired:20",
                    "name" => __("Comics")
                ],[
                    "id" => "hashtag_inspired:21",
                    "name" => __("DIY")
                ],[
                    "id" => "hashtag_inspired:22",
                    "name" => __("Dance")
                ],[
                    "id" => "hashtag_inspired:23",
                    "name" => __("Food")
                ],[
                    "id" => "hashtag_inspired:24",
                    "name" => __("Nature")
                ],[
                    "id" => "hashtag_inspired:26",
                    "name" => __("Style")
                ],[
                    "id" => "hashtag_inspired:27",
                    "name" => __("TV & Movies")
                ],[
                    "id" => "hashtag_inspired:28",
                    "name" => __("Travel")
                ],
            ];

            $this->resp->items = [];
            foreach ($cluster as $c) {
                $this->resp->items[] = [
                    "value" => $c["name"],
                    "data" => [
                        "id" => $c["id"]
                    ]
                ];
            }
            $this->resp->result = 1;
            $this->jsonecho();
        }
		// Get data
		try {
			if ( $type == 'people_follower' ) {
				$search_result = $Instagram->people->search( $query );
				if ( $search_result->isOk() ) {
					foreach ( $search_result->getUsers() as $r ) {
						$this->resp->items[] = [
							'value' => $r->getUsername(),
							'data'  => [
								'sub' => $r->getFullName(),
								'id'  => $r->getPk(),
							],
						];
					}
				}
			} elseif ( $type == 'people_getliker' ) {
				$search_result = $Instagram->people->search( $query );
				if ( $search_result->isOk() ) {
					foreach ( $search_result->getUsers() as $r ) {
						$this->resp->items[] = [
							'value' => $r->getUsername(),
							'data'  => [
								'sub' => $r->getFullName(),
								'id'  => $r->getPk(),
							],
						];
					}
				}
			}  elseif ( $type == 'people_following' ) {
				$search_result = $Instagram->people->search( $query );
				if ( $search_result->isOk() ) {
					foreach ( $search_result->getUsers() as $r ) {
						$this->resp->items[] = [
							'value' => $r->getUsername(),
							'data'  => [
								'sub' => $r->getFullName(),
								'id'  => $r->getPk(),
							],
						];
					}
				}
			} elseif ($type == 'hashtag') {
                $search_result = $Instagram->hashtag->search($query);
                if ($search_result->isOk()) {
                    foreach ($search_result->getResults() as $r) {
                        $this->resp->items[] = [
                            "value" => $r->getName(),
                            "data" => [
                                "sub" => n__("%s public post", "%s public posts", $r->getMediaCount(), $r->getMediaCount()),
                                "id" => str_replace("#", "", $r->getName())
                            ]
                        ];
                    }
                }
            } elseif ($type == 'location') {
                $search_result = $Instagram->location->findPlaces($query);
                if ($search_result->isOk()) {
                    foreach ($search_result->getItems() as $r) {
                        $this->resp->items[] = [
                            "value" => $r->getLocation()->getName(),
                            "data" => [
                                "sub" => false,
                                "id" => $r->getLocation()->getFacebookPlacesId()
                            ]
                        ];
                    }
                }
            }  elseif ($type == 'hashtag_liker') {
                $search_result = $Instagram->hashtag->search($query);
                if ($search_result->isOk()) {
                    foreach ($search_result->getResults() as $r) {
                        $this->resp->items[] = [
                            "value" => $r->getName(),
                            "data" => [
                                "sub" => n__("%s public post", "%s public posts", $r->getMediaCount(), $r->getMediaCount()),
                                "id" => str_replace("#", "", $r->getName())
                            ]
                        ];
                    }
                }
            } elseif ($type == 'location_liker') {
                $search_result = $Instagram->location->findPlaces($query);
                if ($search_result->isOk()) {
                    foreach ($search_result->getItems() as $r) {
                        $this->resp->items[] = [
                            "value" => $r->getLocation()->getName(),
                            "data" => [
                                "sub" => false,
                                "id" => $r->getLocation()->getFacebookPlacesId()
                            ]
                        ];
                    }
                }
            }
		} catch ( \InstagramAPI\Exception\NetworkException $e ) {
			$this->resp->msg = __( "We couldn't connect to Instagram. Please try again in few seconds." );
			$this->jsonecho();
		} catch ( \InstagramAPI\Exception\EmptyResponseException $e ) {
			$this->resp->msg = __( 'Instagram send us empty response. Please try again in few seconds.' );
			$this->jsonecho();
		} catch ( \Exception $e ) {
			$this->resp->msg = $e->getMessage();
			$this->jsonecho();
		}
		$this->resp->result = 1;
		$this->jsonecho();
	}
	/**
	 * Save schedule
	 * @return mixed
	 */
	private function save() {
		$this->resp->result = 0;
		$AuthUser           = $this->getVariable( 'AuthUser' );
		$Account            = $this->getVariable( 'Account' );
		$Schedule           = $this->getVariable( 'Schedule' );
		$Emojione = new \Emojione\Client( new \Emojione\Ruleset() );
		// Targets
		$targets = @json_decode( \Input::post( 'target' ) );
		if ( ! $targets ) {
			$targets = [];
		}
		$valid_targets = [];
		 foreach ($targets as $t) {
            if (isset($t->type, $t->value, $t->id) && 
                in_array($t->type, ["people_follower", "people_getliker", "hashtag", "location", "explore", "hashtag_liker", "location_liker", "people_following"])) 
            {
                $valid_targets[] = [
                    "type" => $t->type,
                    "id" => $t->id,
                    "value" => $t->value
                ];
            }
        }
		$target = json_encode( $valid_targets );
		$answers_pk = \Input::post( 'answers_pk' );
		$answers_pk = $Emojione->shortnameToUnicode( $answers_pk );
		$answers_pk = mb_substr( $answers_pk, 0, 20000 );
		$answers_pk = $Emojione->toShort( $answers_pk );
		// EN
		$answers_pk_en = \Input::post( 'answers_pk_en' );
		$answers_pk_en = $Emojione->shortnameToUnicode( $answers_pk_en );
		$answers_pk_en = mb_substr( $answers_pk_en, 0, 20000 );
		$answers_pk_en = $Emojione->toShort( $answers_pk_en );
		// DE
		$answers_pk_de = \Input::post( 'answers_pk_de' );
		$answers_pk_de = $Emojione->shortnameToUnicode( $answers_pk_de );
		$answers_pk_de = mb_substr( $answers_pk_de, 0, 20000 );
		$answers_pk_de = $Emojione->toShort( $answers_pk_de );
		// FR
		$answers_pk_fr = \Input::post( 'answers_pk_fr' );
		$answers_pk_fr = $Emojione->shortnameToUnicode( $answers_pk_fr );
		$answers_pk_fr = mb_substr( $answers_pk_fr, 0, 20000 );
		$answers_pk_fr = $Emojione->toShort( $answers_pk_fr );
		// TR
		$answers_pk_tr = \Input::post( 'answers_pk_tr' );
		$answers_pk_tr = $Emojione->shortnameToUnicode( $answers_pk_tr );
		$answers_pk_tr = mb_substr( $answers_pk_tr, 0, 20000 );
		$answers_pk_tr = $Emojione->toShort( $answers_pk_tr );
		// AR
		$answers_pk_ar = \Input::post( 'answers_pk_ar' );
		$answers_pk_ar = $Emojione->shortnameToUnicode( $answers_pk_ar );
		$answers_pk_ar = mb_substr( $answers_pk_ar, 0, 20000 );
		$answers_pk_ar = $Emojione->toShort( $answers_pk_ar );
		// IN
		$answers_pk_ind = \Input::post( 'answers_pk_ind' );
		$answers_pk_ind = $Emojione->shortnameToUnicode( $answers_pk_ind );
		$answers_pk_ind = mb_substr( $answers_pk_ind, 0, 20000 );
		$answers_pk_ind = $Emojione->toShort( $answers_pk_ind );
		// INDo
		$answers_pk_id = \Input::post( 'answers_pk_id' );
		$answers_pk_id = $Emojione->shortnameToUnicode( $answers_pk_id );
		$answers_pk_id = mb_substr( $answers_pk_id, 0, 20000 );
		$answers_pk_id = $Emojione->toShort( $answers_pk_id );
		// RU
		$answers_pk_ru = \Input::post( 'answers_pk_ru' );
		$answers_pk_ru = $Emojione->shortnameToUnicode( $answers_pk_ru );
		$answers_pk_ru = mb_substr( $answers_pk_ru, 0, 20000 );
		$answers_pk_ru = $Emojione->toShort( $answers_pk_ru );
		// IT
		$answers_pk_it = \Input::post( 'answers_pk_it' );
		$answers_pk_it = $Emojione->shortnameToUnicode( $answers_pk_it );
		$answers_pk_it = mb_substr( $answers_pk_it, 0, 20000 );
		$answers_pk_it = $Emojione->toShort( $answers_pk_it );
		// ES
		$answers_pk_es = \Input::post( 'answers_pk_es' );
		$answers_pk_es = $Emojione->shortnameToUnicode( $answers_pk_es );
		$answers_pk_es = mb_substr( $answers_pk_es, 0, 20000 );
		$answers_pk_es = $Emojione->toShort( $answers_pk_es );
		// PT
		$answers_pk_pt = \Input::post( 'answers_pk_pt' );
		$answers_pk_pt = $Emojione->shortnameToUnicode( $answers_pk_pt );
		$answers_pk_pt = mb_substr( $answers_pk_pt, 0, 20000 );
		$answers_pk_pt = $Emojione->toShort( $answers_pk_pt );
		// IR
		$answers_pk_ir = \Input::post( 'answers_pk_ir' );
		$answers_pk_ir = $Emojione->shortnameToUnicode( $answers_pk_ir );
		$answers_pk_ir = mb_substr( $answers_pk_ir, 0, 20000 );
		$answers_pk_ir = $Emojione->toShort( $answers_pk_ir );
		// NL
		$answers_pk_nl = \Input::post( 'answers_pk_nl' );
		$answers_pk_nl = $Emojione->shortnameToUnicode( $answers_pk_nl );
		$answers_pk_nl = mb_substr( $answers_pk_nl, 0, 20000 );
		$answers_pk_nl = $Emojione->toShort( $answers_pk_nl );
		// BR
		$answers_pk_br = \Input::post( 'answers_pk_br' );
		$answers_pk_br = $Emojione->shortnameToUnicode( $answers_pk_br );
		$answers_pk_br = mb_substr( $answers_pk_br, 0, 20000 );
		$answers_pk_br = $Emojione->toShort( $answers_pk_br );
		// JP
		$answers_pk_jp = \Input::post( 'answers_pk_jp' );
		$answers_pk_jp = $Emojione->shortnameToUnicode( $answers_pk_jp );
		$answers_pk_jp = mb_substr( $answers_pk_jp, 0, 20000 );
		$answers_pk_jp = $Emojione->toShort( $answers_pk_jp );
		// CN
		$answers_pk_cn = \Input::post( 'answers_pk_cn' );
		$answers_pk_cn = $Emojione->shortnameToUnicode( $answers_pk_cn );
		$answers_pk_cn = mb_substr( $answers_pk_cn, 0, 20000 );
		$answers_pk_cn = $Emojione->toShort( $answers_pk_cn );
		
		// Comment
		$comment = \Input::post( 'comment_text' );
		$comment = $Emojione->shortnameToUnicode( $comment );
		$comment = mb_substr( $comment, 0, 20000 );
		$comment = $Emojione->toShort( $comment );
		
		// End date
		$end_date = count( $valid_targets ) > 0 ? '2200-12-12 23:59:59' : date( 'Y-m-d H:i:s' );
		if ( $end_date > date( 'Y-m-d H:i:s' ) ) {
			$is_active = \Input::post( 'is_active' );
		} else {
			$is_active = 0;
		}
		 $data_path = PLUGINS_PATH."/".IDNAME."/temp/";
        $path = PLUGINS_PATH."/".IDNAME."/temp/".$AuthUser->get("id")."/";
        $filename = "recovery-data-" . $Account->get("instagram_id") . ".json";
        if (file_exists($path.$filename)) {
            unlink($path.$filename);
        }
		// Daily pause
		$daily_pause = (bool) \Input::post( 'daily_pause' );
		// Kill old process
		$pid = $Schedule->get( 'process_id' );
		if ( $pid ) {
			$process = Process::loadFromPid( $pid );
			if ( $process->isRunning() ) {
				$process->stop();
			}
		}
		// Save schedule
		$Schedule->set( 'user_id', $AuthUser->get( 'id' ) )
				 ->set( 'account_id', $Account->get( 'id' ) )
				 ->set( 'target', $target )
				 ->set( 'answers_pk', $answers_pk )
				 ->set( 'data.en', $answers_pk_en )
				  ->set( 'data.de', $answers_pk_de )
				   ->set( 'data.fr', $answers_pk_fr )
				    ->set( 'data.tr', $answers_pk_tr )
					 ->set( 'data.ar', $answers_pk_ar )
					  ->set( 'data.it', $answers_pk_it )
					   ->set( 'data.id', $answers_pk_id )
					    ->set( 'data.ind', $answers_pk_ind )
						->set( 'data.ru', $answers_pk_ru )
						->set( 'data.es', $answers_pk_es )
						->set( 'data.pt', $answers_pk_pt )
						->set( 'data.ir', $answers_pk_ir )
						->set( 'data.nl', $answers_pk_nl )
						->set( 'data.br', $answers_pk_br )
						->set( 'data.jp', $answers_pk_jp )
						->set( 'data.cn', $answers_pk_cn )
						->set( 'data.comment_text', $comment )
				 ->set( 'data.masslookingv2_speed', (int)\Input::post( 'masslookingv2_speed' ) )
				  ->set( 'data.poll_speed', (int)\Input::post( 'poll_speed' ) )
				  ->set( 'data.slide_poll_speed', (int)\Input::post( 'slide_poll_speed' ) )
				  ->set( 'data.quiz_speed', (int)\Input::post( 'quiz_speed' ) )
				  ->set( 'data.question_speed', (int)\Input::post( 'question_speed' ) )
				  ->set( 'data.countdown_speed', (int)\Input::post( 'countdown_speed' ) )
				  ->set( 'poll_answer_option', \Input::post( 'poll_answer_option' ) )
				 ->set( 'login_logout_option', \Input::post('login_logout_option' ) )
				 ->set( 'speed', \Input::post( 'speed' ) )
				 ->set( 'daily_pause', $daily_pause )
				 ->set( 'is_active', $is_active )
				 ->set( 'is_running', 0 )
				 ->set( 'is_executed', 0 )
				                   // Actions
                 ->set("data.is_likes", (bool)\Input::post("is_likes"))
                 ->set("data.likes_per_user", (int)\Input::post("likes_per_user"))
                 ->set("data.is_likes_timeline", (bool)\Input::post("is_likes_timeline"))
                 ->set("data.likes_speed", (int)\Input::post("likes_speed"))
				 ->set("data.business_ignore", (bool)\Input::post("business_ignore"))
				 ->set( 'data.comment_likes_speed', (int)\Input::post( 'comment_likes_speed' ) )
				   ->set("data.is_comments", (bool)\Input::post("is_comments"))
                 ->set("data.comment_per_user", (int)\Input::post("comments_per_user"))
				 ->set("data.comment_speed", (int)\Input::post("comments_speed"))

                 ->set("data.is_c_likes", (bool)\Input::post("is_c_likes"))

                 ->set("data.is_follow", (bool)\Input::post("is_follow"))
                
                 ->set("data.follow_speed", (int)\Input::post("follow_speed"))
				    ->set("data.mute_type",  \Input::post("mute_type"))
				 
				  ->set("data.is_unfollow", (bool)\Input::post("is_unfollow"))
                 ->set("data.unfollow_speed", (int)\Input::post("unfollow_speed"))

                 ->set("data.unfollow_interval", (int)\Input::post("unfollow_interval"))

				   // Telegram Notifications
                 ->set("data.is_telegram_analytics", (bool)\Input::post("is_telegram_analytics"))
				 ->set("data.is_masslookingv2", (bool)\Input::post("is_masslookingv2"))
				 
				 ->set("data.is_masslookingv2_verified", (bool)\Input::post("is_masslookingv2_verified"))
                 ->set("data.is_telegram_errors", (bool)\Input::post("is_telegram_errors"))
                 ->set("data.tg_chat_id", (int)\Input::post("tg_chat_id"))
				 ->set("data.multilang_enable", (bool)\Input::post("multilang_enable"))
                 ->set("data.delay_telegram", (int)\Input::post("delay_telegram"))
				 ->set( 'is_poll_active', \Input::post( 'is_poll_active' ) )
				  ->set( 'is_count_active', \Input::post( 'is_count_active' ) )
				  ->set( 'advanced_log', \Input::post( 'advanced_log' ) )
				 ->set( 'is_question_active', \Input::post( 'is_question_active' ) )
				 ->set( 'follower_ignore', \Input::post( 'follower_ignore' ) )
				 ->set( 'following_ignore', \Input::post( 'following_ignore' ) )
				 ->set( 'follow_request_ignore', \Input::post( 'follow_request_ignore' ) )
				 ->set( 'same_people_story_ignore', \Input::post( 'same_people_story_ignore' ) )
				 ->set( 'is_slider_active', \Input::post( 'is_slider_active' ) )
				 ->set( 'is_quiz_active', \Input::post( 'is_quiz_active' ) )
				 ->set( 'is_mass_story_view_active', \Input::post( 'is_mass_story_view_active' ) )
				 ->set( 'slider_min', \Input::post( 'slider_min' ) )
				 ->set( 'slider_max', \Input::post( 'slider_max' ) )
				  ->set("data.recovery_data", "")
				 ->set( 'data.estimated_speed', 0 )
				 ->set( 'data.fresh_stories', \Input::post( 'fresh_stories' ) )
				 ->set( 'data.fresh_stories_range', \Input::post( 'fresh_stories_range' ) )
				 ->set( 'process_id', 0 )
				 ->set( 'schedule_date', date( 'Y-m-d H:i:s' ) )
				 ->set( 'end_date', $end_date )
				 ->set( 'last_action_date', date( 'Y-m-d H:i:s' ) );
		$schedule_date = date( 'Y-m-d H:i:s', time() + 60 );
		if ( $daily_pause ) {
			$from = new \DateTime(
				date( 'Y-m-d' ) . ' ' . \Input::post( 'daily_pause_from' ),
				new \DateTimeZone( $AuthUser->get( 'preferences.timezone' ) )
			);
			$from->setTimezone( new \DateTimeZone( 'UTC' ) );
			$to = new \DateTime(
				date( 'Y-m-d' ) . ' ' . \Input::post( 'daily_pause_to' ),
				new \DateTimeZone( $AuthUser->get( 'preferences.timezone' ) )
			);
			$to->setTimezone( new \DateTimeZone( 'UTC' ) );
			$Schedule->set( 'daily_pause_from', $from->format( 'H:i:s' ) )
					 ->set( 'daily_pause_to', $to->format( 'H:i:s' ) );
			$to   = $to->format( 'Y-m-d H:i:s' );
			$from = $from->format( 'Y-m-d H:i:s' );
			if ( $to <= $from ) {
				$to = date( 'Y-m-d H:i:s', strtotime( $to ) + 86400 );
			}
			if ( $schedule_date > $to ) {
				// Today's pause interval is over
				$from = date( 'Y-m-d H:i:s', strtotime( $from ) + 86400 );
				$to   = date( 'Y-m-d H:i:s', strtotime( $to ) + 86400 );
			}
			if ( $schedule_date >= $from && $schedule_date <= $to ) {
				$schedule_date = $to;
				$Schedule->set( 'schedule_date', $schedule_date );
			}
		}
		$Schedule->set( 'schedule_date', $schedule_date );
		$Schedule->save();
		$this->resp->msg    = __( 'Changes saved!' );
		$this->resp->result = 1;
		$this->jsonecho();
	}
	/**
	 * Define targets
	 * @return mixed
	 */
	private function define_targets() {
		 $this->resp->result = 0;
		$AuthUser            = $this->getVariable( 'AuthUser' );
		$Account             = $this->getVariable( 'Account' );
		$Schedule            = $this->getVariable( 'Schedule' );
		$targets = \Input::post( 'targets_list' );
		if ( empty( $targets ) ) {
			$this->resp->msg = __( 'You are not insert any target. Please provide valid usernames or Instagram profile links.' );
			$this->jsonecho();
		}
		$targets_type = \Input::post( 'targets_type' );
		if ( ! in_array( $targets_type, [ 'people_follower', 'people_getliker', 'hashtag', 'location', 'hashtag_liker', 'location_liker', 'people_following' ] ) ) {
			$this->resp->msg = __( 'Invalid type parameter.' );
			$this->jsonecho();
		}
		$targets = explode( "\n", str_replace( "\r", '', $targets ) );
		// Get Instagram usernames from links and validate Instagram usernames
		$regex_1 = '/(?:(?:http|https):\/\/)?(?:www.)?(?:instagram.com|instagr.am)\/([A-Za-z0-9-_\.]+)/im';
		$regex_2 = '/^[a-zA-Z0-9._]+$/';
		foreach ( $targets as $key => $t ) {
			$targets[ $key ] = preg_replace( '/\s/', '', $t );
			if ( preg_match( $regex_1, $targets[ $key ], $matches ) ) {
				$targets[ $key ] = $matches[1];
			}
			if ( ! empty( $targets[ $key ] ) && preg_match( $regex_2, $targets[ $key ] ) ) {
				// Username is correct
			} else {
				unset( $targets[ $key ] );
			}
		}
		// Delete duplicated elements
		$targets = array_unique( $targets );
		// Check for empty values
		$targets = array_filter( $targets, 'strlen' );
		// Re-index all
		$targets = array_values( $targets );
		// Login
		try {
			$Instagram = \InstagramController::login( $Account );
		} catch ( \InstagramAPI\Exception\NetworkException $e ) {
			$this->resp->msg = __( "We couldn't connect to Instagram. Please try again in few seconds." );
			$this->jsonecho();
		} catch ( \InstagramAPI\Exception\EmptyResponseException $e ) {
			$this->resp->msg = __( 'Instagram send us empty response. Please try again in few seconds.' );
			$this->jsonecho();
		} catch ( \Exception $e ) {
			$this->resp->msg = $e->getMessage();
			$this->jsonecho();
		}
		// Get targets parameters from Instagram
		$filtered_targets = [];
		foreach ( $targets as $key => $t ) {
			$is_connected       = false;
			$is_connected_count = 0;
			do {
				set_time_limit( 30 );
				if ( $is_connected_count == 10 ) {
					if ( $e->getMessage() ) {
						$this->resp->msg = $e->getMessage();
						$this->jsonecho();
					} else {
						$this->resp->msg = __( "There is a problem with your Ethernet connection or Instagram is down at the moment. We couldn't establish connection with Instagram 10 times. Please try again later." );
						$this->jsonecho();
					}
				}
				try {
					$user_id = $Instagram->people->getUserIdForName( $t );
					$filtered_targets[ $key ] = [
						'type'  => $targets_type,
						'id'    => $user_id,
						'value' => $t,
					];
					$is_connected = true;
					if ( ( $t != $targets[ count( $targets ) - 1 ] ) && ( count( $targets ) > 0 ) ) {
						sleep( 1 );
					}
				} catch ( \InstagramAPI\Exception\NetworkException $e ) {
					sleep( 7 );
				} catch ( \InstagramAPI\Exception\EmptyResponseException $e ) {
					sleep( 7 );
				} catch ( \InstagramAPI\Exception\NotFoundException $e ) {
					// Instagram profile not found or user banned your account
					$is_connected = true;
				} catch ( \InstagramAPI\Exception\InstagramException $e ) {
					if ( $e->hasResponse() ) {
						$msg = $e->getResponse()->getMessage();
					} else {
						$msg = explode( ':', $e->getMessage(), 2 );
						$msg = end( $msg );
					}
					$this->resp->msg = $msg;
					$this->jsonecho();
				} catch ( \Exception $e ) {
					$this->resp->msg = $e->getMessage();
					$this->jsonecho();
				}
				$is_connected_count += 1;
			} while ( ! $is_connected );
		}
		if ( empty( $filtered_targets ) ) {
			$this->resp->msg = __( 'All targets in list is invalid. Please provide valid usernames or Instagram profile links.' );
			$this->jsonecho();
		}
		$this->resp->filtered_targets = json_encode( $filtered_targets );
		$this->resp->result           = 1;
		$this->jsonecho();
	}
}