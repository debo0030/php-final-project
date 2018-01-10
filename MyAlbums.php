<?php
    include("includes/header.php");
    
    if (!$session->is_signed_in()) {
        redirect("LogIn.php");
    }
    extract($_POST);
    if(isset($delete)){
        $album = $delete;
        Album::deleteAlbum($album);
        
    }
    
?>

    <div class="container text-center">
        <h2>My Albums</h2><br />
        <p>Welcome, <?php echo User::find_by_id($session->user_id)->name; ?>!</p>
        <a href="AddAlbum.php">Create New Album</a>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"  enctype="multipart/form-data" id="form-id">
            <table border="1" class="table">
                <tr>
                <th>Title </th>
                <th>Date updated</th>
                <th>Number of Pictures </th>
                <th>Accessibility</th>
                <th> </th>
                </tr>
                <?php 
                   $albums = Album::find_by_owner_id($session->user_id);
                   foreach ($albums as $album ):
                ?>
                <tr>
                    <td><?php echo $album->title?></td>
                    <td><?php echo $album->date_updated?></td>
                    <td></td>
                    <td>
                        <div class="form-group row">
                            <div class="col-sm-5">
                                <select class="form-control" name="accessibility" id="accessibility"onchange="">
                                <option value="">Select Accessibility</option>
                                <option value="private">Private</option>
                                <option value="shared">Shared</option>
                            </select>
                            </div>
                            <span class="text-danger inline-block"><?php print $errorAccess?></span>
                        </div>
                    </td>
                
                        <?php // echo $album->accessibility_code?></td>
                    <td>
                        <button type="submit"name="delete" id="delete" onclick="Confirm()" value="<?php echo $album->album_id;?>" >delete</button>
                    </td>
                </tr>
                <?php endforeach;?>
                
            </table>
           
            <br/><br/>
            <input type="submit" name="btnUpload" value="Upload" class="btn btn-lg btn-success"/>
       </form> 
    </div>
<script>
    function Confirm(){
        var yes = confirm("You realy want to delete?");
        if (yes) document.getElementById("form-id").submit();
        else return false;
    }
    </script>
<?php include("includes/footer.php");