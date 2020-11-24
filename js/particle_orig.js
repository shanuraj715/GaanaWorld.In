$(document).ready( () => {
	let particle_counter = 0;

	$(document).on('click', () => {
		if( $('.particles-js').css('visibility') == 'visible' ){
			$('body').bind( 'keypress click tap' ,() => {
				particle_counter = 0;
				$('.particles-js').css('visibility', 'hidden');
				$('.particles-js').fadeOut(200);
					$('body').css('max-height', 'initial');
					$('body').css('overflow', 'initial');
			});
			$('body').scroll( () => {
				particle_counter = 0;
				$('.particles-js').css('visibility', 'hidden');
				$('.particles-js').fadeOut(200);
					$('body').css('max-height', 'initial');
					$('body').css('overflow', 'initial');
			});
		}
	})
	
	
	let player = $('#song_player')[0];

	$('#visualizer_checkbox').click( () => {
		particle_counter == 0;
		let visualizer_cb_status = $('#visualizer_checkbox').prop("checked");
		let interval5 = setInterval( () => {

			let settings_popup_status = $('.player_popup_bg').css('display');
			if(settings_popup_status == 'none'){
				particle_counter++;
				// console.log(particle_counter);
				if(particle_counter == 10 && player.paused == false && visualizer_cb_status){
					$('.particles-js').css('visibility', 'visible');
					$('.particles-js').fadeIn(1000);
					$('body').css('max-height', '100vh');
					$('body').css('overflow', 'hidden');
				}
				if(particle_counter < 10 || player.paused || visualizer_cb_status != true){
					$('.particles-js').css('visibility', 'hidden');
					$('.particles-js').fadeOut(200);
					$('body').css('max-height', 'initial');
					$('body').css('overflow', 'initial');
				}
				// console.log("running");
				// console.log(is_update_text_transform);
			}
			
		}, 1000);
	});

	
});