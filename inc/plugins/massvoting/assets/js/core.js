/**
 * Hypervote Namespane
 */
var Hypervote = {}

/**
 * Hypervote Schedule Form
 */
 /**
 * tooltip
 */
 
Hypervote.ScheduleForm = function () {
  var $form = $('.js-hypervote-schedule-form')
  var $searchinp = $form.find(":input[name='search']")
  var query
  var icons = {}
  icons.people_following = "mdi mdi-instagram";
   icons.people_getliker = "mdi mdi-instagram";
        icons.people_followers = "mdi mdi-instagram";
        icons.hashtag = "mdi mdi-pound";
        icons.location = "mdi mdi-map-marker";
		icons.explore = "mdi mdi-compass";
		 icons.hashtag_liker = "mdi mdi-pound";
		  icons.location_liker = "mdi mdi-map-marker";
  var target = []

  // Get ready tags
  $form.find('.tag').each(function () {
    target.push($(this).data('type') + '-' + $(this).data('id'))
  })
 
  // Search auto complete for targeting
  $searchinp.devbridgeAutocomplete({
    serviceUrl: $searchinp.data('url'),
    type: 'GET',
    dataType: 'jsonp',
    minChars: 2,
    deferRequestBy: 200,
    appendTo: $form,
    forceFixPosition: true,
    paramName: 'q',
    params: {
      action: 'search',
      type: $form.find(":input[name='type']:checked").val()
    },
    onSearchStart: function () {
      $form.find('.js-search-loading-icon').removeClass('none')
      query = $searchinp.val()
    },
    onSearchComplete: function () {
      $form.find('.js-search-loading-icon').addClass('none')
    },
   
    transformResult: function (resp) {
      return {
        suggestions: resp.result == 1 ? resp.items : []
      }
    },

    beforeRender: function (container, suggestions) {
      for (var i = 0; i < suggestions.length; i++) {
        var type = $form.find(":input[name='type']:checked").val()
        if (target.indexOf(type + '-' + suggestions[i].data.id) >= 0) {
          container.find('.autocomplete-suggestion').eq(i).addClass('none')
        }
      }
    },

    formatResult: function (suggestion, currentValue) {
      var pattern = '(' + currentValue.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, '\\$&') + ')'
      var type = $form.find(":input[name='type']:checked").val()

      return (suggestion.data.img ? "<img src='" + suggestion.data.img + "' style='width: 40px;height: 40px;margin: 0 12px 0 0; border-radius: 50%;float:left;border: 1px solid #e6e6e6;'>" : '') + suggestion.value
        .replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/&lt;(\/?strong)&gt;/g, '<$1>') +
                    (suggestion.data.sub ? "<span class='sub'>" + suggestion.data.sub + '<span>' : '')
    },

    onSelect: function (suggestion) {
      $searchinp.val(query)
      var type = $form.find(":input[name='type']:checked").val()

      if (target.indexOf(type + '-' + suggestion.data.id) >= 0) {
        return false
      }

      var $tag = $("<span style='margin: 0px 2px 3px 0px'></span>")
      $tag.addClass('tag pull-left preadd')
      $tag.attr({
        'data-type': type,
        'data-id': suggestion.data.id,
        'data-value': suggestion.value
      })

      $addit_text = ''
      if (type == 'people_follower') {
        $addit_text = __(' (followers)')
      } else if (type == 'people_getliker') {
        $addit_text = __(' (likers)')
      }else if (type == 'hashtag') {
        $addit_text = __(' (hashtag)')
      }else if (type == 'location') {
        $addit_text = __(' (location)')
      }else if (type == 'hashtag_liker') {
        $addit_text = __(' (hashtaglikers)')
      } else if (type == 'location_liker') {
        $addit_text = __(' (locationlikers)')
      }

      $tag.text(suggestion.value + $addit_text)

      $tag.prepend("<span class='icon " + icons[type] + "'></span>")
      $tag.append("<span class='mdi mdi-close remove'></span>")

      $tag.appendTo($form.find('.tags'))

      setTimeout(function () {
        $tag.removeClass('preadd')
      }, 50)

      target.push(type + '-' + suggestion.data.id)
    }
  })

  // Change search source
  $form.find(":input[name='type']").on('change', function () {
    var type = $form.find(":input[name='type']:checked").val()

    $searchinp.autocomplete('setOptions', {
      params: {
        action: 'search',
        type: type
      }
    })

    $searchinp.trigger('blur')
    setTimeout(function () {
      $searchinp.trigger('focus')
    }, 200)
  })
  

   // Like section
    $form.find(":input[name='likes']").on("change", function() {
        if ($(this).is(":checked")) {
            $form.find(".js-likes-settings").css("opacity", "1");
            $form.find(".js-likes-settings").find(":input").prop("disabled", false);
        } else {
            $form.find(".js-likes-settings").css("opacity", "0.25");
            $form.find(".js-likes-settings").find(":input").prop("disabled", true);
        }
    }).trigger("change");
 // Comment section
    $form.find(":input[name='comments']").on("change", function() {
        if ($(this).is(":checked")) {
            $form.find(".js-comments-settings").css("opacity", "1");
            $form.find(".js-comments-settings").find(":input").prop("disabled", false);
        } else {
            $form.find(".js-comments-settings").css("opacity", "0.25");
            $form.find(".js-comments-settings").find(":input").prop("disabled", true);
        }
    }).trigger("change");
	
    // Follow section
    $form.find(":input[name='follow']").on("change", function() {
        if ($(this).is(":checked")) {
            $form.find(".js-follow-settings").css("opacity", "1");
            $form.find(".js-follow-settings").find(":input").prop("disabled", false);
        } else {
            $form.find(".js-follow-settings").css("opacity", "0.25");
            $form.find(".js-follow-settings").find(":input").prop("disabled", true);
        }
    }).trigger("change");
 // Telegram notifications
    $form.find(":input[name='is-telegram-analytics']").on("change", function() {
        if ($(this).is(":checked")) {
            $form.find(".js-telegram-notifications").css("opacity", "1");
            $form.find(".js-telegram-notifications").find(":input").prop("disabled", false);
        } else {
            $form.find(".js-telegram-notifications").css("opacity", "0.25");
            $form.find(".js-telegram-notifications").find(":input").prop("disabled", true);
        }
    }).trigger("change");
  // Remove target
  $form.on('click', '.tag .remove', function () {
    var $tag = $(this).parents('.tag')

    var index = target.indexOf($tag.data('type') + '-' + $tag.data('id'))
    if (index >= 0) {
      target.splice(index, 1)
    }

    $tag.remove()
  })

  // Daily pause
  $form.find(":input[name='daily-pause']").on('change', function () {
    if ($(this).is(':checked')) {
      $form.find('.js-daily-pause-range').css('opacity', '1')
      $form.find('.js-daily-pause-range').find(':input').prop('disabled', false)
    } else {
      $form.find('.js-daily-pause-range').css('opacity', '0.25')
      $form.find('.js-daily-pause-range').find(':input').prop('disabled', true)
    }
  }).trigger('change')
 
  var emoji = $form.find('.arp-caption-input').emojioneArea({
    saveEmojisAs: 'unicode', // unicode | shortname | image
    imageType: 'svg', // Default image type used by internal CDN
    pickerPosition: 'bottom',
    buttonTitle: __('Use the TAB key to insert emoji faster')
  })

  // Emoji area input filter
  emoji[0].emojioneArea.on('drop', function (obj, event) {
    event.preventDefault()
  })

  emoji[0].emojioneArea.on('paste keyup input emojibtn.click', function () {
    $form.find(":input[name='new-comment-input']").val(emoji[0].emojioneArea.getText())
  })

  // Experiments section
  // Fresh stories
  $form.find(":input[name='fresh-stories']").on('change', function () {
    if ($(this).is(':checked')) {
      $form.find('.js-fresh-stories-range').css('opacity', '1')
      $form.find('.js-fresh-stories-range').find(':input').prop('disabled', false)
    } else {
      $form.find('.js-fresh-stories-range').css('opacity', '0.25')
      $form.find('.js-fresh-stories-range').find(':input').prop('disabled', true)
    }
  }).trigger('change')
 // Unfollow section
    $form.find(":input[name='unfollow']").on("change", function() {
        if ($(this).is(":checked")) {
            $form.find(".js-unfollow-settings").css("opacity", "1");
            $form.find(".js-unfollow-settings").find(":input").prop("disabled", false);
        } else {
            $form.find(".js-unfollow-settings").css("opacity", "0.25");
            $form.find(".js-unfollow-settings").find(":input").prop("disabled", true);
        }
    }).trigger("change");
  // Submit the form
  $form.on('submit', function () {
    $('body').addClass('onprogress')

    var target = []

    $form.find('.tags .tag').each(function () {
      var t = {}
      t.type = $(this).data('type')
      t.id = $(this).data('id').toString()
      t.value = $(this).data('value')

      target.push(t)
    })

    $.ajax({
      url: $form.attr('action'),
      type: $form.attr('method'),
      dataType: 'jsonp',
      data: {
        action: 'save',
        target: JSON.stringify(target),
        answers_pk: emoji[1].emojioneArea.getText(),
		answers_pk_en: emoji[2].emojioneArea.getText(),
		answers_pk_ar: emoji[3].emojioneArea.getText(),
		answers_pk_de: emoji[4].emojioneArea.getText(),
		answers_pk_fr: emoji[5].emojioneArea.getText(),
		answers_pk_tr: emoji[6].emojioneArea.getText(),
		answers_pk_ind : emoji[7].emojioneArea.getText(),
		answers_pk_id: emoji[8].emojioneArea.getText(),
		answers_pk_ru: emoji[9].emojioneArea.getText(),
		answers_pk_it: emoji[10].emojioneArea.getText(),
		answers_pk_es: emoji[11].emojioneArea.getText(),
		answers_pk_pt: emoji[12].emojioneArea.getText(),
		answers_pk_ir: emoji[13].emojioneArea.getText(),
		answers_pk_nl: emoji[14].emojioneArea.getText(),
		answers_pk_br: emoji[15].emojioneArea.getText(),
		answers_pk_jp: emoji[16].emojioneArea.getText(),
		answers_pk_cn: emoji[17].emojioneArea.getText(),
		comment_text: emoji[0].emojioneArea.getText(),
		
		
		
		
		
		
		
		
		
		
        poll_answer_option: $form.find(":input[name='poll_answer_option']").val(),
		masslookingv2_speed: $form.find(":input[name='masslookingv2_speed']").val(),
		poll_speed: $form.find(":input[name='poll_speed']").val(),
		slide_poll_speed: $form.find(":input[name='slide_poll_speed']").val(),
		quiz_speed: $form.find(":input[name='quiz_speed']").val(),
		question_speed: $form.find(":input[name='question_speed']").val(),
		countdown_speed: $form.find(":input[name='countdown_speed']").val(),
		    login_logout_option: $form.find(":input[name='login_logout_option']").val(),
        speed: $form.find(":input[name='speed']").val(),
        fresh_stories: $form.find(":input[name='fresh-stories']").is(':checked') ? 1 : 0,
        fresh_stories_range: $form.find(":input[name='fresh-stories-range']").val(),
        daily_pause: $form.find(":input[name='daily-pause']").is(':checked') ? 1 : 0,
        daily_pause_from: $form.find(":input[name='daily-pause-from']").val(),
        daily_pause_to: $form.find(":input[name='daily-pause-to']").val(),
		 // Telegram Notifications
                is_telegram_analytics: $form.find(":input[name='is-telegram-analytics']").is(":checked") ? 1 : 0,
				 business_ignore: $form.find(":input[name='business_ignore']").is(":checked") ? 1 : 0,
				is_masslookingv2_verified: $form.find(":input[name='blue-badge']").is(":checked") ? 1 : 0,
				is_masslookingv2: $form.find(":input[name='is-masslooking-v2']").is(":checked") ? 1 : 0,
				
                is_telegram_errors: $form.find(":input[name='is-telegram-errors']").is(":checked") ? 1 : 0,
                tg_chat_id: $form.find(":input[name='tg-chat-id']").val(),
				 // Actions settings
                is_likes: $form.find(":input[name='likes']").is(":checked") ? 1 : 0,
				is_comments: $form.find(":input[name='comments']").is(":checked") ? 1 : 0,
				 comments_per_user: $form.find(":input[name='comments-per-user']").val(),
				  comments_speed: $form.find(":input[name='comments-speed']").val(),
                likes_per_user: $form.find(":input[name='likes-per-user']").val(),
                is_likes_timeline: $form.find(":input[name='likes-timeline']").is(":checked") ? 1 : 0,
                likes_speed: $form.find(":input[name='likes-speed']").val(),
				
				

                is_c_likes: $form.find(":input[name='c-likes']").is(":checked") ? 1 : 0,
                comment_likes_speed: $form.find(":input[name='comment-likes-speed']").val(),
                is_follow: $form.find(":input[name='follow']").is(":checked") ? 1 : 0,
                follow_speed: $form.find(":input[name='follow-speed']").val(),
				mute_type: $form.find(":input[name='mute-type']").val(),
				  is_unfollow: $form.find(":input[name='unfollow']").is(":checked") ? 1 : 0,
                unfollow_speed: $form.find(":input[name='unfollow-speed']").val(),

                unfollow_interval: $form.find(":input[name='unfollow-interval']").val(),
                delay_telegram: $form.find(":input[name='delay-telegram']").val(),
        is_active: $form.find(":input[name='is_active']").val(),
        is_poll_active: $form.find(":input[name='is_poll_active']").is(':checked') ? 1 : 0,
		advanced_log: $form.find(":input[name='advanced_log']").is(':checked') ? 1 : 0,
		multilang_enable: $form.find(":input[name='langdetect']").is(":checked") ? 1 : 0,
		 following_ignore: $form.find(":input[name='following_ignore']").is(':checked') ? 1 : 0,
		 follow_request_ignore: $form.find(":input[name='follow_request_ignore']").is(':checked') ? 1 : 0,
		 follower_ignore: $form.find(":input[name='follower_ignore']").is(':checked') ? 1 : 0,
		same_people_story_ignore: $form.find(":input[name='same_people_story_ignore']").is(':checked') ? 1 : 0,
		 is_count_active: $form.find(":input[name='is_count_active']").is(':checked') ? 1 : 0,
        is_question_active: $form.find(":input[name='is_question_active']").is(':checked') ? 1 : 0,
		
        is_slider_active: $form.find(":input[name='is_slider_active']").is(':checked') ? 1 : 0,
        is_quiz_active: $form.find(":input[name='is_quiz_active']").is(':checked') ? 1 : 0,
        is_mass_story_view_active: $form.find(":input[name='is_mass_story_view_active']").is(':checked') ? 1 : 0,
        slider_min: $form.find(":input[name='slider_min']").val(),
        slider_max: $form.find(":input[name='slider_max']").val()
      },
      error: function () {
        $('body').removeClass('onprogress')
        NextPost.DisplayFormResult($form, 'error', __('Oops! An error occured. Please try again later!'))
      },

      success: function (resp) {
        if (resp.result == 1) {
          NextPost.DisplayFormResult($form, 'success', resp.msg)

          var active_schedule = $('.aside-list-item.active')

          if ($form.find(":input[name='is_active']").val() == 1) {
            active_schedule.find('span.status').replaceWith("<span class='status color-green'><span class='mdi mdi-circle mr-2'></span>" + __('Active') + '</span>')
          } else {
            active_schedule.find('span.status').replaceWith("<span class='status'><span class='mdi mdi-circle-outline mr-2'></span>" + __('Deactive') + '</span>')
          }
        } else {
          NextPost.DisplayFormResult($form, 'error', resp.msg)
        }

        $('body').removeClass('onprogress')
      }
    })

    return false
  })

  var target_list_popup = $('#target-list-popup')
  target_list_popup.on('click', 'a.js-hypervote-target-list', function () {
    if ($(this).data('id') == $('.aside-list-item.active').data('id')) {
      var url = $(this).data('url')
      var target_list_textarea = target_list_popup.find('textarea.target-list')
      var targets_list = target_list_textarea.val()

      target_list_textarea.val('')

      var targets_type = 'people_getliker'
      if ($form.find("input[name='type'][value='people_follower']").is(':checked')) {
        targets_type = 'people_follower'
      } else if ($form.find("input[name='type'][value='hashtag']").is(':checked')) {
        targets_type = 'hashtag'
      } else if ($form.find("input[name='type'][value='location']").is(':checked')) {
        targets_type = 'location'
      } else if ($form.find("input[name='type'][value='hashtag_liker']").is(':checked')) {
        targets_type = 'hashtag_liker'
      } else if ($form.find("input[name='type'][value='people_following']").is(':checked')) {
        targets_type = 'people_following'
      }else if ($form.find("input[name='type'][value='location_liker']").is(':checked')) {
        targets_type = 'location_liker'
      }

      $('body').addClass('onprogress')

      $.ajax({
        url: url,
        type: 'POST',
        dataType: 'jsonp',
        data: {
          action: 'insert-targets',
          targets_type: targets_type,
          targets_list: targets_list
        },

        error: function () {
          $('body').removeClass('onprogress')

          NextPost.Alert({
            title: __('Oops...'),
            content: __('An error occured. Please try again later!'),
            confirmText: __('Close')
          })
        },

        success: function (resp) {
          if (resp.result == 1) {
            $('body').removeClass('onprogress')
            target_list_popup.modal('hide')

            if (resp.filtered_targets) {
              var filtered_targets = $.parseJSON(resp.filtered_targets)

              $.each(filtered_targets, function (key, value) {
                if (target.indexOf(value.type + '-' + value.id) >= 0) {
                  // Target already added
                } else {
                  var $tag = $("<span style='margin: 0px 2px 3px 0px'></span>")
                  $tag.addClass('tag pull-left preadd')
                  $tag.attr({
                    'data-type': value.type,
                    'data-id': value.id,
                    'data-value': value.value
                  })

                  $addit_text = ''
                  if (value.type == 'people_follower') {
                    $addit_text = __(' (follower)')
                  } else if (value.type == 'people_getliker') {
                    $addit_text = __(' (liker)')
                  } else if (value.type == 'hashtag') {
                    $addit_text = __(' (hashtag)')
                  } else if (value.type == 'location') {
                    $addit_text = __(' (location)')
                  }  else if (value.type == 'hashtag_liker') {
                    $addit_text = __(' (hashtag_liker)')
                  } else if (value.type == 'people_following') {
                    $addit_text = __(' (following)')
                  }

                  $tag.text(value.value + $addit_text)

                  $tag.prepend("<span class='icon " + icons[value.type] + "'></span>")
                  $tag.append("<span class='mdi mdi-close remove'></span>")

                  $tag.appendTo($form.find('.tags'))

                  setTimeout(function () {
                    $tag.removeClass('preadd')
                  }, 50)

                  target.push(value.type + '-' + value.id)
                }
              })
            }
          } else {
            $('body').removeClass('onprogress')

            NextPost.Alert({
              title: __('Oops...'),
              content: resp.msg,
              confirmText: __('Close'),

              confirm: function () {
                if (resp.redirect) {
                  window.location.href = resp.redirect
                }
              }
            })
          }
        }
      })
    }
  })

  $('body').on('click', 'a.js-remove-all-targets', function () {
    var $tags = $form.find('.tags')
    if ($tags) {
      $tags.html('')
    }
    target = []
  })
}
Hypervote.Tabs = function()
{
    $("body").on("click", ".tabheads a", function() {
        var tab = $(this).data("tab");
        var $tabs = $(this).parents(".tabs");
        var $contents = $tabs.find(".tabcontents");
        var $content = $contents.find(">div[data-tab='"+tab+"']");

        if ($content.length != 1 || $(this).hasClass("active")) {
            return true;
        }

        $(this).parents(".tabheads").find("a").removeClass('active');
        $(this).addClass("active");

        $contents.find(">div").removeClass('active');
        $content.addClass('active');
    });
}
/**
 * Functions for numbers formatting
 */

