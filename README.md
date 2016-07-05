# Yunzhijia-alarm-for-Zabbix
一个通过云之家（金蝶企业IM）发送ZABBIX报警消息的程序。


##	数据库创建
- database.sql
	数据库名称请修改这个文件，也可以直接复制内容放到GUI程序中执行。

##	从ZABBIX获取数据放到数据库
-	zabbix_script/getData.py
处理ZABBIX发送过来的报警，将报警插入到消息队列。
需要先安装 MySQL-python

##	从数据库读取数据，发送到指定的公众号
-	config.json 	配置公众号信息（key、token等）
-	init.py 		配置crontab定时执行，读取数据库数据发送给web（下面介绍）

##	Web，需要使用nginx+php
php编写，用于接收init.py Post过来的信息，并推送给到云之家。


目前是所有人都推送，并未指定单个人，若需此功能需要再次开发。
使用方式详见：http://www.qiansw.com/zabbix-to-yunzhijia.html