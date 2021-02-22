<?php
include_once('../../sql/fn.php');
$id = $_GET['id'];
$name = $_GET['name'];
$slug = $_GET['slug'];
$sql = "UPDATE categories SET name = '$name',slug = '$slug' WHERE id = '$id'";
echo json_encode(my_exec($sql));
