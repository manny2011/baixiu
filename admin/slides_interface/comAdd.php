<?php
include_once('../../sql/fn.php');
// print_r($_POST);

// print_r($_FILES);

$text = $_POST['text'];
$link = $_POST['link'];

$file = $_FILES['image'];
$feature = '';
if ($file['error'] == 0) {
  // 随机生成文件名，但是后缀名不变
  $ext = explode('.', $file['name'])[1];
  // 新文件名
  $newName = time() .  rand(999, 999999) . '.' . $ext;
  // 转移
  move_uploaded_file($file['tmp_name'], '../../uploads/' . $newName);
  // 保存图片地址
  // 由于不同点文件夹相对于uploads的路径不一样，我们能确定图片一定放在uploads里面；
  $feature = 'uploads/' . $newName;
}

if(!empty($feature)){
  // echo 'not empty';
  $newBean['image'] = $feature;
  $newBean['text'] = $text;
  $newBean['link'] = $link;
  $sql = "select * from options where id = 10";
  $data = my_exec_query($sql);
  $oldArr = json_decode($data[0]['value']);
  /* 
  array_push($oldArr,{
    name:obj//能不能有这种写法呢
  });
  */
  array_push($oldArr,$newBean);
  $newSlides = json_encode($oldArr,JSON_UNESCAPED_UNICODE);//原义存储，不把中文转成unicode
  $updateSql = "UPDATE options SET value = '$newSlides' WHERE id = 10";
  $data = my_exec($updateSql);
  echo $data;
}else{
  echo 'empty';
}

