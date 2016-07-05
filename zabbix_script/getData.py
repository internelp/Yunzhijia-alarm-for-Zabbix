#!/usr/bin/python
# -*- coding: utf8 -*-
# ====================================
# 创建：枫叶
# 支持：千思网（http://www.qiansw.com）
# Create Date：2015-04-07
# Last Change：2015-04-07
# Ver：1.0
# 处理ZABBIX发送过来的报警，将报警插入到消息队列。
# 需要先安装 MySQL-python
# ====================================

import json,sys,time
reload(sys)
sys.setdefaultencoding('utf8')

def sql(sql):
    import MySQLdb
    # =====================================数据库配置开始==========================
    host = "localhost"
    port = "3306"
    dbname = "dbname"
    user = "dbuser"
    passwd = "qiansw.com"
    # 数据库配置结束
    db = MySQLdb.connect(host,user,passwd,dbname,charset="utf8")
    cursor = db.cursor()
    try:
        cursor.execute(sql)
        db.commit()
    except Exception, e:
        print "数据库连接出现错误："
        raise e
    finally:
        db.close
try:
    CONF = json.loads(sys.argv[3])
except Exception, e:
    print "获取命令行参数失败。"


msg = CONF["msg"]
host = CONF["host"]
level = CONF["level"]
msg_type = CONF["msg_type"]
cfrom = CONF["from"]
to = CONF["to"]

sqlcmd = 'INSERT INTO `alarm_yzj`.`alarm` (`from`, `from_server`, `create_time`, `to`, `level`, `msg`, `msg_type`) VALUES (\"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\", \"%s\")' % (cfrom,host,long(time.time()),to,level,msg,msg_type)
sql(sqlcmd)