function numberWithSpaces (x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ')
}

function number_styler (n) {
  var result = 0
  var m = __('m')
  if (n < 10000000) {
    result = numberWithSpaces(n)
  } else {
    n = n / 1000000
    result = n.toFixed(2) + m
  }
  return result
}

/**
 * Hypervote Index
 */
Hypervote.Index = function () {
  $(document).ajaxComplete(function (event, xhr, settings) {
    var rx = new RegExp('(hypervote\/[0-9]+(\/)?)$')
    if (rx.test(settings.url)) {
      Hypervote.ScheduleForm()

      // Update selected schedule estimated speed
      var active_schedule = $('.aside-list-item.active')
      $.ajax({
        url: active_schedule.data('url'),
        type: 'POST',
        dataType: 'jsonp',
        data: {
          action: 'update_data',
          id: active_schedule.data('id')
        },
        success: function (resp) {
          if (resp.result == 1 && resp.estimated_speed != 0) {
            active_schedule.find('span.speed.speed-value').replaceWith("<span class='speed-value'>" + resp.estimated_speed + '</span>')
          }
          if (resp.result == 1) {
            if (resp.is_active != 0) {
              active_schedule.find('span.status').replaceWith("<span class='status color-green'><span class='mdi mdi-circle mr-2'></span>" + __('Active') + '</span>')
            } else {
              active_schedule.find('span.status').replaceWith("<span class='status'><span class='mdi mdi-circle-outline mr-2'></span>" + __('Deactive') + '</span>')
            }
          }
        }
      })
    }
  })
}
Hypervote.Settings = function() 
{
    var settings = $("#settings");
    var form =  settings.find(".js-ajax-form");

    // Task status filter
    form.find(":input[name=task-status]").on("change", function() {
        var url = form.attr("action");
        var task_value = $(this).val();
        window.location.href = url + "?task-status=" + task_value;
    });

    // PID status filter
    form.find(":input[name=pid-status]").on("change", function() {
        var url = form.attr("action");
        var pid_value = $(this).val();
        window.location.href = url + "?pid-status=" + pid_value;
    });

    window.loadmore.success = function($item) {
        NextPost.Tooltip();
    }
}
/**
 * Hypervote Restart
 */
