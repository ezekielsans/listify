<?php 
header("Access-Control-Allow-Origin: *");



require_once '../controllers/dbConfig.php';

function loadCategories(){
  
    try {
        $pdo  =(new DbConnection())->connect();
        $statement = $pdo->prepare("SELECT * 
                                    FROM product_category_lu");
        $statement->execute();
         $result = $statement->fetchAll(PDO::FETCH_ASSOC);
         echo  json_encode($result);
       
        //echo "Product deleted successfully";
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Failed to load categories: ' . $e->getMessage()]);
    }
}

loadCategories();




