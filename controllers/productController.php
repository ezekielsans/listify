<?php
require_once 'dbConfig.php';
error_reporting(E_ALL);
$dbConn->connect();
class Products extends DbConnection
{

    // public function startSession()
    // {

    //     error_reporting(E_ALL);
    //     if (session_status() === PHP_SESSION_NONE) {
    //         session_start();
    //     }

    // }

    public function insertProduct($productName, $productDescription, $productCategory, $LoginUser)
    {
        try {
            $pdo = $this->connect();

            $sqlSetTimeZone = "SET time_zone = '+8:00'";
            $pdo->exec($sqlSetTimeZone);

            $statement = $pdo->prepare("INSERT INTO products(product_name,product_description,product_category,added_by,updated_by,created_at)
                                        VALUES (?,?,?,?,?, NOW())");
            $statement->execute([$productName,
                $productDescription,
                $productCategory,
                $LoginUser['email'],
                $LoginUser['email'],

            ]);

            return $pdo->lastInsertId();

        } catch (PDOException $e) {
            echo "Insertion failed" . $e->getMessage();

        }

    }

    public function deleteProduct($productId)
    {
        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("DELETE FROM products WHERE ID = ?");
            $statement->execute([$productId]);
            //echo "Product deleted successfully";
        } catch (PDOException $e) {
            echo "Insertion failed" . $e->getMessage();
        }

    }

    public function editProduct($newProductName, $newProductCategory, $newProductPrice, $newProductStocks, $newProductDescription, $LoginUser, $productId)
    {
        try {
            $pdo = $this->connect();

            $sqlSetTimeZone = "SET time_zone = '+8:00'";
            $pdo->exec($sqlSetTimeZone);
            $statement = $pdo->prepare("UPDATE products
                                        SET product_name = :newProductName,
                                            product_category = :newProductCategory,
                                            product_description = :newProductDescription,
                                            product_price = :newProductPrice,
                                            product_stocks = :newProductStocks,
                                            updated_by = :LoginUser,
                                            updated_at = NOW()
                                        WHERE ID = :productId");
            $statement->bindParam(":newProductName", $newProductName);
            $statement->bindParam(":newProductCategory", $newProductCategory);
            $statement->bindParam(":newProductDescription", $newProductDescription);
            $statement->bindParam(":newProductPrice", $newProductPrice);
            $statement->bindParam(":newProductStocks", $newProductStocks);
            $statement->bindParam(":LoginUser", $LoginUser['email']);
            $statement->bindParam(":productId", $productId);
            $statement->execute();
            // echo "Product Updated successfully";

        } catch (PDOException $e) {
            echo "Insertion failed" . $e->getMessage();
        }

    }

    public function getAllProducts($currentPage, $itemsPerPage, $searchTerm)
    {
        try {
            $pdo = $this->connect();
            $offset = ($currentPage - 1) * $itemsPerPage;

            if (!empty($searchTerm)) {
                print_r($searchTerm);

                $query = "SELECT *
                          FROM products
                          WHERE product_name LIKE :searchTerm
                          LIMIT  $offset , $itemsPerPage";
                $statement = $pdo->prepare($query);
                // Bind the parameters
                $statement->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
            } else {
                $query = "SELECT *
                          FROM products
                          LIMIT $offset , $itemsPerPage";
                $statement = $pdo->prepare($query);
            }

            // Bind the parameters as integers
            //$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
            //$statement->bindValue(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
            $statement->execute();

            $statement->debugDumpParams();
            $products = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $products;

        } catch (PDOException $e) {
            echo "Product Retrieval failed" . $e->getMessage();

        }

    }

    public function generatePageLinks($totalPages, $currentPage, $searchTerm)
    {

        if ($totalPages > 1) {

            $links = "";
            if ($currentPage > 1) {

                $prevPageLink = ($searchTerm !== "") ? "?page=" . ($currentPage - 1) . "&search=$searchTerm" : "?page=" . ($currentPage - 1);
                $links .= "<li class='page-item'><a class='page-link' href='$prevPageLink'>&laquo; Previous </a></li>";

            }

            for ($page = 1; $page <= $totalPages; $page++) {

                $activeClass = ($page == $currentPage) ? 'active' : '';

                $pageLink = ($searchTerm !== "") ? "?page=$page&search=$searchTerm" : "?page=$page";
                $links .= "<li class='page-item'><a href='$pageLink' class='$activeClass page-link'>$page </a></li>";

            }

            if ($currentPage < $totalPages) {

                $nextPageLink = ($searchTerm !== "") ? "?page=" . ($currentPage + 1) . "&search=$searchTerm" : "?page=" . ($currentPage + 1);
                $links .= "<li class='page-item'><a href='$nextPageLink' class='$activeClass page-link'>Next &raquo;</a></li>";

            }
            return $links;
        }

    }

    public function totalProducts($searchTerm)
    {

        try {
            $pdo = $this->connect();

            if (!empty($searchTerm)) {

                $statement = $pdo->prepare("SELECT COUNT(*)
                                                    FROM products
                                                    WHERE product_name LIKE :searchTerm");

                $statement->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
            } else {

                $statement = $pdo->prepare("SELECT COUNT(*)
                                     FROM products");
            }

            $statement->execute();
            $totalItems = $statement->fetchColumn();

            return $totalItems;
        } catch (PDOException $e) {
            echo "Selection failed" . $e->getMessage();

        }

    }

    public function getProductById($productId)
    {

        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("SELECT *
                                FROM products
                                WHERE ID = ?");
            $statement->execute([$productId]);
            $product = $statement->fetch(PDO::FETCH_ASSOC);
            return $product;

        } catch (PDOException $e) {
            echo "Product Updated successfully" . $e->getMessage();

        }

    }

    public function uploadImage($fileInputName, $uploadDirectory, $newFileName)
    {
        //only accesible if form is multipart
        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            $tempFile = $_FILES[$fileInputName]['tmp_name'];
            $originalFileName = $_FILES[$fileInputName]['name'];

            //validate file type
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);

            $mimeType = finfo_file($fileInfo, $tempFile);

            finfo_close($fileInfo);

            $allowedType = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($mimeType, $allowedType)) {

                return "Error: Unsupported file type.";
            }

            //rename uploaded file
            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
            $newFileNameWithExtension = $newFileName . '.' . $fileExtension;

            // Check if the directory exists and try to create it if it doesn't
            if (!is_dir($uploadDirectory)) {
                if (!mkdir($uploadDirectory, 0777, true)) {
                    return "Error: Failed to create upload directory.";
                }
            }
            $destination = $uploadDirectory . '/' .
                $newFileNameWithExtension;

            if (!move_uploaded_file($tempFile, $destination)) {
                return "Failed";

            } else {
                return $newFileNameWithExtension;
            }

        } else {
            return "Error: File uploaded.";
        }

    }

