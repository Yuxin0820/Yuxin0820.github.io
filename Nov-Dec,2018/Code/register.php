<?php
	session_start();
	if( isset($_POST['fName'])) {
   	    $fName = ($_POST['fName']);
   	}

	if( isset($_POST['lName'])) {
   	    $lName = ($_POST['lName']);
   	}

    if( isset($_POST['uname'])) {
   	    $uname = ($_POST['uname']);
   	}
	
	if( isset($_POST['email'])) {
   	    $email = ($_POST['email']);
   	}
	

   	if( isset($_POST['psw'])) {
	   	$psw = ($_POST['psw']);
   	}
	$dbhost = "localhost";
	$dbuser = "id6942946_yuxin";
	$dbpass = "082000";
	$dbname = "id6942946_yuxin_db";
	$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
	}
	$upfile=$_FILES["pic"];
    //Define the allowed types
    $typelist=array("image/jpeg","image/jpg","image/png","image/gif");
    $path="./images/user/";//Define an uploaded directory
    
    //File name definition after uploading (get a file name )
    $extension = pathinfo($upfile["name"],PATHINFO_EXTENSION);//get the name of the uploaded file
    do{ 
        $newfile=date("YmdHis").$uname.".".$extension;
    }while(file_exists($path.$newfile));
    //Whether the picture is already uploaded or not.
    if(is_uploaded_file($upfile["tmp_name"])){
            //Move the uploaded pic to the image/user folder.
            if(move_uploaded_file($upfile["tmp_name"],$path.$newfile)){
				$sql = "INSERT INTO Users (fName, lName, password, email, userName,imageName,imagePath) VALUES (\"$fName\", \"$lName\", \"$psw\", \"$email\", \"$uname\",'$newfile','$path$newfile')";
				$result = mysqli_query($conn, $sql);

				$sql4 = "SELECT * FROM Users WHERE userName = '" .$uname."'";
				$result = mysqli_query($conn, $sql4);
				
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
		
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
                
            } else {
				echo "0 results";
			}
                
            }
            else
             { echo "move error...";}
    }
	else{
		$sql = "INSERT INTO users (fName, lName, password, email, userName,imagePath) VALUES (\"$fName\", \"$lName\", \"$psw\", \"$email\", \"$uname\",'./images/icons/usericon.png')";
		$result = mysqli_query($conn, $sql);
		
		$sql = "SELECT * FROM users WHERE userName = '" .$uname."'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
		
					$_SESSION['user_id']=$row['userID'];
					$_SESSION['username']=$row['userName'];
					$_SESSION['loginpic']=$row['imagePath'];
					if (isset ($_SESSION['url'])){
						$url = $_SESSION['url'];
					} else{
					$url = "storelisting.php";
					}
					header('Location: '.$url);
				}} else {
    	    echo "0 results";
    	}
	}
	mysqli_close($conn);
?>