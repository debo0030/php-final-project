<?php
    include("includes/header.php");
    if (!$session->is_signed_in()) {
        redirect("LogIn.php");
    }
?>

    <div class="container text-center">
        <h2>Upload Pictures</h2><br />
        <p>Accepted file types: JPG (JPEG), GIF, and PNG</p>
        <p>You can select multiple pictures at one time by holding the shift key while selecting pictures.</p>
        <p>When uploading multiple pictures the title and description fields will be applied to all pictures. </p>
        <span class="alert-error"><?php echo $error;?></span>
        <span class="alert-success"><?php echo $uploadSuccess;?></span>
        <form action="uploadPicture.php" method="post"  enctype="multipart/form-data">
                <div class="form-group row">
                <label for="album" class="col-sm-3 col-form-label text-left">Upload to Album:</label>
                <div class="col-sm-5">
                <select class="form-control" name="album" onchange="">
                    <option value="-1">Select Album</option>
                </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="txtUpload" class="col-sm-3 col-form-label text-left">File to Upload:</label>
                <div class="col-sm-5">
                    <input type="file" name="txtUpload[]" multiple size='40' accept="jpg, gif, png"class="form-control" />
                </div>
            </div>
            <div class="form-group row">
                <label for="title" class="col-sm-3 col-form-label text-left">Title:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" placeholder="" name="title" value="<?php ?>" />
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