<?php
$category_id = explode('/', THIS_PAGE);
$category_id = end($category_id);

$prev_page_num = '#';
$next_page_num = '#';

$category_id = explode('?', $category_id);
$category_id = $category_id[0];
$this_page_number = 1;
$preview_btn_disabled = false;
$next_btn_disabled = false;
$initial_count_for_pagination = 1;



$sql = "SELECT song_id from songs WHERE category_id = $category_id";
$query = mysqli_query($conn, $sql);
if($query){
	$rows = mysqli_num_rows($query);

	$total_pages = ceil( $rows / SONG_LIMIT );
}

if(isset($_GET['page']) and !empty($_GET['page'])){
	if(is_numeric($_GET['page'])){
		$this_page_number = $_GET['page'];
	}

	if($this_page_number == 1){
		$preview_btn_disabled = true;
		$prev_page_num = '#';
	}

	if($this_page_number == $total_pages){
		$next_btn_disabled = true;
	}
	else{

	}
}
else{

}


?>


<div class="pagination">
	<?php
	$prev_pages_limit = 2;
	$next_pages_limit = 3;
	if($this_page_number - $prev_pages_limit > 1){
		$start_from = $this_page_number - $prev_pages_limit;
	}
	else{
		$start_from = 1;
	}
	if($total_pages - $this_page_number <= $next_pages_limit){
		$end_till = $total_pages + 1;
	}
	else{
		$end_till = $this_page_number + $next_pages_limit;
	}

	// echo $start_from . ' / ' . $end_till;




	if($start_from != 1){ ?>
		<div class="pagination_btn_block">
			<a class="pagination_btn pagination_link" href="<?php echo SITE_URL . 'category/' . $category_id;?>">1</a>
		</div>
		<span class="pagination_dot"><i class="fas fa-ellipsis-h"></i></span>
		<?php
	}

	while($start_from != $end_till){





		
		if($start_from == $this_page_number){ ?>
			<div class="pagination_btn_block">
				<span class="pagination_btn pagination_link active_page_pagination"><?php echo $start_from; ?></span>
			</div>
		<?php
		}
		else{ ?>
			<div class="pagination_btn_block">
				<a class="pagination_btn pagination_link" href="<?php echo SITE_URL . 'category/' . $category_id . '?page=' . $start_from;?>"><?php echo $start_from; ?></a>
			</div>
		<?php
		}
		$start_from++;
	}

	if($this_page_number != $total_pages and ($end_till < $total_pages)){ ?>

		<span class="pagination_dot"><i class="fas fa-ellipsis-h"></i></span>
		<div class="pagination_btn_block">
			<a class="pagination_btn pagination_link" href="<?php echo SITE_URL . 'category/' . $category_id . '?page=' . $total_pages;?>"><?php echo $total_pages; ?></a>
		</div>
		<?php
	}
	
	?>
	
	
</div>