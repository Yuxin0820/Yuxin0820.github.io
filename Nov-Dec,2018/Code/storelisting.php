<!DOCTYPE html>
<?php
	session_start();
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];
?>
<html>
<title>Store</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="storefront.css">
<link rel="stylesheet" href="register-login.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.w3-sidebar a {font-family: "Roboto", sans-serif}
body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
</style>
<body class="w3-content" style="max-width:1200px">

<!--------------------------------------Register---------------------------------------->
<div id="register" class="modal" style="display:none">
  <form class="modal-register animate" action="register.php" method="POST" enctype="multipart/form-data">
  <center>
    <div class="imgcontainer">
	  <span onclick="document.getElementById('register').style.display='none'" class="close" title="Close Modal">&times;</span>
	  <div>
	    <input type="file" value="Upload" name="pic" id="pic" onchange="javascript:setImagePreview();" /><br>
	  </div>
	  <div data-role="fieldcontain">  
			<div id="localImag"><img id="preview" src="images/icons/usericon.png" /></div>  
	  </div>  
    </div>
    <div id="inputcontainer" class="container">
      <input type="text" placeholder="Enter First Name" name="fName">
	  <input type="text" placeholder="Enter Last Name" name="lName">
      <input type="text" placeholder="Enter Username" name="uname" required>
	  <input type="text" placeholder="Enter Email" name="email" required>
      <input type="password" placeholder="Enter Password" name="psw" required>
      <button type="submit" class="registerbtn" onclick="success()">Register</button>
	  <p class="p01">Already registered?<br><a href="#" onclick="login()" style="font-size:16px;">Login here</a></p>
    </div>
</center>
  </form>
</div>
<!--------------------------------------login---------------------------------------->
<div id="login" class="modal">
	<form class="modal-login animate" action="login.php" method="POST">
    <div class="imgcontainer">
      <span onclick="document.getElementById('login').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img id="preview" src="images/icons/usericon.png" /><br>
    </div>
    <div class="container">
      <input type="text" placeholder="Enter Username" name="uname" required>
      <input type="password" placeholder="Enter Password" name="psw" required>
      <button class="loginbtn" type="submit" onclick="success()">Login</button>
      <p class="psw">Forgot <a href="#">password?</a></span><br><br>
	  Don't have an account? <a href="#" onclick="register()">Register </a></p>
    </div>
  </form>
</div>
<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-bar-block w3-white w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
    <h3 class="w3-wide"><img src="images/icons/logo.jpeg" alt="logo" style="cursor:pointer;" height="70px" onclick="window.location.href='./storelisting.php'"></h3>
  </div>
  <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
    <a onclick="expandDropdown(this.id)" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="clothes">
      Clothes <i class="fa fa-caret-down"></i>
    </a>
    <div id="clothesList" class="w3-bar-block w3-hide w3-padding-large w3-medium">
      <a href="storelisting.php?list=shirts" class="w3-bar-item w3-button">Shirts</a>
      <a href="storelisting.php?list=pants" class="w3-bar-item w3-button">Pants</a>
      <a href="storelisting.php?list=dresses" class="w3-bar-item w3-button">Dresses</a>
	  <a href="storelisting.php?list=hats" class="w3-bar-item w3-button">Hats</a>
	  <a href="storelisting.php?list=other" class="w3-bar-item w3-button">Other</a>
    </div>
	<a onclick="expandDropdown(this.id)" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="computers">
      Computers <i class="fa fa-caret-down"></i>
    </a>
    <div id="computersList" class="w3-bar-block w3-hide w3-padding-large w3-medium">
      <a href="storelisting.php?list=prebuilt" class="w3-bar-item w3-button">Pre-built</a>
      <a href="storelisting.php?list=components" class="w3-bar-item w3-button">Components</a>
      <a href="storelisting.php?list=electronics" class="w3-bar-item w3-button">Electronics</a>
    </div>
	<a onclick="expandDropdown(this.id)" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="boats">
      Boats <i class="fa fa-caret-down"></i>
    </a>
    <div id="boatsList" class="w3-bar-block w3-hide w3-padding-large w3-medium">
      <a href="storelisting.php?list=pwc" class="w3-bar-item w3-button">Personal Water Craft</a>
      <a href="storelisting.php?list=sailboats" class="w3-bar-item w3-button">Sailboats</a>
	  <a href="storelisting.php?list=motorboats" class="w3-bar-item w3-button">Motorboats</a>
	  <a href="storelisting.php?list=yachts" class="w3-bar-item w3-button">Yachts</a>
	  <a href="storelisting.php?list=carriers" class="w3-bar-item w3-button">Aircraft Carriers</a>
    </div>
	<a onclick="expandDropdown(this.id)" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="foods">
      Food <i class="fa fa-caret-down"></i>
    </a>
    <div id="foodsList" class="w3-bar-block w3-hide w3-padding-large w3-medium">
      <a href="storelisting.php?list=frozen" class="w3-bar-item w3-button">Frozen</a>
      <a href="storelisting.php?list=veggies" class="w3-bar-item w3-button">Veggies</a>
	  <a href="storelisting.php?list=meats" class="w3-bar-item w3-button">Meats</a>
	  <a href="storelisting.php?list=fruits" class="w3-bar-item w3-button">Fruits</a>
    </div>
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
  <div class="w3-bar-item w3-padding-24 w3-wide">LOGO</div>
  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:250px">

  <!-- Push down content on small screens -->
  <div class="w3-hide-large" style="margin-top:83px"></div>
  
  <!-------------------------------------------------------------- Top header -->
  <header class="w3-container w3-xlarge">
    <p class="w3-left">Homepage</p>
    <p class="w3-right">
      <a href="Cart.php"><img src="images/icons/carticon.png" width="30px" /></a>
      <i class="fa fa-search"></i>
    </p>
  </header>
		<?php 
	if(isset($_SESSION['user_id'])){//logined, have the session
		$username = $_SESSION['username'];?>
		<br>
		<div id="loginpic" style="text-align:center;padding:3px;position:absolute; right: 23%; top:3%;border: 1px solid #d9dde2;"><a href="account.php"><img src="<?php echo $_SESSION['loginpic']; ?>" width="25px;"></a></div>
		<div id="login03" style="position:absolute; left: 78%; top:4%; height:20px;"><a style="text-decoration: none;" href="account.php"><?php echo $username ?></a></div>
		<div id="login04" style="position:absolute; right: 14%; top:3.8%;height:20px;" ><a href="logout.php" > Log Out</a></div>
<?php
}
else{
?>
	<a id="login01" style="text-decoration:none;font-size:14px;position:absolute; right: 13.5%; 
	top:4.5%;" href="#" onclick="document.getElementById('login').style.display='block'">
	<img title="Login !" src="images/icons/login.png" width="25px"/></a>
<?php }?>

  <!-------------------------------------------- product grid --------------------------------------------->
