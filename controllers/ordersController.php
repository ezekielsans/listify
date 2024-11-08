<?php
require_once 'dbConfig.php';
error_reporting(E_ALL);
$dbConn->connect();
class Orders extends DbConnection
{

    public function addToCart($userId, $productId, $productPrice, $quantity)
    {
        try {
            $pdo = $this->connect();

            // Check if the product is already added to cart (order_items table)
            $statement = $pdo->prepare("SELECT  t1.order_id, t2.product_id, t2.quantity
                                               FROM orders t1
                                               JOIN order_items t2 ON t1.order_id = t2.order_id
                                               JOIN order_status_lu t3 ON t1.order_status =  t3.order_status_id
                                               WHERE t1.user_id = :user_id
                                               AND t2.product_id = :product_id
                                               AND t3.order_status = 'pending'");
            $statement->bindParam(':user_id', $userId);
            $statement->bindParam(':product_id', $productId);

            $statement->execute();
            $existingOrder = $statement->fetch(PDO::FETCH_ASSOC);

            if ($existingOrder) {
                // If the product already exists in the cart, update the quantity
                $orderId = $existingOrder['order_id'];
                $newQuantity = $existingOrder['quantity'] + $quantity;

                $updateStatement = $pdo->prepare("UPDATE order_items
                                                        SET quantity = :quantity
                                                        WHERE product_id = :product_id
                                                        AND order_id = :order_id");

                $updateStatement->bindParam(':quantity', $newQuantity);
                $updateStatement->bindParam(':product_id', $productId);
                $updateStatement->bindParam(':order_id', $orderId); // update for the existing order
                $updateStatement->execute();

            } else {
                $orderId = $this->insertOrder($userId);
                $this->insertOrderItem($orderId, $productId, $productPrice, $quantity);
            }
            return "Item added to cart successfully!";
        } catch (PDOException $e) {
            // Log the error or handle it appropriately
            error_log("Cart operation failed: " . $e->getMessage());
        }
    }

    public function cancelOrder($userId, $orderId)
    {

        try {
            $pdo = $this->connect();

            $statement = $pdo->prepare("UPDATE orders
                                        SET order_status = 6
                                        WHERE user_id =:user_id
                                        AND order_id = :order_id");
            $statement->bindParam(':user_id', $userId);
            $statement->bindParam(':order_id', $orderId);
            $statement->execute();
            return "order cancelled";
        } catch (PDOException $e) {
            echo "Error canceling order" . $e->getMessage();
        }

    }

    public function removeFromCart($userId, $productId, $orderId)
    {
        try {
            $pdo = $this->connect();

            $statement = $pdo->prepare("DELETE t1
                                               FROM order_items t1
                                               INNER JOIN products t2 ON t1.product_id = t2.product_id
                                               INNER JOIN orders t3 ON t1.order_id = t3.order_id
                                               WHERE user_id = :userId
                                               AND t1.product_id = :productId");
            $statement->bindParam(':userId', $userId);
            $statement->bindParam(':productId', $productId);
            $statement->execute();

            $statement = $pdo->prepare("DELETE
                                               FROM orders t1
                                               WHERE user_id = :userId
                                               AND t1.order_id = :orderId");
            $statement->bindParam(':userId', $userId);
            $statement->bindParam(':orderId', $orderId);
            $statement->execute();

            //echo "Product deleted successfully";
        } catch (PDOException $e) {
            echo "Deletion failed" . $e->getMessage();
        }

    }


    public function showOrders()
    {
        try {
            $pdo = $this->connect();
            //check if product is already added to cart
            $statement = $pdo->prepare("SELECT  o.order_id,
                                                        o.created_at,
                                                        u.user_id,
                                                        oi.quantity,
                                                        o.total_price,
                                                        olu.order_status,
                                                        u.user_image,
                                                        u.last_name,
                                                        u.first_name,
                                                        p.product_name,
                                                        p.product_price,
                                                        sd.tracking_number,
                                                        dsl.delivery_status
                                                        FROM orders o
                                                        INNER JOIN order_items oi ON o.order_id = oi.order_id
                                                        INNER JOIN order_status_lu olu ON o.order_status = olu.order_status_id
                                                        INNER JOIN users u ON o.user_id = u.user_id
                                                        INNER JOIN products p ON oi.product_id = p.product_id
                                                        INNER JOIN shipping_details sd ON o.order_id = sd.order_id
                                                        INNER JOIN delivery_status_lu dsl ON sd.delivery_status = dsl.delivery_status_id ");
            $statement->execute();
            $items = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $items;

        } catch (PDOException $e) {
            // Log the error or handle it appropriately
            error_log("Cannot retrieve cart items: " . $e->getMessage());

        }

    }



    public function showCartItems($userId)
    {
        try {
            $pdo = $this->connect();
            //check if product is already added to cart
            $statement = $pdo->prepare("SELECT *
                                FROM order_items t1
                                INNER JOIN products t2
                                ON t1.product_id = t2.product_id
                                INNER JOIN orders t3
                                ON t1.order_id = t3.order_id
                                JOIN order_status_lu t4 ON t3.order_status = t4.order_status_id
                                WHERE user_id = :user_id AND t4.order_status = 'pending'");
            $statement->bindParam(":user_id", $userId);
            $statement->execute();
            $items = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $items;

        } catch (PDOException $e) {
            // Log the error or handle it appropriately
            error_log("Cannot retrieve cart items: " . $e->getMessage());

        }

    }

    public function showCheckoutItems($userId, $itemId)
    {
        try {
            $pdo = $this->connect();
            //check if product is already added to cart
            $statement = $pdo->prepare("SELECT *
                                           FROM products t1
                                           INNER JOIN order_items t2 ON t1.product_id = t2.product_id
                                           INNER JOIN orders t3 ON  t2.order_id = t3.order_id
                                           WHERE user_id = :user_id
                                           AND t1.product_id = :product_id");
            $statement->bindParam(":user_id", $userId);
            $statement->bindParam(":product_id", $itemId);
            $statement->execute();
            $items = $statement->fetch(PDO::FETCH_ASSOC);
            return $items;
        } catch (PDOException $e) {
            // Log the error or handle it appropriately
            error_log("Cannot retrieve cart items: " . $e->getMessage());

        }

    }

    public function countCartItems($userId)
    {

        try {
            $pdo = $this->connect();
            //check if product is already added to cart
            $statement = $pdo->prepare("SELECT COUNT(*)
                                           FROM orders t1
                                           INNER JOIN order_items t2
                                           ON t1.order_id = t2.order_id
                                           JOIN order_status_lu t3 ON t1.order_status = t3.order_status_id
                                           WHERE user_id = :user_id
                                           AND t3.order_status = 'pending'");
            $statement->bindParam(":user_id", $userId);
            $statement->execute();
            $itemCount = $statement->fetchColumn();
            return $itemCount;
        } catch (PDOException $e) {
            // Log the error or handle it appropriately
            error_log("Cannot retrieve cart items: " . $e->getMessage());

        }

    }

    public function generateTransactionId()
    {
        $transactionId = uniqid('LSTRANS') . time() . mt_rand(10000, 99999);
        return $transactionId;
    }

    public function generateTrackingNumber()
    {
        $trackingNumber = uniqid('LSTRACKING') . time() . mt_rand(10000, 99999);
        return $trackingNumber;
    }

    public function placeOrder($userId, $paymentMethod, $shippingAddress)
    {
        try {

            $pendingOrder = $this->findPendingOrder($userId);

            if (!$pendingOrder) {
                throw new Exception("No pending order found for user.");
            }

            //update order status
            $this->updateOrderStatus($pendingOrder['order_id'], 2);

            $this->insertPayments($pendingOrder['order_id'], $paymentMethod, 1);
            $this->insertShippingDetails($pendingOrder['order_id'], $shippingAddress, 1);
            $this->updateOrder($pendingOrder['order_id']);

            return "Order placed successfully!";

        } catch (PDOException $e) {
            // Log the error or handle it appropriately
            error_log("Cannot retrieve cart items: " . $e->getMessage());

        }

    }

    public function updateOrder($orderId)
    {

        try {
            $pdo = $this->connect();

            //get the total
            $statement = $pdo->prepare("SELECT SUM(product_price * quantity) as total
                                    FROM order_items
                                    WHERE order_id = :order_id");
            $statement->bindParam(':order_id', $orderId);
            $statement->execute();

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            $totalPrice = $result['total'];
            //update total in order table
            $updateStmt = $pdo->prepare("UPDATE orders
                                     SET total_price = :totalPrice
                                     WHERE order_id = :orderId");
            $updateStmt->bindParam(':totalPrice', $totalPrice);
            $updateStmt->bindParam(':orderId', $orderId);
            $updateStmt->execute();
            return "Order total updated successfully!";
        } catch (PDOException $e) {
            // Handle exception
            error_log("Failed to update order total: " . $e->getMessage());
            return "Error updating order total.";

        }
    }

    public function insertOrderItem($orderId, $productId, $productPrice, $quantity)
    {
        try {
            $pdo = $this->connect();

            // Insert into the orders table
            $statement = $pdo->prepare("INSERT INTO order_items(order_id,product_id,product_price,quantity)
                                               VALUES (:order_id,:product_id,:product_price,:quantity)");
            $statement->bindParam(':order_id', $orderId);
            $statement->bindParam(':product_id', $productId);
            $statement->bindParam(':product_price', $productPrice);
            $statement->bindParam(':quantity', $quantity);
            $statement->execute();

            return "Success"; // Return the generated order_id

        } catch (PDOException $e) {
            // Log the error or handle it appropriately
            error_log("Order creation failed: " . $e->getMessage());
            return false; // Return false in case of an error
        }
    }

    public function insertOrder($userId)
    {
        try {
            $pdo = $this->connect();
            //check if product is already added to cart
            $statement = $pdo->prepare("INSERT INTO orders (user_id, total_price, order_status,created_at)
                                       VALUES(:user_id, 0, 1,NOW())");
            $statement->bindParam(":user_id", $userId);
            $statement->execute();

            $orderId = $pdo->lastInsertId();
            return $orderId;

        } catch (PDOException $e) {
            // Log the error or handle it appropriately
            error_log("Cannot insert on order table: " . $e->getMessage());

        }

    }

    public function findPendingOrder($userId)
    {

        $pdo = $this->connect();
        $statement = $pdo->prepare("SELECT  *
                                           FROM orders t1
                                           JOIN order_status_lu t2 ON t1.order_status = t2.order_status_id
                                           WHERE t1.user_id = :user_id
                                           AND t2.order_status = 'pending'");
        $statement->bindParam(":user_id", $userId);
        $statement->execute();

        $existingOrder = $statement->fetch(PDO::FETCH_ASSOC);
        return $existingOrder;

    }

    public function updateOrderStatus($orderId, $orderStatus)
    {

        $pdo = $this->connect();
        //check if product is already added to cart
        $statement = $pdo->prepare("UPDATE orders
                                       SET order_status = :order_status,
                                           updated_at = NOW()
                                       WHERE  order_id = :order_id");
        $statement->bindParam(":order_id", $orderId);
        $statement->bindParam(":order_status", $orderStatus);
        $statement->execute();

    }


    public function updateOrderAndShippingStatus($orderId, $shippingStatus)
    {

        try {

            $pdo = $this->connect();
            //check if product is already added to cart
            $statement = $pdo->prepare("UPDATE orders
                                               SET order_status = 3,
                                               updated_at = NOW()
                                           WHERE  order_id = :order_id");
            $statement->bindParam(":order_id", $orderId);
            $statement->execute();
        } catch (PDOException $e) {
            error_log("unable to update order status" . $e->getMessage());

        }


        try {
            $pdo = $this->connect();
            //check if product is already added to cart
            $statement = $pdo->prepare("UPDATE orders
                                               SET order_status = 3,
                                               updated_at = NOW()
                                   WHERE  order_id = :order_id");
            $statement->bindParam(":order_id", $orderId);
            $statement->execute();
        } catch (PDOException $e) {
            error_log("unable to update shipping status" . $e->getMessage());

        }



    }

    public function insertPayments($orderId, $paymentMethod, $paymentStatus)
    {

        try {
            $transactionId = $this->generateTransactionId();
            $pdo = $this->connect();
            /**
            add if statement if paymentMethod === "Cash on Delivery";
            then pending
             **/
            $statement = $pdo->prepare("INSERT INTO payments(order_id,payment_method,payment_status,transaction_id)
                                           VALUES (:order_id,:payment_method,:payment_status,:transaction_id)");
            $statement->bindParam(":order_id", $orderId);
            $statement->bindParam(":payment_method", $paymentMethod);
            $statement->bindValue(":payment_status", $paymentStatus); //payment status default
            $statement->bindParam(":transaction_id", $transactionId);
            $statement->execute();

        } catch (PDOException $e) {

        }
    }

    public function insertShippingDetails($orderId, $shippingAddress, $deliveryStatus)
    {

        $trackingNumber = $this->generateTrackingNumber();
        try {
            $pdo = $this->connect();

            $statement = $pdo->prepare("INSERT INTO shipping_details (order_id, shipping_address, tracking_number, delivery_status)
        VALUES(:order_id, :shipping_address, :tracking_number, :delivery_status)");
            $statement->bindParam(":order_id", $orderId);
            $statement->bindParam(":shipping_address", $shippingAddress);
            $statement->bindParam(":tracking_number", $trackingNumber);
            $statement->bindValue(":delivery_status", $deliveryStatus); //$delivery status default

            $statement->execute();

        } catch (PDOException $e) {

        }
    }

    public function showUserOrders($userId)
    {

        $pdo = $this->connect();
        $statement = $pdo->prepare("SELECT  *
                                           FROM orders t1
                                           JOIN order_items t2 ON t1.order_id = t2.order_id
                                           JOIN order_status_lu t3 ON t1.order_status = t3.order_status_id
                                           JOIN products t4 ON t2.product_id = t4.product_id
                                           WHERE t1.user_id = :user_id
                                           AND t3.order_status = 'placed'");
        $statement->bindParam(":user_id", $userId);
        $statement->execute();

        $existingOrder = $statement->fetchAll();
        return $existingOrder;

    }
    public function showUserOrdersToPay($userId)
    {

        $pdo = $this->connect();
        $statement = $pdo->prepare("SELECT  *
                                           FROM orders t1
                                           JOIN order_items t2 ON t1.order_id = t2.order_id
                                           JOIN order_status_lu t3 ON t1.order_status = t3.order_status_id
                                           JOIN products t4 ON t2.product_id = t4.product_id
                                           WHERE t1.user_id = :user_id
                                           AND t3.order_status = 'placed'");
        $statement->bindParam(":user_id", $userId);
        $statement->execute();

        $existingOrder = $statement->fetchAll();
        return $existingOrder;

    }

    public function showUserOrdersToShip($userId)
    {

        $pdo = $this->connect();
        $statement = $pdo->prepare("SELECT  *
                                           FROM orders t1
                                           JOIN order_items t2 ON t1.order_id = t2.order_id
                                           JOIN order_status_lu t3 ON t1.order_status = t3.order_status_id
                                           JOIN products t4 ON t2.product_id = t4.product_id
                                           WHERE t1.user_id = :user_id
                                           AND t3.order_status = 'shipped'");
        $statement->bindParam(":user_id", $userId);
        $statement->execute();

        $existingOrder = $statement->fetchAll();
        return $existingOrder;

    }

    public function showUserOrdersToReceive($userId)
    {

        $pdo = $this->connect();
        $statement = $pdo->prepare("SELECT  *
                                           FROM orders t1
                                           JOIN order_items t2 ON t1.order_id = t2.order_id
                                           JOIN order_status_lu t3 ON t1.order_status = t3.order_status_id
                                           JOIN products t4 ON t2.product_id = t4.product_id
                                           WHERE t1.user_id = :user_id
                                           AND t3.order_status = 'out for delivery'");
        $statement->bindParam(":user_id", $userId);
        $statement->execute();

        $existingOrder = $statement->fetchAll();
        return $existingOrder;

    }


    public function showUserOrdersCompleted($userId)
    {

        $pdo = $this->connect();
        $statement = $pdo->prepare("SELECT  *
                                           FROM orders t1
                                           JOIN order_items t2 ON t1.order_id = t2.order_id
                                           JOIN order_status_lu t3 ON t1.order_status = t3.order_status_id
                                           JOIN products t4 ON t2.product_id = t4.product_id
                                           WHERE t1.user_id = :user_id
                                           AND t3.order_status = 'completed'");
        $statement->bindParam(":user_id", $userId);
        $statement->execute();

        $existingOrder = $statement->fetchAll();
        return $existingOrder;

    }

    public function showUserOrdersCancelled($userId)
    {

        $pdo = $this->connect();
        $statement = $pdo->prepare("SELECT  *
                                           FROM orders t1
                                           JOIN order_items t2 ON t1.order_id = t2.order_id
                                           JOIN order_status_lu t3 ON t1.order_status = t3.order_status_id
                                           JOIN products t4 ON t2.product_id = t4.product_id
                                           WHERE t1.user_id = :user_id
                                           AND t3.order_status = 'cancelled'");
        $statement->bindParam(":user_id", $userId);
        $statement->execute();

        $existingOrder = $statement->fetchAll();
        return $existingOrder;

    }

    public function showSpecificUserOrder($userId, $productId)
    {

        $pdo = $this->connect();
        $statement = $pdo->prepare("SELECT  *
                                           FROM orders t1
                                           JOIN order_items t2 ON t1.order_id = t2.order_id
                                           JOIN order_status_lu t3 ON t1.order_status = t3.order_status_id
                                           JOIN products t4 ON t2.product_id = t4.product_id
                                           WHERE t1.user_id = :user_id
                                           AND t4.product_id = :product_id
                                           AND t3.order_status = 'placed'");
        $statement->bindParam(":user_id", $userId);
        $statement->bindParam(":product_id", $productId);
        $statement->execute();

        $existingOrder = $statement->fetch();
        return $existingOrder;

    }

    // for dashboard purposes
    public function countOrders()
    {
        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("SELECT COUNT(*) AS total_orders FROM orders");
            $statement->execute();

            // fetchColumn() will retrieve the count directly without needing an argument
            $result = $statement->fetchColumn();
            return $result;

        } catch (PDOException $e) {
            echo "Error counting orders: " . $e->getMessage();
            return null; // return null or a default value on failure
        }
    }


    public function countPendingOrders()
    {
        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare("SELECT count(*)  as pending_orders
                                        FROM orders o 
                                        INNER JOIN order_status_lu orl  ON  o.order_status = orl.order_status_id 
                                        WHERE orl.order_status = 'pending'");
            $statement->execute();

            // fetchColumn() will retrieve the count directly without needing an argument
            $result = $statement->fetchColumn();
            return $result;

        } catch (PDOException $e) {
            echo "Error counting orders: " . $e->getMessage();
            return null; // return null or a default value on failure
        }
    }


}

$orders = new Orders();
