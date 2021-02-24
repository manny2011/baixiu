<?php
include_once('../../sql/fn.php');
$id = $_GET['id'];
$sql = "select * from options where id = 10";
$data = my_exec_query($sql);
$slides = json_decode($data[0]['value']);
// print_r($slides);
array_splice($slides,$id,1);
// print_r($slides);
$newSlides = json_encode($slides,JSON_UNESCAPED_UNICODE);//中文直接原样转换，不进行unicode转码
$updateSql = "UPDATE options SET value = '$newSlides' WHERE id = 10";
$data = my_exec($updateSql);
echo $data; 


