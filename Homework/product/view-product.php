<?php
require_once '../product/Product.php';
//Maakt een object van product
$product = new Product();
$producten = $product->getAllProducts();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Producten Overzicht</title>
</head>

<body>
    <h1>Producten Overzicht</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ProductNaam</th>
                <th>Omschrijving</th>
                <th>Prijs Per Stuk</th>
                <th>Foto</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($producten as $product): ?>
                <tr>
                    <!-- Zet alle gegevens van de product op een rij -->
                    <td><?php echo htmlspecialchars($product['productNaam']); ?></td>
                    <td><?php echo htmlspecialchars($product['omschrijving']); ?></td>
                    <td>€<?php echo number_format($product['prijsPerStuk'], 2); ?></td>
                    <td>
                        <!-- Geef aan hoe groot het image moet zijn width+height -->
                        <img src="<?php echo htmlspecialchars($product['foto']); ?>" alt="Foto" width="50" height="50">
                    </td>
                    <td>
                        <a href="edit-product.php?id=<?php echo $product['id']; ?>">Bewerken</a>
                        <a href="delete-product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">Verwijderen</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>