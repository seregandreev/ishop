<?php
$title = 'Список продуктов';
require_once '../../templates/header.php';

$query = "SELECT * FROM products";
$res = $pdo->query($query);
$products = $res->fetchAll();

$query = "SELECT * FROM categories";
$res = $pdo->query($query);
$categories = $res->fetchAll();

if (isset($_SESSION['createProductErrors'])) {
    $errors = implode('<br>', $_SESSION['createProductErrors']);
    echo 
    "
    <div class='alert alert-warning text-center' role='alert'>
        $errors
    </div>
    ";
    unset($_SESSION['createProductErrors']);
}
?>

<form method="POST" enctype="multipart/form-data" action="/actions/admin/createProduct.php">
    <input value="<?= $_SESSION['lastProductCreate']['name'] ?? '' ?>" class="form-control mb-2" name='name' placeholder="Наименование продукта">
    <textarea class="form-control mb-2" name='description' placeholder="Описание"><?= $_SESSION['lastProductCreate']['description'] ?? '' ?></textarea>
    <input value="<?= $_SESSION['lastProductCreate']['price'] ?? '' ?>" class="form-control mb-2" name='price' placeholder="Цена">
    <input type="file" class="form-control mb-2" name='file'>
    <select class="form-control mb-2" name="category_id">
        <?php
            $lastCategory = $_SESSION['lastProductCreate']['category_id'];
            if(!$lastCategory) {
                echo '<option selected disabled>-- Выберите категорию --</option>';
            }
            foreach($categories as $category) {
                $selected = $lastCategory == $category['id'] ? 'selected' : '';
                echo "<option $selected value='{$category['id']}'>{$category['name']}</option>";
            }
        ?>
    </select>
    <button class="btn btn-primary w-100" type="submit">Сохранить</button>
</form>

<table class="table table-bordered mt-5">
    <thead>
        <tr>
            <th>#</th>
            <th>Наименование</th>
            <th>Описание</th>
            <th>Цена</th>
            <th>Категория</th>
            <th>Картинка</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!$products) {
            echo
            "
            <tr>
                <td class='text-center' colspan='6'>
                    <em>Продукты отсутствуют</em>
                </td>
            </tr>
            ";
        }
        $pathImg = PRODUCTS_IMAGE_PATH;
        foreach ($products as $product) {
            echo
            "
            <tr>
                <td>{$product['id']}</td>
                <td>{$product['name']}</td>
                <td>{$product['description']}</td>
                <td>{$product['price']}</td>
                <td>{$product['category_id']}</td>
                <td class='text-center'>
                    <img height='100' src='{$pathImg}{$product['picture']}'>
                </td>
            </tr>
            ";
        }
        ?>
    </tbody>
</table>

<?php

require_once '../../templates/footer.php';