<!DOCTYPE html>
<html lang="ja">
    <head>
      <meta charset="utf-8">
      <title>ハッピーウェザー</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- stylesheet.cssの読み込み -->
      <link rel="stylesheet" href="stylesheet1.css">
      <!-- <a href="radar.html">雨雲レーダー</a> -->
    </head>
    <body>
      <div class="media">
    <?php

    require('prefec.php');  
    $array = json_decode($json3, true);
  
    echo '<form action="gaikyoubun.php" method = "POST">';

    $prefecture = '';
     foreach ($array as $key => $value) {
        $prefecture .= '<option value="'.$value['code'].'">'.$value['name'].'</option>';
        
     }
     
    // echo "<select name='prefecture'>'.$prefecture.'</select>";
    echo "<select name='prefecture'>";
    ?>
     <option value="" disabled style="display:none;" <?php if(empty($_POST['prefecture'])) echo 'selected'; ?>>選択してください</option>
    <?php echo "'.$prefecture.'</select>";?>

    <option value= <?php $value['code']?>  <?php echo array_key_exists('prefcture', $_POST) && $_POST['prefecture'] == $value['code'] ? 'selected' : ''?>><?php $value['name'] ?></option>
    <?php
    echo "</select>";
    echo '<input type="submit"name="submit"value="送信"/>';
    echo '</form>';
    

    foreach ($array as $key => $value){

      if(isset($_POST["prefecture"]) && $value['code'] === $_POST["prefecture"]){
        $url4 = "https://www.jma.go.jp/bosai/forecast/data/overview_forecast/{$value['code']}.json";
  
        $json5 = file_get_contents($url4);
        $data3 = json_decode($json5,true);
  
        $reportDatetime = $data3['reportDatetime'];
        $reportDatetime = str_replace(':00+09:00', '', $reportDatetime);

        $headlineText = $data3['headlineText'];
        $text = $data3['text'];
  
        echo '発表日時　　：　'.$reportDatetime.'</br>';
        echo '天気概況　　：　'.$headlineText.'</br>'.$text.'</br>';
      }
    }
    ?>
    </div>
    <footer>
      <p>セレクトボックスで都道府県を選択してください。<br>★気象庁JSONデータを利用しています★</p>
    </footer>
    </body>
</html>