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
	
	if(!empty($_POST['name'])){
		$name = $_POST['name'];
	}
	
	if(!empty($_POST['description'])){
		$description = $_POST['description'];
	}
	
	if(!empty($_POST['price'])){
		$price = $_POST['price'];
	}
	
	if(!empty($_POST['image'])){
		$image = $_POST['image'];
	}
	
	if(!empty($_POST['category'])){
		$category = $_POST['category'];
	}
	
	if(!empty($_POST['type'])){
	$type = $_POST['type'];
	}
	
	if(!empty($_POST['sort'])){
		$sort = $_POST['sort'];
	}
	
	if(!empty($_POST['edit'])){
		$edit = $_POST['edit'];
	}
	
	if(!empty($_POST['search'])){
		$search = $_POST['search'];
		if($sort=="name"){
			$sql4 = "SELECT * FROM product WHERE ".$sort." LIKE '%".$search."%'";
		}
		else {
		$sql4 = "SELECT * FROM product WHERE ".$sort."= '".$search."'"; }
		unset($_POST['search']);
		unset($_POST['search']);
	}
	else{
		$sql4 = "SELECT id, name, price, category, type FROM product";
	}
	
	if(!empty($_POST['add'])){
		//insert
		$sql = "INSERT INTO product (name, description, price, image, category,type,code) VALUES (\"$name\", \"$description\", \"$price\", \"images/inv/none.jpg\", \"$category\",'$type','test')";
		$result = mysqli_query($conn, $sql);
		$id = mysqli_insert_id($conn);
		// set code
		$code = $name."-".$id;
		$sql1 = "UPDATE product SET code = '".$code."' WHERE product.id = ".$id;
		$result = mysqli_query($conn, $sql1);
		
		//Whether the product picture uploaded is correct
		if(!empty($_FILES["pic"])){
			$upfile=$_FILES["pic"];
			$typelist=array("image/jpeg","image/jpg","image/png","image/gif");
			$path="./images/inv/";//Define an uploaded directory
			$extension = pathinfo($upfile["name"],PATHINFO_EXTENSION);//get the name of the uploaded file
			$newname = $name."-".$code.".".$extension;
		if(is_uploaded_file($upfile["tmp_name"])){
			if(move_uploaded_file($upfile["tmp_name"],$path.$newname)){
				$sql3 = "UPDATE product SET image = '".$path.$newname."' WHERE product.id = ".$id;
				$result3 = mysqli_query($conn, $sql3);
			}else{
				echo("Error...<br><br>");
			}
		}
	}}
?>
<html>
<head>
<title>Inventory</title>
<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
<link href="Inventory.css" type="text/css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

<div id="leftcon">
	<div>
	<table id="t01" style="height:30%;">
		<tr class="tr01"><td id="inv" class="td01" onclick="list()">Inventory  &nbsp  List</td></tr>
		<tr class="tr01"><td id="additem" class="td01" onclick="add()">Add Item</td></tr>
		<tr class="tr01"><td class="td01" onclick="window.location.href='account.php'">Account Setting</td></tr>
	</table>
	<div>
</div>

<div id="rightcon">
<div style="position:absolute;margin-left:5.5%;top:1.5%;"><a href="storelisting.php" style="text-decoration:none; color:black;">Home</a>&nbsp&nbsp>&nbsp&nbsp Inventory</div>
<a href="storelisting.php">
<img style="margin-left:0.5%;margin-top:0.5%;" title="Back Home!" src="images/icons/home-1.png" width="25px"/></a>
<h2 id="subtitle">Inventory &nbsp List</h2>
<hr class="hr" style="top:20%;"/>
<!------------------------------------Add-------------------------------------->
<form method="post" action="Inventory.php" enctype="multipart/form-data" id="add">
	<div id="img">
		<div>
			<input type="file" value="Upload" name="pic" id="pic" onchange="javascript:setImagePreview();" /><br>
		</div><br>
		<div id="localImag"><img id="preview" src="images/icons/none.jpg" /></div>  	
	</div>
		<br><br><br><br><br><br><br><br>
	<div id="info">	
	<table>
		<tr class="tr02">
			<td class="t02">Name: </td>
			<td><input type="text" name="name"></td>
		</tr>
		<tr class="tr02">
			<td>Description: </td>
			<td><input type="text" name="description"></td>
		</tr>
		<tr class="tr02">
			<td>Price: </td>
			<td><input type="text" name="price"></td>
		</tr>
		<tr class="tr02">
			<td>Category: </td>
			<td>
				<select style="width:160px;height:25px;" id="cateadd" name="category">
