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


window.onload = function(){
  // console.log('start js');

  // フッターを画面最下部に固定
    var $ftr = document.getElementById('js-footer');
    if( window.innerHeight > $ftr.offset().top + $ftr.outerHeight() ){
      $ftr.attr({'style': 'position:fixed; top:' + (window.innerHeight - $ftr.outerHeight()) +'px;' });
    }

  // セッションから渡される文字列を表示
  var $msg = document.getElementById("js-show-msg");
  var text = $msg.textContent;

  // 正規表現で改行、空白を除去後、文字列が存在する場合はテキストを表示
  if (text.replace(/\s/g, "").length){
    $msg.classList.add("show-msg");

    // 2秒後に表示を隠す
    setTimeout(function () { $msg.classList.remove("show-msg"); },2000);
  }
  // console.log("End js");
};


