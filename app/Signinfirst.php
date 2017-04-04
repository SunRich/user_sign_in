<?php
/**
 * Created by PhpStorm.
 * User: liuwenfu
 * Date: 2017/4/1
 * Time: 下午4:47
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Signinfirst extends Model
{
    protected $table='signin_firsr';

    public function tryGetFirstSignin($userId)
    {
        return $this::where('user_id', $userId)->value('first_time');
    }

    public function initSignFirst($userId, $firstTime)
    {
        return $this::insert([
            'user_id' => $userId,
            'first_time' => $firstTime
        ]);
    }

    public function updateSignFirst($userId, $firstTime)
    {
        $this::update('update signin_first set first_time= ? where user_id = ?',[$firstTime,$userId]);
    }
}