<?php
include_once('../../sql/fn.php');
$id = $_GET['id'];
$sql = "select * from categories where id = '$id'";
$data = my_exec_query($sql);
echo json_encode($data[0]);