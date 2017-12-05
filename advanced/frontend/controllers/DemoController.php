<?php

namespace frontend\controllers;
use yii;
use app\models\Filed;
use app\models\Username;

class DemoController extends \yii\web\Controller
{
	/** 展示注册 */
    public function actionAdd()
    {
    	$data = yii::$app->request->post();

    	if (!empty($data)) {

    		$res = Filed::find()->orderby(['id'=>'ace'])->asArray()->all();
    		foreach ($res as $k => $v) {
    			if ($v['is_choise'] == 1) {
    				if (empty($data[$v['title']])) {
    					echo "<script>alert('".$v['name']."没有设置');location.href=history.back()</script>";die;
    				}else{
    					if ($v['title'] == 'tel') {
    						$z_tel="/^1[358]\d{9}$/";
							if (preg_match($z_tel,$data['tel'])==0) {
								echo "<script>alert('".$v['name']."必须是13或15或18开头的11位数字');location.href=history.back()</script>";die;
							}
    					}
    					if ($v['title'] == 'pwd') {
    						$z_pwd="/^[\d]\w{".$v['begin'].",".$v['stop']."}$/i";
							if (preg_match($z_pwd,$data['pwd'])==0) {
								echo "<script>alert('".$v['name']."必须是".$v['begin']."到".$v['stop']."');location.href=history.back()</script>";die;
							}
    					}
    					if ($v['title'] == 'name') {
    						$z_name="/^[\x{4e00}-\x{9fa5}]{".$v['begin'].",".$v['stop']."}$/u";
							if (preg_match($z_name,$data['name'])==0) {
								echo "<script>alert('".$v['name']."必须是".$v['begin']."到".$v['stop']."');location.href=history.back()</script>";die;
							}
    					}
    				}
    			}
    		}

    		$user = new Username;
    		$user->name = $data['name'];
    		$user->pwd = $data['pwd'];
    		$user->tel = $data['tel'];
    		$user->content = $data['content'];
    		$res = $user->save();
    		if ($res) {
    			echo 3;die;
    		}
    	}else{

    		$data['data'] = Filed::find()->orderby(['id'=>'ace'])->asArray()->all();

        	return $this->render('add', $data);
    	}
    }

}
