<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
<script type="text/javascript" src="../../public/js/laydate.js"></script>
</head>
<body>
	欢迎<font color="red"><?=$user['name']?></font>
	<hr>
	<button id="sign">签到</button>&nbsp;<button id="repair">补签</button><br>
	<input class="laydate-icon" id="time" value="">

	<hr>
	<input type="hidden" id="lian" value="<?=isset($days) ? $days : 0 ;?>">
	已签到<span id="day"><?=isset($day) ? $day : 0 ;?></span>天 <br /><br /><br />
	获得<span id="maney"><?=isset($maney) ? $maney : 0 ;?></span>金币

	<input type="hidden" id="id" value="<?=$user['id']?>"><br><br><br>

	<div id="log">
		<?php if (isset($log)): ?>
				<li>
			<?php foreach ($log as $key => $v): ?>
					<ul><?=date('Y-m-d',$v['date_time']).'：'.$v['content'] ?></ul>
			<?php endforeach ?>
				</li>
		<?php endif ?>
	</div>
</body>

</html>



<script src="../../public/jquery.js"></script>
<script>
!function(){
laydate.skin('molv');//切换皮肤，请查看skins下面皮肤库
laydate({elem: '#time'});//绑定元素
}();
$(document).ready(function() {
	var date = new Date();
	var y = date.getFullYear()
	var m = date.getMonth()+1;
	var d = date.getDate()
	var time = y + '-' + m + '-' + d;
	$('#time').val(time);
});
	$('#sign').click(function() {

		var str = '<li>';
		var day = $('#day').text();
		var id = $('#id').val();
		var time = $('#time').val();
		var lian = $('#lian').val();
		$.ajax({
			url: "index.php?r=demo/add",
			type: 'get',
			dataType: 'json',
			data: {day:day, id:id, time:time},
			success:function(msg){
				if (msg == 10) {
					alert('不能超过当前时间');
					return
				}
				if (msg == 11) {
					alert('签过到了');
					return
				}
				if (msg == 12) {
					alert('代表不能从第一天前补签');
					return
				}
				if (msg == 13) {
					alert('没有点击补签');
					return
				}
				if (msg == 14) {
					alert('补签过倒');
					return
				}
				if (msg == 15) {
					alert('余额不足');
					return
				}
				$.each(msg, function(k, v) {
					var date1 = new Date(v['date_time']*1000);
					var y = date1.getFullYear();
					var m = date1.getMonth()+1;
					var d = date1.getDate()
					str += '<ul>' +y + '-' + m + '-' + d + v.content + '</ul>';
				});
				str += '</li>';
				$('#maney').text(msg[0].maney);
				$('#day').text(msg[0].day);
				$('#lian').text(msg[0].days);
				$('#log').html(str);
			}
		})
	});
	$('#repair').click(function() {
		var str = '<li>';
		var day = $('#day').text();
		var id = $('#id').val();
		var time = $('#time').val();
		var lian = $('#lian').val();
		$.ajax({
			url: "index.php?r=demo/add",
			type: 'get',
			dataType: 'json',
			data: {day:day, id:id, time:time ,repair:'repair'},
			success:function(msg){
				if (msg == 10) {
					alert('不能超过当前时间');
					return
				}
				if (msg == 11) {
					alert('签过到了');
					return
				}
				if (msg == 12) {
					alert('代表不能从第一天前补签');
					return
				}
				if (msg == 13) {
					alert('没有点击补签');
					return
				}
				if (msg == 14) {
					alert('补签过倒');
					return
				}
				if (msg == 15) {
					alert('余额不足');
					return
				}
				$.each(msg, function(k, v) {
					var date1 = new Date(v['date_time']*1000);
					var y = date1.getFullYear();
					var m = date1.getMonth()+1;
					var d = date1.getDate()
					str += '<ul>' +y + '-' + m + '-' + d + '：' + v.content + '</ul>';
				});
				str += '</li>';

				$('#maney').text(msg[0].maney);
				$('#day').text(msg[0].day);
				$('#lian').text(msg[0].days);
				$('#log').html(str);
			}
		})
	});
</script>