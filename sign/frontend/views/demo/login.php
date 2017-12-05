<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<?=html::beginForm(['demo/login'],'post');?>
	<table>
		<tr>
			<td>姓名</td>
			<td><input type="text" name="name"></td>
		</tr>
		<tr>
			<td>密码</td>
			<td><input type="text" name="pwd"></td>
		</tr>
		<tr>
			<td colspan="2"><?= Html::submitButton('Submit', ['class' => 'submit']) ?></td>
		</tr>
	</table>
<?=html::endForm();?>
</body>
</html>