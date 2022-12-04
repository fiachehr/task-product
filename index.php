<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

const MYSQL_HOST = 'localhost';
const MYSQL_NAME = 'task_db';
const MYSQL_USERNAME = 'root';
const MYSQL_PASSWORD = 'Fia12345@';
const RELATIONAL_DB = ['mysql','mariadb','postgresql','sqlite'];

use App\FetchData;

require __DIR__ . '/vendor/autoload.php';

$isClassExists = true;
$type = 'Mysql';

if ($_GET) {
    $type = $_GET['type'];
}

$connectionClass = "App\\Libraries\\" . ucfirst($type) . "Connection";

if (class_exists($connectionClass)) {

    if (in_array(strtolower($type),RELATIONAL_DB)) {
        $db = $connectionClass::getInstance(MYSQL_HOST, MYSQL_NAME, MYSQL_USERNAME, MYSQL_PASSWORD);
    } else {
        $db = $connectionClass::getInstance('./data/products.' . strtolower($type));
    }
} else {
    $isClassExists = false;
}

if ($isClassExists) {

    $list = null;
    $counter = 1;

    $fetch = new FetchData($db);
    $products = $fetch->fetchAllData();

    foreach ($products as $product) {
        $list .= "<tr>
                    <td scope=\"col\">{$counter}</td>
                    <td scope=\"col\">{$product['id']}</td>
                    <td scope=\"col\"><img class=\"rounded mx-auto d-block\"  src=\"{$product['product_image']}\" alt=\"{$product['name']}\"/></td>
                    <td scope=\"col\">{$product['name']}</td>
                    <td scope=\"col\">{$product['manufacturer']}</td>
                    <td scope=\"col\">{$product['additional']}</td>
                    <td scope=\"col\">{$product['price']}</td>
                    <td scope=\"col\">{$product['availability']}</td>
                 </tr>";
        $counter++;
    }
} else {
    $list = "<tr><td colspan=\"8\">Something is wrong | Class does not exist or there aren't any product</td></tr>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        img{
            width: 90px;
            height: auto;
        }
        td ,th{
            text-align: center;
            vertical-align: middle;
        }
    </style>
    <title>My Task</title>
</head>
<body>
    <div class="container">
        <table class="table table-success table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Manufacturer</th>
                    <th scope="col">Additional</th>
                    <th scope="col">Price</th>
                    <th scope="col">Availability</th>
                </tr>
            </thead>
            <tbody>
                <?=$list;?>
            </tbody>
        </table>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
