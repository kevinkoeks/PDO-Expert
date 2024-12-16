<?php
require_once "../includes/Database.php";

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function insertProduct($productNaam, $omschrijving, $prijsPerStuk, $fotoPad)
    {
        $sql = "INSERT INTO products (productNaam, omschrijving, prijsPerStuk, foto) 
                VALUES (:productNaam, :omschrijving, :prijsPerStuk, :foto)";
        $params = [
            ':productNaam' => $productNaam,
            ':omschrijving' => $omschrijving,
            ':prijsPerStuk' => $prijsPerStuk,
            ':foto' => $fotoPad
        ];

        return $this->db->run($sql, $params);
    }

    // Select alle producten van Database
    public function getAllProducts() {
        $sql = "SELECT * FROM products";
        return $this->db->run($sql)->fetchAll(); // Haalt alle rijen op uit de MySQL-database
    }

    // Nodig voor update van 1 product
    public function getProductById($productID) {
        $sql = "SELECT * FROM products WHERE productID = :productID";

        $params = ["productID" => $productID];

        return $this->db->run($sql, $params)->fetch(); // Haalt 1 rij op uit de MySQL-database
    }

    // Update gegevens van een product
    public function updateProduct($productID, $productNaam, $omschrijving, $prijsPerStuk, $fotoPad) {
        $sql = "UPDATE products 
                SET productNaam = :productNaam, omschrijving = :omschrijving, prijsPerStuk = :prijsPerStuk, foto = :foto 
                WHERE productID = :productID";
        
        $params = [
            ':productNaam' => $productNaam,
            ':omschrijving' => $omschrijving,
            ':prijsPerStuk' => $prijsPerStuk,
            ':foto' => $fotoPad,
            ':productID' => $productID
        ];

        // Geeft een true of false terug
        return $this->db->run($sql, $params) ? true : false;
    }




}
