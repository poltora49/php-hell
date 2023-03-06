<?php

include 'db.class.php';

$db= new DATEBASE();


if (isset($_POST['new_post']))
    $title = $_POST['title'];
    $body = $_POST['content'];
    if($_FILES['image']['tmp_name']){
        $handler = fopen($_FILES['image']['tmp_name'], 'r');
        $img = fread($handler, filesize($_FILES['image']['tmp_name']));
    } else {
        $img=NULL;
    }
    $db->addPost($title, $body, $img);

    header("location: /index.php?info=added");
?>