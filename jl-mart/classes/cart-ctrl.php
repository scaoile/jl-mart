<?php

class CartCtrl extends DatabaseConnect
{

    public function getCartDetails($customer_id)
    {
        // Get the cart id for the customer
        $query = $this->connect()->prepare("SELECT id FROM carts WHERE customer_id = ?;");
        $query->execute([$customer_id]);
        $cart = $query->fetch();

        if (!$cart) {
            header("location: ../views/cart.php?error=cartnotfound");
            exit();
        }

        $cart_id = $cart['id'];

        // Join cart_items with products to get the product details
        $query = $this->connect()->prepare("
            SELECT 
                cart_items.product_id,
                cart_items.quantity,
                products.image,
                products.name,
                products.price,
                categories.category_name AS category
            FROM 
                cart_items 
            JOIN 
                products ON cart_items.product_id = products.id 
            JOIN 
                categories ON products.category_id = categories.id
            WHERE 
                cart_items.cart_id = ?;
        ");
        $query->execute([$cart_id]);
        $cart_details = $query->fetchAll(PDO::FETCH_ASSOC);

        return $cart_details;
    }

    public function addProductToCart($customer_id, $product_id, $quantity)
    {
        // Get the cart id for the customer
        $query = $this->connect()->prepare("SELECT id FROM carts WHERE customer_id = ?;");
        $query->execute([$customer_id]);
        $cart = $query->fetch();

        if (!$cart) {
            header("location: ../views/cart.php?error=cartnotfound");
            exit();
        }

        $cart_id = $cart['id'];

        // Check if the product already exists in the cart
        $query = $this->connect()->prepare("SELECT quantity FROM cart_items WHERE cart_id = ? AND product_id = ?;");
        $query->execute([$cart_id, $product_id]);
        $cart_item = $query->fetch();

        if ($cart_item) {
            // Update the quantity of the existing product in the cart
            $new_quantity = $cart_item['quantity'] + $quantity;
            $query = $this->connect()->prepare("UPDATE cart_items SET quantity = ? WHERE cart_id = ? AND product_id = ?;");
            if (!$query->execute([$new_quantity, $cart_id, $product_id])) {
                $query = null;
                header("location: ../views/cart.php?error=queryfailed");
                exit();
            }
        } else {
            // Add the product to the cart_items table
            $query = $this->connect()->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?);");
            if (!$query->execute([$cart_id, $product_id, $quantity])) {
                $query = null;
                header("location: ../views/cart.php?error=queryfailed");
                exit();
            }
        }
    }

    public function createCart($customer_id)
    {
        // Check if a cart already exists for the customer
        $query = $this->connect()->prepare("SELECT * FROM carts WHERE customer_id = ?;");
        $query->execute([$customer_id]);

        if ($query->rowCount() < 1) {
            // Create a new cart
            $query = $this->connect()->prepare("INSERT INTO carts (customer_id) VALUES (?);");
            if (!$query->execute([$customer_id])) {
                $query = null;
                header("location: ../views/cart.php?error=queryfailed");
                exit();
            }
        }
    }
}
