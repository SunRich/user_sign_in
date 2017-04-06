<?php
/**
 * Created by PhpStorm.
 * User: liuwenfu
 * Date: 2017/4/1
 * Time: 下午2:10
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Signininfo extends Model
{
    protected $table='signin_info';

    public $timestamps = false;

    /**
     * 获取上一次的签到数据
     * @param $userId
     * @return mixed
     */
    public function getLastTimeByUserId($userId)
    {
        return $this::where('user_id', $userId)->orderBy('id', 'desc')->value('time');
    }


    public function addOneSignin($userId,$time)
    {
        return $this::insert([
            'user_id' => $userId,
            'time' => $time
        ]);
    }

    public function trySignin($userId, $nowtime)
    {
        $lastTime = $this->getLastTimeByUserId($userId);
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
        return $this->addOneSignin($userId, $nowtime);
    }

    private function getDiffDayNums($a, $b)
    {
        $aTimestamp = strtotime(date('Y-m-d', strtotime($a)));
        $bTimestamp = strtotime(date('Y-m-d', strtotime($b)));
        return ($bTimestamp - $aTimestamp) / 86400;
    }


}