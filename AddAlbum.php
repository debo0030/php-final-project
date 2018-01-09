<?php
    include("includes/header.php");
    if (!$session->is_signed_in()) {
        redirect("LogIn.php");
    }
?>

    <div class="container text-center">
        <h2>My Albums</h2><br />
        <p>Welcome, <?php echo User::find_by_id($session->user_id)->name; ?>!</p>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"  enctype="multipart/form-data">
            <div class="form-group row">
                <label for="title" class="col-sm-3 col-form-label text-left">Title:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" placeholder="" name="title" value="<?php ?>" />
                </div>
            </div>
            <div class="form-group row">
                <label for="album" class="col-sm-3 col-form-label text-left">Accessibility:</label>
                <div class="col-sm-5">
                <select class="form-control" name="album" onchange="">
                    <option value="-1">Select Accessibility</option>
                    <option value="1">Private</option>
                    <option value="2">Shared</option>
                </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label text-left">Description:</label>
                <div class="col-sm-5">
                    <textarea type="textarea" class="form-control" placeholder="" name="description" value="<?php ?>" >
                    </textarea>

                </div>
            </div>
           
            <br/><br/>
            <input type="submit" name="btnUpload" value="Upload" class="btn btn-lg btn-success"/>
            <input type="reset" name="btnReset" value="Reset" class="btn btn-lg btn-success"/>
       </form> 
    </div>

<?php include("includes/footer.php");
