<?php
include 'database.php';

if(isset($_POST) && !empty($_POST)) {
    //Validations check and returns message
    if(empty(trim($_POST['name'])) || empty(trim($_POST['slug'])) || empty(trim($_POST['category']))  || empty(trim($_POST['description'])) || empty($_FILES['image']['size'])) {
        echo json_encode([
            'status' => 'required',
            'message' => 'Please fill the required fields',
        ]);
        return;
    }

    $filename       = $_FILES['image']['name'];
	$name           = mysqli_real_escape_string($db, $_POST['name']);
    $category       = mysqli_real_escape_string($db, $_POST['category']);
	$slug           = mysqli_real_escape_string($db, $_POST['slug']);
    $description    = mysqli_real_escape_string($db, $_POST['description']);
    $created_date   = date('Y-m-d H:i:s');
    $updated_date   = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO products (name,category ,slug, image, description, created_date, updated_date) VALUES ('$name','$category','$slug', '$filename', '$description', '$created_date', '$updated_date')";
	
	if( in_array(strtolower(pathinfo($filename,PATHINFO_EXTENSION)),["jpg","jpeg","png","gif"]) ) {
        //checking if folder exists
        if (!file_exists('upload/')) {
            mkdir('upload/', 0777);
        }   
        move_uploaded_file($_FILES["image"]["tmp_name"],'upload/'.$filename);
    }

	if($db->query($sql)) {
		$product = [
                'name'              => $name,
                'category'          => $category,
                'slug'              => $slug,
                'image'             => 'upload/'.$filename,
                'description'       => $description,
                'created_date'      => $created_date
            ];
                
		echo json_encode([
            'message' => 'Data inserted successfully',
            'data' => $product
        ]);
	}
}
