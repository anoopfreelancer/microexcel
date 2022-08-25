<?php 
require 'database.php';

/*
getting records from database based on Id form URL
*/
if(!empty($_GET['id'])) {
    
    $SelectSql = "SELECT * FROM products WHERE id = ".$_GET['id']."";
    $result = $db->query($SelectSql);
    
    if ($result->num_rows > 0) { 
        
        $row = $result->fetch_assoc();
		
        $products['id']             = $row['id'];
		$products['name']           = $row['name'];
        $products['category']       = $row['category'];
        $products['slug']           = $row['slug'];
        $products['image']          = $row['image'];
        $products['description']    = $row['description'];
        $products['created_date']   = date("Y-m-d",strtotime($row['created_date']));
        
        echo json_encode([
                'success' => 'Data listed sucessfully',
                'data' => $products
            ]);
        return;
    }
}

/*
Updating records
*/
if(isset($_POST) && !empty($_POST)) {
    //Validations check and returns message
    if(empty(trim($_POST['id'])) || empty(trim($_POST['name'])) || empty(trim($_POST['category'])) ||  empty(trim($_POST['slug'])) || empty(trim($_POST['description']))) {    
        echo json_encode([
            'status' => 'required',
            'message' => 'Please fill the required fields',
        ]);
        return;
    }
 
	$id                 = mysqli_real_escape_string($db, (int)$_POST['id']);
	$name               = mysqli_real_escape_string($db, trim($_POST['name']));
    $category           = mysqli_real_escape_string($db, $_POST['category']);
	$slug               = mysqli_real_escape_string($db, $_POST['slug']);
    $description        = mysqli_real_escape_string($db, $_POST['description']);
    $updated_date       = date('Y-m-d H:i:s');

    $SelectSql = "SELECT * FROM products WHERE id = $id";
    $result = $db->query($SelectSql);

    if ($result->num_rows > 0) { 
        
        $data = $result->fetch_assoc();
        
        //If image is tried to update
        if(!empty($_FILES)) {
            $filename = $_FILES['image']['name'];

            if( in_array(strtolower(pathinfo($filename,PATHINFO_EXTENSION)),["jpg","jpeg","png","gif"]) ) {
                //checking if folder exists
                if (!file_exists('upload/')) {
                    mkdir('upload/', 0777);
                }   
                move_uploaded_file($_FILES["image"]["tmp_name"],'upload/'.$filename);
            }      
            
            $sql = "UPDATE products SET name='$name',image = '$filename', category='$category', slug='$slug', description='$description', updated_date='$updated_date' WHERE id = $id";  

       } else {
            
            $sql = "UPDATE products SET name='$name', category='$category', slug='$slug', description='$description', updated_date='$updated_date' WHERE id = $id";
       }
        
        if($db->query($sql)) {
            echo json_encode('Data updated successfully');
            return;
        }
    } else { 
        echo json_encode('No records found');
        return;
	}
}

?>