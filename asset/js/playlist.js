
/*==========================================================================================================================================
  GLOBAL VARIABLES
==========================================================================================================================================*/

    var player;
    //var playlist = [];
    var filters;
    var startVidOnLoad = false;
    var youtubeIframeLoaded = false;

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
      $('#playlist').append('<a class="More" href="#">View More</a>');

      ////////////////////////////////////////////////////////////////////////////////////////////
      //  Set classes and initial function calling
      ////////////////////////////////////////////////////////////////////////////////////////////

      // toggle the player to be enlarged
      //togglePlayer();

      // toogle leftBar to be hidden
      toggleLeftBar(false, function() { 
        $('#leftBar').css('display', 'block');
      });

      // Tracking first entry as current, and show as selected
      var current = $('#playlist > a.vidSelection').first().attr('name');
      $('#playlist > a.vidSelection > div').first().addClass('selected');


      ////////////////////////////////////////////////////////////////////////////////////////////
      //  Set listeners
      ////////////////////////////////////////////////////////////////////////////////////////////

      // Listen for playlist vid clicking
      $('#playlist > a.vidSelection').click(function(e) {
        e.preventDefault();
        nextVideo($(this).attr('name'));
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
          appendVids(filters);
        }
      });

      // Listen for toggling of the option panel
      $('div.options a.toggle').click(function(e) {
        e.preventDefault();
        if ($('div.options').css('right').replace('px', '') == 0) {
          var right = -1 * (parseInt($('div.options').css('width').replace('px', '')) + 20);
          $('div.options').animate({"right": right + "px"}, "slow");
        }
        else {
          $('div.options').animate({"right":"0px"}, "slow");
        }
      });

      // Listen for the toggle of closing or openning playlist
      $('#playlist a.close').click(function() {
        toggleLeftBar();
      });

      // Listen for Search
      $('.options .search').click(function(e) {
        e.preventDefault();

        var searchString = $('.options .searchText').val();
        //  Split string by spaces
        var wordList = searchString.split(" ");
        filters = "";
        for (word in wordList) {
          filters += wordList[word] + "/";
        }
        resetPlaylist();
      });

      $(".options .searchText").keyup(function(event){
        if(event.keyCode == 13){
          var searchString = $('.options .searchText').val();
          //  Split string by spaces
          var wordList = searchString.split(" ");
          filters = "";
          for (word in wordList) {
            filters += wordList[word] + "/";
          }
          resetPlaylist();
        }
      });

      // Listen for browser resizing
      $(window).resize(winResize);
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
      appendVids(filters, function() {
        $('#playlist > a.vidSelection > div').first().addClass('selected');
        player = new YT.Player('YTplayer101', {
          height: '315',
          width: '560',
          videoId: $('#playlist > a.vidSelection').eq(0).attr('name'),
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
    }

    /*  Listens for when the state of the player has changed : 
    /*  ENDED, PLAYING, PAUSED, BUFFERING, CUED
    ------------------------------------------------------------------------------------------*/
    function onPlayerStateChange(event) {
      if (event.data == YT.PlayerState.ENDED) {
        nextVideo($('a[name="' + current + '"]').next().attr('name'));
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
    function nextVideo(code) {
      //  Set class 'selected'
      $('#playlist > a.vidSelection > div').removeClass('selected');
      $('a[name="' + code + '"]').children('div').addClass('selected');

      //  Set new current and switch to next vid
      current = $('a[name="' + code + '"]').attr('name');
      player.loadVideoById(current, 0, "large");

      //  Scroll to proper location in playlist
      $('#playlist').animate({ scrollTop: ($('#playlist').scrollTop() + $('a[name="' + current + '"]').offset().top - $('#playlist').offset().top) }, 1000);
    }


    //////////////////////////////////////////////////////////////////////////////////////////// 
    //  PLAYER ACTIONS
    ////////////////////////////////////////////////////////////////////////////////////////////


    /*  Toggle video player from in left bar (#leftBar) to a more enlarged version, or reverse
    ------------------------------------------------------------------------------------------*/
    function togglePlayer(state) {
      //alert($('.leftBar:has(#player').size());
      var openPlayer = state != null ? state : !$('#player').hasClass('YTmovePlayer');

      if (openPlayer) {
        $('#player').stop().slideUp(500, function() {
          $('#player').addClass('YTmovePlayer');
          $('#YTplayer101').addClass('YTiframeEnlarge');
          $('#player > .YTlightSwitch').addClass('YTpoppedColor');
          $('#player > .YTpop').addClass('YTpoppedColor');
          $('#player').fadeIn(1000);
        });
      }
      else {
        $('#player').stop().fadeOut(1000, function() {
          $('#player').removeClass('YTmovePlayer');
          $('#YTplayer101').removeClass('YTiframeEnlarge');
          $('#player > .YTlightSwitch').removeClass('YTpoppedColor');
          $('#player > .YTpop').removeClass('YTpoppedColor');
          $('#player').slideDown(500);
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
    function toggleOptions(state, callback) {
      var openOptions = state != null ? state : $('div.options').css('right').replace('px', '') == 0;
      if (openOptions) {
        var right = -1 * (parseInt($('div.options').css('width').replace('px', '')) + 20);
        $('div.options').animate({"right": right + "px"}, "slow", callback);
      }
      else {
        $('div.options').animate({"right":"0px"}, "slow", callback);
      }
    }

    /*  return if options tab is open
    ------------------------------------------------------------------------------------------*/
    function optionsIsOpen() {
      return $('div.options').css('right').replace('px', '') != 0;
    }

    /*  toggles options tab visible/invisible, according to parameter (or current state)
    ------------------------------------------------------------------------------------------*/
    function toggleOptionsVisible(state, callback) {
      var toVisible = state != null ? state : $('div.options').css('display') == 'none';
      if (toVisible){
        $('div.options').stop().fadeIn(callback);
      }
      else {
        $('div.options').stop().fadeOut(callback);
      }
    }


    //////////////////////////////////////////////////////////////////////////////////////////// 
    //  OPTIONS ACTIONS
    ////////////////////////////////////////////////////////////////////////////////////////////

    /*  toggles leftBar panel visible/invisible, according to parameter (or current state)
    ------------------------------------------------------------------------------------------*/
    function toggleLeftBar(state, callback) {
      var openLeftBar = state != null ? state : $('#leftBar').position().left != 0;
      if (openLeftBar) {
        $('#leftBar').animate({'left': '0px'}, 'slow', callback);
        $('#playlist .close').text('<<');
        toggleOptionsVisible(true);
      }
      else {
        $('#leftBar').animate({'left': '-' + $('#leftBar').outerWidth() + 'px'}, 'slow', callback);
        $('#playlist .close').text('YT');
        //  If player is not enlarged (in left bar), pause it, since it's going to be hidden anyways
        if (youtubeIframeLoaded && !playerIsEnlarged()) {
          pauseVideo();
        }
        toggleOptions(false, function() { toggleOptionsVisible(false); });
      }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////
    //  PLAYLIST SETTINGS
    ////////////////////////////////////////////////////////////////////////////////////////////

    /*  Resets the playlist with the preferred filter
    ------------------------------------------------------------------------------------------*/
    function resetPlaylist(filter) {
      $('.vidSelection').remove();
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
      if (filters != null && filters != '') {
        url += '/-/' + filters;
      }
      //  Set return type to JSON and version 2
      url += '?alt=json&v=2';
      //  Set starting index
      var lastIndex = parseInt($('#playlist > a.vidSelection').eq($('#playlist > a').length - 1).attr('key'));
      url += '&start-index=' + (isNaN(lastIndex) ? 1 : lastIndex);
      //  Set max amount of results
      var maxResults = 10;
      url += '&max-results=' + maxResults;
    
      //  Call URL and get returned JSON content into data
      $.getJSON(url, function(data) {
        var json = data;

        //  Add list of videos to playlist[] and add to actual playlist as well
        $.each(json.feed.entry, function(key, val) {
          //playlist.push(val.media$group.yt$videoid.$t);
          $('#playlist > a:last').before(
            '<a href="#" class="vidSelection" name="' + val.media$group.yt$videoid.$t + '" tooltip="hi" key="' + lastIndex++ + '">' + 
              '<div class="thumbnailBlock">' + 
                '<img src="' + val.media$group.media$thumbnail[1].url + '" alt="' + val.media$group.media$title.$t + '" />' + 
                '<p class="title">' + val.media$group.media$title.$t + '</p>' + 
                '<p class="smallDetails"><b>Views:</b> 12393 |  <b>Duration:</b> ' + '' + '</p>' + 
                '<div style="clear: both;"></div>' + 
              '</div>' + 
            '</a>'
          );
        });
        $('#playlist > a.vidSelection').click(function(e) {
          e.preventDefault();
          nextVideo($(this).attr('name'));
        });
        callback();
      });
      $(this).scrollTop(scrolledPos);
      winResize();
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
      $('#leftBar').height($(this).height() - $('header').height());
    }



