<?php
	session_start();

  if(!isset($_SESSION['user_id'])){//No session
    if( isset($_POST['uname'])) {
   	    $username = ($_POST['uname']);
   	}

   	if( isset($_POST['psw'])) {
	   	$password = ($_POST['psw']);
   	}
	$dbhost = "localhost";
	$dbuser = "id6942946_yuxin";
	$dbpass = "082000";
	$dbname = "id6942946_yuxin_db";
	$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
	}

	$sql = "SELECT userName, imagePath, password,userID FROM Users WHERE userName = '" .$username."'";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
            if ($username==$row["userName"] && $password==$row["password"])
            {
				$_SESSION['user_id']=$row['userID'];
                $_SESSION['username']=$row['userName'];
				$_SESSION['loginpic']=$row['imagePath'];
				if (isset ($_SESSION['url'])){
					$url = $_SESSION['url'];
				} else{
				$url = "storelisting.php";
				}
                header('Location: '.$url);
            }
            else
            {
                echo "login not successful. retry";
            }
	    }
	} else {
	    echo "Register please!<br><br>";
		echo '<a href="Cart.php"> Back to cart page('.$_SESSION['username'].')</a>';
	}
	mysqli_close($conn);
  }
  else{ //logined , have the session
	  echo "You are already Logined as " .$_SESSION['username']."<br><br>";
	}
?>