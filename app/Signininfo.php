<?php
/**
 * Created by PhpStorm.
 * User: liuwenfu
 * Date: 2017/4/1
 * Time: 下午2:10
 */
namespace App;


use Illuminate\Support\Facades\DB;

class Signininfo
{

    /**
     * 获取上一次的签到数据
     * @param $userId
     * @return mixed
     */
    public function getLastTimeByUserId($userId)
    {
        return strtotime(DB::where('user_id', $userId)->orderBy('id', 'desc')->value('signin_time'));
    }

}