$(function(){
  console.log('js-stssart')
  // フッターを最下部に固定
  var $ftr = $('#js-footer');
  if( window.innerHeight > $ftr.offset().top + $ftr.outerHeight() ){
    $ftr.attr({'style': 'position:fixed; top:' + (window.innerHeight - $ftr.outerHeight()) +'px;' });
  }

  // メッセージを5秒間表示する
  console.log('js-message-show')
  var $jsShowMsg = $('#js-show-msg');
  var msg = $jsShowMsg.text();
  if (msg.replace(/^[\s　]+|[\s　]+$/g, "").length) {
    $jsShowMsg.removeClass("hidden");
    setTimeout(function () { $jsShowMsg.addClass("hidden"); },3000)
    // $jsShowMsg.slideToggle('fast');
    // setTimeout(function () { $jsShowMsg.slideToggle('fast'); }, 3000);
  }

});

