<?php
	// ユーザから受け取った内容(名前・投稿内容) および投稿時刻を変数に保存
	if ( 0 != strlen( $_POST["name"] ) ) {
		$r_name = htmlspecialchars($_POST["name"]);
	} else {
		$r_name = "no name";
	}
	date_default_timezone_set('Asia/Tokyo');
	$r_time = date("Y/m/j H:i:s"); // 指定書式で時刻情報を取得
	$r_content = htmlspecialchars($_POST["content"]);

	// log-fileを開く
	$fp = fopen("./log.csv", "a");
	flock($fp, LOCK_EX);

	// データをCSV形式にして，log-fileに書き込む
	$line = $r_name.",".$r_time.",".$r_content."\n";
	fputs($fp, $line);

	// log-fileを閉じる
	flock($fp, LOCK_UN);
	fclose($fp);
?>

<!DOCTYPE html>
<html lang=ja>
	<head>
		<meta charset="utf-8">
		<title> 投稿を受け付けました </title>
	</head>

	<body>
		<header>
			<h1> 投稿内容 <h1>
		</header>

		<hr>
		<?php
			// ログファイルの中身を出力する
			echo "<p>"
			echo "<b>名前: ".$r_name."</b> ";
			echo "投稿日時:<time>".$r_time."</time>";
			echo "<br>";
			echo $r_content;
			echo "</p>";
		?>
		<p>
			<a href="./view.php" target="_self">掲示板に戻る</a>
			<a href="./index.html" target="_self">トップに戻る</a>
		</p>

		<footer>
			<p>
				<small>
					&copy; Copyright 2020, Media Network, U.E.C., Tokyo, Japan.
				</small>
			</p>
		</footer>
	</body>
</html>

