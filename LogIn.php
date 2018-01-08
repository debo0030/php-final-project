<?php
    require_once("includes/header.php");
    if($session->is_signed_in()) {
        redirect("Index.php");
    }    
    extract($_POST);    
    $validation = TRUE;   
    if (isset($btnSubmit)) {
        $errorStudentID = ValidateID($student_id);
        $errorStudentPassword = ValidateStudentPassword($password); 
        if((strlen(trim($errorStudentID)) != 0) || (strlen(trim($errorStudentPassword)) != 0)) {
            $validation = FALSE; 
        } else {
            $student_id = trim($student_id);
            $password = sha1(trim($password));
            $user_found = User::verify_user($student_id, $password);
            if($user_found) {
                $session->login($user_found);
                redirect("Index.php");
            } else {
                $the_message = "Your Password or Student ID is incorrect.";
            }          
        }        
    }
    if (isset($btnClear)) {
        $student_id = "";
        $password = "";                             
    } 
?>

    <div class="container text-center">
        <br /><h2>Log In</h2><br />
        <p><i>You need to <a href="NewUser.php">sing up</a> if you are a new user.</i></p><br />
        <p class="text-danger"><?php echo $the_message; ?></p><br />	
        <form id="login-id" action="" method="post">	
            <div class="form-group row">
                <label for="student_id" class="col-sm-3 col-form-label text-center">Student ID</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="student_id" value="<?php echo htmlentities($student_id); ?>" />
                </div>
                <div class="col-sm-4 text-danger text-left">
                    <?php
                        if(!$validation) {
                            echo $errorStudentID;
                        }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label text-center">Password</label>
                <div class="col-sm-5">
                    <input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>" />
                </div>
                <div class="col-sm-4 text-danger text-left">
                    <?php
                        if(!$validation) {
                            echo $errorStudentPassword;
                        }
                    ?>
                </div>
            </div>
            <br />
            <p>
                <input type="submit" name="btnSubmit" value="Submit" class="btn btn-success btn-lg" />
                &nbsp; &nbsp; &nbsp;
                <input type="submit" name="btnClear" value="Clear" class="btn btn-success btn-lg" />
            </p>       
        </form>
    </div>
            
<?php require_once("includes/footer.php");