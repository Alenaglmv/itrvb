<?php
include "model/Basket.php";
include "model/Feedback.php";
include "model/Product.php";
include "model/Review.php";
include "model/User.php";
include "model/ProductCard.php";

$product1 = new Product(1, "Кружка", "Стеклянная, 450мл", 750);
$product2 = new Product(2, "Менажница", "деревянная, 3 отсека", 549);
$product3 = new Product(3, "Набор бокалов", "6 штук, 300мл", 1499);

echo "<b>Товары : </b><br>";
echo $product1 . "<br>";
echo $product2 . "<br>";
echo $product3 . "<br>";

$productCard1 = new ProductCard($product1, "img/1.png", "kuchenland");
echo "<b>Карточка товара : </b><br>" . $productCard1 . "<br>";

$basket = new Basket();
$basket->addProduct($product1, 4);
$basket->addProduct($product3, 2);
$basket->removeProduct($product3);
$basket->addProduct($product3, 1);

echo "<b>Корзина: </b><br>";
foreach ($basket->getProducts() as $value) {
    $product = $value['product'];
    $count = $value['count'];
    echo "Продукт : " . $product->getName() . "<br> Количество : " . $count . "<br><br>";
}

$user = new User(1, "Ivan", "Ivanov", "Ivanov@mail.com");
echo "<b>Покупатель : </b><br>" . $user . "<br>";

$feedback = new Feedback(1, $user, "Отличный магазин, хороший ассортимент");
echo "<b>Обратная связь : </b><br>" . $feedback . "<br>";

$review1 = new Review(1, $product1, $user, "Отлично", "Однозначно рекомендую");
$review2 = new Review(2, $product3, $user, "Хорошо", "Пришли целые, но с задержкой по доставке");
echo "<b>Отзывы : </b><br>";
echo $review1 . "<br>";
echo $review2 . "<br>";

