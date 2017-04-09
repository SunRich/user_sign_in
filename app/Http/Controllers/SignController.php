<?php
/**
 * Created by PhpStorm.
 * User: liuwenfu
 * Date: 2017/3/31
 * Time: 下午5:23
 */
namespace App\Http\Controllers;

use App\Signinfirst;
use Illuminate\Http\Request;
use App\Signininfo;

class SignController extends RestController
{

    /**
     * 获取签到数据
     * @param $userId
     * @param $startTime
     * @param $endTime
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($userId, $startTime, $endTime)
    {
        $return = $this->restInit();
        $times = Signininfo::where('user_id', $userId)
            ->whereBetween('time', [$startTime, $endTime])
            ->pluck('time');
        if ($times->isEmpty()) {
            $return['message'] = 'empty signindara';
        } else {
            $return = [
                'code' => 200,
                'result' => $times->toArray()
            ];
        }
        return response()->json($return);
    }

    /**
     * 签到
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request)
    {
        $userId = $request->input('userId', 0);
        $return = $this->restInit();
        if ($userId > 0) {
            $nowtime = date('Y-m-d h:i:s', time());
            $Signininfo = new Signininfo();
            $signDays = $Signininfo->trySignin($userId, $nowtime);
            if ($signDays > 0) {
                $return = [
                    'code' => 200,
                    'result' => $signDays
                ];
            }
        } else {
            $return['message'] = 'userId intval';
        }
        return response()->json($return);
    }


}
