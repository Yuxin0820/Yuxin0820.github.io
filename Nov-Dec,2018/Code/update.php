<?php
	$dbhost = "localhost";
	$dbuser = "id6942946_yuxin";
	$dbpass = "082000";
	$dbname = "id6942946_yuxin_db";
	$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
	}
	
	if(!empty($_FILES["pic"])){
	$upfile=$_FILES["pic"];
    $typelist=array("image/jpeg","image/jpg","image/png","image/gif");
    $path="./Images/User/";//Define an uploaded directory
    $fileinfo=pathinfo($upfile["name"]);//Parse the name of the uploaded file
    do{ 
        $newfile=date("YmdHis").$uname.".".$fileinfo["extension"];
    }while(file_exists($path.$newfile));
    if(is_uploaded_file($upfile["tmp_name"])){
            if(move_uploaded_file($upfile["tmp_name"],$path.$newfile)){
				unlink($photo);
				unset($_SESSION['loginpic']);
				if( isset($_POST['psw'])){
					
					$psw = ($_POST['psw']);
					$sql = "UPDATE users SET password = '".$psw."' WHERE users.userID = ".$id;
					$result = mysqli_query($conn, $sql);
					
				$sql2 = "UPDATE users SET imagePath = '".$path.$newfile."' WHERE users.userID = ".$id;
				$result = mysqli_query($conn, $sql2);
				
				$sql2 = "UPDATE users SET imageName = '".$newfile."' WHERE users.userID = ".$id;
				$result = mysqli_query($conn, $sql2);
				}
				$url="account.php";
				echo $url;
				echo $id;
				//header('Location: '.$url);
                
            }else{
            echo("Error...<br><br>");
        }
    }
	else{
    echo("Not a file!<br><br>");
	}}
	else{echo "not work!";}
	mysqli_close($conn);
?>