<?php
	// 入力データの読み込み
	if ( is_readable("./result.csv") && $fp = fopen("./result.csv", "r") ) ) {

		// ファイルの読み込みロック
		flock($fp, LOCK_SH);

		// 集計用変数の初期化
		$cnt["ct"] = 0;
		$cnt["co"] = 0;
		$cnt["kc"] = 0;

		while ( $csvline = fgets($fp) ) {
			$data = explode(",", trim($csvline, "\n"));
			if (3 == count($data)) {
				$menu = (string)$data[2];
				if (isset($cnt[$menu])) { $cnt[$menu]++; }
			}
		}
		// ファイルの読み込みロックを解除
		flock($fp, LOCK_UN);

		fclose($fp);
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>
			アンケート結果
		</title>
	</head>

	<body>
		<?php if (is_readable("./result.csv")): // データファイルが読み込み可能か判断 ?>
			<header>
				<h1> みんなの好きなメニュー: </h1>
				現時点でのアンケート結果です．
			</header>
			<p>
				商品名，得票数 <br>
				チキンおろしだれ：
					<?php echo $cnt["co"] ?> <br>
				クリームチーズメンチカツ：
					<?php echo $cnt["cm"] ?> <br>
				カツカレー：
					<?php echo $cnt["kc"] ?> <br>
			</p>
			<p>
				<a href="./form.html" target="_self">アンケートに戻る</a>
			</p>

		<?php else: ?>
			<header>
				<h1> Error: </h1>
			</header>
			<p>
				アンケートデータが記録されたCSVファイルがありません．
				<br>
				前回講義の演習が終了しているか確認して下さい．
			</p>

		<?php endif; ?>

		<footer>
			<p><small>
				&copy; Copyright 2020, Media network, Cluster 2, U.E.C., Tokyo
			</small></p>
		</footer>

	</body>
</html>
