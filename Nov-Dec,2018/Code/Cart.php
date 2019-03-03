<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

if(isset($_POST['empty'])){
	$action = "empty";}

if(isset($_POST['remove'])){
	$code=$_POST['remove'];
	$action = "remove"; }
	
if(isset($_POST['update'])){
	$code=$_POST['update'];
	$action = "update";}
	
if(isset($_SESSION['add'])){
	$code = $_SESSION['code'];
	$action = "add";
	unset($_SESSION['add']);
	}
	
if(!empty($action)) {
switch($action) {
	case "add":
		if(!empty($_POST["quantity"])||!empty($code)) {//from product page or home page
			$productByid = $db_handle->runQuery("SELECT * FROM product WHERE code='" . $code . "'");
			if(isset($code)){
				$itemArray = array($productByid[0]["code"]=>array('id'=>$productByid[0]["id"],'name'=>$productByid[0]["name"], 'code'=>$productByid[0]["code"], 'quantity'=>1, 'price'=>$productByid[0]["price"], 'image'=>$productByid[0]["image"]));
			}
			else{
				$itemArray = array($productByid[0]["code"]=>array('id'=>$productByid[0]["id"],'name'=>$productByid[0]["name"], 'code'=>$productByid[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByid[0]["price"], 'image'=>$productByid[0]["image"]));
			}
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByid[0]["code"],array_keys($_SESSION["cart_item"]))) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($code == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								if(isset($_POST["quantity"]))
									$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
								else if(isset($code))
									$_SESSION["cart_item"][$k]["quantity"] += 1;
							}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
	  }
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($code == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
	case "update":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($code == $k)
						$_SESSION["cart_item"][$k]["quantity"] = $_POST["quantity"];	
			}
		}
	break;
}
}
?>
<HTML>
<HEAD>
<TITLE>Shopping Cart</TITLE>
<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
<link href="Style.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="register-login.css">
</HEAD>
<BODY>
<?php 
if(isset($_SESSION['user_id'])){//logined, have the session
		$username = $_SESSION['username'];?>
		<br>
		<div id="loginpic" style="text-align:center;padding:3px;position:absolute; right: 15%; top:3%;border: 1px solid #d9dde2;"><a href="account.php"><img src="<?php echo $_SESSION['loginpic']; ?>" width="25px;"></a></div>
		<div id="login03" style="position:absolute; left: 85.5%; top:4%; height:20px;"><?php echo $username ?> </div>
		<div id="login04" style="position:absolute; right: 6%; top:3.8%;height:20px;" ><a href="logout.php" style="color:black;"> Log Out</a></div>
<?php
}
else{
?>
	<div id="login01"><a href="#" onclick="document.getElementById('login').style.display='block'" class="link">Login >></div></a>
	<div id="login02"><a href="#" onclick="document.getElementById('login').style.display='block'"><img title="Login !" src="images/icons/login.png" width="25px"/></a></div><br>
<?php }?>

<!----------------------------------------------Register---------------------------------------->

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

<!----------------------------------------------Login---------------------------------------->

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

<!----------------------------------------------Shopping---------------------------------------->

	<div id="shopping-cart">
	
	<div id="div-1"><a href="storelisting.php" class="link">Home</a>&nbsp&nbsp>&nbsp&nbspCart </div>
	<a href="storelisting.php">
	<img class="div-2" title="Back Home!" src="images/icons/home-1.png" width="25px"/></a>
	
	<div class="div-title">Shopping Cart</div>
	<br>
	<br>
	<hr style=" height:1px;border:none;width: 1120px; position: absolute; left: 6.5%;top:20%;border-top:1.5px solid #E0E0E0;" />
<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>	

