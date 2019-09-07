<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>サンプル</title>
<script>
function test(){
  var obj = document.getElementById("dv1");

  //要素に設定されているclassの一覧を取得する
  var list = obj.classList;
  console.log(list);

  //要素にclass="hoge"を追加する
  obj.classList.add("hoge");
  console.log(obj.classList);

  //要素からclass="cs2"を削除する
  obj.classList.remove("cs2");
  console.log(obj.classList);

  //要素にclass="cs3"が含まれているか判定する
  var result = obj.classList.contains("cs3");
  console.log(result);

  //要素にclass="cs3"が含まれていれば削除、含まれなければ追加する
  obj.classList.toggle("cs3");
  console.log(result.classList);
}
</script>
</head>
<body>
  <div id="dv1" class="cs1 cs2 cs3">aa</div>
  <input type="button" value="ボタン" onclick="test();">
</body>
</html>