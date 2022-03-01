<?php
	// 'name'という名称のCookieがあることを確認する
	$boolean = isset($_COOKIE['name']);

	$r_name = 'Anonymous';
	if ($boolean) {
		$r_name = $_COOKIE['name'];
	}
?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>
			こんにちは 
		</title>
	</head>

	<body>
		<?php if($boolean): ?>
		<header>
			<h1> ようこそ </h1>
			<p>
				<?php echo $r_name; ?>さん
			</p>
		</header>

		<?php else: ?>
		<p>
			閲覧が許可されていません<br>
			<a href="">ログイン画面</a>に戻ってログインして下さい．
		</p>
		<?php endif; ?>

		<footer>
			<p>
				<small>
					&copy; Copyright 2020. Media Network, U.E.C., Tokyo, Japan
				</small>
			</p>
		</footer>
	</body>
</html>
