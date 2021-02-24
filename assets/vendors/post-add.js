define(['bootstrap', 'moment', 'wangEditor', 'template'],//使用 define 定义模块
  function (bootstrap,moment,wangEditor,template) {//在此接收导出项，并在此局部作用域中使用！
    'use strict';
    // var categories = {
    //   uncategorized: '未分类',
    //   funny: '奇趣事',
    //   living: '会生活',
    //   travel: '去旅行'
    // }
    $.ajax({
      url: './post_interface/comCategories.php',
      dataType: 'json',
      success: function (categories) {
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

    $('#slug').on('input', function () {
      console.log('.....slug......');
      var slug = $(this).val();
      // $('#slug-strong').text(slug ? slug : 'slug');优化下，替代三目
      $('#slug-strong').text(slug || 'slug');
    })
    $('#feature').on('change', function () {
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

    const E = wangEditor
    const editor = new E('#editor-box')
    // 或者 const editor = new E( document.getElementById('div1') )
    const $text1 = $('#content')
    editor.config.onchange = function (html) {
      // 第二步，监控变化，同步更新到 textarea , 目的是方便利用表单提交
      $text1.val(html)
    }
    editor.create()
  });