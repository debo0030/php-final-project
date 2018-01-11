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
    $friend_id = $_GET["friend_id"];
    $albums = Album::find_shared_album($friend_id);

    if(isset($_GET['albumId']))
    {
        $selected_album_id = $_GET['albumId'];
        $selectecAlbum = Album::find_album_by_id($selected_album_id, $session->user_id);
        $albumTitle = $selectecAlbum->title;
        $pictures = Photo::get_all_photos($selected_album_id);
        
        if (isset($_GET['pictureId'])) {
            $selectedPic = Photo::getPictureById($_GET['pictureId']);
        }
    }
    if(isset($_POST['btnSubmit']))
    {
        $comment = new Comment();
        $comment->author_id = $session->user_id;
        $comment->picture_id = $_POST['pictureId'];
        $comment->comment_text = htmlspecialchars($_POST['comment']);
        $comment->date = date("Y-m-d h:i:sa");
       
        $comment->create();
        redirect("FriendPictures.php?albumId=".$_POST["albumId"]);
    }
?>

    <div class="container text-center">
        <div class="row">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="get">
            <div class="row">
                <h2>My Pictures</h2><br />
            </div>
                <div class="row">
                    <div class="form-group">
                                <select class="form-control" name="albumId" id="albumDdl">
                                <option value="-1">Select Album</option>
                                <?php
                                    foreach ($albums as $album): ?>
                                        <option value="<?php echo $album->album_id; ?>"
                                            <?php if ($_GET['albumId'] == $album->album_id) { echo 'selected'; } ?>>
                                            <?php echo $album->title; ?>
                                        </option>
                                <?php endforeach;?>
                                </select>
                        </div>
                </div>
                <div class="row">           
                    <h3><?php echo $selectedPic->title; ?></h3>
                </div>
                    <div class="col-sm-8">
                        <div class="iconContainer">

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

                        
                        </div>
                        <div class="row">
                             <?php
                             if(!is_null($pictures) && $pictures !== false): 
                                $i=0;
                                foreach ($pictures as $pic) :
                                 $fileName = $pic->getName();
                                $thumbnail = $pic->getThumbnailFilePath()."?rnd=".rand();
                                $i++;
                             ?>
                                <div class="column"
                                     data-index ="<?php echo $i; ?>"
                                     data-id="<?php echo $pic->picture_id; ?>">
                                    <a href="FriendPictures.php?pictureId=<?php echo $pic->picture_id; ?>&albumId=<?php echo $pic->album_id; ?>" >
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
            </form>
                <div class="col-sm-4">
                 <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

                <br /><br /><br /><br /><br /><br />
                    <?php 
                    $selectedPic = Photo::getPictureById($_GET['pictureId']);
                    $pictureId = isset($_GET['pictureId']) ? $_GET["pictureId"] : $pictures[0]->picture_id;
                    $comments= Comment::get_photo_comments($pictureId); ?>
                <div class="text-left"><p><strong>Description:</strong><br /><?php echo $selectedPic->description;?></p></div>
                <div class="text-left"><p><strong>Comments:</strong><br />
                        
                        <?php 
                        if($comments !== false) : 
                            foreach ($comments as $c) : 
                            $user = User::find_by_id($c->author_id);
                        ?>
                        
                        <em><?php echo $user->name. " (".$c->date.") </em>". $c->comment_text ; ?></p></div>
                            <?php endforeach; 
                        endif; ?>
                    <textarea type="textarea" class="form-control" name="comment" placeholder="Leave a comment..." ></textarea>
                    <div>
                        <input type="text" name="albumId" id="albumId" 
                               value="<?php if (isset($_GET["albumId"]))
                               {
                                   echo $_GET["albumId"];
                               }?>">
                        <input type="hidden" name="pictureId" id="pictureId"
                                       value="<?php if (isset($_GET["pictureId"])) 
                                                    {
                                                       echo $_GET["pictureId"];  
                                                    }
                                                    else {
                                                        echo $pictures[0]->picture_id;
                                                    }?>"/>
                       <input type="submit" name="btnSubmit" value="Add Comment" class="btn btn-success btn-lg" />
                    </div>
                </form>
                </div> 
        </div>
    </div>
 </div>   
    <?php   include("includes/footer.php"); ?>
    <script>
        $('#albumDdl').on('change', function() {
            window.location.href = "FriendPictures.php?albumId="+$(this).val();
        });
        <?php include("./includes/scripts.js");?>
    </script>