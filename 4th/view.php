<!DOCTYPE html>
<html lang=ja>
	<head>
		<meta charset="utf-8">
		<title> 掲示板 </title>
	</head>

	<body>
		<header>
		</header>

		<hr>
		<p>
			<b> 投稿フォーム </b>
			<form method="POST" action="./post.php">
				名前：<input type="text" name="name"><br>
				投稿内容：<br>
				<textarea name="content" rows="4" cols="40"></textarea><br>
				<input type="submit" value="投稿">
			</form>
		</p>
		<hr>

		<?php
			$logfile = "./log.csv";
			if ( is_file($logfile) ) { // log-fileが存在するか確認
				if ( is_readable($logfile) ) { // log-fileが読み取り可能か確認
					// log-fileを開く
					$fp = fopen($logfile, "r");
					flock($fp, LOCK_SH); // ファイルを読み取りロックする
					$dataCounter=0;

					// ログファイルからデータを読み取り，出力する
					while ( !feof($fp) ) {
						// 一行づつデータを読みこみ，CSVデータを個別データに分ける
						$line = fgets($fp);
						$content = explode(",", $line);
						// データの確認 (エラー防止用)
						if ( 3 == count($content) ) { // 1行のデータには3つのデータがある
							echo "<p>".$count;
							echo "：<strong>名前: $content[0]</strong> ";
							echo "投稿日時:<time>$content[1]</time><br>$content[2]</p>";
							echo "<hr>";
							$dataCounter++;
						}
					}

					// ロックを解除して，log-fileを閉じる
					flock($fp, LOCK_UN);
					fclose($fp);
				} else {
					echo "ファイルが開けません";
				}
			} else {
				echo "誰も投稿していません";
			}
		?>

	</body>
</html>
