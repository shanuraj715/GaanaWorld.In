<div class="area2">
	<!-- <div class="visualizer_button_block">
		<input type="checkbox" id="visualizer_checkbox">
		<label for="visualizer_checkbox" class="visualizer_cb_text">Enable Visualizer</label>
	</div> -->
	

	<div class="player_container">

		<audio id="song_player" src="<?php echo getFilePath( $file_name, $upload_timestamp);?>"></audio>
		
		<div class="player">
			<div class="play-pause_btn_cont">
				<i class="fas fa-play play-pause"></i>
			</div>

			<div class="audio_player">
				<span class="playing_audio_duration" id="player_audio_time">--:--</span>
				<input type="range" id="audio_seeker" min="0" max="100" value="0" step="1" />
				<span class="playing_audio_duration" id="player_audio_remain">--:--</span>
				
			</div>

			<div class="play-pause_btn_cont">
				<i class="fas fa-cog setting_icon"></i>
			</div>
		</div>
	</div>

	<div class="song_download_btn_block">
		<a href="<?php echo SITE_URL . 'file/?sid=' . $song_id . '&key=' . time();?>" class="song_download_btn" rel="nofollow">Download Now</a>
	</div>
</div>



<div class="player_popup_bg">
	<div class="player_settings" id="player_settings_popup">
		<div class="player_popup_head">
			<div class="player_popup_head_title">
				<span class="player_p_h_title">Player Settings</span>
				<span class="player_popup_close" id="player_popup_close"><i class="fas fa-times"></i></span>
			</div>
		</div>
		<div class="player_popup_content">
			<div class="player_options">
				<div class="player_opt_col1">
					<div class="player_sett_row">
						<label>
							<input type="checkbox" class="radio_btn" id="visualizer_checkbox">
							<span class="player_opt_name">Enable Visualization</span>
						</label>
					</div>
					<div class="player_sett_row">
						<label>
							<input type="checkbox" class="radio_btn" id="repeat_cb_btn">
							<span class="player_opt_name">Repeat Song</span>
						</label>
					</div>
				</div>
				<div class="player_opt_col2">
					<div class="player_sett_row">
						<label>
							<div class="player_volume_controler">
								<input type="range" class="range_slider" id="volume_seeker" min="0" max="100" value="100" />
							</div>
						</label>
					</div>
				</div>
					
			</div>
			<div class="player_sett_close">
				<button class="player_sett_close_btn">Close</button>
			</div>
		</div>
	</div>
</div>
<?php if(isset($_GET['vis'])){ ?>
	<canvas id="myCanvas" width="400" height="400"></canvas>
	<script type="text/javascript">
	let myCanvas = document.getElementById("myCanvas");
	let ctx = myCanvas.getContext("2d");

	let freqs;

	navigator.mediaDevices.enumerateDevices().then(devices => {
	  devices.forEach((d, i) => console.log(d.label, i));

	  // devices.forEach((d, i) => document.write(d.label + ' ' + i + '<br/>'));
	  navigator.mediaDevices
		.getUserMedia({
		  // audio:{speakers:true, headphones:true}
		  audio: {
		  	deviceId: devices[5].deviceId
		  }
		})
		.then(stream => {
		  const context = new (window.AudioContext || window.webkitAudioContext)();
		  const analyser = context.createAnalyser();
		  const source = context.createMediaStreamSource(stream);
		  source.connect(analyser);
		  analyser.connect(context.destination);

		  freqs = new Uint8Array(analyser.frequencyBinCount);

		  function draw() {
			let radius = 75;
			let bars = 100;

			// Draw Background
			ctx.fillStyle = "rgba(34, 47, 62,1.0)";
			ctx.fillRect(0, 0, myCanvas.width, myCanvas.height);

			// Draw circle
			ctx.beginPath();
			ctx.arc(
			  myCanvas.width / 2,
			  myCanvas.height / 2,
			  radius,
			  0,
			  2 * Math.PI
			);
			ctx.stroke();
			analyser.getByteFrequencyData(freqs);

			// Draw label
			ctx.font = "500 20px Helvetica Neue";
			const avg =
			  [...Array(255).keys()].reduce((acc, curr) => acc + freqs[curr], 0) /
			  255;
			ctx.fillStyle = "rgb(" + 200 + ", " + (200 - avg) + ", " + avg + ")";
			ctx.textAlign = "center";
			ctx.textBaseline = "top";
			ctx.fillText("GaanaWorld.in", myCanvas.width / 2, myCanvas.height / 2 - 12);
			// ctx.fillText("", myCanvas.width / 2, myCanvas.height / 2 + 6);

			// Draw bars
			for (var i = 0; i < bars; i++) {
			  let radians = (Math.PI * 2) / bars;
			  let bar_height = freqs[i] * 0.5;

			  let x = myCanvas.width / 2 + Math.cos(radians * i) * radius;
			  let y = myCanvas.height / 2 + Math.sin(radians * i) * radius;
			  let x_end =
				myCanvas.width / 2 + Math.cos(radians * i) * (radius + bar_height);
			  let y_end =
				myCanvas.height / 2 + Math.sin(radians * i) * (radius + bar_height);
			  let color =
				"rgb(" + 200 + ", " + (200 - freqs[i]) + ", " + freqs[i] + ")";
			  ctx.strokeStyle = color;
			  ctx.lineWidth = 3;
			  ctx.beginPath();
			  ctx.moveTo(x, y);
			  ctx.lineTo(x_end, y_end);
			  ctx.stroke();
			}

			requestAnimationFrame(draw);
		  }

		  requestAnimationFrame(draw);
		});
	});

	</script>
	<?php
} ?>