    public function updateImageData($productId, $imageName)
    {

        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("UPDATE products
                                        SET product_image = ?
                                        WHERE ID = ?");
            $statement->execute([$imageName, $productId]);
            // echo "Product Updated successfully";

        } catch (PDOException $e) {
            echo "Insertion failed" . $e->getMessage();
        }

    }

    public function addToCart($userId, $productId, $quantity)
    {

        try {
            $pdo = $this->connect();
            //check if product is already added to cart
            $statement = $pdo->prepare("SELECT * FROM
                                        user_cart WHERE user_id = :user_id AND product_id = :product_id");

            $statement->bindParam(':user_id', $userId);
            $statement->bindParam(':product_id', $productId);
            $statement->execute();

            // Fetch the current product in the cart, if exists
            $existingCartItem = $statement->fetch(PDO::FETCH_ASSOC);

            if ($existingCartItem) {

                // If the product already exists in the cart, update the quantity
                $newQuantity = $existingCartItem['quantity'] + $quantity;
                $updateStatement = $pdo->prepare("
                UPDATE user_cart
                SET quantity = :quantity
                WHERE user_id = :user_id AND product_id = :product_id
            ");
                $updateStatement->bindParam(':user_id', $userId);
                $updateStatement->bindParam(':product_id', $productId);
                $updateStatement->bindParam(':quantity', $newQuantity);
                $updateStatement->execute();

            } else {
                $statement = $pdo->prepare("INSERT INTO user_cart (user_id,product_id,quantity)
                 VALUES (:user_id, :product_id, :quantity)");

                $statement->bindParam(':user_id', $userId);
                $statement->bindParam(':product_id', $productId);
                $statement->bindParam(':quantity', $quantity);
                $statement->execute();
            }

            // echo "Product Updated successfully";

        } catch (PDOException $e) {
            // Log the error or handle it appropriately
            error_log("Cart operation failed: " . $e->getMessage());

        }

    }


    public function showCartItems($userId){
try{  $pdo = $this->connect();
    //check if product is already added to cart
    $statement = $pdo->prepare("SELECT *
                                       FROM user_cart t1
                                       INNER JOIN products t2
                                       ON t1.product_id = t2.ID
                                       WHERE user_id = :user_id");
    $statement->bindParam(":user_id",$userId);
    $statement->execute();
    $items = $statement->fetchAll(PDO::FETCH_ASSOC);
return  $items;

}catch (PDOException $e) {
    // Log the error or handle it appropriately
    error_log("Cannot retrieve cart items: " . $e->getMessage());

}

}


public function showCheckoutItems($userId,$itemId){
    try{  $pdo = $this->connect();
        //check if product is already added to cart
        $statement = $pdo->prepare("SELECT *
                                           FROM user_cart t1
                                           INNER JOIN products t2
                                           ON t1.product_id = t2.ID
                                           WHERE user_id = :user_id
                                           AND t1.product_id = :product_id");
        $statement->bindParam(":user_id",$userId);
        $statement->bindParam(":product_id",$itemId);
        $statement->execute();
        $items = $statement->fetch(PDO::FETCH_ASSOC);
    return  $items;
    
    }catch (PDOException $e) {
        // Log the error or handle it appropriately
        error_log("Cannot retrieve cart items: " . $e->getMessage());
    
    }
    
    }




public function countCartItems($userId){


    try{  $pdo = $this->connect();
        //check if product is already added to cart
        $statement = $pdo->prepare("SELECT COUNT(*)
                                           FROM user_cart t1
                                           INNER JOIN products t2
                                           ON t1.product_id = t2.ID
                                           WHERE user_id = :user_id");
        $statement->bindParam(":user_id",$userId);
        $statement->execute();
        $itemCount = $statement->fetchColumn();
    return  $itemCount;
    
    }catch (PDOException $e) {
        // Log the error or handle it appropriately
        error_log("Cannot retrieve cart items: " . $e->getMessage());
    
    }







}



}

$products = new Products();
