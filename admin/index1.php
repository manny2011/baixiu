<?php 
  include_once('../sql/fn.php');
  include_once('./include/checkLoginStatus.php');
  checkLoginStatus();
  $postsNumSql = "select COUNT(*) as total from posts";
  $draftsNumSql = "select COUNT(*) as total from posts where status ='drafted'";
  $categoryNumSql = "select COUNT(*) as total from categories";
  $commentsNumSql = "select COUNT(*) as total from comments";
  $heldCommentsNumSql = "select COUNT(*) as total from comments where status = 'held'";

  $postNum = my_exec_query($postsNumSql)[0]['total'];
  $draftsNum = my_exec_query($draftsNumSql)[0]['total'];
  $categoryNum = my_exec_query($categoryNumSql)[0]['total'];
  $commentsNum = my_exec_query($commentsNumSql)[0]['total'];
  $heldCommentsNum = my_exec_query($heldCommentsNumSql)[0]['total'];

?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>

<body>
  <script>
    NProgress.start()
  </script>

  <div class="main">
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="login.html"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.html" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo $postNum?></strong>篇文章（<strong><?php echo $draftsNum?></strong>篇草稿）</li>
              <li class="list-group-item"><strong><?php echo $categoryNum?></strong>个分类</li>
              <li class="list-group-item"><strong><?php echo $commentsNum?></strong>条评论（<strong><?php echo $heldCommentsNum?></strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>

  <!-- include aside -->
  <?php
  $page = 'index1';
  include_once('./include/aside.php') ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>
    NProgress.done()
  </script>
</body>

</html>