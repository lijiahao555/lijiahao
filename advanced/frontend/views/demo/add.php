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
	<?= Html::beginForm(['demo/add'], 'post') ?>
		<table width="500">
			<?php foreach ($data as $k => $v): ?>
				<tr>
					<td><?=$v['name'];?></td>
					<td><?= Html::{$v['type']}($v['title']); ?></td>
				</tr>
			<?php endforeach ?>
			<tr>
				<td colspan="2"><?= Html::submitButton('注册', ['class' => 'submit']) ?></td>
			</tr>
		</table>
	<?= Html::endForm() ?>
</body>
</html>