<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加日程</title>
	<script type="text/javascript" src="../../js/laydate.js"></script>
</head>
<body>
	<form action="adddo" method="post">
		<table>
			<tr>
				<td>提醒时间</td>
				<td><input placeholder="请输入日期" class="laydate-icon" name="time" onClick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"></td>
			</tr>
			<tr>
				<td>日程内容：</td>
				<td><textarea name="content" cols="30" rows="5"></textarea></td>
			</tr>
			<tr>
				<td>是否提醒</td>
				<td><input type="radio" name="type" value="1">是<input type="radio" name="type" value="0">否</td>
			</tr>
			<tr>
				<td><input type="submit" value="添加"></td>
				<td></td>
			</tr>
			<input type="hidden" name="user_id" value="<?=Cookie::get('name')?>">
		</table>
	</form>
</body>
</html>