<form method="post" action="storefront.php">
  <div class="w3-container w3-text-grey" id="jeans">
    
  </div>

  
  <div class="invTable">
    <?php
        if( isset($_GET['list'])) {
			$list = ($_GET['list']);
			$sql = "SELECT * FROM product WHERE type='".$list."'";
   	    }
		else{
			$sql = "SELECT id,image,name,price FROM product ORDER BY RAND() LIMIT 8";
		}
    
      $dbhost = "localhost";
  $dbuser = "id6942946_yuxin";
  $dbpass = "082000";
  $dbname = "id6942946_yuxin_db";
    	$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
    	$result = mysqli_query($conn, $sql);
    
    	if (mysqli_num_rows($result) > 0) {
    
            echo "<table class=\"featuredTable\">";
            echo "<tr>";
    	    // output data of each row
    	    $counter = 1;
    	    while($row = mysqli_fetch_assoc($result)) {
    	        if ($counter > 4)
                {
                    echo "</tr><tr>";
					$counter = 1;
                }
                $counter = $counter + 1;
    	        
                //echo "<td><img src=\"".$row["id"]."\"></td>";
                //echo $row["image"];
                ?>
				<td>
					<div class="w3-container">
						<div class="w3-display-container">
							<img  src="<?php echo $row['image'];?>" style="width:180px; height: 120px;">
							<div class="w3-display-middle w3-display-hover">
								<button type="submit" class="w3-button w3-black" name="add" value="<?php echo $row['id'];?>">Buy now <i class="fa fa-shopping-cart"></i></button>
							</div>
						</div>
						<p style="text-align:center;"><?php echo $row['name'];?><br><b>$&nbsp<?php echo $row['price']; ?></b></p>
					</div>
				</td>
				<?php
    	    }
    	    echo "</tr>";
    	    echo "</table>";
    	} else {
    	    echo "0 results";
    	}
    
    	mysqli_close($conn);
	    
	    
    ?>
  </div>
  
  <!-- Footer -->
  <footer class="w3-padding-64 w3-light-grey w3-small w3-center" id="footer">
    <div class="w3-row-padding">

    </div>
  </footer>

  <div class="w3-black w3-center w3-padding-24">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></div>

  <!-- End page content -->
</div>


<script>
// Accordion 
function expandDropdown(id) {
    var x = document.getElementById(id+"List");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}


// Script to open and close sidebar
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}

var modal1 = document.getElementById('register');
var modal2 = document.getElementById('login');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal1.style.display = "none";
		modal2.style.display = "none";
    }
}
function success(){
	document.getElementById('register').style.display='none';
	location.reload([bForceGet]);
}
function login(){
	document.getElementById('register').style.display='none';
	document.getElementById('login').style.display='block';
}

function register(){
	document.getElementById('login').style.display='none';
	document.getElementById('register').style.display='block';
}
function setImagePreview() {  
        var preview, img_txt, localImag, file_head = document.getElementById("pic"),  
        picture = file_head.value;  
        if (!picture.match(/.jpg|.gif|.png|.bmp/i)) return alert("The format of the picture you uploaded is not correct, please reselect it！"),  
        !1;  
        if (preview = document.getElementById("preview"), file_head.files && file_head.files[0]) preview.style.display = "block",  
            preview.style.width = "115px",  
            preview.style.height = "115px",  
            preview.src = window.navigator.userAgent.indexOf("Chrome") >= 1 || window.navigator.userAgent.indexOf("Safari") >= 1 ? window.webkitURL.createObjectURL(file_head.files[0]) : window.URL.createObjectURL(file_head.files[0]);  
        else {  
            file_head.select(),  
            file_head.blur(),  
            img_txt = document.selection.createRange().text,  
            localImag = document.getElementById("localImag"),  
            localImag.style.width = "115px",  
            localImag.style.height = "115px";  
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

</body>
</html>
