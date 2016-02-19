<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>我的书库</title>
	<link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
	require './vendor/autoload.php';
	require './public/config.php';

	$sqlite = sqlite::getInstance();
	$sqlite->connect('C:/Code/PHP/sqlite/book.sqlite3');
?>
<?php
if(@$_POST['isbn']) {
	$str = @file_get_contents('https://api.douban.com/v2/book/isbn/' . $_POST['isbn']);
	$arr = json_decode($str, true);
	if(!$arr) {
		die('isbn错误');
	}
	$info = [
		'title' => $arr['title'],
		'author' => $arr['author'][0],
		'image' => $arr['image'],
		'publisher' => $arr['publisher'],
		'isbn' => $arr['isbn13'],
		'alt' => $arr['alt'],
		'readtime' => date('Y-m-d H:i:s', time()),
		'comment' => ''
	];

	$res = $sqlite->table('books')->data($info)->save();
	
}

	$result = $sqlite->table('books')->findAll();
?>
<div class="container">
		<div class="col-md-12">
			<div class="form-group">
				<form action="" method="post">
					<div class="row">
						<div class="col-md-8">
							<label for="isbn">ISBN:</label>
							<input type="text" id="isbn" name="isbn" class="form-control">
						</div>
						<div class="col-md-4">
							<label for="">确认添加</label>
							<input type="submit" class="form-control btn btn-default" value="添加">
						</div>
					</div>
				</form>
			</div>
			<table class="table table-default">
				<tr>
					<th>书名</th>
					<th>作者</th>
					<th>链接</th>
					<th>出版社</th>
					<th>ISBN</th>
					<th>阅读时间</th>
				</tr>
				<?php foreach($result as $row) { ?>
				<tr>
					<td><?=$row['title']?></td>
					<td><?=$row['author']?></td>
					<td><a href="<?=$row['alt']?>">点击访问</a></td>
					<td><?=$row['publisher']?></td>
					<td><?=$row['isbn']?></td>
					<td><?=$row['readtime']?></td>
				</tr>
				<?php } ?>
			</table>
		</div>
</body>
</html>