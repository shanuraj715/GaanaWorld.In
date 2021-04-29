function get_hostname(url) {
    var m = url.match(/^http:\/\/[^/]+/);
    return m ? m[0] : null;
}
document.addEventListener('contextmenu', event => event.preventDefault());
// const HOST_NAME = get_hostname( window.location.href )
const HOST_NAME = "https://gaanaworld.in"
let USER_EMAIL
// PLAYER VARS AND CONSTANTS
let REPEAT = false
let PREV_SONG = 0
let NEXT_SONG = 0
let IS_PLAYING = false
let CURRENT_SONG = 0
let MUTED = false

let FAV_SONGS = []
let QUEUE = []
let PLAYING_SONG_INDEX_FROM_FAV_LIST = 0

let PAGE_TITLE = ''


/* INTERVAL VARIABLES */
// let SONG_CURR_POSITION



// audio element
let AUDIO_ELEM = ''

$(document).ready( () => {
    USER_EMAIL = $('#user-email-container').html()
    // login functionality
    $('#fs-login-btn').click( () => {
        const userEmail = $('#fs-login-inp').val()
        $.ajax({
            type: 'POST',
            url: HOST_NAME + '/ajax/login.php',
            data: 'email=' + userEmail,
            dataType: 'json',
            success: data => {
                if( data.status ){
                    location.reload();
                }
            },
            error: () => {
                console.log("error")
            }
        })
    })
    
    if( USER_EMAIL !== '' ){
        getFavSongs()
    }
    
})

function getSongData( songId ){
    $.ajax({
        type: 'POST',
        url: HOST_NAME + '/ajax/getSongData.php',
        data: 'sid=' + songId,
        dataType: 'json',
        success: data => {
            if( data.status ){
                const song_title = data.title
                const song_image = data.image
                const song_file = data.file

                PAGE_TITLE = data.pageTitle
                $('#fs-song-title').html( song_title )
                $('#fs-song-img').attr('src', song_image)
                $('#fs-audio-player').attr('src', song_file)
                CURRENT_SONG = songId
                AUDIO_ELEM = $('#fs-audio-player')[0]
                play()
                set_current_pos()
            }
        },
        error: () => {
            console.log("error")
        }
    })
}

function listFavSongs(){
    FAV_SONGS.map( ( item, index ) => {
        let element = document.createElement('div')
        element.title = item.title
        element.className = 'fs-song-row fs-fav-song-card-width'
        element.innerHTML = `<span class="fs-row-song-title"><i class="fas fa-star fs-row-icon"></i>` + item.title + `</span>
        <div class="fs-song-row-btn-cont">
            <button class="fs-row-btn"><i class="far fa-trash-alt"></i></button>
        </div>`
        element.onclick = ( function(){ return favSongCardClick(index)})
        document.getElementById('fs-fav-songs-container').appendChild( element )
    })
}

function getFavSongs(){
    $.ajax({
        type: 'GET',
        url: HOST_NAME + '/ajax/getFavSongsList.php',
        data: '',
        dataType: 'json',
        success: data => {
            if( data.status ){
                FAV_SONGS = data.data
                listFavSongs()
            }
            else{
                console.log("SOME ERROR OCCURED")
            }
        },
        error: () => {
            console.log("ERROR")
        }
    })
}

function play(){
    IS_PLAYING = true
    AUDIO_ELEM.play()
    $('#play-pause-btn-icon').removeClass('fa-play').addClass('fa-pause')
}

function pause( bool_val ){
    IS_PLAYING = false
    AUDIO_ELEM.pause()
    if( bool_val ){
        seekAudio( 0 )
    }
    $('#play-pause-btn-icon').removeClass('fa-pause').addClass('fa-play')
}

$('#play-pause-btn').click( () => {
    if( AUDIO_ELEM === '' ){
        getSongData( 604534 )
    }
    else{
        if( AUDIO_ELEM.paused ){
            play()  
        }
        else{
            pause() 
        }
    }
})

function set_current_pos(){
    window.SONG_CURR_POSITION = setInterval( () => {
        if( IS_PLAYING ){
            let audio_seeker = document.getElementById('fs-player-slider');
            audio_seeker.value = (AUDIO_ELEM.currentTime / AUDIO_ELEM.duration) * 100;
            
            let duration = AUDIO_ELEM.duration
            $('#fs-player-slider').attr('max', Math.floor(duration))
            $('#fs-player-slider').val( AUDIO_ELEM.currentTime )
            $('#fs-player-time').html(audioDurationToTime());
            $('#fs-player-length-text').html(audioRemainTime());
            if( Math.floor( AUDIO_ELEM.duration ) - Math.floor( AUDIO_ELEM.currentTime ) === 0 && !REPEAT ){
                pause( true )
                next()
            }
            if( Math.floor(AUDIO_ELEM.duration) - Math.floor(AUDIO_ELEM.currentTime) === 0 && REPEAT ){
                AUDIO_ELEM.currentTime = 0
            }
        }
            
    }, 1000);
}

$('#fs-player-slider').change( event => {
    seekAudio( event )
})

function next(){
    let found = false
    QUEUE.map( (item, index) => {
        if( item.songId === CURRENT_SONG ){
            clearInterval( SONG_CURR_POSITION )
            found = true
            QUEUE[index + 1] ? getSongData( QUEUE[index + 1].songId ) : null
        }
    })
    if( !found ){
        clearInterval( SONG_CURR_POSITION )
        // QUEUE.length = 0
    }
}

