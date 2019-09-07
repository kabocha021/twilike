// $(function(){
//   console.log('js-stssart')
//   // フッターを最下部に固定
//   var $ftr = $('#js-footer');
//   if( window.innerHeight > $ftr.offset().top + $ftr.outerHeight() ){
//     $ftr.attr({'style': 'position:fixed; top:' + (window.innerHeight - $ftr.outerHeight()) +'px;' });
//   }
// });

  // メッセージを5秒間表示する
  // console.log('js-message-show')
  // var $jsShowMsg = $('#js-show-msg');
  // var msg = $jsShowMsg.text();
  // if (msg.replace(/^[\s　]+|[\s　]+$/g, "").length) {
  //   $jsShowMsg.removeClass("hidden");
  //   setTimeout(function () { $jsShowMsg.addClass("hidden"); },3000)

  // }


// jQueryを使わないで書く
window.onload = function(){
  console.log('windows.onload funtion');
  var $msg = document.getElementById("js-show-msg");
  console.log("文字長 = " + $msg);
  // if ($msg.replace("/^[\s　]+|[\s　]+$/g", "").length){
  //   $msg.classList.add("show-msg");
  //   setTimeout(function () { $msg.classList.remove("show-msg"); },2000);
  // }
};


