<style>
    .ytcontainer {
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 56.25%;
    }
    .ytvideo {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
<div class="row jlr-dashbox">
    <div class="col-lg-11 col-lg-offset-0">

        <div class="box">
            <div class="box-header">
                <center><h3>Jams</h3></center>
            </div>
            <div class="box-body scroll-snappers">
                <div class="row">
                    <div class="col-lg-12">
                        <center>
                            <div class="col-sm-12 snapit">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?php if(strpos($result->link, '=') !== FALSE) { ?>
                                            <?php $hash = substr($result->link, strpos($result->link, '=')+1); ?>
                                        <?php } else { ?>
                                            <?php $hash = substr($result->link, strpos($result->link, 'be/')+3); ?>
                                        <?php } ?>
                                        <div class="ytcontainer">
                                            <div id="player" class="ytvideo"></div>
                                        </div>
                                        <script>
                                            // documentation
                                            // https://developers.google.com/youtube/iframe_api_reference

                                            // 2. This code loads the IFrame Player API code asynchronously.
                                            var tag = document.createElement('script');
                                            var lastId = 0;
                                            var counter = 0;

                                            tag.src = "https://www.youtube.com/iframe_api";
                                            var firstScriptTag = document.getElementsByTagName('script')[0];
                                            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                                            // 3. This function creates an <iframe> (and YouTube player)
                                            //    after the API code downloads.
                                            var player;
                                            function onYouTubeIframeAPIReady() {
                                                player = new YT.Player('player', {
                                                    events: {
                                                        'onReady': onPlayerReady,
                                                        'onStateChange': onPlayerStateChange
                                                    }
                                                });
                                            }

                                            // 4. The API will call this function when the video player is ready.
                                            function onPlayerReady(event) {
                                                // cue a playlist.
                                                player.cuePlaylist({list: 'PL92F-0qxnJkOS9ZqBeIrl6WJkKCVqtzTp'});
                                                var playlist = player.getPlaylist();
                                                var newPlaylist = [];
                                                <?php foreach($jams as $jam) { ?>
                                                <?php if(strpos($jam->i_r_c_jam->link, '=') !== FALSE) { ?>
                                                <?php $hash = substr($jam->i_r_c_jam->link, strpos($jam->i_r_c_jam->link, '=')+1); ?>
                                                <?php } else { ?>
                                                <?php $hash = substr($jam->i_r_c_jam->link, strpos($jam->i_r_c_jam->link, 'be/')+3); ?>
                                                <?php } ?>
                                                newPlaylist.push('<?= $hash ?>');
                                                <?php $jammer = $jam; ?>
                                                <?php } ?>
                                                lastId = <?= $jammer->id ?>;
                                                player.loadPlaylist({playlist: newPlaylist});
                                                player.playVideo();
                                            }

                                            // 5. The API calls this function when the player's state changes.
                                            //    The function indicates that when playing a video (state=1),
                                            //    the player should play for six seconds and then stop.
                                            var done = false;
                                            function onPlayerStateChange(event) {
                                                if (event.data === 0) {
                                                    counter++;
                                                    // load in the new playlist after the first cue event occurs.
                                                    once = false;
                                                    // get the video id's from the playlist.
                                                    var playlist = player.getPlaylist();
                                                    var newPlaylist = [];
                                                    var played = playlist[counter-1];

                                                    $.ajax({
                                                        type: "GET",
                                                        url: "/i_r_c_jams/jams/ajax_played/" + played,
                                                        success: function (data) {

                                                        },
                                                        error: function (data) {

                                                        }
                                                    });

                                                    for (var i = counter; i < playlist.length; i++) {
                                                        newPlaylist.push(playlist[i]);
                                                    }
                                                    // create the new playlist with additional video id's.
                                                    $.ajax({
                                                        type: "GET",
                                                        url: "/i_r_c_jams/jams/ajax_player/" + lastId,

                                                        success: function (data) {

                                                            var playList = data.jams;

                                                            for(var xx = 0; xx < playList.length; xx++) {
                                                                lastId = playList[xx].id;
                                                                var hash = playList[xx].i_r_c_jam.link;
                                                                if(hash.indexOf('=') == -1) {
                                                                    hash = hash.split('e/');
                                                                }
                                                                else {
                                                                    hash = hash.split('=');
                                                                }
                                                                hash = hash[1];
                                                                newPlaylist.push(hash);
                                                            }

                                                            if(counter == playlist.length && playList.length == 0) {
                                                                newPlaylist.push('oHg5SJYRHA0');
                                                            }

                                                            player.loadPlaylist({playlist: newPlaylist});
                                                            player.playVideo();

                                                            return false;
                                                        },
                                                        error: function (data) {

                                                            return false;
                                                        }
                                                    });

                                                    counter = 0;
                                                }
                                            }
                                        </script>
                                    </div>
                                </div>
                                <hr/>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
