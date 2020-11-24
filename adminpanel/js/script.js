$(document).ready( () => {
	$('#file_input').change( ( e ) => {
		let file = e.target.files[0].name;
		let file_ext = file.split('.').pop();
		let file_name = file.replace('.' + file_ext, '');
		let file_name_input = $('#file_title');
		console.log(file_name_input.val());
		if(file_name_input.val() == ''){
			console.log("entered");
			file_name_input.val( file_name );
		}
	});
});