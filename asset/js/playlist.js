
/*==========================================================================================================================================
  GLOBAL VARIABLES
==========================================================================================================================================*/

    var player;
    var filters = $.cookie('filters') != null ? $.cookie('filters') : '';
    var startVidOnLoad = false;
    var youtubeIframeLoaded = false;
    var playlistFilter = $.cookie('playlistFilter') != null ? $.cookie('playlistFilter') : '';
    var startIndex = 1;
    var resultsPerLoad = 10;
    var current = '';

/*==========================================================================================================================================
  INIT
==========================================================================================================================================*/

    $(function() {
      ////////////////////////////////////////////////////////////////////////////////////////////
      //  Load libraries & elements
      ////////////////////////////////////////////////////////////////////////////////////////////

      // This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');
      tag.src = "//www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // Add actual container for youtube iframe & light switch
      $('#player').append('<div id="YTplayer101"></div>');
      $('#player').append('<a class="YTlightSwitch" href="#">Light</a>');
      $('#player').append('<a class="YTpop" href="#">Pop</a>');
      $('#player').append('<a class="YTdrag" href="#">Drag</a>');
      $('#player').css('cursor', 'move').draggable({ constainment: '#playlist', scroll: false });
      $('#YTplayer101').resizable({ animate: true });
      $('#playlist').append('<a class="More" href="#">View More</a>');


      // Add playlist selection list in Options
      populateOptionsPlaylists();

      ////////////////////////////////////////////////////////////////////////////////////////////
      //  Set classes and initial function calling
      ////////////////////////////////////////////////////////////////////////////////////////////


      // Tracking first entry as current, and show as selected
      current = $('#playlist > a.vidSelection').first().attr('name');
      $('#playlist > a.vidSelection > div').first().addClass('selected');


      ////////////////////////////////////////////////////////////////////////////////////////////
      //  Set listeners
      ////////////////////////////////////////////////////////////////////////////////////////////

      // Listen for playlist vid clicking
      $('#playlist > a.vidSelection').click(function(e) {
        e.preventDefault();
        nextVideo();
      });

      // Listen for light switch button clicking (sets overlay)
      $('.YTlightSwitch').click(function(e) {
        e.preventDefault();
        toggleOverlay();
      });

      // Listen for Popping
      $('.YTpop').click(function(e) {
        e.preventDefault();
        togglePlayer();
      });

      // Listen for location of playlist scroll bar (add more vid when scrolled to a certain point)
      $('#playlist').scroll(function() {
        var maxHeight = $(this)[0].scrollHeight - $(this).height();

        //  If scrolled more than 98%, do this
        if (maxHeight * 0.98 < $(this).scrollTop()) {
          appendVids();
        }
      });

      // Listen for toggling of the option panel
      $('div.options a.toggle').click(function(e) {
        e.preventDefault();
        toggleOptions();
      });

      // Listen for the toggle of closing or openning playlist
      $('#playlist a.close').click(function(e) {
        e.preventDefault();
        toggleLeftBar();
      });

      // Listen for Search
      $('.options .search').click(function(e) {
        e.preventDefault();
        setFilterTxt($('.options .searchText').val());
        resetPlaylist();
      });

      $(".options .searchText").keyup(function(event){
        if(event.keyCode == 13){
          setFilterTxt($('.options .searchText').val());
          resetPlaylist();
        }
      });

      // Listen for browser resizing
      $(window).resize(winResize);

      $( window ).on('unload', setForReturn); 
      $( window ).click(function() {
        if ($(event.target).parents().index($('#leftBar')) == -1 && $(event.target).parents().index($('#showIntro')) == -1) {
          toggleOptions(false);
        }
      });
    });



