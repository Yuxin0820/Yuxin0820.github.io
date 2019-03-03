<?php
/**
 * Created by PhpStorm.
 * User: jiangnan
 * Date: 2018/10/8
 * Time: 14:07
 */
	session_start();
	$dbhost = "localhost";
	$dbuser = "id6942946_yuxin";
	$dbpass = "082000";
	$dbname = "id6942946_yuxin_db";
	$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
	}
$category = $_POST['cateadd'];   //Get the value by POST

	$sql1 = "SELECT * FROM type WHERE type.Category = '".$category."'";
	$result1 = mysqli_query($conn, $sql1);
	if (mysqli_num_rows($result1) > 0) {
			while($row = mysqli_fetch_assoc($result1)) {
				$value[] = $row['Type'];
			}
	}
	
	
//Determine whether it is within the data range and load the data
if(!empty($value)){
    $result['status'] = 200;
    $result['data'] = $value;
}else{
    $result['status'] = 220;
}

echo json_encode($result);  //Return the Json data
?>