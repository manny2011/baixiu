<?php
include_once('./include/checkLoginStatus.php');
checkLoginStatus();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../lib/pagination.css">
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
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch pull-left btn-batch" style="display: none">
          <button class="btn btn-info btn-sm btn-approve-all">批量批准</button>
          <!-- <button class="btn btn-warning btn-sm">批量拒绝</button> -->
          <button class="btn btn-danger btn-sm btn-del-all">批量删除</button>
        </div>
        <div class="pagination pagination-sm pull-right">

        </div>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox" class="th-chk"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>

  <!-- include aside -->
  <?php
  $page = 'comments';
  include_once('./include/aside.php') ?>

  <script type="text/template" id="template">
    {{each list v i}}
    <tr>
      <td class="text-center" data_id={{v.id}}><input type="checkbox" class='tr-chk'></td>
      <td>{{v.author}}</td>
      <td style='width:500px'>{{v.content}}</td>
      <td>《{{v.title}}》</td>
      <td>{{v.created}}</td>
      <td>{{state[v.status]}}</td>
      <td class="text-right" data_id={{v.id}}>
        {{if v.status == 'held'}}
        <a href="javascript:;" class="btn btn-info btn-xs btn-approve">批准</a>
        {{/if}}
        <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
      </td>
    </tr>
    {{/each}}
  </script>
  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../lib/template-web.js"></script>
  <script src="../lib/jquery.pagination.js"></script>
  <script>
    NProgress.done()
  </script>
  <script>
    var currentPage = 0;
    // 待审核（held）/ 准许（approved）/ 拒绝（rejected）/ 回收站（trashed）
    var state = {
      held: '待审核',
      approved: '准许',
      rejected: '拒绝',
      trashed: '回收站'
    }

    function getData(page) {
      $.ajax({
        type: 'get',
        url: './interface/comGet.php',
        dataType: 'json',
        data: { //string || object
          page: page,
          pageSize: 10,
        },
        success: function(data) {
          console.log(data);
          $('tbody').html(template('template', {
            list: data,
            state: state,
          }));
        },
        error: function(err) {
          console.log(err);
        }
      });
    }

    $.ajax({
      url: './interface/comTotal.php',
      dataType: 'json',
      success: function(info) {
        // console.log(info);  
        renderPagination(info.total);
      }
    })

    //事件委托机制
    $('tbody').on('click', '.btn-approve', function() { //此处的this指的是处理的子元素
      // console.log(this);
      var data_id = $(this).parent().attr('data_id')
      $.ajax({
        url: './interface/comApprove.php',
        data: {
          id: data_id,
        },
        success: function(data) {
          if (data != 0) {
            getData(currentPage)
          }
        },
        error: function(err) {
          console.log(err);
        }
      })
    })

    $('tbody').on('click', '.btn-del', function() {
      console.log('btn_del');
      var id = $(this).parent().attr('data_id')
      $.ajax({
        url: './interface/comDel.php',
        dataType: 'json', //这玩意必须得显式指定返回类型才行
        data: {
          id: id,
        },
        success: function(data) {
          console.log(data);
          var total = data['total'];
          var maxPages = Math.ceil(total / 10);
          if (currentPage > (maxPages - 1)) {
            currentPage = maxPages - 1
          }
          console.log(total);
          renderPagination(total)
        },
        err: function(err) {
          console.log(err);
        }
      })
    })

    $('.th-chk').on('change', function() {
      var checked = $(this).prop('checked')
      console.log(checked)
      $('.tr-chk').prop('checked', checked)
      if (checked) {
        $('.btn-batch').show()
      } else {
        $('.btn-batch').hide()
      }

    })

    $('tbody').on('change', '.tr-chk', function() {
      console.log($('.tr-chk').length)
      console.log($('.tr-chk:checked').length)
      if ($('.tr-chk').length == $('.tr-chk:checked').length) {
        $('.th-chk').prop('checked', true)
      } else {
        $('.th-chk').prop('checked', false)
      }

      if ($('.tr-chk:checked').length >= 2) {
        $('.btn-batch').show()
      } else {
        $('.btn-batch').hide()
      }

    })

    $('.btn-approve-all').click(function() {
      // console.log($('.tr-chk:checked'));
      var ids = getIds();
      $.ajax({
        url: './interface/comApprove.php',
        dataType: 'json',
        data: {
          id: ids.join(), //默认用逗号隔开 ’1，2，3，‘
        },
        success: function(data) {
          // console.log(data);
          if (data != 0) {
            getData(currentPage)
            $('.th-chk').prop('checked', false)
            $('.btn-batch').hide()
          }
        }
      })
    })
    $('.btn-del-all').click(function() {
      var ids = getIds()
      $.ajax({
        url: './interface/comDel.php',
        dataType: 'json',
        data: {
          id: ids.join(),
        },
        success: function(data) {
          var total = data['total'];
          var maxPages = Math.ceil(total / 10);
          if (currentPage > (maxPages - 1)) {
            currentPage = maxPages - 1
          }
          console.log(total);
          renderPagination(total)
          $('.th-chk').prop('checked', false)
          $('.btn-batch').hide()
        }
      })
    })

    function getIds() {
      var ids = []
      $('.tr-chk:checked').each(function(i, elem) {
        ids.push($(elem).parent().attr('data_id'))
      })
      return ids
    }

    function renderPagination(total) {
      $('.pagination').pagination(total, {
        prev_text: "« 上一页",
        next_text: "下一页 »",
        num_edge_entries: 1, //两侧首尾分页条目数
        num_display_entries: 5,
        current_page: currentPage,
        callback: function(index) {
          currentPage = index
          getData(index)
        }
      })
    }
  </script>
</body>

</html>