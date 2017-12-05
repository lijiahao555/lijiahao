<?php
namespace App\Http\Controllers;


use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

use Response,Cookie,Redirect,Sensitive;


class DemoController extends Controller
{
  	/** 处理登录 */
    public function loginDo(){

    	$data = Input::get();

    	$res = DB::select('select * from user where name = "'.$data['name'].'" and password = "'.$data['password'].'"');

    	if (!empty($res)) {
    		Cookie::queue('name', $res[0]->id);
    		return Redirect::to('add');
    	}

	   // <input type="hidden" name="_token" value="{{ csrf_token() }}"> 视图验证
    }

    /** 处理添加日程 */
    public function addDo(){
    	$data = Input::get();
    	$data['time'] = strtotime($data['time']);
    	$data['add_time'] = time();

    	$res = DB::table('richeng')->insertGetId(['content'=>$data['content'],'add_time'=>$data['add_time'],'ti_time'=>$data['time'],'user_id'=>$data['user_id'],'type'=>$data['type']]);


    	if ($res) {
            if ($data['type'] == 1) {
                Redis::lpush('plan',serialize($data));
                return Redirect::to('show');
            }else{
                return Redirect::to('show');
            }
    	}
    }

    /** 计划任务 */
    // */1 * * * * curl http://47.95.198.52/laravel/public/index.php/time
    public function time(){
        //长度
        $len = Redis::llen('plan');
        if ($len > 0) {
           for ($i=0; $i < $len ; $i++) {
                $data = unserialize(Redis::rpop('plan'));
                $res = DB::table('plan')->insertGetId(['content'=>$data['content'],'add_time'=>$data['add_time'],'ti_time'=>$data['time'],'user_id'=>$data['user_id']]);
            }
        }
    }

}
