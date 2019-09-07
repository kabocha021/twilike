<!DOCTYPE html>
<html lang="ja">
  <meta charset="utf-8">
  <title>サンプル</title>
  <style>
    .space{
      width: 80%;
      height: 1000px;
      margin: 100px auto;
      border: 1px solid #eee;

    }
    .body{
      overflow: hidden;
      display: table;
      width: 100%;
    }
    .fadein{
      /* widht: 30%; */
      min-height: 300px;
      margin: 10px auto;
      border: 1px solid #ccc;
      /* float: left; */
      display: table-cell;
      box-sizing: border-box;
      color: red;;
    }
    .fadein{
      opacity: 0.1;
      /* transform: translate(0,50px); */
      transition: all 1500ms;
    }
    .fadein.scrollin{
      opacity: 1;
      transform: translate(0,0);
    }
  </style>
  <body>
  <div class="space"></div>
  <section class="fadein">
    <h2>タイトル</h2>
      <p>hogehogehogeohghoehgoehgoehgoehgoehgoehe</p>
  </section>
  <section class="fadein">
    <h2>タイトル</h2>
      <p>hogehogehogeohghoehgoehgoehgoehgoehgoehe</p>
  </section>

  <section class="fadein">
    <h2>タイトル</h2>
      <p>hoge</p>
  </section>
  <div class="space"></div>

  <div id="hoge" class="hoge2 hoge3"></div>

  <script>
      window.onload = function(){
      var fadein = document.getElementsByClassName("fadein");
      var list = fadein.classList;
      console.log(list);
      console.log(fadein);

      var hoge = document.getElementById("hoge");
      var hogelist = hoge.classList;
      console.log(hogelist);
      };
  </script>
  </body>
</html>