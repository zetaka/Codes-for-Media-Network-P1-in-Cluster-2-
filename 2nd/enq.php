<?php
	// 入力データの書き込み
	if ( 0 != strlen($_POST["name"]) ) {
		// 入力された情報を変数に格納(代入)
		$name = $_POST["name"];
		$prog = $_POST["prog"];
		$menu = $_POST["menu"];

		// ファイルへの書き込み
		$fp = fopen("./enq_result.csv", "a+");

		// ファイルの書き込みロック
		flock($fp, LOCK_EX);
		// 出力データの生成
		$output = join(",", array($name, $prog, $menu))."\n";
		fputs($fp, $output);
		// ファイルの書き込みロックを解除
		flock($fp, LOCK_UN);

		fclose($fp);
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>
			アンケート受付完了
		</title>
	</head>

	<body>
		<?php if (strlen($_POST["name"]) > 0): ?>
			<header>
				<h1> Thank you for your answer: </h1>
				回答内容は以下の通りです．
			</header>
			<p>
				氏名：        <?php echo $name ?> <br>
				プログラム名：<?php echo $prog ?> <br>
				メニュー名：  <?php echo $menu ?>
			</p>
			<p>
				⚠️ 注意：<br>
				プログラム名：
				md(メディア情報学), ke(経営情報学), sc(セキュリティ情報学), et(その他)
				メニュー名：
				co(チキンおろしだれ), cm(クリームチーズメンチカツ), kc(カツカレー)
			</p>
		<?php else: ?>
			<header>
				<h1> Error: </h1>
			</header>
			<p>
				入力データに不備があるようです．
				<br>
				アンケート入力画面に戻り，再入力をお願いします．
			</p>
		<?php endif; ?>

		<footer>
			<p><small>
				&copy; Copyright 2020, Media network, Cluster 2, U.E.C., Tokyo
			</small></p>
		</footer>

	</body>
</html>
