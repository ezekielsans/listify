<?php
require_once 'dbConfig.php';
error_reporting(E_ALL);
$dbConn->connect();
class Products extends DbConnection
{
    public function insertProduct($productName, $productDescription, $productCategory, $LoginUser)
    {
        try {
            $pdo = $this->connect();

            $sqlSetTimeZone = "SET time_zone = '+8:00'";
            $pdo->exec($sqlSetTimeZone);

            $statement = $pdo->prepare("INSERT INTO products(product_name,product_description,product_category,added_by,updated_by,created_at)
                                        VALUES (:product_name,:product_description,:product_category,:added_by,:updated_by, NOW())");

            $statement->bindParam(':product_name', $productName);
            $statement->bindParam(':product_description', $productDescription);
            $statement->bindParam(':product_category', $productCategory);
            $statement->bindParam(':added_by', $LoginUser['email']);
            $statement->bindParam(':updated_by', $LoginUser['email']);
            $statement->execute();

            return $pdo->lastInsertId();

        } catch (PDOException $e) {
            echo "Insertion failed" . $e->getMessage();

        }

    }


    public function deleteProduct($productId)
    {
        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("DELETE FROM products WHERE product_id = :product_id");
            $statement->bindParam(':product_id', $productId);
            $statement->execute();
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
                                        WHERE product_id = :productId");
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

    // get products via catergory



    public function getProductByCategory($categoryId, $currentPage, $itemsPerPage, $searchTerm)
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
                      FROM products p
                      JOIN product_category_lu pc ON p.product_category = pc.product_category_id
                      WHERE pc.product_category_id = :category_id
                      LIMIT $offset , $itemsPerPage";
                $statement = $pdo->prepare($query);
                $statement->bindParam(":category_id", $categoryId);
            }

            $statement->execute();

            // $statement->debugDumpParams();

            $products = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $products;

        } catch (PDOException $e) {
            echo "Product Retrieval failed" . $e->getMessage();
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

            $statement->execute();

            // $statement->debugDumpParams();

            $products = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $products;

        } catch (PDOException $e) {
            echo "Product Retrieval failed" . $e->getMessage();

        }

    }


    public function getAllPromotionProducts($currentPage, $itemsPerPage, $searchTerm)
    {
        try {
            $pdo = $this->connect();
            $offset = ($currentPage - 1) * $itemsPerPage;

            if (!empty($searchTerm)) {
                print_r($searchTerm);

                $query = "SELECT * 
                          FROM promotion promotion
                          INNER JOIN products product ON  promotion.product_id =  product.product_id
                          INNER JOIN promotion_type_lu promo ON promotion.promotion_type = promo.promotion_type_id
                          WHERE product.product_name LIKE :searchTerm
                          LIMIT  $offset , $itemsPerPage";
                $statement = $pdo->prepare($query);
                // Bind the parameters
                $statement->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
            } else {
                $query = "SELECT * 
                            FROM promotion promotion
                            INNER JOIN products product ON  promotion.product_id =  product.product_id
                            INNER JOIN promotion_type_lu promo ON promotion.promotion_type = promo.promotion_type_id
                          LIMIT $offset , $itemsPerPage";
                $statement = $pdo->prepare($query);
            }

            $statement->execute();

            // $statement->debugDumpParams();

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
                                     FROM products p 
                                     INNER JOIN product_category_lu pc ON p.product_category = pc.product_category_id  
                                     WHERE p.product_category = :category_id");
                $statement->bindParam(':category_id', $categoryId);
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
                                WHERE product_id = :productId");
            $statement->bindParam(':productId', $productId);
            $statement->execute();
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
                                        WHERE product_id = ?");
            $statement->execute([$imageName, $productId]);
            // echo "Product Updated successfully";

        } catch (PDOException $e) {
            echo "Insertion failed" . $e->getMessage();
        }

    }

    //for products dashboard


    public function countTotalProducts()
    {

        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("SELECT COUNT(*) as total_products
                                               FROM products");
            $statement->execute();
            $result = $statement->fetchColumn();

            return $result;
            // echo "Product Updated successfully";

        } catch (PDOException $e) {
            echo "count total products failed" . $e->getMessage();
        }

    }
    public function totalProductsSum()
    {

        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("SELECT SUM(product_price) as total_product_price
                                               FROM products");
            $statement->execute();
            $result = $statement->fetchColumn();

            return $result;
            // echo "Product Updated successfully";

        } catch (PDOException $e) {
            echo "count total products failed" . $e->getMessage();
        }

    }
    public function totalStocks()
    {

        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("SELECT SUM(product_stocks) as total_stocks
                                               FROM products");
            $statement->execute();
            $result = $statement->fetchColumn();

            return $result;
            // echo "Product Updated successfully";

        } catch (PDOException $e) {
            echo "count total products failed" . $e->getMessage();
        }

    }
}

$products = new Products();
