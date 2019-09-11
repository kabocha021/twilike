window.onload = function () {
  var debugFlg = true;

  // デバッグ用ログ出力
  function debug(str) {
    if (debugFlg === true)
      console.log(str);
  }
  // console.log('start js');

  // セッションから渡される文字列を表示
  var $msg = document.getElementById("js-show-msg");
  if ($msg) {
    var text = $msg.textContent;

    // 正規表現で改行、空白を除去後、文字列が存在する場合はテキストを表示
    if (text.replace(/\s/g, "").length) {
      $msg.classList.add("show-msg");

      // 2秒後に表示を隠す
      setTimeout(function () { $msg.classList.remove("show-msg"); }, 2000);
    }
  }

  // 投稿時の文字長を表示
  var $count = document.getElementById("js-count");

  if ($count) {
    $count.addEventListener('keyup', function () {

      var text = this.value;
      var len = text.length;
      var $showCount = document.getElementById("show-count");
      $showCount.textContent = len;

      // 140字を超えた場合はハイライト用のクラスを追加する
      if (len > 140) {
        $showCount.classList.add("highlight");
      } else {
        $showCount.classList.remove("highlight");
      }
    }, false);
  }

  //ライブプレビュー
  var $imgLabel = document.querySelector(".img-label");
  var $inputFile = document.querySelector(".input-file");
  // console.log($inputFile);

  // ドラッグ中は点線を表示
  if ($imgLabel !== null && $inputFile !== null) {
    $inputFile.addEventListener('dragover', function () {
      $imgLabel.classList.add("dash");
      // console.log($inputFile);
      debug($inputFile);
    });
    $inputFile.addEventListener('dragleave', function () {
      $imgLabel.classList.remove("dash");
      // console.log($inputFile);
    });

    $inputFile.addEventListener('change', function () {
      $imgLabel.classList.remove("dash");
      var file = this.files[0];
      var $img = this.nextElementSibling;
      // console.log(file);
      // console.log($img);
      fileReader = new FileReader();
      fileReader.onload = function (event) {
        console.log(event.target.result);
        $img.setAttribute("src", event.target.result);
      };
      fileReader.readAsDataURL(file);
    });
  }

  // ファボ昨日
  var $fav = document.getElementsByClassName("js-fav");
  if ($fav) {
    for (var $i = 0; $i < $fav.length; $i++) {
      $fav[$i].onclick = function () {
        debug('click!');
        this.classList.toggle('active');
      }
    }
  }
};


