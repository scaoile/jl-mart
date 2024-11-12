<?php

class OrderCtrl extends DatabaseConnect
{

    public function addOrder($customer_id, $total, $ship_address, $proof_of_payment, $products)
    {
        $query = $this->connect()->prepare("INSERT INTO orders (customer_id, total_price, status_id, proof, shipping_address) VALUES (?, ?, ?, ?, ?);");
        if (!$query->execute([$customer_id, $total, 1, $proof_of_payment, $ship_address])) {
            $query = null;
            header("location: ../views/cart.php?error=queryfailed");
            exit();
        }

        $query = $this->connect()->prepare("SELECT id FROM orders WHERE customer_id = ? ORDER BY order_date DESC LIMIT 1;");
        $query->execute([$customer_id]);
        $id = $query->fetch();

        if (!$id) {
            header("location: ../views/cart.php?error=cartnotfound");
            exit();
        }

        foreach ($products as $product) {
            $query = $this->connect()->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?);");
            if (!$query->execute([$id['id'], $product['product_id'], $product['quantity'], $product['price']])) {
                $query = null;
                header("location: ../views/cart.php?error=queryfailed");
                exit();
            }
        }
    }

    public function getOrders($customer_id)
    {
        $query = $this->connect()->prepare("SELECT * FROM orders WHERE customer_id = ?;");
        $query->execute([$customer_id]);

        return $query->fetchAll();
    }

    public function getOrderItems($order_id)
    {
        $query = $this->connect()->prepare("
            SELECT order_items.*, products.name AS product_name 
            FROM order_items 
            JOIN products ON order_items.product_id = products.id 
            WHERE order_items.order_id = ?;
        ");
        $query->execute([$order_id]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrders()
    {
        $query = $this->connect()->prepare("
            SELECT
                orders.id AS order_id,
                orders.customer_id,
                orders.total_price,
                orders.shipping_address,
                orders.proof,
                orders.order_date,
                users.name AS customer_name,
                users.phone_number AS customer_number,
                users.email AS customer_email,  
                order_statuses.status_name AS status_name
            FROM orders
            JOIN users ON orders.customer_id = users.id  
            JOIN order_statuses ON orders.status_id = order_statuses.id  
            ORDER BY orders.order_date DESC;
        ");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrdersOfCustomer($customer_id)
    {
        $query = $this->connect()->prepare("
            SELECT
                orders.id AS order_id,
                orders.customer_id,
                orders.total_price,
                orders.shipping_address,
                orders.proof,
                orders.order_date,
                users.name AS customer_name,  
                order_statuses.status_name AS status_name
            FROM orders
            JOIN users ON orders.customer_id = users.id  
            JOIN order_statuses ON orders.status_id = order_statuses.id  
            WHERE orders.customer_id = ?
            ORDER BY orders.order_date DESC;
        ");
        $query->execute([$customer_id]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOrderStatus($order_id, $status_id)
    {
        $query = $this->connect()->prepare("UPDATE orders SET status_id = ? WHERE id = ?;");
        $query->execute([$status_id, $order_id]);

        header("location: ../views/adminDashboard.php");
    }
}
