<?php
global $conn;
$userid = $_SESSION['userid'];

$sql = "SELECT * FROM accounts WHERE user_id = $userid";
$query = mysqli_query($conn, $sql);
if($query){
	$result = mysqli_fetch_assoc($query);
	if($result['is_admin'] != 1){
		echo '<h1 style="text-align: center">You are not allowed to view this page</h1>';
		exit();
	}
	else{
		$sql = "SELECT * FROM singers ORDER BY singer_name ASC";
		$singer_query = mysqli_query($conn, $sql);
		
	}
}

function printSingerRows( $data ){ ?>
	<div class="singer-list-block border-bottom">
		<span class="singer-list-row singer-id"><?php echo $data['singer_id'];?></span>
		<span class="singer-list-row singer-name"><?php echo $data['singer_name'];?></span>
		<span class="singer-list-row singer-tags"><?php echo $data['tags'];?></span>
		<span class="singer-list-row singer-action">
			<a class="admin-cat_action" href="<?php echo SITE_URL . 'adminpanel/?page=singer&action=rename&singer_id=' . $data['singer_id'];?>" title="Rename"><i class="far fa-edit admin-cat-action-btn"></i></a>

         <a class="admin-cat_action" href="<?php echo SITE_URL . 'adminpanel/?page=singer&action=delete&singer_id=' . $data['singer_id'];?>" title="Delete"><i class="far fa-trash-alt admin-cat-action-btn"></i></a>
		</span>
	</div>
	<?php
}


?>


    <div class="admin-category">
    
    	<div class="admin_category_block">
    		<div class="add-cat-block">
                <a class="add-cat-btn" href="<?php echo SITE_URL . 'adminpanel/?page=singer&action=add';?>">Add New Singer</a>
          </div>
    
    		<div class="action_container">
    			
    		<?php
    		if(isset($_GET['action']) and !empty($_GET['action'])){
    			$action = $_GET['action'];
    			if($action == 'add'){ ?>
    				<div class="singer-add-cont">
    					<p class="admin_page_titles">All Singers List</p>
    					<div class="singer-add-block">
    						<input type="text" class="add-singer-name" placeholder="Enter singer name" />
    						<textarea class="add-singer-tag" placeholder="Enter tags"></textarea>
    						<button class="singer-button">Add</button>
    					</div>
    				</div>
    				<script>
    				    $('.singer-button').click( () => {
    				        const singer_name = $('.add-singer-name').val();
    				        const singer_tags = $('.add-singer-tag').val();
    				        if(singer_name != ''){
    				            $.ajax({
        				            type: 'POST',
        				            data: 'singer_name=' + singer_name + '&tags=' + singer_tags,
        				            url: '<?php echo SITE_URL;?>adminpanel/ajax/add-singer.php',
        				            success: ( data ) => {
        				                if(data == 'success'){
        				                    window.open('<?php echo SITE_URL;?>adminpanel/?page=singer', '_self');
        				                }
        				                else{
        				                    alert(data);
        				                }
        				            },
        				            error: () => {
        				                alert("Unable to send the data to server. Please check your internet connection.");
        				            }
        				        });
    				        }
    				        else{
    				            alert("Please enter singer name");
    				        }
    				        
    				    })
    				</script>
    
    			<?php
    			}
    			elseif($action == 'rename'){
    			    if(isset($_GET['singer_id']) and is_numeric($_GET['singer_id'])){
    			        $singer_id = $_GET['singer_id'];
    			        $sql = "SELECT * FROM singers WHERE singer_id = $singer_id";
    			        global $conn;
    			        $query = mysqli_query($conn, $sql);
    			        if($query){
    			            $result = mysqli_fetch_assoc($query);
    			            $singer_name = $result['singer_name'];
    			            $singer_tags = $result['tags'];
    			        }
    			        else{
    			            $singer_name = 'Unable to fetch name from server';
    			            $singer_tags = 'Unable to fetch tags from server';
    			        }
    			        
    			        ?>
    			        <div class="singer-add-cont">
        					<p class="admin_page_titles">All Singers List</p>
        					<div class="singer-add-block">
        						<input type="text" class="add-singer-name" placeholder="Enter singer name" value="<?php echo $singer_name;?>" />
        						<textarea class="add-singer-tag" placeholder="Enter tags"><?php echo $singer_tags;?></textarea>
        						<button class="singer-button">Modify</button>
        					</div>
        				</div>
        				<script>
        				    $('.singer-button').click( () => {
        				        const singer_name = $('.add-singer-name').val();
        				        const singer_tags = $('.add-singer-tag').val();
        				        if(singer_name != ''){
        				            $.ajax({
            				            type: 'POST',
            				            data: 'singer_id=' + <?php echo $singer_id;?> + '&singer_name=' + singer_name + '&tags=' + singer_tags,
            				            url: '<?php echo SITE_URL;?>adminpanel/ajax/edit-singer.php',
            				            success: ( data ) => {
            				                if(data == 'success'){
            				                    window.open('<?php echo SITE_URL;?>adminpanel/?page=singer', '_self');
            				                }
            				                else{
            				                    alert(data);
            				                }
            				            },
            				            error: () => {
            				                alert("Unable to send the data to server. Please check your internet connection.");
            				            }
            				        });
        				        }
        				        else{
        				            alert("Please enter singer name");
        				        }
        				        
        				    })
        				</script>
        				<?php
    			    }
    			    else{
    			        echo "Missing singer id.";
    			    }
    			}
    			elseif($action == 'delete'){
    			    if(isset($_GET['singer_id']) and is_numeric($_GET['singer_id'])){
    			        $singer_id = $_GET['singer_id'];
    			    }
    			        ?>
                    <button class="singer-button singer-delete-btn">Confirm Delete</button>
                    <script>
                        $('.singer-delete-btn').click( () => {
                            $.ajax({
                                type: 'POST',
                                data: 'singer_id=<?php echo $singer_id;?>',
                                url: '<?php echo SITE_URL;?>adminpanel/ajax/delete-singer.php',
                                success: ( data ) => {
                                    if(data == 'success'){
                                        window.open('<?php echo SITE_URL;?>adminpanel/?page=singer', '_self');
                                    }
                                    else{
                                        alert( data );
                                    }
                                },
                                error: () => {
                                    alert("Unable to sebd request to server. Please check your internet connection.");
                                }
                            });
                        });
                    </script>
                <?php
    			}
    			else{
    
    			}
    		} ?>
    
    
    
    
    
    
    		</div>
    
    
    
    
    
    		<p class="admin_page_titles">All Singers List</p>
    		<div class="singer-list_cont">
    
    			<div class="singer-list-block">
    				<span class="singer-list-head singer-id">Id</span>
    				<span class="singer-list-head singer-name">Singer Name</span>
    				<span class="singer-list-head singer-tags">Tags</span>
    				<span class="singer-list-head singer-action">Action</span>
    			</div>
    
    			<?php 
    			if($singer_query){
    				while($result = mysqli_fetch_assoc($singer_query)){
    					printSingerRows( $result );
    				}
    			} ?>
    		</div>
    	</div>
    </div>