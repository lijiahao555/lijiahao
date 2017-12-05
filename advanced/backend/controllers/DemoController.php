<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\helpers\Url;
use app\models\Filed;

class DemoController extends Controller
{
    /** 添加 */
    public function actionAdd()
    {
    	$id = yii::$app->request->get('id');
    	if (isset($id)) {
    		$data = Filed::find()->where(['id'=>$id])->asArray()->one();

    		return $this->render('add',['data'=>$data]);
    	}else{
    		return $this->render('add');
    	}
    }

    /** 添加处理 */
    public function actionAdddo()
    {

      	// User::find()->where(['uid'=>'1'])->getField('username'); // 返回 a获取字段
      	// User::getlastsql(); 和 User::getError(); // 返回最后操作的SQL语句，主要是便于调试

        //接值
        $data = Yii::$app->request->post();

        //是修改还是添加
        if (isset($data['id'])) {
            $filed = Filed::find()->where(['id'=>$data['id']])->one();
        }else{
            $filed= new Filed;
        }

        //设置值
        $filed->name = $data['name'];
        $filed->title = $data['title'];
        $filed->type = $data['type'];
        $filed->is_choise = $data['is_choise'];
        $filed->rule = $data['rule'];
        $filed->begin = $data['begin'];
        $filed->stop = $data['stop'];

        //执行
        $res = $filed->save();

       	if ($res) {
       		 return $this->redirect(['demo/show']);
       	}
    }

    /** 展示 */
    public function actionShow()
    {

       	$data['data'] = Filed::find()->orderby(['id'=>'desc'])->asArray()->all();
        return $this->render('show',$data);
    }

    /** 删除 */
    public function actionDel(){
    	$id = yii::$app->request->get('id');
       	$res = Filed::find()->where(['id'=>$id])->one();
       	$res = $res->delete();
       	if ($res) {
       		return $this->redirect(['demo/show']);
       	}
    }

    /** 修改 */
    public function actionUp(){
    	$id = yii::$app->request->get('id');
       	return $this->redirect(['demo/add','id'=>$id]);
    }
}
