<?php
include("includes/header.php");
if (!$session->is_signed_in()) {
    redirect("LogIn.php");
}
date_default_timezone_set("America/New_York");

if (($_POST["delete"]) != FALSE) {
    $album = $_POST["delete"];
    $userId = $session->user_id;
    Album::deleteAlbum($album);
}
//var_dump($_SESSION["id"]);
if (isset($_POST["btnUpload"])) {
   // $albumID = $_SESSION["id"];
    $accessibility = $_POST["accessibility"];
    var_dump($accessibility);
     $newAlbum = new Album();
                 $newAlbum->album_id = $accessibility;
                $newAlbum->title = $album->title;
                $newAlbum->description = $album->description;
                $newAlbum->date_updated = date("Y-m-d h:i:sa");
                $newAlbum->owner_id = $session->owner_id;
                $newAlbum->accessibility_code = $accessibility;
                $newAlbum->update();  
    //var_dump($accessibility);
    //$albums = Album::find_By_Accessibility($accessibility);
   
}
?>

<div class="container text-center">
    <h2>My Albums</h2><br />
    <p>Welcome, <?php echo User::find_by_id($session->user_id)->name; ?>!</p>
    <a href="AddAlbum.php">Create New Album</a>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"  enctype="multipart/form-data">
        <table border="1" class="table">
            <tr>
                <th>Title </th>
                <th>Date updated</th>
                <th>Number of Pictures </th>
                <th>Accessibility</th>
                <th> </th>
            </tr>
<?php
$albums = Album::find_all();

//var_dump($albums);
foreach ($albums as $album):
    ?>
                <tr>
                    <td><?php echo $album->album_id ?></td>
                    <td><?php echo $album->title ?></td>
                    <td><?php echo $album->date_updated ?></td>
                    <td></td>
                    <td><div class="form-group row">
                            <div class="col-sm-5">
                                <select class="form-control" name="accessibility" id="accessibility" onchange="" value="<?php echo $album->album_id; ?>">
                                    <option value="<?php echo $album->accessibility_code; ?>"<?php  if( $_POST["accessibility"]== $album->album_Id) {    echo 'selected="selected"';}?>>
                                    <?php echo $album->accessibility_code;  ?>
                                    </option>
                                    
                                    <option value="<?php   $selecte = $album->accessibility_code;
                                                        $choies = (strcmp($selecte, "private")) ? "private" : "shared";?>" <?php  if( $_POST["accessibility"] != $album->Album_Id) {    echo 'selected="selected"';}?> > <?php echo $choies; ?></option>
                                </select>
                            </div>

                        </div>
    <?php // echo $album->accessibility_code ?></td>
                    <td>
                        <!--<a id="<?php //echo '$album->album_id';?>" name="delete" onclick="ConfirmDelete(<?php //echo '$album->album_id';?>)">delete</a>-->
                        <button type="submit" name="delete" id="delete" onclick="ConfirmDelete()" value="<?php echo $album->album_id; ?>" >delete</button>
                    </td>
                </tr>
<?php endforeach; ?>
        </table>
        <br/>
        <div align="right">
            <input type="submit" name="btnUpload" value="Save Changes" class="btn btn-sm btn-success "/>
        </div>  
    </form> 
</div>


<script>
    function ConfirmDelete( ) {
        if (confirm("Are you sure?")) {
            document.getElementById("form-id").submit();
        } else
            return false;
    }
</script>
<?php
include("includes/footer.php");
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

