<?php
error_reporting(E_ALL & ~E_NOTICE);
try {
            $pdo = new PDO('mysql:host=104.196.140.231;dbname=school', 'root', 'sample');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
             echo $e->getMessage();
                  exit;
}
switch ($_SERVER['REQUEST_METHOD']) {
case 'GET':
          $st = $pdo->query("SELECT * FROM students");
            echo json_encode($st->fetchAll(PDO::FETCH_ASSOC));
            break;
case 'POST':
          $in = json_decode(file_get_contents('php://input'), true);
            if (isset($in['id'])) {
                        $st = $pdo->prepare("UPDATE students SET name=:name,age=:age,comment=:comment WHERE id=:id");
                          } else {
                                      $st = $pdo->prepare("INSERT INTO students(name,age,comment) VALUES(:name,:age,:comment)");
                                        }
            $st->execute($in);
            break;
case 'DELETE':
          $st = $pdo->prepare("DELETE FROM students WHERE id=?");
            $st->execute([$_GET['id']]);
            break;
}
