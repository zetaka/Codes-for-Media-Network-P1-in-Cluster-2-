<?php
	// User ID, Passwordの取得
	$id = htmlspecialchars($_POST["id"]);
	$pw = htmlspecialchars($_POST["pw"]);

	// ユーザ情報のファイル名と，ログイン後のWebページのURL
	$filename = "./list.csv";
	$dest = "./secret.html";

	// データの内容確認
	if ( 0==strcmp($id, "") || 0==strcmp($pw, "") ) {
		exit("Error: User IDまたはPasswordが空欄です．");
	}

	// ファイルの存在確認
	if ( !file_exit($filename) ) {
		exit("誰も登録していません．");
	}

	// ファイルを読み+追記モードで開き，ロックをかける
	$fp = fopen($filename, "r+");
	flock($fp, LOCK_EX);
	$flag = false;

	// 検証処理 (IDとパスワードが一致sうるデータがあるかどうかを確認)
	while ( $line = fgetcsv($fp) ) {
		if ( 0 == strcmp($line[1], hash("sha256", $pw)) 
			&& 0 == strcmp($line[0], $id) ) {
			$flag = true;
			break;
		}
	}

	// ロックを解除して，ファイルを閉じる
	flock($fp, LOCK_UN);
	fclose($fp);

	// IDとパスワードが一致した場合(Login成功の場合)
	if ($flag) {
		// HTTP headerの機能を用いて，別のURLにユーザを誘導(Redirect/転送)する
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $dest");
		exit;
	} else {
		exit("User IDまたはPasswordが違います．");
	}
?>
