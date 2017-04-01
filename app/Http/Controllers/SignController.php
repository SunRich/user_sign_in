<?php
/**
 * Created by PhpStorm.
 * User: liuwenfu
 * Date: 2017/3/31
 * Time: 下午5:23
 */
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Signininfo;

class SignController extends Controller
{

    public function index()
    {
        $info = Signininfo::where([
            ['signin_time', '>', date('Y-m-d', time())]
        ])->toSql();
        dd($info);
    }

    public function signin(Request $request)
    {
        $userId = $request->input('userId', 0);
        if ($userId > 0) {
            $Signininfo = new Signininfo();
            $lastTime = $Signininfo->getLastTimeByUserId($userId);
            $this->trySignin($userId, $lastTime);
        } else {

        }
    }

    private function trySignin($userId, $lastTime)
    {
        //可以签到
        if (strtotime(date('Y-m-d', time())) > $lastTime) {
            //判断连续签到了多少天

        }
    }
}