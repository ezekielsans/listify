<?php
require_once 'dbConfig.php';

$dbConn->connect();
class Products extends DbConnection
{

    public function insertProduct($productName, $productDescription, $productCategory)
    {
        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("INSERT INTO products(product_name,product_description,product_category)
                                        VALUES (?,?,?)");
            $statement->execute([$productName, $productDescription, $productCategory]);

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

    public function editProduct($newProductName, $newProductCategory, $newProductDescription, $productId)
    {
        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("UPDATE products
                                        SET product_name = ?,
                                            product_category = ?,
                                            product_description = ?
                                        WHERE ID = ?");
            $statement->execute([$newProductName, $newProductCategory, $newProductDescription, $productId]);
            // echo "Product Updated successfully";

        } catch (PDOException $e) {
            echo "Insertion failed" . $e->getMessage();
        }

    }

    public function getAllProducts()
    {

        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("SELECT *
                                FROM products");
            $statement->execute();
            $products = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $products;

        } catch (PDOException $e) {
            echo "Product Retrieval failed" . $e->getMessage();

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

    /* USER CREATION */

    public function registerUser($email,$password)
    {try {
        $pdo = $this->connect();
    //check if user exist
     $statement = $pdo->prepare("SELECT * 
                                 FROM users WHERE email = ? ");
     $statement->execute($email);
     $statementResult = $statement->fetch(PDO::FETCH_ASSOC);
     if ($statementResult){

       return "User already exists"; 
         
    }
    //encrypt password
    $hashPassword = password_hash($password,PASSWORD_DEFAULT);

         $statement = $pdo->prepare("INSERT INTO users(email,password)
                                      VALUES(?,?,?,?)");
         $statement->execute([$email,$hashPassword]);                                 
    
    } catch (PDOException $e) {
        echo "Register failed" . $e->getMessage();
    }}




    public function login($email,$password)
    {try {
        $pdo = $this->connect();
    //check if user exist
     $statement = $pdo->prepare("SELECT * 
                                 FROM users WHERE email = ?");
     $statement->execute($email);

     $statementResult = $statement->fetch(PDO::FETCH_ASSOC);
    
     if ($statementResult){
        if(password_verify($password,$statementResult['password'])){
            return $statementResult;
    } else {
    return "Invalid Credentials";

    }
         
    
} else {
    return "User not found";

    }                    
    
    } catch (PDOException $e) {
        echo "Register failed" . $e->getMessage();
    }}
}

$products = new Products();
