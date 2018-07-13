<?php 

$query = query("SELECT * FROM reports");
confirm($query);
while($row = fetch_array($query)){
	echo $row['product_id'] . " ";
	echo $row['product_price'] . " ";
	echo $row['product_quantity'] . " ";
	echo "<br>";
}

 ?>