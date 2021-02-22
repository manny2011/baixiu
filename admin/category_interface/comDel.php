<?php
include_once('../../sql/fn.php');
$id = $_GET['id'];
$sql = "DELETE FROM categories where id = '$id'";
echo json_encode(my_exec($sql));