Hypervote.Restart = function () {
  $('body').on('click', 'a.js-hypervote-restart', function () {
    var id = $(this).data('id')
    var url = $(this).data('url')

    $ms_section = $('.hypervote-section')
    $ms_section.addClass('onprogress')

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'jsonp',
      data: {
        action: 'restart',
        id: id
      },

      error: function () {
        $ms_section.removeClass('onprogress')

        NextPost.Alert({
          title: __('Oops...'),
          content: __('An error occured. Please try again later!'),
          confirmText: __('Close')
        })
      },

      success: function (resp) {
        if (resp.result == 1) {
          $ms_section.removeClass('onprogress')

          $ms_section.find(".tm-hypervote-task[data-id='" + id + "']").find('.status').replaceWith("<span class='status color-green'><span class='mdi mdi-circle mr-2'></span>" + __('Active') + '</span>')
          $ms_section.find(".tm-hypervote-pid[data-id='" + id + "']").find('.status').replaceWith("<span class='status color-basic'><span class='mdi mdi-clock mr-2'></span>" + __('Scheduled') + '</span>')
        } else {
          $ms_section.removeClass('onprogress')

          NextPost.Alert({
            title: __('Oops...'),
            content: resp.msg,
            confirmText: __('Close')
          })
        }
      }
    })
  })
  Hypervote.Settings = function() 
{
    var settings = $("#settings");
    var form =  settings.find(".js-ajax-form");

    // Task status filter
    form.find(":input[name=task-status]").on("change", function() {
        var url = form.attr("action");
        var task_value = $(this).val();
        window.location.href = url + "?task-status=" + task_value;
    });

    // PID status filter
    form.find(":input[name=pid-status]").on("change", function() {
        var url = form.attr("action");
        var pid_value = $(this).val();
        window.location.href = url + "?pid-status=" + pid_value;
    });

    window.loadmore.success = function($item) {
        NextPost.Tooltip();
    }
}

