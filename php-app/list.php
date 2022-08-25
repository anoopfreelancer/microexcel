<?php
include 'database.php';

$sql = "SELECT * FROM products";
$result = $db->query($sql);

$products = [];

if ($result->num_rows > 0) {
	
    $i = 0;
	while($row = $result->fetch_assoc()) {
		$products[$i]['id']             = $row['id'];
		$products[$i]['name']           = $row['name'];
        $products[$i]['category']       = $row['category'];
        $products[$i]['slug']           = $row['slug'];
        $products[$i]['description']    = $row['description'];
        $products[$i]['created_date']   = date("Y-m-d",strtotime($row['created_date']));
        $i++;
	}

	echo json_encode([
            'success' => 'Data listed sucessfully',
            'data' => $products
        ]);
    return;
    
} else {
	echo json_encode([
        'status' => 'empty',
        'message' => 'No records found'
    ]);
    return;
}
?>