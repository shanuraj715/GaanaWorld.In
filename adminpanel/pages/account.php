<div class="admin-account">
    <div class="admin-account-sub">
        <p class="admin_page_titles">Manage Account</p>
        <div class="admin-account-form-block">
            <p class="admin-account-sub-title">Change Password</p>
            <input type="password" class="admin-account-pass1" placeholder="Enter new password" value="" />
            <input type="password" class="admin-account-pass2" placeholder="Re-Enter your new password" value="" />
            <button class="admin-account-submit_btn">Change Password</button>
        </div>



        <div class="admin-account-more-text-block">
            <p class="admin_page_titles">More Info</p>
            <span class="admin-account-more-text">For more help please contact us. We will help you in every problem. Please feel free to write us.</span>
        </div>
    </div>
</div>
<script>
    $('.admin-account-submit_btn').click( () => {
        let pass1 = $('.admin-account-pass1').val();
        let pass2 = $('.admin-account-pass2').val();
        console.log("Clicked");
        if(pass1 == pass2){
            if(pass1.length >= 8){
                $.ajax({
                    type: "POST",
                    data: 'pass=' + pass1,
                    url: '<?php echo SITE_URL;?>adminpanel/ajax/change-password.php',
                    success: ( data ) => {
                        if(data == 'success'){
                            alert("Password Changed. Please log in again.");
                            window.open('<?php echo SITE_URL;?>adminpanel/logout.php', "_self");
                        }
                        else{
                            alert(data);
                        }
                    },
                    error: () => {
                        alert("Unable to send request to server. Please check your internet connection.");
                    }
                });
            }
            else{
                alert('Password length too short');
            }
        }
        else{
            alert("Password not matched.");
        }
    });
</script>