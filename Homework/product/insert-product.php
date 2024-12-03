<?php
require_once "../product/Product.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productNaam = $_POST['productNaam'];
    $omschrijving = $_POST['omschrijving'];
    $prijsPerStuk = $_POST['prijsPerStuk'];
    $foto = $_FILES['foto']; //Pakt de geupload bestand en bewaard het in $foto

    // Upload de foto in map uploads
    $fotoPath = "../uploads/" . basename($foto['name']); // basename = veilig de originele bestand naam overnemen
    $fotoSaved = move_uploaded_file($foto['tmp_name'], $fotoPath);





    if ($fotoSaved) {
        // Voeg het product toe via de Product-class
        $product = new Product();
        $success = $product->insertProduct($productNaam, $omschrijving, $prijsPerStuk, $fotoPath);

        if ($success) {
            echo "Product succesvol toegevoegd!";
        } else {
            echo "Er is iets misgegaan bij het toevoegen van het product.";
        }
    } else {
        echo "Upload van foto mislukt: ";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Nieuw Product Toevoegen</title>
</head>

<body>
    <h1>Nieuw Product Toevoegen</h1>
    <!-- enctype is nodig voor uploaden van bestanden/files -->
    <form action="insert-product.php" method="POST" enctype="multipart/form-data">
        <label for="productNaam">Productnaam:</label>
        <input type="text" name="productNaam"required><br>

        <label for="omschrijving">Omschrijving:</label>
        <input type="text" name="omschrijving"required><br>

        <label for="prijsPerStuk">Prijs Per Stuk:</label>
        <input type="number" name="prijsPerStuk" required><br>

        <label for="foto">Foto:</label>
        <input type="file" name="foto" ><br>

        <button type="submit">Product Toevoegen</button>
    </form>
</body>

</html>