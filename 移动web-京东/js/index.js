// js begin
//封装到词法/局部作用域中，避免变量相互污染
//1.倒计时
//2.头部

countDown()
setHeader()
jdNewsSlide()
bannerSlide()

function countDown() {
  var target = moment('2021-03-08 19:30:00')
  setInterval(() => {
    const diff = moment.duration(target.diff(moment()))
    // console.log(diff);
    var times = $('.time span:nth-child(odd)')
    // console.log(times);
    times[0].innerText = autoAddZero(diff.hours().toString())
    times[1].innerText = autoAddZero(diff.minutes().toString())
    times[2].innerText = autoAddZero(diff.seconds().toString())
  }, 1000);

}

function setHeader() {
  window.onscroll = function (e) {
    //获取的方法是固定的
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
    console.log(scrollTop);
    if (scrollTop <= 200) {
      var alpha = scrollTop / 220
    }
    $('.jd-header').css('background-color', 'rgba(222,27,22,' + alpha + ')')
  }
}

function jdNewsSlide() {//这就是二个闭包
  var index = 0
  var ul = $('.jd-news .list ul')
  setInterval(() => {
    index++
    ul.css('transform', 'translateY(' + (-index * 30) + 'px)')
    ul.css('transition', 'transform .5s')

  }, 1000);

  ul.on('transitionend', function () {
    console.log('end');
    if (index == ul.children().length - 1) {
      index = 0
      ul.css('transform', 'translateY(0)');
      ul.css('transition', 'none')
    }
  })
}

function bannerSlide() {
  var index = 1
  var ul = $('.banner ul')
  var banner = $('.banner')
  var width = ul.children()[0].offsetWidth
  var timer = setInterval(() => {
    index--
    console.log(index, -index * width);
    ul.css('transform', 'translateX(' + (- width * index) + 'px)')
    ul.css('transition', 'transform .3s')
    toggleIndicator(index)
  }, 1000);

  ul.on('transitionend', function () {
    if (index == ul.children().length) {
      index = 1
      ul.css('transform', 'translateX(' + (- width * index) + 'px)')
      ul.css('transition', 'none')
    }

    if (index == 0) {
      index = ul.children().length - 2
      ul.css('transform', 'translateX(' + (- width * index) + 'px)')
      ul.css('transition', 'none')
    }

  })

  var distanceX = 0
  var startX = 0
  banner[0].ontouchstart = function (e) {
    clearInterval(timer)
    startX = e.targetTouches[0].clientX
  }
  banner[0].ontouchmove = function (e) {
    console.log(e);
    distanceX = e.targetTouches[0].clientX - startX
    console.log(distanceX);
    var newTranslationX = -width * index + distanceX
    ul.css('transform', 'translateX(' + newTranslationX + 'px)')
    ul.css('transition', 'none')
  }
  banner[0].ontouchend = function (e) {
    // console.log(e);
    if (Math.abs(distanceX) >= width / 3) {
      if (distanceX > 0) {
        index--
      } else {
        index++
      }
      ul.css('transform', 'translateX(' + (- width * index) + 'px)')
      ul.css('transition', 'transform .3s')
      toggleIndicator(index)
    } else {
      ul.css('transform', 'translateX(' + (- width * index) + 'px)')
      ul.css('transition', 'transform .3s')
    }
    //重置数据
    startX = 0
    distanceX = 0

    //
    timer = setInterval(() => {
      index--
      console.log(index, -index * width);
      ul.css('transform', 'translateX(' + (- width * index) + 'px)')
      ul.css('transition', 'transform .3s')
      toggleIndicator(index)
    }, 1000);


    
  }

}

function toggleIndicator(index) {
  var lis = $('.banner ol li')
  lis.removeClass('current')
  lis.eq(index).addClass('current')
}
function autoAddZero(input = '00') {
  if (input.length == 1) {
    input = '0' + input
  }
  return input
}

