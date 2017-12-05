<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\url;
?>
<meta charset="utf8">

<style>
table{ border-collapse: collapse; border: 1px solid #ddd; width: 800px; margin: 0 auto;margin-top: 50px; background: rgba(121, 217, 221, 0.4); color: #666}
table tr{ height: 40px;}
table td{ border: 1px solid #ddd; text-align: center}

*{margin: 0; padding:0 ; font-family: 微软雅黑}
a{ text-decoration: none; color: #666;}

.top{ width: 100%; background: rgba(14, 196, 210, 0.99); color: #fff; height: 100px; line-height: 150px; text-align: right;}
.top span{ margin-right: 20px}


.left{ width: 260px; float: left; height: 400px; background: rgba(121, 217, 221, 0.4)}
.left ul{ list-style: none; width: 100%;}
.left ul li{ height: 40px; width: 100%; border: 1px solid #ddd; line-height: 40px; text-align: center;}
.left .selected{ background: rgba(14, 196, 210, 0.99);}
.left .selected a{ color: #fff;}


.right{ float: left; width: 800px;}
.title{ background: rgba(14, 196, 210, 0.99); color: #fff}
.search-box{ width: 900px; margin: 0 auto; margin-top: 100px; }
</style>

<div class="top">
    <span>欢迎管理员：admin</span>
</div>

<div class="left">
    <ul>
        <li><a href="<?=Url::toRoute(['demo/show'])?>">查看注册字段</a></li>
        <li><a href="<?=Url::toRoute(['demo/add'])?>">添加注册字段</a></li>
    </ul>
</div>

<div class="right">
    <div class="search-box">
        <table>
            <tr class="title">
                <td>ID</td>
                <td>字段名</td>
                <td>字段类型</td>
                <td>字段默认值</td>
                <td>是否必填</td>
                <td>验证规则</td>
                <td>字符数限制</td>
                <td>操作</td>
            </tr>
            <?php foreach ($data as $key => $v): ?>
                <tr>
                    <td><?=$v['id'] ?></td>
                    <td><?=$v['name'] ?></td>
                    <td><?php switch ($v['type']) {
                        case 'text':
                            echo '文本框';
                            break;
                        case 'radio':
                            echo '单选框';
                            break;
                        case 'password':
                            echo '密码框';
                            break;
                        case 'textarea':
                            echo '文本域';
                            break;
                    } ?></td>
                    <td><?=$v['title'] ?></td>
                    <td><?=$v['is_choise'] ? "是" : "否" ?></td>
                    <td><?php switch ($v['rule']) {
                        case 'phone':
                            echo '手机';
                            break;
                        case '0':
                            echo '无';
                            break;
                        case 'length':
                            echo '长度';
                            break;
                    } ?></td>
                    <td><?=$v['begin'] ? $v['begin'].'-'.$v['stop'] : '无';?></td>
                    <td><a href="<?=Url::toRoute(['demo/del','id'=>$v['id']]);?>">删除</a>&nbsp;|&nbsp;<a href="<?=Url::toRoute(['demo/up','id'=>$v['id']]);?>">修改</a></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>