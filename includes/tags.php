<?php
// $this_page = explode('/', $_SERVER['SCRIPT_NAME']);
// $this_page = $this_page[1];

$tags = str_replace(', ', ',', $tags);
$tags_array = explode(',', $tags);
// print_r($tags_array); ?>

<div class="tags">

    <div class="main_title_cont">
        <p class="main_title">Tags Realated To This Page</p>
    </div>


    <div class="tag-block">
        <?php
        foreach( $tags_array as $value){
            echo '<span class="tag_text">' . $value . '</span>';
        } ?>
    </div>
</div>