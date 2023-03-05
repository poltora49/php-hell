<?php

include 'db.class.php';

$db= new DATEBASE();

if (isset($_POST['delete']))
    $id = $_POST['id'];
    $db->delPost( $id);

    header("location: /index.php?info=added");
?>