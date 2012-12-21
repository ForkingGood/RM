   // This code loads the IFrame Player API code asynchronously.
    var tag = document.createElement('script');
    tag.src = "//www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // Tracking first entry as current
    var current = $('#playlist > a').first().attr('name');
    $('#playlist > a > div').first().addClass('selected');

    // Add actual container for youtube iframe & light switch
    $('#player').append('<div id="YTplayer101"></div>');
    $('#player').append('<a class="YTlightSwitch" href="#">Light</a>');
    $('#player').append('<a class="YTpop" href="#">Pop</a>');
    $('#playlist').append('<a class="More" href="#">View More</a>');

    var player;
    function onYouTubeIframeAPIReady() {
      appendVids(function() {
        $('#playlist > a > div').first().addClass('selected');
        player = new YT.Player('YTplayer101', {
          height: '315',
          width: '560',
          videoId: $('#playlist > a').eq(0).attr('name'),
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
        setOverlay();
      });
    }

    function onPlayerReady(event) {
      event.target.playVideo();
    }

    function onPlayerStateChange(event) {
      if (event.data == YT.PlayerState.ENDED) {
        nextVideo($('a[name="' + current + '"]').next().attr('name'));
      }
    }

    function stopVideo() {
      player.stopVideo();
    }

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
    function appendVids(callback){
      var scrolledPos = $(this).scrollTop();
      var url = 'http://gdata.youtube.com/feeds/api/users/redmercy/uploads?alt=json&v=2';
      var lastIndex = parseInt($('#playlist > a').eq($('#playlist > a').length - 2).attr('key'));
      var init = false;
      if (isNaN(lastIndex)) {
        lastIndex = 0;
        init = true;
      }

      $.getJSON(url + "&start-index=" + (++lastIndex) + "&max-results=" + '10', function(data) {
        var json = data;
        var playlist = [];

        //  Add list of videos to playlist[] and add to actual playlist as well
        $.each(json.feed.entry, function(key, val) {
          playlist.push(val.media$group.yt$videoid.$t);
          $('#playlist > a:last').before(
            '<a href="#" name="' + val.media$group.yt$videoid.$t + '" tooltip="hi" key="' + lastIndex++ + '">' + 
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

    function winResize() {
      $('#leftBar').height($(this).height() - $('header').height());
    }

    $(function() {
      $('#playlist > a').click(function(e) {
        e.preventDefault();
        nextVideo($(this).attr('name'));
      });

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

      $('.YTpop').click(function(e) {
        e.preventDefault();
        movePlayer();
      });
      movePlayer();

      $('#playlist').scroll(function() {
        var maxHeight = $(this)[0].scrollHeight - $(this).height();

        //  If scrolled more than 98%, do this
        if (maxHeight * 0.98 < $(this).scrollTop()) {
          appendVids();
        }
      });

      $(window).resize(winResize);
    });