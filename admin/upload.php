<?php
var_dump($_FILES);
var_dump($_POST);
if($_FILES['userfile']['tmp_name'] != ''){
	$uploaddir = '/var/www/vhosts/model.tiary.jp/httpdocs/pjpic';
	$basename = basename($_FILES['userfile']['tmp_name']);
	$fileext = strrchr($_FILES['userfile']['name'], '.');
	$filename = $basename . $fileext;
	$uploadfile = $uploaddir . "/" . $filename;
	$is_uploaded = move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
}
?>
<!DOCTYPE html>
<html>
	<head>
		<body>
			<form action="" method="post"  enctype="multipart/form-data">
				<table>
					<tr>
						<td><input type="file" name="userfile" /></td>

					</tr>
					<tr>
						<td><input type="submit" value="確認" name="submit_btn"/></td>
					</tr>
				</table>
			</form>
		</body>
	</head>
</html>