#!/usr/bin/python
# -*- coding: utf8 -*-
# ====================================
# 创建：枫叶
# 支持：千思网（http://www.qiansw.com）
# Create Date：2015-04-02
# Last Change：2015-08-03
# Ver：1.0
# 处理报警消息队列，将报警消息post到消息api。
# 需要先安装 MySQL-python
# ====================================

import json,sys
import MySQLdb

reload(sys)  
sys.setdefaultencoding('utf8')   

# 载入配置 CONF
try:
    f=open(sys.path[0] + '/config.json',"r")
    CONF = json.load(f)
except Exception, e:
    print "配置文件有错误，请检查。"
else:
    pass
finally:
    f.close()

# 获取URL
URL = CONF["api"]["url"]

def post(pubId,msg):
    #post信息到报警接口
    import urllib2,urllib
    global URL
    global CONF

    data = {"no":CONF["to"][pubId]["no"],"pub":CONF["to"][pubId]["pub"],"pubkey":CONF["to"][pubId]["pubkey"],"msg":msg}
    data = urllib.urlencode(data)
    req = urllib2.Request(URL)
    response = urllib2.urlopen(req, data)
    return response.read()

def main():
    import os,time
    global CONF
    # 创建MySQL连接
    db = MySQLdb.connect(CONF["db"]["host"],CONF["db"]["dbuser"],CONF["db"]["dbpasswd"],CONF["db"]["dbname"],charset="utf8")
    # 使用cursor()方法获取操作游标 
    select = db.cursor()
    # 创建SQL查询语句
    selectsql = 'SELECT `id`,`from`,`create_time`,`to`,`level`,`msg`,`msg_type`,`from_server` FROM `alarm_yzj`.`alarm` WHERE `sent` = 0'

    try:
        # 执行select
        select.execute(selectsql)
        # 取回结果
        results = select.fetchall()
        # 计算行数
        rows = len(results)
        if (rows == 0) :
            print "没有最新的消息，要退出。"
        # 将结果按行输出，可以用此方法执行需要执行的程序。
        for n in range(0,rows):
            msgId = results[n][0]
            try:
                msgFrom = CONF["from"][str(results[n][1])]
            except Exception, e:
                msgFrom = "未知系统"
            msgTime = time.strftime("%m/%d %H:%M:%S", time.localtime(results[n][2]))
            try:
                msgFromServer = str(results[n][7])

                if (msgFromServer == ""):
                    msgFromServer = msgFrom;
            except Exception, e:
                msgFromServer = msgFrom
            try:
                msgTo = str(results[n][3])
                CONF["to"][msgTo]
            except Exception, e:
                msgTo = "100"
            try:
                msgLevel = CONF["level"][str(results[n][4])]
            except Exception, e:
                msgLevel = "未知级别"
            msgContent = results[n][5]
            try:
                msgType = CONF["msgType"][str(results[n][6])]
            except Exception, e:
                msgType = "消息类型未知"
            # 构建message信息
            message = """监控项目[%s]%s
---------------------------
警报ID：%s
警报时间：%s
警报级别：%s
%s
---------------------------""" % (msgFromServer,msgType,msgId,msgTime,msgLevel,msgContent.replace("|",'\r\n'))
            http = json.loads(post(msgTo,message))
            print http
            if (http["STATUS"] == 200) :
                print "200 ok"
                # 如果发送成功，则更新队列中消息的状态。
                try:
                    updatesql = "UPDATE `alarm_yzj`.`alarm` SET `sent` = '1' ,`sent_response` = \'%s\', `sent_time` = UNIX_TIMESTAMP(NOW()) WHERE `id` = %s" % (http["RESPONSE"], msgId)
                    update = db.cursor()
                    update.execute(updatesql)
                    db.commit()
                except Exception, e:
                    print "更新失败"
                    post("100","消息队列状态更新失败。")
            else:
                print "呵呵，失败了吧。"
                print  json.loads(post("100",http))
    except Exception, e:
        raise e
        print "连接数据库出错。"
    db.close



if __name__ == '__main__':
    main()
