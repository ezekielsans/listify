<?php
require_once 'dbConfig.php';

$dbConn->connect();
class Products extends DbConnection
{

    public function insertProduct($product_name)
    {
        try {

            $pdo = $this->connect();

            $statement = $pdo->prepare("INSERT INTO products(product_name) VALUES (?)");
            $statement->execute([$product_name]);

            echo "Product was added successfully";
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
            echo "Product deleted successfully";
        } catch (PDOException $e) {
            echo "Insertion failed" . $e->getMessage();
        }

    }

    public function editProduct($productId, $newProductName)
    {
        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("UPDATE products
                                SET product_name = ?
                                WHERE ID = ?");
            $statement->execute([$newProductName, $productId]);
            echo "Product Updated successfully";
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
            echo "Product Updated successfully";

        }

    }
    public function getProductById($productId)
    {

        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("SELECT *
                                FROM products
                                WHERE ID = ?");
            $statement->execute($productId);
            $product = $statement->fetch(PDO::FETCH_ASSOC);
            return $product;

        } catch (PDOException $e) {
            echo "Product Updated successfully";

        }

    }
}
$products = new Products();