function seekAudio( position ){
    if( position >= 0 && position !== undefined ){
        AUDIO_ELEM.currentTime = position
        document.getElementById('fs-player-slider').value = position
        $('#fs-player-time').html(audioDurationToTime( position ));
        $('#fs-player-length-text').html(audioRemainTime( position ));
    }
    else{
        var seekto = (document.getElementById('fs-player-slider').value);
        AUDIO_ELEM.currentTime = seekto;
    }
}


function audioDurationToTime( position ){
	let duration = position && position !== '' ? position : AUDIO_ELEM.currentTime;
	let min = 0;
	let sec = 0;

	min = Math.floor(duration / 60);
	sec = Math.ceil(duration - ( 60 * min));
	if(sec == 60){
		min = min + 1;
		sec = 0;
	}

	min = ('0' + min).slice(-2);
	sec = ('0' + sec).slice(-2);
	let string = min + ':' + sec;
	return string;
}

audioRemainTime = ( position ) => {
	let remain = position && position!== '' ? AUDIO_ELEM.duration - position : AUDIO_ELEM.duration - AUDIO_ELEM.currentTime;
	let min = 0;
	let sec = 0;

	min = Math.floor( remain / 60 );
	sec = Math.floor( remain - ( 60 * min ) );
	if(sec == 60){
		min = min + 1;
		sec = sec - 1;
	}

	min = ('0' + min).slice(-2);
	sec = ('0' + sec).slice(-2);
	let string = min + ':' + sec;

	return string;
}

// REPEAT FUNCTIONALITY
$('#repeat-btn').click(() => {
    if( !REPEAT ){
        REPEAT = true
        $('#repeat-btn-icon').addClass('fa-repeat-1-alt').removeClass('fa-repeat-alt')
    }
    else{
        REPEAT = false
        $('#repeat-btn-icon').addClass('fa-repeat-alt').removeClass('fa-repeat-1-alt')
    }
})

// DOWNLOAD SONG FUNCTIONALITY
$('#fs-download-btn').click( () => {
    CURRENT_SONG !== 0 ? window.open( HOST_NAME +'/ajax/downloadFile.php?sid=' + CURRENT_SONG, '_self' ) : null
})

$('#fs-open-external').click( () => {
    window.open( HOST_NAME + '/song/' + CURRENT_SONG + '/' + PAGE_TITLE, '_blank')
})

function favSongCardClick( index ){
    PLAYING_SONG_INDEX_FROM_FAV_LIST = index
    getSongData( FAV_SONGS[index].songId )
    refreshSongQueue( index )
}

function refreshSongQueue( index ){
    QUEUE = []
    if( index !== undefined && index !== null ){
        FAV_SONGS.map( (item, i) => {
            if( i >= index ){
                QUEUE.push( item )
            }
        })
        FAV_SONGS
    }
    
    queue()
}


$('#fs-mute-btn').click( () => {
    if( MUTED ){
        MUTED = false
        AUDIO_ELEM.muted = false
        $('#fs-mute-btn-icon').addClass('fa-volume-up').removeClass('fa-volume-mute')
    }
    else{
        MUTED = true
        AUDIO_ELEM.muted = true
        $('#fs-mute-btn-icon').addClass('fa-volume-mute').removeClass('fa-volume-up')
    }
})

$('#fs-next-song-btn').click( () => {
    QUEUE.map( (item, index) => {
        if( item.songId === CURRENT_SONG ){
            QUEUE[index + 1] ? getSongData(QUEUE[index + 1].songId) : null
        }
    })
})

$('#fs-prev-song-btn').click( () => {
    QUEUE.map( (item, index) => {
        if( item.songId === CURRENT_SONG ){
            QUEUE[index - 1] ? getSongData(QUEUE[index - 1].songId) : null
        }
    })
})

function removeSongFromQueue( songId ){
    QUEUE.map( (item, index) => {
        if( item.songId === songId ){
            QUEUE.splice( index, 1 )
            if( songId === CURRENT_SONG ){
                QUEUE[index] ? getSongData( QUEUE[index].songId ) : null 
            }
        }
    })
    queue()
}

function queue(){
    document.getElementById('fs-queue-container').innerHTML = ''
    QUEUE.map( (item,index) => {
        let element = document.createElement('div')
        element.className = 'fs-song-row'
        let span = document.createElement('span')
        span.className = 'fs-row-song-title'
        span.innerHTML = item.title
        span.onclick = ( function(){ return getSongData( item.songId )})
        
        let innerDiv = document.createElement('div')
        innerDiv.className = 'fs-song-row-btn-cont'

        let button = document.createElement('button')
        button.className = 'fs-row-btn'
        button.onclick = (function(){ return removeSongFromQueue( item.songId )})
        button.innerHTML = '<i class="far fa-times"></i>'

        innerDiv.appendChild( button )
        element.appendChild(span)
        element.appendChild( innerDiv )
        document.getElementById('fs-queue-container').appendChild( element )
    })
}

function setNextSong( sid ){
    NEXT_SONG = sid
}

function setPrevSong( sid ){
    PREV_SONG = sid
}

// LOGOUT

$('#fs-logout-btn').click( () => {
    $.ajax({
        type: 'get',
        url: HOST_NAME + '/ajax/logout.php',
        data: '',
        dataType: 'json',
        success: data => {
            if( data.status ){
                window.open(HOST_NAME, '_self');
            }
        },
        error: () => {
            console.log("SOME ERROR OCCURED")
        }
    })
})