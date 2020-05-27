<?php 
    require_once('../util/main.php');
    require_once('../util/secure_conn.php');
    require_once('../util/valid_admin.php');
    require_once('../model/database.php');
    require_once('../model/category_db.php');
    require_once('../model/category.php');
    require_once('../model/city_db.php');
    require_once('../model/city.php');
    include ('../view/header.php');
    include ('../view/sidebar_admin.php');
?>

<main class="nofloat">
    <h1>Мени за администратор</h1>
    <p><a href="product">Менаџер на производи</a></p>
    <p><a href="category">Менаџер на категории</a></p>
    <p><a href="user">Менаџер на корисници</a></p>
    <p><a href="account">Kорисничка сметка</a></p>
    
</main>

<?php include ('../view/footer.php'); ?>