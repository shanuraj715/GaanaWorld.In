<?php
global $page;
global $total_pages;
?>

<div class="list_paginaltion-opt">
	<select id="pagination_select" class="select_pagination">
		<?php
		$i = 1;
		while($i <= $total_pages){
			if($i == $page){
				$selected = 'selected="selected"';
			}
			else{
				$selected = '';
			} ?>
			<option value="<?php echo $i;?>" class="pagination_opt" <?php echo $selected;?>>Page <?php echo $i;?></option>
		<?php
		$i++;
		} ?>
	</select>
</div>
<script type="text/javascript">
	$('#pagination_select').change( () => {
		let selected = $('#pagination_select').children('option:selected').val();
		let url = '<?php echo SITE_URL . "singer-list?page=";?>' + selected;
		window.open(url, '_self');
	});
</script>