<?php
    include("includes/header.php");
    if (!$session->is_signed_in()) {
        redirect("LogIn.php");
    }
    extract($_POST);
    $albums = Album::find_all();
    
    if(isset($selected_album))
    {
        $selectecAlbum = Album::find_by_id($selected_album);
        $albumTitle = $selectecAlbum->title;
        $pictures = Photo::get_all_photos($selected_album);
    }
?>

    <div class="container text-center">
        <h2>My Pictures</h2><br />
        <div class="container">                  
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <div class="col-sm-8">
                        <div class="form-group row">
                            <div class="col-sm-5">
                                <select class="form-control" name="selected_album" onchange="this.form.submit();">
                                <option value="-1">Select Album</option>
                                <?php
                                    foreach ($albums as $album): ?>
                                        <option value="<?php echo $album->album_id; ?>"
                                            <?php if ($_POST['selected_album'] == $album->album_id) { echo 'selected="selected"'; } ?>>
                                            <?php echo $album->title; ?>
                                        </option>
                                <?php 

                                endforeach;?>
                                </select>
                            </div>
                        </div>

                    <h2><?php echo $albumTitle; ?></h2>

                    <div class="container iconContainer">

                    <?php foreach ($pictures as $pic) :
                        $slides = $pic."?rnd=".rand();
                    { ?>
                        <div class="slides">
                            <img src="<?php print $slides;?>" 
                                 style="width:100%">
                        </div>

                    <?php } endforeach; ?>

                    <div class="row iconRow">
                        <button type="image" name="btnLeft" class="glyphicon glyphicon-repeat gly-flip-horizontal"></button>
                        <button type="image" name="btnRight" class="glyphicon glyphicon-repeat" value="andreaRightBtn"></button>
                        <button type="image" name="download" class="glyphicon glyphicon-download-alt"></button>
                        <button type="image" name="delete" class="glyphicon glyphicon-trash" value="delete"></button>   
                    </div>
                    <div class="container iconContainer"></div>
                </div>
                
                <div class="col-sm-4">
                    <!--add comment section here-->
                    <textarea type="textarea" class="form-control" name="comment" placeholder="Leave a comment..." value="" ><?php echo $comment; ?></textarea>
                    <div>
                       <input type="submit" name="btnSubmit" value="Add Comment" class="btn btn-success btn-lg" />
                    </div>
                </div> 
        </div>
        </form>
        </div>
    </div>

<?php include("includes/footer.php");