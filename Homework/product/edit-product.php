<?php
require_once '../product/Product.php';


// Haal het productID op uit de URL
$productID = $_GET['id'];
if (!$productID) {
    echo "Geen product ID gevoonden.";
}

$product = new Product();
$currentProduct = $product->getProductById($productID);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productNaam = $_POST['productNaam'];
    $omschrijving = $_POST['omschrijving'];
    $prijsPerStuk = $_POST['prijsPerStuk'];
    $foto = $_FILES['foto'];

    // Verwerk foto indien geüpload
    if ( empty($foto['name']) == false) {
        // Delete de oude foto (url) uit je uploads-map
        if (file_exists($currentProduct["foto"])) {
            unlink($currentProduct["foto"]);
        }
        // Bewaar de nieuwe foto in uploads-map
        $fotoPad = '../uploads/' . basename($foto['name']);
        move_uploaded_file($foto['tmp_name'], $fotoPad);
    } else {
        // Zet de orginele foto terug (dus is niet ge-update)
        $fotoPad = $currentProduct['foto'];
    }

    // Update product in de MySQL-database
    $success = $product->updateProduct($productID, $productNaam, $omschrijving, $prijsPerStuk, $fotoPad);

    if ($success == true) {
        header("Location: ../product/view-product.php");
    } else {
        echo "Er is iets misgegaan bij het bijwerken van het product.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Product Bewerken</title>
</head>

<body>
    <h1>Product Bewerken</h1>
    <form action=" " method="POST" enctype="multipart/form-data">
        <label for="productNaam">Productnaam:</label>
        <input type="text" name="productNaam" value="<?php echo htmlspecialchars($currentProduct['productNaam']); ?>" required><br>

        <label for="omschrijving">Omschrijving:</label>
        <input type="text" name="omschrijving" value="<?php echo htmlspecialchars($currentProduct['omschrijving']); ?>" required><br>

        <label for="prijsPerStuk">Prijs Per Stuk:</label>
        <input type="number" name="prijsPerStuk" step="0.01" value="<?php echo htmlspecialchars($currentProduct['prijsPerStuk']); ?>" required><br>

        <label for="foto">Foto:</label>
        <input type="file" name="foto" accept="image/*"><br>
        <img src="<?php echo htmlspecialchars($currentProduct['foto']); ?>" alt="Huidige Foto" width="100"><br>

        <button type="submit">Product Bijwerkennn</button>
    </form>
</body>

</html>