/*==========================================================================================================================================
  FUNCTIONS
==========================================================================================================================================*/


    ////////////////////////////////////////////////////////////////////////////////////////////
    //  VIDEO STATES
    ////////////////////////////////////////////////////////////////////////////////////////////

    /*  Listens for when the Youtube library is properly loaded
    ------------------------------------------------------------------------------------------*/
    function onYouTubeIframeAPIReady() {
      if ($.cookie('leftBarIsOpened') != null) {
        toggleLeftBar($.cookie('leftBarIsOpened') == 'true', 0);
        toggleOptions($.cookie('optionsIsOpened') == 'true', 0);
        togglePlayer($.cookie('playerIsEnlarged') == 'true', 0);
        setFilterTxt($.cookie('filters'));
        setPlaylist($.cookie('playlistFilter').replace('/', ' '));
      }
      appendVids(null, function() {
        player = new YT.Player('YTplayer101', {
          height: '315',
          width: '560',
          videoId: $.cookie('selectedCode') != null ? $.cookie('selectedCode') : $('#playlist > a.vidSelection').eq(0).attr('name'),
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      });
      youtubeIframeLoaded = true;
    }

    /*  Listens for when the player is ready
    ------------------------------------------------------------------------------------------*/
    function onPlayerReady(event) {

      if (startVidOnLoad) {
        event.target.playVideo();
      }
      //  Since only applies first time, set the rest to be true
      startVidOnLoad = true;
      
      if ($.cookie('selectedCode') != null) {
        nextVideo($.cookie('selectedCode'), $.cookie('playerTime'));
        switch (parseInt($.cookie('playerState'))) {
          case 1:
            event.target.playVideo();
            break;
          case 2:
            event.target.pauseVideo();
            break;
        }
      } else {
        $('#playlist > a.vidSelection > div').first().addClass('selected');
      }

      winResize();
    }

    /*  Listens for when the state of the player has changed : 
    /*  ENDED, PLAYING, PAUSED, BUFFERING, CUED
    ------------------------------------------------------------------------------------------*/
    function onPlayerStateChange(event) {
      if (event.data == YT.PlayerState.ENDED) {
        nextVideo();
      }
    }

    /*  Stops the current video
    ------------------------------------------------------------------------------------------*/
    function stopVideo() {
      player.stopVideo();
    }

    /*  Pause the current video
    ------------------------------------------------------------------------------------------*/
    function pauseVideo() {
      player.pauseVideo();
    }

    /*  Switch the player to load the video with the Vid id passed in the parameter, 
    /*  while setting the selected vid bar (in playlist) with the code with class 'selected',
    /*  as well as scrolling selected vid bar (in playlist) to top
    ------------------------------------------------------------------------------------------*/
    function nextVideo(code, startSecond, callback) {
      // If didn't pass in parameter, set currently selected's next video's code as code
      if (code == undefined) {
        code = $('#playlist > a.vidSelection > div.selected').parent().next().attr('name');
      }
      //  Set class 'selected'
      $('#playlist > a.vidSelection > div').removeClass('selected');
      $('a[name="' + code + '"]').children('div').addClass('selected');

      //  Set new current and switch to next vid
      current = code;
      player.loadVideoById(code, startSecond != null ? startSecond : 0, "large");

      //  Scroll to proper location in playlist
      // alert($('a[name="' + current + '"]').offset().top);
      $('#playlist').animate({ scrollTop: ($('#playlist').scrollTop() + $('a.vidSelection[name="' + current + '"]').offset().top - $('#playlist').offset().top) }, 1000, callback);
      // $('#playlist').animate({ scrollTop: ($('#playlist').scrollTop() + $('a[name="' + current + '"]').offset().top - $('#playlist').offset().top) }, 1000, callback);
    }

    /*  Store information on cookie when page unloads.  For resume on return to page
    ------------------------------------------------------------------------------------------*/
    function setForReturn() {
      $.cookie('playerIsEnlarged', playerIsEnlarged(), { expires: 1, path: '/' });
      $.cookie('playerTime', player.getCurrentTime(), { expires: 1, path: '/' });
      $.cookie('leftBarIsOpened', leftBarIsOpened(), { expires: 1, path: '/' });
      $.cookie('optionsIsOpened', optionsIsOpened(), { expires: 1, path: '/' });
      $.cookie('startIndex', startIndex, { expires: 1, path: '/' });
      $.cookie('filters', filters, { expires: 1, path: '/' });
      $.cookie('playlistFilter', playlistFilter, { expires: 1, path: '/' });
      $.cookie('selectedCode', $('div.thumbnailBlock.selected').parent().attr('name'), { expires: 1, path: '/' });
      $.cookie('playerState', player.getPlayerState(), { expires: 1, path: '/' });
    }


    //////////////////////////////////////////////////////////////////////////////////////////// 
    //  PLAYER ACTIONS
    ////////////////////////////////////////////////////////////////////////////////////////////


    /*  Toggle video player from in left bar (#leftBar) to a more enlarged version, or reverse
    ------------------------------------------------------------------------------------------*/
    function togglePlayer(state, speed) {
      var openPlayer = state != null ? state : !$('#player').hasClass('YTmovePlayer');
      speed = speed != null ? speed / 2 : 500;

      if (openPlayer) {
        $('#player').stop().slideUp(speed, function() {
          $('#player').addClass('YTmovePlayer');
          $('#YTplayer101').addClass('YTiframeEnlarge');
          $('#player > .YTlightSwitch').addClass('YTpoppedColor');
          $('#player > .YTpop').addClass('YTpoppedColor');
          $('#player > .YTdrag').addClass('YTpoppedColor');
          winResize();
          $('#player').fadeIn(speed);
        });
      }
      else {
        $('#player').stop().fadeOut(speed, function() {
          if (!leftBarIsOpened()) {
            pauseVideo();
          }
          $('#player').removeClass('YTmovePlayer');
          $('#YTplayer101').removeClass('YTiframeEnlarge');
          $('#player > .YTlightSwitch').removeClass('YTpoppedColor');
          $('#player > .YTpop').removeClass('YTpoppedColor');
          $('#player > .YTdrag').removeClass('YTpoppedColor');
          winResize();
          $('#player').slideDown(speed);
        });
      }
    }

    /*  return state of player location
    ------------------------------------------------------------------------------------------*/
    function playerIsEnlarged() {
      return $('#player').hasClass('YTmovePlayer');
    }

    //////////////////////////////////////////////////////////////////////////////////////////// 
    //  OPTIONS ACTIONS
    ////////////////////////////////////////////////////////////////////////////////////////////

    /*  toggle options tab open/close, according to parameter (or current state)
    ------------------------------------------------------------------------------------------*/
    function toggleOptions(state, speed, callback) {
      var openOptions = state != null ? state : $('#leftBar div.options').css('right').replace('px', '') == 0;
      speed = speed != null ? speed : 1000;
      if (openOptions) {
        var moveRight = -1 * $('#leftBar div.options').outerWidth();
        $('#leftBar div.options').clearQueue().animate({"right": moveRight + "px"}, speed, callback);
      }
      else {
        $('#leftBar div.options').clearQueue().animate({"right":"0px"}, speed, callback);
      }
    }

    /*  return if options tab is open
    ------------------------------------------------------------------------------------------*/
    function optionsIsOpened() {
      return $('#leftBar div.options').css('right').replace('px', '') != 0;
    }

    /*  toggles options tab visible/invisible, according to parameter (or current state)
    ------------------------------------------------------------------------------------------*/
    function toggleOptionsVisible(state, callback) {
      var toVisible = state != null ? state : $('#leftBar div.options').css('display') == 'none';
      if (toVisible){
        $('#leftBar div.options').stop().fadeIn(callback);
      }
      else {
        $('#leftBar div.options').stop().fadeOut(callback);
      }
    }

    function setFilterTxt(string) {
      $('.options input.searchText').val(string);
      filters = string.trim().replace(/[^a-z0-9\s]/gi, '').replace(/ /g, '/');
    }

    /*  initial populating of playlistSelection
    ------------------------------------------------------------------------------------------*/
    function populateOptionsPlaylists() {
      // Set init elements
      $('#leftBar .options').append('<b class="playlistTitle">Select Playlist</b>');
      if ($('#leftBar .options .playlistSet').length == 0) {
        $('#leftBar .options').append('<div class="playlistSet"></div>');
      }

      var url = "https://gdata.youtube.com/feeds/api/users/redmercy/playlists?alt=json&v=2";
      //  Call URL and get returned JSON content into data
      $.getJSON(url, function(data) {
        var json = data;
        //  Add button to options panel
        $.each(json.feed.entry, function(key, val) {
          $('#leftBar .options .playlistSet').append('<a href="#" class="selectPlaylist" playlistid="' + val.yt$playlistId.$t + '">' + val.title.$t + '</a>');
        });
        // Set listener for these buttons
        $('#leftBar .options .selectPlaylist').click(function(event) {
          event.preventDefault();
          setPlaylist($(this).text());
          resetPlaylist();
        });
      });
    }

    /*  set playlist according the the selected playlist in options
    ------------------------------------------------------------------------------------------*/
    function setPlaylist(name) {
      playlistFilter = '';
      $('#leftBar div.options a.selectPlaylist').each(function() {
        if ($(this).text() == name && !$(this).hasClass('selected')) {
          $(this).addClass('selected');

          playlistFilter = name.trim().replace(/[^a-z0-9\s]/gi, '').replace(/ /g, '/');
        } else {
          $(this).removeClass('selected');
        }
      });
    }

    //////////////////////////////////////////////////////////////////////////////////////////// 
    //  TOGGLE LEFTBAR ACTIONS
    ////////////////////////////////////////////////////////////////////////////////////////////

    /*  toggles leftBar panel visible/invisible, according to parameter (or current state)
    ------------------------------------------------------------------------------------------*/
    function toggleLeftBar(state, speed, callback) {
      var openLeftBar = state != null ? state : $('#leftBar').position().left != 0;
      speed = speed != null ? speed : 1000;

      if (openLeftBar) {
        $('#leftBar').clearQueue().animate({'left': '0px'}, speed, callback);
        $('#playlist .close').text('<<');
        toggleOptionsVisible(true);
        // Shift content to right
        $('body').animate({marginLeft: $('#leftBar').css('width')});
      }
      else {
        $('#leftBar').clearQueue().animate({'left': '-' + $('#leftBar').outerWidth() + 'px'}, speed, callback);
        $('#playlist .close').text('YT');
        //  If player is not enlarged (in left bar), pause it, since it's going to be hidden anyways
        if (youtubeIframeLoaded && !playerIsEnlarged()) {
          pauseVideo();
        }
        toggleOptions(false, null, function() { toggleOptionsVisible(false); });

        //  Shift content back to center
        $('body').animate({marginLeft: '0px'});
      }
    }

    /*  check if LeftBar is opened
    ------------------------------------------------------------------------------------------*/
    function leftBarIsOpened() { return $('#leftBar').position().left == 0; };

    ////////////////////////////////////////////////////////////////////////////////////////////
    //  PLAYLIST SETTINGS
    ////////////////////////////////////////////////////////////////////////////////////////////

    /*  Resets the playlist with the preferred filter
    ------------------------------------------------------------------------------------------*/
    function resetPlaylist(filter) {
      $('.vidSelection').remove();
      startIndex = 1;
      appendVids(filter, function() {
        nextVideo($('#playlist > a.vidSelection').eq(0).attr('name'));
      });
    }

    /*  load list of entries from youtube API (json) to playlist
    /*  starting from the last index in playlist (or start from 1 if playlist is empty)
    ------------------------------------------------------------------------------------------*/
    function appendVids(filter, callback){
      var scrolledPos = $(this).scrollTop();
      var url = 'http://gdata.youtube.com/feeds/api/users/redmercy/uploads';
      //  If filter is applied, add filter
      if (filter != null) {
        filters = filter;
      }
      if (filters + playlistFilter != '') {
        url += '/-/' + (filters == '' ? '' : filters + '/') + playlistFilter;
      }
      //  Set return type to JSON and version 2
      url += '?alt=json&v=2';
      //  Set starting index
      url += '&start-index=' + startIndex;
      //  Set max amount of results
      url += '&max-results=' + resultsPerLoad;
      //  Call URL and get returned JSON content into data
      $.getJSON(url, function(data) {
        var json = data;

        //  Add list of videos to playlist[] and add to actual playlist as well
        // alert('hi' + json.feed.entry);
        if (json.feed.entry != undefined) {
          var count = json.feed.entry.length;
          $.each(json.feed.entry, function(key, val) {
            //playlist.push(val.media$group.yt$videoid.$t);
            $('#playlist > a:last').before(
              '<a href="#" class="vidSelection" name="' + val.media$group.yt$videoid.$t + '" key="' + startIndex++ + '">' + 
                '<div class="thumbnailBlock">' + 
                  '<img src="' + val.media$group.media$thumbnail[1].url + '" alt="' + val.media$group.media$title.$t + '" />' + 
                  '<p class="title">' + val.media$group.media$title.$t + '</p>' + 
                  '<p class="smallDetails"><b>Views:</b> ' + val.yt$statistics.viewCount + ' |  <b>Duration:</b> ' + getTime(val.media$group.yt$duration.seconds) + '</p>' + 
                  '<div style="clear: both;"></div>' + 
                '</div>' + 
              '</a>'
            );
            if (!--count) {
              if ($.cookie('startIndex') != null && startIndex < parseInt($.cookie('startIndex'))) {
                appendVids(null, callback);
              } else {
                $('#playlist > a.vidSelection').click(function(e) {
                  e.preventDefault();
                  nextVideo($(this).attr('name'));
                });
                $(this).scrollTop(scrolledPos);
                callback();
              }
            }
          });
        } else {
          if ($.cookie('startIndex') != null && startIndex < parseInt($.cookie('startIndex'))) {
                appendVids(null, callback);
              } else {
                $('#playlist > a.vidSelection').click(function(e) {
                  e.preventDefault();
                  nextVideo($(this).attr('name'));
                });
                $(this).scrollTop(scrolledPos);
                callback();
              }
        }
      });
    }

    /*  Load overlay to fade in, covering everything other than things in #leftBar,
    /*  as well as setting a listener for clicking the overlay (which removes it)
    ------------------------------------------------------------------------------------------*/
    function toggleOverlay(state) {
      var setOverlay = state != null ? state : $('body').has('.playerOverlay').size() == 0;

      if (setOverlay) {
        //  add overlay element
        $('body').append('<div class="playerOverlay"></div>');
        //  fade it in
        $('.playerOverlay').stop().fadeIn(1000);
        //  set listener for clicking overlay
        $('.playerOverlay').click(function() {
          //  fade out overlay then remove element
          $('.playerOverlay').stop().fadeOut(function() {
            $('.playerOverlay').remove();
          });
        });
      }
      else {
        //  fade overlay
        $('.playerOverlay').stop().fadeOut(function() {
          //  remove physical element
          $('.playerOverlay').remove();
        });
      }
    }


    ////////////////////////////////////////////////////////////////////////////////////////////
    //  resets the #leftBar height to fit perfectly
    ////////////////////////////////////////////////////////////////////////////////////////////
    function winResize() {
      // Set leftbar height
      $('#leftBar').height($(this).height() - $('header').height()).css('display', 'block');

      // Set playlist height according to whether player is popped or not
      if (!$('#player').hasClass('YTmovePlayer')) {
        $('#playlist').animate({height:($('#leftBar').outerHeight() - $('#player').outerHeight()) + "px"}, 500);
      } else {
        $('#playlist').animate({height:$('#leftBar').outerHeight() + "px"}, 500);
      }
    }



    function getTime(seconds) {
      //the amount of seconds we have left
      var leftover = seconds;
      //how many full days fits in the amount of leftover seconds
      var days = Math.floor(leftover / 86400);
      //how many seconds are left
      leftover = leftover - (days * 86400);
      //how many full hours fits in the amount of leftover seconds
      var hours = Math.floor(leftover / 3600);
      //how many seconds are left
      leftover = leftover - (hours * 3600);
      //how many minutes fits in the amount of leftover seconds
      var minutes = Math.floor(leftover / 60);
      //how many seconds are left
      leftover = leftover - (minutes * 60);

      return (days == 0 ? '' : days + ':') + (hours == 0 ? '' : hours + ':') + minutes + ':' + (leftover > 9 ? '': '0') + leftover;
    }