<?php
$q = $_POST['q'];
$dsn = "mysql:host=127.0.0.1;charset=utf8;";
$pdo = new PDO($dsn, 'root', 'root');
$pdo->query("CREATE DATABASE IF NOT EXISTS `loftschoolsecurity`");
$pdo->query('use loftschoolsecurity;');
$pdo->query("CREATE TABLE IF NOT EXISTS `sqlinjection` (
  `text` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

//Form => text, password
const SALT = 'loftschool20nov';
$password = md5('asd'.SALT); //$_POST['password'] . SALT

if (!empty($q)) {
    $pdo->query("insert into sqlinjection (text, password) VALUES ('{$q}', '{$password}');");
    header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?')); //Переадресация чтобы не было дубляжа
}
if (!empty($_GET['clean'])) {
    $pdo->query("truncate table sqlinjection");
    header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?')); //Переадресация чтобы не было дубляжа
}
if (!empty($_POST['f'])) {
    $f = $_POST['f']; //intval
    //$f = 1; truncate table users;
//    $query = "select * from sqlinjection where text={$f}";

    $prepared = $pdo->prepare('select * from sqlinjection where text = :asd');
    $noinjection = $prepared->execute(['asd' => $f]);

    $prepared = $pdo->query($query);
    if ($prepared != false && $prepared->rowCount()) {
        echo "Поиск:";
        $data = $prepared->fetchAll();
        print_r($data);
    }

//    header('Location: '.strtok($_SERVER["REQUEST_URI"],'?')); //Переадресация чтобы не было дубляжа
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Пример SQL-Injection</title>
</head>
<body>
<h1>Добавить пользователя</h1>
<form action="" method="post">
    <input type="text" name="q" placeholder="" value="123">
    <input type="submit" value="add">
</form>

<h1>Эксплуатация уязвимости</h1>
<form action="" method="post">
    <input type="text" name="f" placeholder="" value="1; truncate table sqlinjection;">
    <input type="submit" value="Поиск">
</form>

<a href="?clean=1">Очистить таблицу</a>
<h1>Значение в базе:</h1>
<?php
$query = $pdo->query('select * from sqlinjection;');
$result = $query->fetchAll();
echo "<pre>";
print_r($result);
echo "</pre>";



?>

</body>
</html>

