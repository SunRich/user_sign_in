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


}