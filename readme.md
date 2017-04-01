---
layout: README
title: 签到服务
date: 2017-04-01
modifiedOn: 2017-04-01
---
## 开发环境
1. 开启服务
```shell
php -S localhost:3000 -t public
```
2. 复制.env.example到.env并修改其中的数据库配置。

3. 数据初始化
```shell
php artisan migrate
```

## docker部署

## 服务功能
- 用户签到
- 获取一个用户签到详情
