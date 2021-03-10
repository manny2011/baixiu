var pop = document.querySelector('.win-pop')
var del = document.querySelector('.win-pop .del')
var delBtns = document.querySelectorAll('.p-list .item .del')
var cancelBtn = document.querySelector('.win-pop .left')
delBtns.forEach(function(v,i){
  v.onclick = function(){
    //1 show dialog
    pop.classList.add('show')
    del.classList.add('bounceInDown')//一次只能加一个类名，中间不能有空格
    console.log('click')
    //2 animation
    this.classList.add('open')
    
  }
})
cancelBtn.onclick = function(){
  pop.classList.remove('show')
  del.classList.remove('bounceInDown')
  document.querySelector('.item .open').classList.remove('open')
}


