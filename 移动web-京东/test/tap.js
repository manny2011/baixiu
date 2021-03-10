//如何判断是click事件呢
//1。没有move事件产生
//2。从按下到抬起不超过150ms

function tap(selector, func) {
  var target = document.querySelector(selector)
  var start = 0
  var ifMoved = false
  target.ontouchstart = function (e) {
    start = Date.now()
    ifMoved = false
  }
  target.ontouchmove = function (e) {
    console.log('move')
    ifMoved = true
  }
  target.ontouchend = function (e) {
    if(!ifMoved && Date.now() - start < 150){
      func && func(e)
    }
  }

}
