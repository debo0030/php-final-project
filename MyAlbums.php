<?php
    include("includes/header.php");
    if (!$session->is_signed_in()) {
        redirect("LogIn.php");
    }
?>

    <div class="container text-center">
        <h2>My Albums</h2><br />
        <p>Welcome, <?php echo User::find_by_id($session->user_id)->name; ?>!</p>
        <a href="AddAlbum.php">Create New Album</a>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"  enctype="multipart/form-data">
            
           
            <br/><br/>
            <input type="submit" name="btnUpload" value="Upload" class="btn btn-lg btn-success"/>
       </form> 
    </div>

<?php include("includes/footer.php");