/**
 * Show only active tasks
 */
var search_timer;
var search_xhr;
var $form = $(".skeleton-aside .search-box");

$("body").on("click", "a.js-only-active", function() {
    var _this = $(this);
    var only_active_inp = $form.find(":input[name='only_active']");
    var search_query = $form.find(":input[name='q']");

    if (only_active_inp.val() == 0) {
        only_active_inp.val(1);
        _this.removeClass('button--light-outline');
        _this.addClass('active');
    } else {
        only_active_inp.val(0)
        _this.addClass('button--light-outline');
        _this.removeClass('active');
    }

    if (search_xhr) {
        // Abort previous ajax request
        search_xhr.abort();
    }

    if (search_timer) {
        clearTimeout(search_timer);
    }

    data = $.param({
        only_active: (only_active_inp.val() == 1) ? "yes" : "no"
    });

    if (search_query.val() != '') {
        data += '&' + $.param({
            q: search_query.val(),
        });
    }

    var duration = 200;
    search_timer = setTimeout(function(){
        search_query.addClass("onprogress");

        $.ajax({
            url: $form.attr("action"),
            type: $form.attr("method"),
            dataType: 'html',
            data: data,
            complete: function() {
                search_query.removeClass('onprogress');
            },
            success: function(resp) {
                $resp = $(resp);

                if ($resp.find(".skeleton-aside .js-search-results").length == 1) {
                    $(".skeleton-aside .js-search-results")
                        .html($resp.find(".skeleton-aside .js-search-results").html());
                }
            }
        });
    }, duration);
});
  $('body').on('click', 'a.js-hypervote-bulk-restart', function () {
    var url = $(this).data('url')

    $ms_section = $('.hypervote-section')
    $ms_section.addClass('onprogress')

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'jsonp',
      data: {
        action: 'bulk-restart'
      },

      error: function () {
        $ms_section.removeClass('onprogress')

        NextPost.Alert({
          title: __('Oops...'),
          content: __('An error occured. Please try again later!'),
          confirmText: __('Close')
        })
      },

      success: function (resp) {
        if (resp.result == 1) {
          $ms_section.removeClass('onprogress')

          if (resp.redirect) {
            window.location.href = resp.redirect
          }
        } else {
          $ms_section.removeClass('onprogress')

          NextPost.Alert({
            title: __('Oops...'),
            content: resp.msg,
            confirmText: __('Close')
          })
        }
      }
    })
  })
}
