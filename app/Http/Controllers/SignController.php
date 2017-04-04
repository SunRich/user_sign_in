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

    public function index($userId, $startTime, $endTime)
    {
        $return = $this->restInit();
        $times = Signininfo::where('user_id', $userId)
            ->whereBetween('time', [$startTime, $endTime])
            ->pluck('time');
        if ($times->isEmpty()) {
            $return['message'] = 'empty signin';
        } else {
            $return = [
                'code' => 200,
                'result' => $times->toArray()
            ];
        }
        return response()->json($return);
    }

    public function signin(Request $request)
    {
        $userId = $request->input('userId', 0);
        $return = $this->restInit();
        if ($userId > 0) {
            $nowtime = date('Y-m-d h:i:s', time());
            $signDays = $this->trySignin($userId, $nowtime);
            if ($signDays > 0) {
                $return = [
                    'code' => 200,
                    'result' => $signDays
                ];
            }
        } else {
            $return['message'] = 'not login';
        }
        return response()->json($return);
    }

    private function trySignin($userId, $nowtime)
    {
        $Signininfo = new Signininfo();
        $lastTime = $Signininfo->getLastTimeByUserId($userId);
        $Signinfirst = new Signinfirst();

        if ($lastTime) {
            if (strtotime(date('Y-m-d', time())) > strtotime($lastTime)) {
                //可以签到判断连续签到了多少天
                $firstTime = $Signinfirst->tryGetFirstSignin($userId);
                if ($firstTime) {
                    $signDays = $this->getSignDays($firstTime, $lastTime, $nowtime);
                } else {
                    $signDays = 1;
                    //首次签到，插入数据
                    $Signinfirst->initSignFirst($userId, $nowtime);
                }
            } else {
                return 0;
            }
        } else {
            $signDays = 1;
            //首次签到，插入数据
            $Signinfirst->initSignFirst($userId, $nowtime);
        }
        $this->saveData($userId, $signDays, $nowtime);
        return $signDays;
    }

    private function getSignDays($firstTime, $lastTime, $nowtime)
    {
        $signDays = 1;
        //检查是否连续签到
        if ($this->getDiffDayNums($lastTime, $nowtime) == 1) {
            $signDays = $this->getDiffDayNums($firstTime, $nowtime) + 1;
        }
        return $signDays;
    }

    private function saveData($userId, $signdays, $nowtime)
    {
        //如果没有连续签到，更新首次签到时间
        if ($signdays == 1) {
            $Signinfirst = new Signinfirst();
            $Signinfirst->updateSignFirst($userId, $nowtime);
        }
        $Signininfo = new Signininfo();
        return $Signininfo->addOneSignin($userId, $nowtime);
    }

    private function getDiffDayNums($a, $b)
    {
        $aTimestamp = strtotime(date('Y-m-d', strtotime($a)));
        $bTimestamp = strtotime(date('Y-m-d', strtotime($b)));
        return ($bTimestamp - $aTimestamp) / 86400;
    }
}