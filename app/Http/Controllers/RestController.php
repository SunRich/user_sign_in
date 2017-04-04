<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/3 0003
 * Time: 23:13
 */
namespace App\Http\Controllers;

class RestController extends Controller
{
    public function restInit()
    {
        return [
            'code'=>404,
            'message'=>'error'
        ];
    }
}