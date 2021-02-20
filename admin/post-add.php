<?php
include_once('./include/checkLoginStatus.php');
checkLoginStatus();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
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
      <div class="page-title">
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" action="./post_interface/comPostAdd.php" method="post" enctype="multipart/form-data">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <div id="editor-box"></div>
            <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容" style="display: none;"></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong id="slug-strong">slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none">
            <input id="feature" class="form-control" name="feature" type="file" accept="image/jpeg">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
              <option value="2">潮生活</option>
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local" ">
          </div>
          <div class=" form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- include aside -->
  <?php
  $page = 'post-add';
  include_once('./include/aside.php') ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../lib/moment.min.js"></script>
  <script src="../lib/wangEditor.min.js"></script>
  <script src="../lib/template-web.js"></script>

  <script>
    NProgress.done()
  </script>

  <script type="text/template" id="category-temp">
    {{each $data}}// $data 可以是数组，也可以是个对象
    <option value={{$value.id}}>{{$value.name}}</option>
    {{/each}}
  </script>
  <script type="text/template" id="state-temp">
    {{each $data}}// $data 可以是数组，也可以是个对象
    <option value="{{$index}}">{{$value}}</option>
    {{/each}}
  </script>

  <script>
    // var categories = {
    //   uncategorized: '未分类',
    //   funny: '奇趣事',
    //   living: '会生活',
    //   travel: '去旅行'
    // }
    $.ajax({
      url: './post_interface/comCategories.php',
      dataType: 'json',
      success: function(categories) {
        $('#category').html(template('category-temp', categories))
      }
    })
    var state = {
      held: '待审核',
      approved: '准许',
      rejected: '拒绝',
      trashed: '回收站'
    }
    $('#status').html(template('state-temp', state))

    $('#slug').on('input', function() {
      console.log('.....slug......');
      var slug = $(this).val();
      // $('#slug-strong').text(slug ? slug : 'slug');优化下，替代三目
      $('#slug-strong').text(slug || 'slug');
    })
    $('#feature').on('change', function() {
      console.log('change func');
      console.log(this);
      var file = this.files[0]
      var url = URL.createObjectURL(file)
      console.log(url);
      // $('.thumbnail').attr('src',url).css('display','block')
      $('.thumbnail').attr('src', url).fadeIn()

    })
    // 2021-02-17T16:14
    $('#created').val(moment().format('YYYY-MM-DDTHH:mm')) //只有input才有val(...)方法

    const E = window.wangEditor
    const editor = new E('#editor-box')
    // 或者 const editor = new E( document.getElementById('div1') )
    const $text1 = $('#content')
    editor.config.onchange = function(html) {
      // 第二步，监控变化，同步更新到 textarea , 目的是方便利用表单提交
      $text1.val(html)
    }
    editor.create()
  </script>
</body>

</html>