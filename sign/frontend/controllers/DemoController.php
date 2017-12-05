<?php

namespace frontend\controllers;
use yii;
use app\models\Login;
use yii\web\Session;
use app\models\Sign;
use app\models\Log;

class DemoController extends \yii\web\Controller
{

	/** 签到 */
    public function actionAdd()
    {

    	$data = yii::$app->request->get();
    	unset($data['r']);

    	if (empty($data)) {

    		//用户信息
    		$arr['user'] = Login::find()->where(['id'=>yii::$app->session['id']])->asArray()->one();
    		$sign = Sign::find()->where(['user_id'=>yii::$app->session['id']])->orderby('date_time DESC')->asArray()->all();
    		$log = Log::find()->where(['user_id'=>yii::$app->session['id']])->orderby('id DESC')->limit(5)->asArray()->all();
    		//签到信息
    		if (empty($sign)) {

      	  		return $this->render('add',$arr);

    		}else{

	    		$arr['maney'] = $sign[0]['maney'];
	    		$arr['day'] = $sign[0]['day'];
	    		$arr['days'] = $sign[0]['days'];

	    		$arr['log'] = $log;

      	  		return $this->render('add',$arr);
    		}


    	}else{

    		//签到补签

    		$res = $this->sign($data);

    		//签到或补签 成功 返回信息
    		if (is_int($res)) {
    			switch ($res) {
    				//不能超过当前时间
    				case 10:
    					echo 10;
    					break;

    				//签过到了
    				case 11:
    					echo 11;
    					break;

    				// 代表不能从第一天前补签
    				case 12:
    					echo 12;
    					break;

    				// 没有补签参数
    				case 13:
    					echo 13;
    					break;

    				// 补签过倒
    				case 14:
    					echo 14;
    					break;
    				//余额不足
    				case 15:
    					echo 15;
    					break;
    				//补签成功
    				case 5:
    					$info = $this->info($data);
		    			echo json_encode($info);
    					break;
    			}

    		}else{

    			//签到成功 搜索数据
    			$info = $this->info($data);

		    	echo json_encode($info);

    		}

    	}


    }

    /** 签到 补签 */
    public function sign($data){

		//签到信息
		$res = Sign::find()->where(['user_id'=>$data['id']])->orderby('date_time DESC')->asArray()->all();

    	$sign = new Sign;
    	$log = new Log;

    	//签到或补签 小于等于当前时间才能签到或补签
		// if (strtotime($data['time']) <= strtotime(date('Y-m-d'))) {


			if ($data['day'] == 0) {

    			$result = $this->qiandao($res,$sign,$data,$log);

	    	}else{

	    		// 当前天数 和 签到天数一致时 代表签倒  否则补签
	    		if (strtotime($data['time']) == strtotime(date('Y-m-d'))) {

	    			$result = $this->qiandao($res,$sign,$data,$log);

		    	}else{

		    		$result = $this->buqian($res,$sign,$data,$log);

		    	}

	    	}

		return $result;

    }

    /** 展示数据 */
    public function info($data){

    	//用户签到信息
    	$sign_info = Log::find()->where(['user_id'=>$data['id']])->orderby('days DESC')->asArray()->all();

    	//总条数
    	$num = isset($sign_info) ? count($sign_info) : 0 ;

    	//签到天数 等于总条数没有断签 不等于总条数补签没有补全
    	if (!empty($sign_info)) {
    		if (!isset($data['repair'])) {

	    		$info = Log::find()->where(['user_id'=>$data['id']])->orderby('date_time DESC')->limit(5)->asArray()->all();

	    	}else{

	    		$info = Log::find()->where(['user_id'=>$data['id']])->orderby('id DESC')->limit(5)->asArray()->all();

	    	}
    	}

    	return $info;

    }



