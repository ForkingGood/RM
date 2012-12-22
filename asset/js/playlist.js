
/*==========================================================================================================================================
  GLOBAL VARIABLES
==========================================================================================================================================*/

    var player;


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

      // Pop the player to be enlarged
      movePlayer();

      // Tracking first entry as current, and show as selected
      var current = $('#playlist > a').first().attr('name');
      $('#playlist > a > div').first().addClass('selected');


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
        if ($('body').has('.playerOverlay').size() != 0){
          $('.playerOverlay').stop().fadeOut(function() {
            $('.playerOverlay').remove();
          });
        }
        else {
          setOverlay();
        }
      });

      // Listen for Popping
      $('.YTpop').click(function(e) {
        e.preventDefault();
        movePlayer();
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
        if ($('#leftBar').position().left == 0) {
          $('#leftBar').animate({'left': '-' + $('#leftBar').outerWidth() + 'px'}, 'slow');
          $(this).text('>>');
        }
        else {
          $('#leftBar').animate({'left': '0px'}, 'slow');
          $(this).text('<<');
        }
      });

      //  Listen for browser resizing
      $(window).resize(winResize);
    });



/*==========================================================================================================================================
  FUNCTIONS
==========================================================================================================================================*/


    ////////////////////////////////////////////////////////////////////////////////////////////
    //  Listens for when the Youtube library is properly loaded
    ////////////////////////////////////////////////////////////////////////////////////////////
    function onYouTubeIframeAPIReady() {
      appendVids(function() {
        $('#playlist > a > div').first().addClass('selected');
        player = new YT.Player('YTplayer101', {
          height: '315',
          width: '560',
          videoId: $('#playlist > a.vidSelection').eq(0).attr('name'),
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
        setOverlay();
      });
    }

    ////////////////////////////////////////////////////////////////////////////////////////////
    //  Listens for when the player is ready
    ////////////////////////////////////////////////////////////////////////////////////////////
    function onPlayerReady(event) {
      event.target.playVideo();
    }

    //////////////////////////////////////////////////////////////////////////////////////////// 
    //  Listens for when the state of the player has changed : 
    //  ENDED, PLAYING, PAUSED, BUFFERING, CUED
    ////////////////////////////////////////////////////////////////////////////////////////////
    function onPlayerStateChange(event) {
      if (event.data == YT.PlayerState.ENDED) {
        nextVideo($('a[name="' + current + '"]').next().attr('name'));
      }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////
    //  Stops the current video
    ////////////////////////////////////////////////////////////////////////////////////////////
    function stopVideo() {
      player.stopVideo();
    }

    //////////////////////////////////////////////////////////////////////////////////////////// 
    //  Switch the player to load the video with the Vid id passed in the parameter, 
    //  while setting the selected vid bar (in playlist) with the code with class 'selected',
    //  as well as scrolling selected vid bar (in playlist) to top
    ////////////////////////////////////////////////////////////////////////////////////////////
    function nextVideo(code) {
      //  Set class 'selected'
        $('#playlist > a > div').removeClass('selected');
        $('a[name="' + code + '"]').children('div').addClass('selected');

        //  Set new current and switch to next vid
        current = $('a[name="' + code + '"]').attr('name');
        player.loadVideoById(current, 0, "large");

        //  Scroll to proper location in playlist
        $('#playlist').animate({ scrollTop: ($('#playlist').scrollTop() + $('a[name="' + current + '"]').offset().top - $('#playlist').offset().top) }, 1000);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////
    //  Load overlay to fade in, covering everything other than things in #leftBar,
    //  as well as setting a listener for clicking the overlay (which removes it)
    ////////////////////////////////////////////////////////////////////////////////////////////
    function setOverlay() {
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

    ////////////////////////////////////////////////////////////////////////////////////////////
    //  load list of entries from youtube API (json) to playlist
    //  starting from the last index in playlist (or start from 1 if playlist is empty)
    ////////////////////////////////////////////////////////////////////////////////////////////
    function appendVids(callback){
      var scrolledPos = $(this).scrollTop();
      var url = 'http://gdata.youtube.com/feeds/api/users/redmercy/uploads?alt=json&v=2';
      var lastIndex = parseInt($('#playlist > a.vidSelection').eq($('#playlist > a').length - 1).attr('key'));
      var maxResults = 10;
      var init = false;
      if (isNaN(lastIndex)) {
        lastIndex = 0;
        init = true;
      }

      $.getJSON(url + "&start-index=" + (++lastIndex) + "&max-results=" + maxResults, function(data) {
        var json = data;
        var playlist = [];

        //  Add list of videos to playlist[] and add to actual playlist as well
        $.each(json.feed.entry, function(key, val) {
          playlist.push(val.media$group.yt$videoid.$t);
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
        $('#playlist > a').click(function(e) {
          e.preventDefault();
          nextVideo($(this).attr('name'));
        });
        callback();
      });
      $(this).scrollTop(scrolledPos);
    }

    //////////////////////////////////////////////////////////////////////////////////////////// 
    //  Toggle video player from in left bar (#leftBar) to a more enlarged version, or reverse
    ////////////////////////////////////////////////////////////////////////////////////////////
    function movePlayer() {
      //alert($('.leftBar:has(#player').size());
        if (!$('#player').hasClass('YTmovePlayer')) {
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

    ////////////////////////////////////////////////////////////////////////////////////////////
    //  resets the #leftBar height to fit perfectly
    ////////////////////////////////////////////////////////////////////////////////////////////
    function winResize() {
      $('#leftBar').height($(this).height() - $('header').height());
    }



