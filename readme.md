---
layout: README
title: 签到服务
date: 2017-04-01
modifiedOn: 2017-04-01
---
## 开发环境
1. 开启服务
```
php -S localhost:3000 -t public
```
2. 复制.env.example到.env并修改其中的数据库配置。

3. 数据初始化
```
php artisan migrate
```
4. 单元测试
```
phpunit
```

## docker部署

## 服务功能
### 1)用户签到
  - 请求 `post $host/v1/signins/`
  - 参数
    1. userId(int):用户编号
  - 请求示例:`curl -H "Content-Type: application/json" --data '{"userId": "1"}' $host/v1/signins/`
  - 响应:
   1. 成功响应
     ```
     {
     "code": 200,
     "result": 1
     }
     ```
   2. 失败响应
     ```
     {
     "code": 404,
     "message": "error"
     }
     ```

### 2)获取一个用户签到详情
  - 请求 `get $host/v1/users/`
  - 参数
    1. userId(int):用户编号
    2. startTime(string):开始时间
    3. endTime(string):结束时间
  - 请求示例:`get $host/v1/users/1/startTime/2017-04-01/endTime/2017-04-10`
  - 响应:
    ```
    {
      "code": 200,
      "result": [
        "2017-04-09 12:10:23"
      ]
    }
    ```
