<?php


?>


<div class="upload-container">
		<div class="upload_block">
		<p class="admin_page_titles">Upload Directory Songs</p>
		<form action="" method="post" enctype="multipart/form-data" id="multiple_uploader">
			
			<div class="file_upload_block">
				<span class="selector_text">Mp3 File Dir</span>
				<input type="file" accept="audio/mp3" id="file_input" name="files[]" required="required" multiple>
			</div>
			<div class="file_upload_block">
				<span class="selector_text">Select Image File</span>
				<input type="file" accept="image/png,image/jpg,image/jpeg" name="image">
			</div>
			<div class="option_block">
				<span class="selector_text">Select Category</span>
				<select class="category_selector" name="category">
					<option class="category_option" value="424191">AIDM</option>                 
				</select>
			</div>

			<div class="option_block">
				<span class="selector_text">Select Album</span>
				<select class="category_selector" name="album">
					<option class="category_option" value="200002">Unknown Album</option>
				</select>
			</div>
			<div class="input_block">
				<textarea name="tags" class="tags_input" placeholder="Enter Tags Here. [Example : Hindi song, Punjabi Song, Hindi Remix]"></textarea>
			</div>

			<div class="upload_now_btn_block">
				<input type="submit" class="upload_btn" value="Upload Now">
			</div>
		</form>
	</div>
</div>

<script>
		let btn = $('.upload_btn');
		let dataSet = {
			image: '',
			files: [],
			category: 0,
			album: 0,
			tags: ''
		}






		btn.click( ( event ) => {
			// event.preventDefault();
		})

		$('#multiple_uploader').submit( ( event ) => {
			let formData = new FormData($(this)[0]);
			console.log(formData)

			$.ajax({
				url: '<?php echo SITE_URL;?>adminpanel/ajax/auto_uploader.php',
				type: 'POST',
				async: false,
				cache: false,
				contentType: false,
				enctype: 'multipart/form-data',
				processData: false,
				success: ( data ) => {
					alert('SUCCESS');
				},
				error: () => {
					alert("ERROR");
				}
			})
			return false;
		})

		_onFileSelect = () => {

		}

		$('#file_input').change( () => {
			// console.log($('#file_input').prop('files'));


			let files = $('#file_input').prop('files');

			for( var i=0; i<= files.length; i++){
				dataSet.files.push(files[i]);
			}

			// console.log(dataSet.files)
			console.log($('#file_input').val())
		})

		
</script>