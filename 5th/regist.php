<?php
	$id = htmlspecialchars($_POST["id"]);
	$pw = htmlspecialchars($_POST["pw"]);
	$filename = "./list.csv"; // ユーザ情報を保存するファイル

	// 送られてきたデータの内容確認
	if (0 == strcmp($id, "") || 0 == strlen($pw, "")) {
		exit("Error: User IDまたはPasswordが空欄です");
	}

	// ファイルが存在しなければ，空のファイルを作成する
	if ( !file_exist($filename) ) {
		touch($filename);
	}

	$fp = fopen($filename, "r+");
	flock($fp, LOCK_EX);
	$flag = false;

	// 登録済みユーザかどうかを確認する
	while ( $line = fgetcsv($fp) ) {
		if (0 == strcmp($line[0], $id)) {
			$flag = true;
			break;
		}
	}
	if ($flag) {
		exit("既に登録されているUser IDです．");
	} else {
		fputcsv($fp, Array($id, hash("sha256", $pw)));
	}

	flock($fp, LOCK_UN);
	fclose($fp);
?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title> ユーザ登録完了 </title>
	</head>

	<body>
		<header>
			<h1> 登録が完了しました </h1>
		</header>

		ユーザ名　：<?php echo $id ?>
		パスワード：<?php echo $pw ?>
		<a href="./regist.html" target="_self">登録画面に戻る</a>

		<footer>
			<p><small>
				&copy; Copyright 2020., Media Network, U.E.C., Tokyo, Japan.
			</small></p>
		</footer>
	</body>
</html>
