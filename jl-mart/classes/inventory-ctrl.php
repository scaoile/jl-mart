<?php

class InventoryCtrl extends DatabaseConnect
{

    public function addCategory($category)
    {
        $query = $this->connect()->prepare("INSERT INTO categories (category_name) VALUES (?);");
        //Checks if the query ran if not sends the user back into the login page
        if (!$query->execute([$category])) {
            $query = null;

            header("location: ../views/adminInventory.php?error=queryfailed");
            exit();
        }

        $query = null;
        header("location: ../views/adminInventory.php?message=Category Added");
        exit();
    }

    public function getProducts()
    {

        $query = $this->connect()->prepare("
            SELECT products.*, categories.category_name 
            FROM products
            INNER JOIN categories ON products.category_id = categories.id
            ORDER BY products.updated_at DESC;
        ");
        //Checks if the query ran if not sends the user back into the login page
        if (!$query->execute()) {
            $query = null;

            header("location: ../views/adminInventory.php?error=queryfailed");
            exit();
        }

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProductsByCategory($category)
    {

        $query = $this->connect()->prepare("
            SELECT products.*, categories.category_name 
            FROM products
            INNER JOIN categories ON products.category_id = categories.id
            WHERE products.category_id = ?
            ORDER BY products.updated_at DESC;
        ");
        //Checks if the query ran if not sends the user back into the login page
        if (!$query->execute([$category])) {
            $query = null;

            header("location: ../views/adminInventory.php?error=queryfailed");
            exit();
        }

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchProducts($searchTerm)
    {
        $query = $this->connect()->prepare("
        SELECT
            p.id AS product_id,
            p.name AS product_name,
            p.price AS product_price,
            p.image AS product_image,
            c.category_name,
            COALESCE(SUM(oi.quantity), 0) AS total_quantity_sold
        FROM 
            products p
        LEFT JOIN 
            order_items oi ON p.id = oi.product_id
        LEFT JOIN 
            orders o ON oi.order_id = o.id
        LEFT JOIN 
            order_statuses os ON o.status_id = os.id AND os.status_name = 'completed'
        INNER JOIN 
            categories c ON p.category_id = c.id
        WHERE 
            p.name LIKE ?
        GROUP BY 
            p.id, p.name, p.price, p.image, c.category_name 
        ORDER BY 
            p.name ASC;
    ");

        // Bind the search term with wildcards for partial matching
        $likeSearchTerm = '%' . $searchTerm . '%';

        // Check if the query ran; if not, redirect with an error
        if (!$query->execute([$likeSearchTerm])) {
            $query = null;
            header("location: ../views/products.php?error=queryfailed");
            exit();
        }

        // Fetch all results
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProductsByCategoryAndTotalSold($category)
    {
        $query = $this->connect()->prepare("
        SELECT 
            p.id AS product_id,
            p.name AS product_name,
            p.price AS product_price,
            p.image AS product_image,
            c.category_name,
            COALESCE(SUM(oi.quantity), 0) AS total_quantity_sold
        FROM 
            products p
        LEFT JOIN 
            order_items oi ON p.id = oi.product_id
        LEFT JOIN 
            orders o ON oi.order_id = o.id
        LEFT JOIN 
            order_statuses os ON o.status_id = os.id AND os.status_name = 'completed'
        INNER JOIN 
            categories c ON p.category_id = c.id
        WHERE 
            p.category_id = ?
        GROUP BY 
            p.id, p.name, p.price, p.image, c.category_name
        ORDER BY 
            p.updated_at DESC;
    ");

        // Check if the query ran; if not, redirect with an error
        if (!$query->execute([$category])) {
            $query = null;
            header("location: ../views/adminInventory.php?error=queryfailed");
            exit();
        }

        // Fetch all results
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProductById($id)
    {
        $query = $this->connect()->prepare("
            SELECT * FROM products WHERE id = ?;
        ");
        // Checks if the query ran if not sends the user back into the login page
        if (!$query->execute([$id])) {
            $query = null;

            header("location: ../views/adminInventory.php?error=queryfailed");
            exit();
        }

        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCategories()
    {

        $query = $this->connect()->prepare("SELECT * FROM categories;");
        //Checks if the query ran if not sends the user back into the login page
        if (!$query->execute()) {
            $query = null;

            header("location: ../views/adminInventory.php?error=queryfailed");
            exit();
        }

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function addProduct($image, $name, $description, $price, $category, $quantity)
    {
        $query = $this->connect()->prepare("INSERT INTO products (image, name, description, price, category_id, inventory) VALUES (?, ?, ?, ?, ?, ?);");
        //Checks if the query ran if not sends the user back into the login page
        if (!$query->execute([$image, $name, $description, $price, $category, $quantity])) {
            $query = null;

            header("location: ../views/adminInventory.php?error=queryfailed");
            exit();
        }
    }

    public function editProduct($id, $image, $name, $description, $price, $category, $quantity)
    {
        $query = $this->connect()->prepare("UPDATE products SET image = ?, name = ?, description = ?, price = ?, category_id = ?, inventory = ? WHERE id = ?;");
        // Checks if the query ran, if not sends the user back into the inventory page
        if (!$query->execute([$image, $name, $description, $price, $category, $quantity, $id])) {
            $query = null;

            header("location: ../views/adminInventory.php?error=queryfailed");
            exit();
        }
    }

    public function deleteProduct($id)
    {
        $query = $this->connect()->prepare("DELETE FROM products WHERE id = ?;");
        //Checks if the query ran if not sends the user back into the login page
        if (!$query->execute([$id])) {
            $query = null;

            header("location: ../views/adminInventory.php?error=queryfailed");
            exit();
        }

        $query = null;
        header("location: ../views/adminInventory.php?error=none");
        exit();
    }

    public function getProductsAndTotalSold()
    {
        $query = $this->connect()->prepare("
            SELECT 
                p.id AS product_id,
                p.name AS product_name,
                p.price AS product_price,
                p.image AS product_image,
                COALESCE(SUM(oi.quantity), 0) AS total_quantity_sold
            FROM 
                products p
            LEFT JOIN 
                order_items oi ON p.id = oi.product_id
            LEFT JOIN 
                orders o ON oi.order_id = o.id
            LEFT JOIN 
                order_statuses os ON o.status_id = os.id AND os.status_name = 'completed'
            GROUP BY 
                p.id, p.name, p.price, p.image
            ORDER BY 
                total_quantity_sold DESC;
        ");
        //Checks if the query ran if not sends the user back into the login page
        if (!$query->execute()) {
            $query = null;

            header("location: ../views/products.php?error=queryfailed");
            exit();
        }

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
