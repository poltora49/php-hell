<?php

include 'db.class.php';

$db= new DATEBASE();

if (isset($_POST['new_post']))
    $title = $_POST['title'];
    $body = $_POST['content'];
    $handler = fopen($_FILES['image']['tmp_name'], 'r');
    $img = fread($handler, filesize($_FILES['image']['tmp_name']));
    $db->addPost($title, $body, $img);

    header("location: /index.php?info=added");
?>