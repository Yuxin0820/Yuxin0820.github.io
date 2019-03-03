<?php
session_start();

if(isset($_SESSION['user_id'])){
	if (isset ($_SESSION['url'])){ //Get the last page url
		$url = $_SESSION['url'];
	} else{
		$url = "storelisting.php";
	}
    //If a session cookie exists, remove it by setting the expiration time to the previous hour
    if(isset($_COOKIE[session_name()])){
        setcookie(session_name(),'',time()-3600);
    }
    //Unset all the session data gotten from the database.
    unset($_SESSION["user_id"]);
	unset($_SESSION["username"]);
	unset($_SESSION["password"]);
	unset($_SESSION["fName"]);
	unset($_SESSION["lName"]);
	unset($_SESSION['loginpic']);
}
header('Location:'.$url);
?>