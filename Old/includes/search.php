<div class="search_container">
    <form action="" method="get">
        <div class="search_cont">
            <input type="text" class="search_box" value="" id="search_input" required="required" name="search" />
            <input type="submit" class="search_btn" id="search_btn" value="Search" />
        </div>
    </form>
    <script>
        document.getElementById("search_btn").addEventListener("click", function(event){
            let search_string = document.getElementById('search_input').value;
            // console.log(search_string);

            if(search_string != ''){
                event.preventDefault();
                window.open("<?php echo SITE_URL;?>search/" + search_string, "_self");
            }
            
        });
    </script>
</div>