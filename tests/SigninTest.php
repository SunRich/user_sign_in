<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: liuwenfu
 * Date: 2017/4/6
 * Time: 下午1:38
 */
class SigninTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 测试签到天数
     */
    public function testSignDays()
    {
        $Signinfo = new \App\Signininfo();
        $days = $Signinfo->trySignin(30, '2017-04-01');
        $this->assertEquals(1, $days);
        $days = $Signinfo->trySignin(30, '2017-04-02');
        $this->assertEquals(2, $days);//连续签到2天
        $days = $Signinfo->trySignin(30, '2017-04-03');
        $this->assertEquals(3, $days);//连续签到3天
        $days = $Signinfo->trySignin(30, '2017-04-05');
        $this->assertEquals(1, $days);//间断
        $this->get('/v1/users/30/startTime/2017-04-01/endTime/2017-04-07')
            ->seeJson([
                'result' => [
                    '2017-04-01 00:00:00',
                    '2017-04-02 00:00:00',
                    '2017-04-03 00:00:00',
                    '2017-04-05 00:00:00',
                ]
            ]);
    }

    /**
     * 签到基本功能(签到完不能再次签到)
     */
    public function testSigninAgain()
    {
        $this->post('/v1/signins', ['userId' => '30'])
            ->seeJsonEquals([
                'code' => 200,
                'result' => 1
            ]);
        $this->post('/v1/signins', ['userId' => '30'])
            ->seeJsonEquals([
                'code' => 404,
                'message' => 'error'
            ]);
    }
}