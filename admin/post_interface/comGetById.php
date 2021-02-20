<?php
include_once('../../sql/fn.php');
$id = $_GET['id'];
$sql = "select * from posts where id = $id";
$data = my_exec_query($sql);
echo json_encode($data[0]);
