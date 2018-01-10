<?php
    include("includes/header.php");
    if (!$session->is_signed_in()) {
        redirect("LogIn.php");
    }
    
    extract($_POST);

    if (isset($btnUpload)) {
        for ($j=0; $j < count($_FILES['txtUpload']['tmp_name']); $j++) {
       
            $photo = new Photo();
            $photo->album_id = $selected_album;
            $photo->title = htmlspecialchars($title);
            $photo->description = htmlspecialchars($description);
            $photo->date_added = date("Y-m-d h:i:sa");
            $photo->file_name = $_FILES['txtUpload']['name'][$j]; 
            $photo->set_file($_FILES['txtUpload']['tmp_name'][$j]);
                        
            if ($_FILES['txtUpload[]']['error'][$j] == 0) { //successful upload
            $filePath = $photo->save_uploaded_file(ORIGINAL_PICTURES_DIR, $j); //save original uploaded file
            $imageDetails = getimagesize($filePath);
        
            if ($imageDetails && in_array($imageDetails[2], $supportedImageTypes)) {
                //resize and save file
                $photo->resamplePicture($filePath, ALBUM_PICTURES_DIR, IMG_MAX_WIDTH, IMG_MAX_HEIGHT);
                $photo->resamplePicture($filePath, THUMBNAIL_DIR, THUMB_MAX_WIDTH, THUMB_MAX_HEIGHT);
                $uploadSuccess = "File(s) uploaded successfully!";
                $photo->create();
            }
            else {
                $error = "Uploaded file is not a supported type";
                unlink($filePath);
            }
        }
        elseif ($_FILES['txtUpload[]']['error'][$j] == 1) { //error
            $error = "Upload file is too large";
        }
        elseif ($_FILES['txtUpload[]']['error'][$j] == 4) { //error
            $error = "No upload file specified";
        }
        else { //error
           $error = "Error while uploading file. Please try again later.";    
        }
        
        }
    
}
?>

    <div class="container text-center">
        <h2>Upload Pictures</h2><br />
        <p>Accepted file types: JPG (JPEG), GIF, and PNG</p>
        <p>You can select multiple pictures at one time by holding the shift key while selecting pictures.</p>
        <p>When uploading multiple pictures the title and description fields will be applied to all pictures. </p>
        <span class="alert-error"><?php echo $error;?></span>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"  enctype="multipart/form-data">
                <div class="form-group row">
                <label for="album" class="col-sm-3 col-form-label text-left">Upload to Album:</label>
                <div class="col-sm-5">
                <select class="form-control" name="selected_album" onchange="">
                    <option value="-1">Select Album</option>
                    <?php $albums = Album::find_by_owner_id($session->user_id);
                        foreach ($albums as $album): ?>
                            <option value="<?php echo $album->album_id; ?>"
                                <?php if ($_POST['selected_album'] == $album->album_id) { echo 'selected="selected"'; } ?>>
                                <?php echo $album->title; ?>
                            </option>
                    <?php endforeach;?>
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
                    <input type="text" class="form-control" placeholder="" name="title" value="<?php echo $title?>" />
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label text-left">Description:</label>
                <div class="col-sm-5">
                    <textarea type="textarea" class="form-control" name="description" value="" ><?php echo $description; ?></textarea>

                </div>
            </div>
           
            <br/><br/>
            <input type="submit" name="btnUpload" value="Upload" class="btn btn-lg btn-success"/>
            <input type="reset" name="btnReset" value="Reset" class="btn btn-lg btn-success"/>
       </form> 
    </div>

<?php include("includes/footer.php");