    /** 签到 */
    public function qiandao($res,$sign,$data,$log){

    	//是否首签
    	if (!empty($res)) {
    		if (strtotime($data['time']) != $res[0]['date_time']) {
	    		// 判断是 签到 还是 连续签到
			    if ($data['day'] == 0) {

					// 不是首次签到
					$sign->maney = intval($res[0]['maney'])+1;

					$log->content = '签到'.intval($data['day']+1).'天,获得'.(intval($res[0]['maney'])+1).'金币';
					$log->maney = intval($res[0]['maney']+1);
				}else{
					//不是首签 或 断签

					//大于5天
					if ($data['day'] > 4) {

						// 连续签到60天 获得额外奖励
						if (($res[0]['day']+1) % 60 == 0) {

							$sign->maney = intval($res[0]['maney'])+5+100;

							$log->content = '签到'.intval($data['day']+1).'天,获得'.(intval($res[0]['maney']+5+100)).'金币';
							$log->maney = 5+100+intval($res[0]['maney']);

						}else{
							// 大于 5
							$sign->maney = intval($res[0]['maney'])+5;

							$log->content = '签到'.intval($data['day']+1).'天,获得'.(intval($res[0]['maney']+5)).'金币';
							$log->maney = 5+intval($res[0]['maney']);

						}

					}else{
						//小于5天

						$sign->maney = intval($data['day'])+intval($res[0]['maney'])+1;

						$log->content = '签到'.intval($data['day']+1).'天,获得'.(intval($data['day'])+intval($res[0]['maney']+1)).'金币';
						$log->maney = intval($data['day'])+intval($res[0]['maney'])+1;

					}
				}

				$sign->user_id = $data['id'];
				$sign->date_time = strtotime($data['time']);
				$sign->days = intval($res[0]['days'])+1;
				$sign->day = intval($data['day'])+1;

				$log->user_id = $data['id'];
				$log->date_time = strtotime($data['time']);
				$log->days = intval($res[0]['days'])+1;
				$log->day = intval($data['day'])+1;

				$sign_res = $sign->save();

				if ($sign_res) {
					return $log->save();
				}

	    	}else{
	    		//签过到
	    		return 11;
	    	}

    	}else{
	    		//首次签到
				$sign->user_id = $data['id'];
				$sign->date_time = strtotime($data['time']);
				$sign->days = 1;
				$sign->day = 1;
				$sign->maney = 1;

				$sign_res = $sign->save();

				if ($sign_res) {
					$log->user_id = $data['id'];
					$log->content = '签到1天,获得1金币';
					$log->date_time = strtotime($data['time']);
					$log->days = 1;
					$log->day = 1;
					$log->maney = 1;
					return $log->save();
				}
    	}

    }

    /** 补签 */
    public function buqian($res,$sign,$data,$log){

    	// 如果参数设置代表补签  没有设置代表签过到
		if (isset($data['repair'])) {

			if (!empty($res)) {

				//补签日期
				$repair_time = strtotime($data['time']);


				//补签天数的 上一天信息
				$prev_time = $repair_time-(60*60*24);
				$nxet_time = $repair_time+(60*60*24);
				// 10天前的
				$prev_time10 = $repair_time-(60*60*24*10);

				$prev_repair_info = Sign::find()->where(['date_time'=>$prev_time])->asArray()->one();

				//所有签到天数
				$length = count($res);


				// 如果补签时间大于第一天签到时间 在10天之内 则补签
				if ($repair_time > $res[$length-1]['date_time'] && $repair_time > $prev_time10 && $repair_time < $nxet_time ) {

					//补签信息
					$repair_info = Sign::find()->where(['date_time'=>$repair_time])->asArray()->one();

					//是否补签过
					if (empty($repair_info) ) {

						//判断余额是否能补签
						if ($res[0]['maney'] > 100 ) {

							//修改金币
							$result = Sign::find()->where(['id'=>$res[0]['id']])->one();


							//补签后所拥有的金币
							$jin = $prev_repair_info['day'] > 4 ? 5 : $prev_repair_info['day'];
							$jinbi = intval($result->maney-100+$jin);

							//补签的金币
							$bu_jinbi = $prev_repair_info['day'] > 4 ? $prev_repair_info['maney']+5 : $prev_repair_info['maney']+$prev_repair_info['day'];

							$result->maney = intval($jinbi);
							$res2 = $result->save();

							// 补签
							$sign->user_id = $data['id'];
							$sign->date_time = $repair_time;
							$sign->days = intval($prev_repair_info['days'])+1;
							$sign->day = intval($prev_repair_info['day'])+1;
							$sign->maney = $bu_jinbi;

							$res = $sign->save();

							if ($res && $res2) {
								// 日志
								$log->user_id = $data['id'];
								$log->content = '补签1天,减去100金币,共获得'.intval($jinbi).'金币';
								$log->date_time = strtotime($data['time']);
								$log->days = intval($prev_repair_info['days'])+1;
								$log->day = intval($prev_repair_info['day'])+1;
								$log->maney = $jinbi;
								if ($log->save()) {
									return 5;
								}
							}

						}else{

							//余额不足
							return 15;

						}

					}else{

						//补签过到
						return 14;

					}

				}else{

					// 代表不能从第一天前补签
					return 12;
				}

			}

		}else{

			//没有补签参数
			return 13;

		}
    }

	/** 登录 */
	public function actionLogin()
    {
    	$data = yii::$app->request->post();

    	if (empty($data)) {

        	return $this->render('login');

    	}else{

    		$data = Login::find()->where(['name'=>$data['name'],'pwd'=>$data['pwd']])->asArray()->one();

    		if (is_array($data)) {

    			yii::$app->session['id'] = $data['id'];

    			return $this->redirect(['demo/add']);

    		}else{

    			echo "<script>alert('账号或密码不对');location.href=history.back()</script>";die;

    		}

    	}
    }

}
