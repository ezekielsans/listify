<?php 
header("Access-Control-Allow-Origin: *");



require_once '../controllers/dbConfig.php';


function loadStatus(){
  
    try {
        $pdo  =(new DbConnection())->connect();
        $statement = $pdo->prepare("SELECT * 
                                           FROM order_status_lu");
        $statement->execute();
         $result = $statement->fetchAll(PDO::FETCH_ASSOC);
         echo  json_encode($result);
       
        //echo "Product deleted successfully";
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Failed to load status: ' . $e->getMessage()]);
    }
}

loadStatus();