<table rules="rows" id="tbl-cart" style="width: 760px;">
<tbody>
<tr height="70px" style="font-size:15px;">
<td style="text-align:left;">Product</td>
<td style="text-align:center; width:150px;">Quantity</td>
<td style="text-align:center;" >Price</td>
<td style="text-align:center; width:40px">Remove</td>
</tr>	
<?php		
    foreach ($_SESSION["cart_item"] as $item){
        $item_price = $item["quantity"]*$item["price"];
		?>
				
				<form method="post" action="Cart.php">
				<tr height="200px">
				<td width="370px"><table  style="font-size:12px;border-spacing:0px;">
					<tr>
						<td rowspan="2" width="200px"><img src="<?php echo $item["image"]; ?>" class="cart-item-image" style="width: 200px;height: auto;border-radius: 0;padding:0; border-color:#FFFFFF;"/></td>
						<td style="font-size:14px;"><?php echo $item["name"]; ?></td></tr>
					<tr><td><?php echo "$ ".$item["price"]; ?></td></tr>
					</table>
				<td><div><center><input style="text-align:right; width:50px" type="number" class="product-quantity" name="quantity" min='1' value="<?php echo $item["quantity"] ?>" size="2" required="required" />
					</center><button type="submit"  name="update" value="<?php echo $item["code"]; ?>" class="btnAddAction" />Update</div></td>
				<td  style="text-align:center;"><?php echo "$ ". number_format($item_price,2); ?></td>
				<td style="text-align:center;"> <button type="submit" name="remove" value="<?php echo $item["code"]; ?>" style="background-color:white;" style="outline: none; width:100px;"><img src="images/icons/delete.png" width="20px" title="Remove Item" /></a></td>
				</tr></form>
				
				
				<?php
				$total_quantity += $item["quantity"];
				$total_price += ($item["price"]*$item["quantity"]);
		}
		?>

<tr height="70px;">
<td align="right">Total:</td>
<td align="center"><?php echo $total_quantity; ?></td>
<td align="center"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
<form method="POST" action="Cart.php">
<td><button type="submit" name="empty" href="Cart.php" style="background-color: white;"><img src="images/icons/empty.png" width="35px" title="Empty cart !"/></a></td>
</form>
</tr>
</tbody>
</table>	
  <?php
} else {
?>
<div id="no-records">Your Cart is Empty<br><br><a href="storelisting.php">Back Home >></a></div>
<?php 
}
?>
</div>
<?php
 if(!empty($_SESSION["cart_item"])) {?>
<form method="POST" action="Checkout.php"><div style="margin-left:640px; position:absolute;"><a href="Checkout.php" >
	<img type="submit" name="total" value="1500" src="images/icons/checkout.png" width="200px" title="Check Out!" /></a></div><br><br><br>
<br><br>
<div id="subtotal" style="background-color: #efd1bd;
	opacity:0.8;
	position: fixed;
	right: 6%;
	top: 27.5%;
	width: 300px;
	height: 370px;">
	<strong><p style=" margin-left:7%; margin-top:7%; font-size:20px;">SUMMARY</p></strong>
	<hr style="border:none;width: 278px; position: absolute; left: 3.5%;top:13%;border-top:1.5px solid #E0E0E0;" />
	<table style=" width:275px; border-spacing:10px; margin-left:5%; margin-top: 5%; font-size: 15px;">
	<tr>
		<td style="text-align:left; width:100px;"><strong>ITEM TOTAL:</strong></td>
		<td style="text-align:right;width:100px;"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
	</tr>
	<tr>
		<td style="text-align:left;"><strong>SHIPPING:</strong></td>
		<td style="text-align:right;"><strong>$ 0.00</strong></td>
	</tr>
	<tr>
		<td style="text-align:left;"><strong>TAX:</strong></td>
		<td style="text-align:right;"><strong>$ 0.00</strong></td>
	</tr>
	<tr><td colspan="2">
		<hr style="border:none;width: 278px; position: absolute; left: 3.5%;top:48.5%;border-top:1.5px solid #E0E0E0;" />
	</td></tr>
	<tr>
		<td style="text-align:left; width:220px;"><strong>SUBTOTAL:</strong></td>
		<td style="text-align:right;"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
	</tr></table>
	<div>
		<a href="Checkout.php" ><img title="Buy Now!" src="images/icons/paypal.png" width="200px"  style="margin-left:16.5%; margin-top:3%;"/></a>
	</div>
</div>
 <?php 
 } 
 else{ ?>
 <hr style=" height:1px;border:none;width: 1120px; position: absolute; left: 6.5%;border-top:1.5px solid #E0E0E0;" /><br><br>
<?php
}
?>
 <script>
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
</BODY>
</HTML>