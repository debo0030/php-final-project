<?php
    include("includes/header.php");?>
<style>
    <?php include("includes/styles.css"); ?>
</style>
    <?php
    if (!$session->is_signed_in()) {
        redirect("LogIn.php");
    }
    
    extract($_POST);
    $albums = Album::find_by_owner_id($session->user_id);

    if(isset($selected_album)  || isset($_GET['albumId']))
    {
        $selected_album_id = $selected_album;
        $selectecAlbum = Album::find_album_by_id($selected_album_id, $session->user_id);
        $albumTitle = $selectecAlbum->title;
        $pictures = Photo::get_all_photos($selected_album_id);
        
        if (isset($_GET['pictureId'])) {
            $selectedPic = Photo::getPictureById($_GET['pictureId']);
                if($selectedPic !== false)
                {
                    if (isset($_GET['btnLeft']))
                    {
                        rotateImage($selectedPic->getAlbumFilePath(), 90);
                        rotateImage($selectedPic->getOriginalFilePath(), 90);
                        rotateImage($selectedPic->getThumbnailFilePath(), 90);

                    }
                    elseif (isset($_GET['btnRight']))
                    {
                        rotateImage($selectedPic->getAlbumFilePath(), -90);
                        rotateImage($selectedPic->getOriginalFilePath(), -90);
                        rotateImage($selectedPic->getThumbnailFilePath(), -90);
                    }
                    elseif (isset($_GET['download'])) 
                    {
                        downloadImage($selectedPic->getOriginalFilePath());
                    }
                    elseif (isset($_GET['delete'])) 
                    {
                        deleteImage($selectedPic);
                    }
                    $_SESSION["selectedPicId"] = $selectedPic->picture_id;
                    header("location: myPictures.php");
                }
        }
    }
?>

    <div class="container text-center">
        <h2>My Pictures</h2><br />
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
                                <?php endforeach;?>
                                </select>
                            </div>
                        </div>

                    <h2><?php echo $albumTitle; ?></h2>

                    <div class="container iconContainer">

                    <?php 
                    if(!is_null($pictures) && $pictures !== false): 
                      foreach ($pictures as $pic) :
                         $slides = $pic->getAlbumFilePath()."?rnd=".rand(); ?>
                         <div class="slides">
                             <img src="<?php echo $slides;?>" 
                                  style="width:100%">
                         </div>
                    <?php  endforeach; 
                    endif; ?>

                           <div class="row iconRow">
                               <button type="image" name="btnLeft" class="glyphicon glyphicon-repeat gly-flip-horizontal"></button>
                               <button type="image" name="btnRight" class="glyphicon glyphicon-repeat" value="andreaRightBtn"></button>
                               <button type="image" name="download" class="glyphicon glyphicon-download-alt"></button>
                               <button type="image" name="delete" class="glyphicon glyphicon-trash" value="delete"></button>   
                           </div>
                           <div class="container iconContainer">
                               <input type="text" name="pictureId" id="pictureId"
                                   value="<?php if (isset($_SESSION["selectedPicId"])) 
                                                {
                                                   echo $_SESSION["selectedPicId"];  
                                                }
                                                else {

                                                    echo $pictures[0]->picture_id;
                                                }?>"/>
                           </div>
                    </div>
                    <div class="container">
                        <div class="row">
                             <?php
                             if(!is_null($pictures) && $pictures !== false): 
                                $i=0;
                                foreach ($pictures as $pic) :
                                 $fileName = $pic->getName();
                                $thumbnail = $pic->getThumbnailFilePath();
                                $i++;
                             ?>
                                <div class="column"
                                     data-index ="<?php echo $i; ?>"
                                     data-id="<?php echo $pic->picture_id; ?>">
                                    <a href="MyPictures.php?pictureId=<?php echo $pic->picture_id; ?>&albumId=<?php echo $pic->album_id; ?>" >
                                       <img class="demo cursor" 
                                         src="<?php print $thumbnail;?>" 
                                         style="width:100%" 
                                         alt="<?php $fileName;?>" 
                                         value="<?php $fileName;?>">
                                    </a>
                                </div>

                            <?php endforeach;
                            endif; ?>
                        </div>
                    </div>
                
                <div class="col-sm-4">
                    <div><?php echo $description?></div>
                    <!--add comment section here-->
                    <textarea type="textarea" class="form-control" name="comment" placeholder="Leave a comment..." value="" ><?php echo $comment; ?></textarea>
                    <div>
                       <input type="submit" name="btnSubmit" value="Add Comment" class="btn btn-success btn-lg" />
                    </div>
                </div> 
        </div>
        </form>
    </div>
    <script>
        <?php include("./includes/scripts.js");?>
    </script>
    <?php   include("includes/footer.php");