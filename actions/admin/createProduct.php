<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$category_id = $_POST['category_id'];

$errors = [];

$file = $_FILES['file'];
if(!$file['name']) {
    $errors[] = 'Вы не загрузили изображение!';
} else {
    $types = $file['type'];
    $type = explode('/', $types);
    if($type[0] != 'image') {
        $errors[] = 'Файл должен быть изображением!';
    }
}

if(!$name) {
    $errors[] = 'Вы не заполнили имя!';
}

if(!$description) {
    $errors[] = 'Вы не заполнили описание!';
}

if(!$price) {
    $errors[] = 'Вы не заполнили цену!';
}

if(!$category_id) {
    $errors[] = 'Вы не выбрали категорию!';
}

if(count($errors)) {
    $_SESSION['lastProductCreate'] = [
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'category_id' => $category_id
    ];
    $_SESSION['createProductErrors'] = $errors;
    header('Location: /pages/admin/products.php');
    exit();
}

$tempExt = explode('.', $file['name']);
$ext = $tempExt[count($tempExt) - 1];
$fileName = time() . rand(10000, 99999) . '.' . $ext;

move_uploaded_file($file['tmp_name'], "$ducument_root/images/products/$fileName");

$query = "INSERT INTO products (name, description, price, category_id, picture) 
            VALUES(:name, :description, :price, :category_id, :picture)";
$res = $pdo->prepare($query);
$res->execute([
    ':name' => $name,
    ':description' => $description,
    ':price' => $price,
    ':category_id' => $category_id,
    ':picture' => $fileName
]);

unset($_SESSION['lastProductCreate']);
header('Location: /pages/admin/products.php');

