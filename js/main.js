$(function(){
 console.log('js-start')
 // フッターを最下部に固定
 var $ftr = $('#js-footer');
 if( window.innerHeight > $ftr.offset().top + $ftr.outerHeight() ){
   $ftr.attr({'style': 'position:fixed; top:' + (window.innerHeight - $ftr.outerHeight()) +'px;' });
 }
});

