var audio = $('#song_player')[0];
// console.log(audio);
let play_pause_btn = $('.play-pause');
let audio_seeker = $('#audio_seeker');

play_pause_btn.click(() => {
	set_current_pos();
	if(audio.paused){
		audio.play();
		$('.play-pause').removeClass('fa-play');
		$('.play-pause').addClass('fa-pause');
		$('.visualizer_button_block').show(500);
		$('#visualizer_checkbox').css('opacity', '1');
		$('.visualizer_cb_text').css('opacity', '1');
	}
	else{
		audio.pause();
		$('.play-pause').removeClass('fa-pause');
		$('.play-pause').addClass('fa-play');
		$('.visualizer_button_block').hide(500);
		$('#visualizer_checkbox').css('opacity', '0');
		$('.visualizer_cb_text').css('opacity', '0');
	}
});

$('#volume_seeker').change(() => {
	volume_controller();
})

$('#audio_seeker').change( ( event ) => {
	audio_controler( event );
});

volume_controller = () => {
	audio.volume = volume_seeker.value / 100;
	// console.log('Setting Audio Volume to : ' + audio.volume);
}

audio_controler = (event) => {
	// $('#audio_seeker').value = event.clientX - audio_seeker.offsetLeft;
	var seekto = Math.floor(audio.duration * (document.getElementById('audio_seeker').value) / 100);
	// console.log('Seeking to : ' + seekto);
	audio.currentTime = seekto;
}

function set_current_pos(){
	var interval = setInterval( () => {
		let audio_seeker = document.getElementById('audio_seeker');
		audio_seeker.value = (audio.currentTime / audio.duration) * 100;
		// console.log(audio_seeker.value);
		if(audio.currentTime == audio.duration){
			$('.play-pause').removeClass('fa-pause');
			$('.play-pause').addClass('fa-play');
			// console.log('RUNNED');
			// clearInterval(interval);

		}
		if(audio.paused == true){
			$('.play-pause').removeClass('fa-pause');
			$('.play-pause').addClass('fa-play');
			// clearInterval(interval);
		}
		else{
			$('.play-pause').removeClass('fa-play');
			$('.play-pause').addClass('fa-pause');            
		}

		if( $('#repeat_cb_btn').prop('checked') && audio.paused == true && audio.duration == audio.currentTime ){
			audio.play();
		}
		$('#player_audio_time').html(audioDurationToTime());
		$('#player_audio_remain').html(audioRemainTime());
	}, 1000);
}

function audioDurationToTime(){
	let duration = audio.currentTime;
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

audioRemainTime = () => {
	let remain = audio.duration - audio.currentTime;
	let min = 0;
	let sec = 0;

	min = Math.floor( remain / 60 );
	sec = Math.ceil( remain - ( 60 * min ) );
	if(sec == 60){
		min = min + 1;
		sec = sec - 1;
	}

	min = ('0' + min).slice(-2);
	sec = ('0' + sec).slice(-2);
	let string = min + ':' + sec;

	return string;
}

$(document).ready( () => {

	$('.setting_icon').click(() => {
		showSettingsPopup();
	})

	$('#player_popup_close').click( () => {
		hideSettingsPopup();
	})

	$('.player_sett_close_btn').click( () => {
		hideSettingsPopup();
	})
})

showSettingsPopup = () => {


	$('.player_popup_bg').css('display', 'initial');
	$('.player_popup_bg').addClass('player_popup_animation');
	// $('body').css('max-height', '100vh');
	// $('body').css('overflow', 'hidden');
}

hideSettingsPopup = () => {
	$('.player_popup_bg').css('display', 'none');
	// $('body').css('max-height', 'initial');
	// $('body').css('overflow', 'initial');
	$('.player_popup_bg').removeClass('player_popup_animation');
}

$(document).on('scroll', () => {

	let top = $(window).scrollTop();
	let left = $(window).scrollLeft();
	$('.player_popup_bg').css('top', top);
	$('.player_popup_bg').css('left', left);
})


/*$(document).keydown( (e) => {
	if(e.which == 79){
		console.log(audio.volume);
		volume_seeker.value = volume_seeker.value - 1;
		audio.volume = volume_seeker.value / 100;
		console.log('Setting Audio Volume to : ' + audio.volume);
		volume_controller();
	}
	if(e.which == 80){
		console.log(audio.volume);
		volume_seeker.value = volume_seeker.value + 1;
		audio.volume = volume_seeker.value / 100;
		console.log('Setting Audio Volume to : ' + audio.volume);
		volume_controller();
	}
	if(e.which == 32){
		set_current_pos();
		if(audio.paused){
			audio.play();
			$('.play-pause').removeClass('fa-play');
			$('.play-pause').addClass('fa-pause');
		}
		else{
			audio.pause();
			$('.play-pause').removeClass('fa-pause');
			$('.play-pause').addClass('fa-play');
		}
	}
});*/