<?php
					$sql = "SELECT distinct Category FROM type";
					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result) > 0) {
						while($row = mysqli_fetch_assoc($result)) {
							$cateadd= $row['Category'];
?>
							<option value="<?php echo $cateadd; ?>"><?php echo $cateadd; ?></option>
<?php 					}}?>
				</select>
			</td>
		</tr>
		<tr class="tr02">
			<td>Type: </td>
			<td>
				<select style="width:100px;height:25px;" id="typee" name="type">
				</select>
			</td>
		</tr>
		<tr class="tr02"><td colspan="2" style="text-align:center;"><button type="submit" id="addbtn" name="add" value="Add" onclick="window.location.replace('Inventory.php')" >Add</button></td></tr>
	</table>
	</div>
</form>
<!----------------------------------Editor------------------------------->
<iframe id="editor" name="editor" class="modal" style="display:none"></iframe>
<!------------------------------------product-------------------------------------->
<div id="list">
<!-----------------Search------------------->
	<form method="post" action="Inventory.php">  
	<div>
	<table id="t04">
		<tr>
			<td>Search &nbsp by:</td> 
			<td>
				<select name="sort"> <!--It should be search, but I already have a name called search in line 184-->
					<option value="id">ID</option>
					<option value="name">Name</option>
					<option value="price">Price</option>
					<option value="category">Category</option>
					<option value="type">Type</option>
				</select>
			</td> 
			<td><input style="width:70%;" type="text" name="search"></td> 
			<td><button type="submit" class="searchbtn"><img src="images/icons/search.png" width="25px" /></button></td> 
			<td><button class="searchbtn" title="Show all items!" onclick="window.location.replace('Inventory.php')"><!--Replace the page to show all-->
					<img src="images/icons/showall.png" width="25px" /></button></td> 
		</tr>
	</table>
	</div>
	</form>
<!-----------------list------------------->
<div>
<form method="post" action="editor.php" target="editor">
	<table id="t03">
		<thead class="head">
		<tr style="height:40px;">
			<th width="60px">ID </th>
			<th width="190px">Name </th>
			<th width="95px">Price </th>
			<th width="130px">Category </th>
			<th width="120px">Type </th>
			<th width="50px">Edit </th>
			<th width="55px">Delete</th>
		</tr>
		</thead>
		<tbody class="scrollTbody">
		<?php
			$result = mysqli_query($conn, $sql4);
			if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {?>
				<tr class="tr03"><td  width="60px"><?php echo $row["id"];?></td>
				<td width="190px"><?php echo $row["name"];?></td>
				<td width="100px"><?php echo $row["price"];?></td>
				<td width="130px"><?php echo $row["category"];?></td>
				<td width="120px"><?php echo $row["type"];?></td>
				<td width="50px"><button onclick="document.getElementById('editor').style.display='block'" type="submit" value="<?php echo $row["id"]; ?>" name="editid" class="searchbtn"><img src="images/icons/edit.png" width="18px" style="cursor:pointer;"/></button></td>
				<td width="55px"><button onclick="window.location.replace('Inventory.php')" type="submit" value="<?php echo $row["id"]; ?>" name="delete" class="searchbtn"><img src="images/icons/delete.png" width="18px" style="cursor:pointer;"/></button></td></tr>
		<?php	
			}}
			else { echo "0 results"; }
			mysqli_close($conn);
		?>
		</tbody>
	</table>	
	</table>	
</form></div>
</div>

</div>
</body>
<script>
//****************************************ajax - category - type
$(document).ready(function () {//AJAX . Get the type from the database according to the category 
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
function setImagePreview() {  //Show the picture that user uploaded.
        var preview, img_txt, localImag, file_head = document.getElementById("pic"),  
        picture = file_head.value;  
        if (!picture.match(/.jpg|.gif|.png|.bmp/i)) return alert("The format of the picture you uploaded is not correct, please reselect it！"),  
        !1;  
        if (preview = document.getElementById("preview"), file_head.files && file_head.files[0]) 
			preview.style.display = "block",  
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
function list(){
	document.getElementById("subtitle").innerHTML = "Inventory &nbsp List";
	document.getElementById("add").style.display = "none";
	document.getElementById("list").style.display = "block";
	
	document.getElementById("inv").style.backgroundColor = "#d8d4d8";
	document.getElementById("additem").style.backgroundColor = "#c7c0d6";
}

function add(){
	document.getElementById("subtitle").innerHTML = "Add &nbsp Item";
	document.getElementById("add").style.display = "block";
	document.getElementById("list").style.display = "none";
	
	document.getElementById("additem").style.backgroundColor = "#d8d4d8";
	document.getElementById("inv").style.backgroundColor = "#c7c0d6";
}
var modal1 = document.getElementById('register');
window.onclick = function(event) {
    if (event.target == modal) {
        modal1.style.display = "none";
    }
}
function edit(){
	document.getElementById("editor").style.display = "block";
}
</script>
</html>