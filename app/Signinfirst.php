<?php
/**
 * Created by PhpStorm.
 * User: liuwenfu
 * Date: 2017/4/1
 * Time: 下午4:47
 */
namespace App;


use Illuminate\Support\Facades\DB;

class Signinfirst
{

    public function tryGetFirstSignin($userId)
    {
        $firstTime = DB::where('user_id', '=', $userId)->value('first_time');
    }
}