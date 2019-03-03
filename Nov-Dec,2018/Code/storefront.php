<?php
session_start();
$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$dbname = 'final';
	$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
	}
//******************************** A D D *******************************
if( isset($_POST['add'])) {
   	$id = ($_POST['add']);
}

$sql = "SELECT * FROM product WHERE id='".$id."'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	$name = $row['name'];
	$code = $name."-".$id;
	$_SESSION['add'] = $id;
	$_SESSION['code'] = $code;
	$url = "Cart.php";
	header('Location: '.$url);
}} else {
    	    echo "0 results";
    	}
    
    	mysqli_close($conn);

?>