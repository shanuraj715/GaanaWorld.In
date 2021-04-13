<?php include '../config.php';
include '../db.php';

$status = 'false';

if(isset($_POST['name']) and !empty($_POST['name'])){
    if(isset($_POST['mobile']) and !empty($_POST['mobile'])){
        if(isset($_POST['contact_type']) and !empty($_POST['contact_type'])){
            if(isset($_POST['query']) and !empty($_POST['query'])){
                global $conn;
                $time = time();
                $date = date('d-m-Y');

                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
                $contact_type = mysqli_real_escape_string($conn, $_POST['contact_type']);
                $query = mysqli_real_escape_string($conn, $_POST['query']);

                $sql = "INSERT INTO contact_form (`name`, mobile, query_type, query, `date`, dt_timestamp) VALUES('$name', '$mobile', '$contact_type', '$query', '$date', '$time')";
                $query = mysqli_query($conn, $sql);
                if($query){
                    $status = "Successfully saved to our database.";
                }
                else{
                    $status = "Unable to save the record to our databadse";
                }
            }
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="index,follow" />
    <!-- Meta -->
    <meta name="subject" content="Ganaaworld Contact Us Page." />

    <meta name="description" content="You can share your valuable feedback, queries, copyright issues, report bugs and many more through our contact us page." />

    <meta name="author" content="<?php echo SITE_TITLE;?>" />

    <meta name="keywords" content="<?php echo SITE_TITLE;?>, contact us gaanaworld, gaanaworld help, gaanaworld copyright report, copyright gaanaworld, report bug gaanaworld" />

    <meta name="revised" content="<?php echo date('l' . ',' . 'd F Y', time() - 86400);?>" />

    <meta name="revisit-after" content="1 days" />

    <meta name="og:title" content="<?php echo SITE_TITLE;?>" />

    <meta name="og:url" content="<?php echo SITE_URL;?>" />

    <meta name="og:image" content="<?php echo SITE_URL;?>images/fevicon.png" />

    <meta name="og:site_name" content="<?php echo SITE_TITLE;?>" />

    <meta name="og:description" content="You can share your valuable feedback, queries, copyright issues, report bugs and many more through our contact us page." />

    <meta http-equiv="Pragma" content="cache" />
    <meta http-equiv="Cache-Control" content="cache" />
    <title>Contact Us | <?php echo SITE_TITLE;?></title>
    <?php include '../includes/files.php'; ?>
    
</head>
<body>
<?php
    include '../includes/header.php'; 
    include '../includes/search.php'; ?>
    <div class="page_container">
    <?php
    if($status != 'false'){ ?>
        <p style="background-color: yellow; border-bottom: solid 1px black; padding: 8px 0; font-size: 18px; margin: 0;"><?php echo $status;?></p>

        <?php
    } ?>
        <div  class="page_window">
            <p class="page_title">Contact Us</p>
            <div class="page_data">
                <p>You can fill this form in case of any complaint, assistance, query, copyright issue or account related problems</p>
                <div style="display: inline-block; width: 400px;">
                    <form action="" method="post">
                        <div>
                            <input style="width: 80%; padding: 4px 8px; font-size: 16px; border: solid 1px red; outline: none; margin: 10px 20px;" type="text" name="name" placeholder="Enter your name" required />
                        </div>
                        <div>
                            <input style="width: 80%; padding: 4px 8px; font-size: 16px; border: solid 1px red; outline: none; margin: 10px 20px;" type="text" name="mobile" placeholder="Enter your mobile number" required />
                        </div>
                        <div>
                            <select name="contact_type" style="width: 80%; padding: 4px 8px; font-size: 16px; border: solid 1px red; outline: none; margin: 10px 20px;">
                                <option value="help">Help</option>
                                <option value="account">Account Related</option>
                                <option value="copyright">Copyright Related</option>
                                <option value="query">Query Related</option>
                                <option value="complaint">Complaint</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <textarea required="required" name="query" placeholder="Enter your message or question here." style="width: 80%; min-height: 200px; padding: 4px 8px; font-size: 16px; border: solid 1px red; outline: none; margin: 10px 20px;"></textarea>
                        </div>
                        <div>
                            <input style="border: solid 1px black; border-radius: 4px; padding: 8px 30px; margin: 0 0 20px 0;" type="submit" value="Submit" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    include '../includes/other-features.php';
    include '../includes/footer.php';
    ?>
</body>
</html>