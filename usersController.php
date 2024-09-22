<?php
require_once 'dbConfig.php';
error_reporting(E_ALL);
$dbConn->connect();
class Users extends DbConnection
{

    public function startSession()
    {
        error_reporting(E_ALL);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

    }



    public function deleteUser($userId)
    {
        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("DELETE FROM users WHERE ID = :userId");
            $statement->bindParam(':userId',$userId);
            $statement->execute();
            //echo "Product deleted successfully";
        } catch (PDOException $e) {
            echo "Insertion failed" . $e->getMessage();
        }

    }

    public function deactivateUser($userId)
    {
        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("UPDATE users
                                               SET status = 'inactive' 
                                               WHERE ID = :userId");
            $statement->bindParam(':userId',$userId);
            $statement->execute();
            //echo "Product deleted successfully";
        } catch (PDOException $e) {
            echo "Insertion failed" . $e->getMessage();
        }

    }





    public function editUser($newProductName, $newProductCategory, $newProductDescription, $LoginUser, $productId)
    {
        try {
            $pdo = $this->connect();

            $sqlSetTimeZone = "SET time_zone = '+8:00'";
            $pdo->exec($sqlSetTimeZone);
            $statement = $pdo->prepare("UPDATE products
                                        SET product_name = ?,
                                            product_category = ?,
                                            product_description = ?,
                                            updated_by = ?,
                                            updated_at = NOW()
                                        WHERE ID = ?");
            $statement->execute([$newProductName, $newProductCategory, $newProductDescription, $LoginUser['email'], $productId]);
            // echo "Product Updated successfully";

        } catch (PDOException $e) {
            echo "Insertion failed" . $e->getMessage();
        }

    }

    public function getAllUsers($currentPage, $itemsPerPage,$searchTerm)
    {
        try {
            $pdo = $this->connect();
            $offset = ($currentPage - 1) * $itemsPerPage;


            if (!empty($searchTerm)) {
                //print_r($searchTerm);
                
                $query = "SELECT *
                          FROM users
                          WHERE CONCAT(first_name,' ',last_name) LIKE :searchTerm 
                          LIMIT  $offset , $itemsPerPage";
                $statement = $pdo->prepare($query);
                // Bind the parameters
                $statement->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
            } else {
                $query = "SELECT *
                          FROM users
                          LIMIT $offset , $itemsPerPage";
                $statement = $pdo->prepare($query);
            }

            // Bind the parameters as integers
            //$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
            //$statement->bindValue(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
            $statement->execute();

            $statement->debugDumpParams();
            $users = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $users;

        } catch (PDOException $e) {
            echo "Users Retrieval failed" . $e->getMessage();

        }

    }

    public function generatePageLinks($totalPages, $currentPage, $searchTerm )
    {

        if ($totalPages > 1) {

            $links =  ""; 
            if ($currentPage > 1) {

                $prevPageLink = ($searchTerm !== "") ? "?page=".($currentPage - 1)."&search=$searchTerm" : "?page=".($currentPage - 1 );
                $links .= "<li class='page-item'><a class='page-link' href='$prevPageLink'>&laquo; Previous </a></li>";

            }

            for ($page = 1; $page <= $totalPages; $page++) {

                $activeClass = ($page == $currentPage) ? 'active' : '';
               
               $pageLink = ($searchTerm !== "") ? "?page=$page&search=$searchTerm" : "?page=$page";
                $links .= "<li class='page-item'><a href='$pageLink' class='$activeClass page-link'>$page </a></li>";

            }

            if ($currentPage < $totalPages) {

                $nextPageLink =($searchTerm !== "") ? "?page=".($currentPage + 1)."&search=$searchTerm":"?page=".($currentPage + 1 );
                $links .= "<li class='page-item'><a href='$nextPageLink' class='$activeClass page-link'>Next &raquo;</a></li>";

            }
            return $links;
        }


    }

    public function totalUsers($searchTerm)
    {

        try {
            $pdo = $this->connect();

            if (!empty($searchTerm)) {

                $statement = $pdo->prepare("SELECT COUNT(*)
                                                    FROM products
                                                    WHERE product_name LIKE :searchTerm");
                                                     
                $statement->bindValue(':searchTerm', "%$searchTerm%",PDO::PARAM_STR);
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

    public function getUserById($userId)
    {

        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("SELECT *
                                FROM products
                                WHERE ID = ?");
            $statement->execute([$userId]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            return $user;

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

    public function registerUser($first_name,$last_name,$email, $password)
    {try {
        $pdo = $this->connect();
        //check if user exist
        $statement = $pdo->prepare("SELECT *
                                 FROM users WHERE email = ? ");
        $statement->execute([$email]);
        $statementResult = $statement->fetch(PDO::FETCH_ASSOC);
        if ($statementResult) {

            return "User already exists";

        }
        //encrypt password
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $statement = $pdo->prepare("INSERT INTO users(email,password,first_name,last_name,role,status)
                                           VALUES(:email,:password,:first_name,:last_name,'customer','active')");
        $statement->bindParam(':email',$email);
        $statement->bindParam(':password', $hashPassword);
        $statement->bindParam(':first_name', $first_name);
        $statement->bindParam(':last_name', $last_name);
        $statement->execute();
        return "success";
    } catch (PDOException $e) {
        echo "Register failed" . $e->getMessage();
    }}

    public function login($email, $password)
    {try {
        $pdo = $this->connect();
        //check if user exist
        $statement = $pdo->prepare("SELECT *
                                 FROM users WHERE email = ?");
        $statement->execute([$email]);

        $statementResult = $statement->fetch(PDO::FETCH_ASSOC);

        if ($statementResult) {
            if (password_verify($password, $statementResult['password'])) {
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

    public function getUserId($userId)
    {

        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("SELECT *
                            FROM users
                            WHERE ID = ?");
            $statement->execute([$userId]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            return $user;

        } catch (PDOException $e) {
            echo "Product Updated successfully" . $e->getMessage();

        }

    }

    public function editUserProfile($newFirstName, $newLastName, $newEmail, $newRole, $userId)
    {
        try {
            $pdo = $this->connect();

            $sqlSetTimeZone = "SET time_zone = '+8:00'";
            $pdo->exec($sqlSetTimeZone);
            $statement = $pdo->prepare("UPDATE users
                                        SET
                                            email = ?,
                                            first_name = ?,
                                            last_name = ?,
                                            role = ?
                                        WHERE ID = ?");
            $statement->execute([$newEmail, $newFirstName, $newLastName, $newRole, $userId]);
            // echo "Product Updated successfully";

        } catch (PDOException $e) {
            echo "Insertion failed" . $e->getMessage();
        }

    }

    public function updateUserImage($userId, $imageName)
    {

        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("UPDATE users
                                        SET user_image = ?
                                        WHERE ID = ?");
            $statement->execute([$imageName, $userId]);
            // echo "Product Updated successfully";

        } catch (PDOException $e) {
            echo "Insertion failed" . $e->getMessage();
        }

    }

    }



$users = new Users();
