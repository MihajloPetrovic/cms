<?php include("includes/header.php"); ?>

<?php

    if(empty($_GET['id'])){
        redirect("users.php");
    }

    $user = User::find_by_id($_GET['id']);
    if($user){
        $user->delete_user();
    }
    redirect("users.php");

?>