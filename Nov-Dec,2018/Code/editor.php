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
	if(isset($_POST['editid'])){
		$select_id = $_POST['editid'];
		$_SESSION['id'] = $_POST['editid'];
	}
	/***********************************************************///Get id from inventory
	if(!empty($select_id)){
			$sql = "SELECT name, image, description, price, category, type FROM product WHERE id='".$select_id."'";
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$select_name = $row['name'];
				$select_img = $row['image'];
				$select_des = $row['description'];
				$select_price = $row['price'];
				$select_cate = $row['category'];
				$select_type = $row['type'];
			}}
			else {echo "error";}
			?>
 <html>
	<head>
	<link href="Inventory.css" type="text/css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
	<style type="text/css">
	.editinput{
		width: 75%;
		padding: 12px 20px;
		margin: 8px 55px;
		display: inline-block;
		border: 1px solid #ccc;
		box-sizing: border-box;
		height:35px;
		
	}
	td{
		text-align:right;
	}
	</style>
	</head>
	<body>
<form class="modal-editor animate" action="editor.php" method="POST" enctype="multipart/form-data">
	<span onclick="window.parent.location.replace('Inventory.php')" class="close" title="Close Modal">&times;</span>
	<div id="imgedit">
		<input type="file" value="Upload" name="pic" id="pic" onchange="javascript:setImagePreview();" /><br><br>
		<div id="localImag"><img id="preview" src="<?php echo $select_img;?>" /></div>  	
	</div> 
	<div id="conedit">
	<table id="t05">
		<tr><td>Name: </td>
			<td><input class="editinput" type="text" value="<?php echo $select_name; ?>" name="name"/></td></tr>
		<tr><td>Description: </td>
			<td style="text-align:right;"><textarea rows="3" col="15" name="description"><?php echo $select_des; ?></textarea></td></tr>
		<tr><td>Price: </td>
			<td><input  class="editinput"type="text" value="<?php echo $select_price; ?>" name="price"/></td></tr>
		<tr><td>Category: </td>
			<td style="text-align:right;">
				<select style="width:160px;height:25px;" id="cateadd" name="category">
					<option>Default:<?php echo $select_cate; ?></option>
<?php
					$sql = "SELECT distinct Category FROM type";
					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result) > 0) {
						while($row = mysqli_fetch_assoc($result)) {
							$cate= $row['Category'];
?>
							<option value="<?php echo $cate; ?>"><?php echo $cate; ?></option>
<?php 					}}
					else {echo "Can't find the category.";} ?>
				</select>
			</td></tr>
		<tr><td>Type: </td>
			<td>
				<select style="width:100px;height:25px;" id="typee" name="type">
					<option>Default:<?php echo $select_type; ?></option>
				</select>
			</td>
		</tr>
      <tr><td colspan="2"><center><button onclick="" type="submit" name="update" class="registerbtn">Submit</button></center></td></tr>
    </div>
	</form>
	</body>
	<script>
	$(document).ready(function () {
            var url = 'gettype.php';
            $("#cateadd").change(function () {
                var value = $(this).val();

                $.ajax({
                    type: 'post',
                    url: url,
                    data: {cateadd: value},
                    dataType: 'json',
                    success:function (data) {
                        var status = data.status;
                        if(status == 200){
                            var types = data.data;
                            var option = '';
                            for(var i=0; i<types.length; i++){
                                option += "<option value='"+types[i]+"'>" + types[i] + '</option>';
                            }
                        }
                        $("#typee").html(option);
                    }
                });
            });
        });
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
<?php }
	///*********************************************/Get data from the submit in editor.php
	if(!empty($_POST['name'])){ 
	
	echo "<script>window.parent.location.replace('Inventory.php');</script>";
		//delete photo
		$sql = "SELECT image FROM product WHERE id='".$_SESSION['id']."'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$photo = $row['image'];
			}}
		else {echo "no name result.";}
		$code = $_POST['name']."-".$_SESSION['id'];
		//insert
		$sql = "Update product SET name='".$_POST['name']."', description='".$_POST['description']."', price='".$_POST['price']."', category='".$_POST['category']."', type='".$_POST['type']."', code='".$code."' WHERE id='".$_SESSION['id']."'";
		$result = mysqli_query($conn, $sql);
		
		//Whether the Inventory picture uploaded is correct
		if(!empty($_FILES["pic"])){
			$upfile=$_FILES["pic"];
			$typelist=array("image/jpeg","image/jpg","image/png","image/gif");
			$path="./images/inv/";//Define an uploaded directory
			$extension = pathinfo($upfile["name"],PATHINFO_EXTENSION);//get the name of the uploaded file
			$newname = $_POST['name']."-".$code.".".$extension;
		if(is_uploaded_file($upfile["tmp_name"])){
			if(move_uploaded_file($upfile["tmp_name"],$path.$newname)){
				unlink($photo);
				$sql3 = "UPDATE product SET image = '".$path.$newname."' WHERE product.id = ".$_SESSION['id'];
				
			}else{
				echo("Error...<br><br>");
			}
		}else{
			$sql3 = "UPDATE product SET image = '".$photo."' WHERE product.id = ".$_SESSION['id'];
		}
		$result3 = mysqli_query($conn, $sql3);
		unset($_SESSION['id']);
		}
		?>
		<center><img src="images/icons/wait.png" width="100px" style="position:absolute; top:10%;"></center>
		<?php } 
		if(isset($_POST['delete'])){
			$sql = "DELETE FROM product WHERE id=".$_POST['delete'];
			$result = mysqli_query($conn, $sql);
		}?>

