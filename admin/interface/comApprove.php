<?php
include_once('../../sql/fn.php');
//UPDATE comments SET status =  'approved' WHERE id = 8;
$id = $_GET['id'];
$sql = "UPDATE comments SET status =  'approved' WHERE id = $id";
$data = my_exec($sql);
echo $data;
