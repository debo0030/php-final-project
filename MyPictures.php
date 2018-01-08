<?php
    include("includes/header.php");
    if (!$session->is_signed_in()) {
        redirect("LogIn.php");
    }
?>

    <div class="container text-center">
        <h2>My Pictures</h2><br />
    </div>

<?php include("includes/footer.php");