<?php
	session_start();
	$dbhost = "localhost";
	$dbuser = "id6942946_yuxin";
	$dbpass = "082000";
	$dbname = "id6942946_yuxin_db";
	$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
	}
	
	if(!empty($_SESSION['loginpic'])){
		$photo = $_SESSION['loginpic'];
	}
	if(!empty($_SESSION['user_id'])){
		$id = $_SESSION['user_id'];
	}
	
	if( !empty($_POST['psw'])){
					
		$psw = ($_POST['psw']);
		$sql = "UPDATE Users SET password = '".$psw."' WHERE Users.userID = ".$id;
		$result1 = mysqli_query($conn, $sql);
	}
	
if(!empty($_FILES["pic"])){
	$upfile=$_FILES["pic"];
    $typelist=array("image/jpeg","image/jpg","image/png","image/gif");
    $path="./images/user/";//Define an uploaded directory
    $extension = pathinfo($upfile["name"],PATHINFO_EXTENSION);//get the name of the uploaded file

		$sql = "SELECT userName FROM Users WHERE userID = '" .$id."'";
		$result0 = mysqli_query($conn, $sql);
	
		while($row = mysqli_fetch_assoc($result0)) {
			$uname=$row['userName'];	
		}	
        $newfile=date("YmdHis").$uname.".".$extension;
    if(is_uploaded_file($upfile["tmp_name"])){
            if(move_uploaded_file($upfile["tmp_name"],$path.$newfile)){
				
				$sql2 = "UPDATE Users SET imagePath = '".$path.$newfile."' WHERE Users.userID = ".$id;
				$result2 = mysqli_query($conn, $sql2);
				
				$sql3 = "UPDATE Users SET imageName = '".$newfile."' WHERE Users.userID = ".$id;
				$result3 = mysqli_query($conn, $sql3);
				
					unlink($_SESSION['loginpic']);
					unset($_SESSION['loginpic']);
					unset($_FILES["pic"]);
					$_SESSION['loginpic'] = $path.$newfile;
					$url="account.php";
					header('Location: '.$url);
            }else{
            echo("Error...<br><br>");
        }
    }
	else{
    echo("Not a file!<br><br>");
	}}
?>
<html>
<head>
<title>Account Settings</title>
<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
<link href="account.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div id="leftcon">
	<div>
	   <table id="t01" style="height:10%;">
<?php 
	$sql5 = "SELECT * FROM Users WHERE Users.userID = '" .$id."'";
	$result = mysqli_query($conn, $sql5);
if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	$admin = $row['admin'];
	if($admin=='1'){ ?>
	    <tr class="tr01"><td id="inv" class="td01" onclick="window.location.href='Inventory.php'">Inventory  &nbsp  List</td></tr>
<?php  }
	}
} else {
    	    echo "<br><br>ID = ".$id;
    	    echo "<br>You couldn't view the Inventory.";
    	}
		
	mysqli_close($conn);
?>
	</table>
    </div>
</div>
</div>
<div id="rightcon">
<div style="position:absolute;margin-left:5.5%;top:3%;"><a href="storelisting.php" style="text-decoration:none; color:black;">Home</a>&nbsp&nbsp>&nbsp&nbspAccount Setting </div>
<a href="storelisting.php">
<img style="margin-left:0.5%;margin-top:0.5%;" title="Back Home!" src="images/icons/home-1.png" width="25px"/></a>
<h2 id="subtitle">Account Settings</h2>
<hr class="hr" style="top:20%;"/>

<form method="post" action="account.php" enctype="multipart/form-data">
	<div>
		<div>
			<input type="file" value="Upload" name="pic" id="pic" onchange="javascript:setImagePreview();" /><br>
		</div><br>
	<div id="localImag"><img id="preview" src="<?php echo $photo;?>" /></div>  
	<button type="submit" id="upbtn">Upload</button>	
	</div>
</form>

<form method="post" action="account.php">
	<div id="pswdiv">Password: &nbsp&nbsp&nbsp
		<input type="password" placeholder="Enter Password" name="psw">
		<br><br><br>
		<center><button type="submit">Change</button></center>
	</div>
</form>
</div>
</body>
<script>
function setImagePreview() {  
        var preview, img_txt, localImag, file_head = document.getElementById("pic"),  
        picture = file_head.value;  
        if (!picture.match(/.jpg|.gif|.png|.bmp/i)) return alert("The format of the picture you uploaded is not correct, please reselect it！"),  
        !1;  
        if (preview = document.getElementById("preview"), file_head.files && file_head.files[0]) preview.style.display = "block",  
            preview.style.width = "150px",  
            preview.style.height = "150px",  
            preview.src = window.navigator.userAgent.indexOf("Chrome") >= 1 || window.navigator.userAgent.indexOf("Safari") >= 1 ? window.webkitURL.createObjectURL(file_head.files[0]) : window.URL.createObjectURL(file_head.files[0]);  
        else {  
            file_head.select(),  
            file_head.blur(),  
            img_txt = document.selection.createRange().text,  
            localImag = document.getElementById("localImag"),  
            localImag.style.width = "150px",  
            localImag.style.height = "150px";  
            try {  
                localImag.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)",  
                localImag.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = img_txt  
            } catch(f) {  
                return alert("The format of the picture you uploaded is not correct, please reselect it！"),  
                !1  
            }  
            preview.style.display = "none",  
            document.selection.empty()  
        }  
        !0  
    }  
</script>
</html>
