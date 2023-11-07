<?php
include "Product.php";
include "DigitalProduct.php";
include "PieceProduct.php";
include "WeightProduct.php";

$digitalProduct1 = new DigitalProduct(1,"Кофе(nft)", 100, 5);
$pieceProduct = new PieceProduct(1, "Кофе(пачка)", 100, 7);
$weightProduct = new WeightProduct(1, "Кофе(вес)", 100, 2);

echo $digitalProduct1 . "<br>" . $pieceProduct . "<br>" . $weightProduct;
