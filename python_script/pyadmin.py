__author__ = 'AZONE'

import threading
import os
import time
import subprocess
import sys
import requests
import urllib2
os_char='gb18030'
def getLastestIpData():

    url = 'http://ipblock.chacuo.net/down/t_txt=c_RU'

    print '[Note] Try to get IP data from '+ url +' ....'

    try:
        response = requests.get(url)
        dataContent = response.content[7:-8].replace('\t',' ').replace('\r\n','\n')

        print '[Note] Get IP data success! Data length is '+ str(len(dataContent)) +'.'

        logFile = open(sys.path[0] + '/cnip.log','w')
        try:
            logFile.write(dataContent)
            logFile.close()
            print '[Note] Write data into log file success! Path : '+sys.path[0] + '/cnip.log'
        except Exception,e:
            print e
            print '[Note] Program exit...'
            sys.exit()

    except Exception,e:
        print e
        print '[Note] Program exit...'
        sys.exit()
def taskpid():
    imagename = "python.exe"
    p = os.popen('tasklist /FI "IMAGENAME eq %s"' % imagename)
    #print p.read()
    pid = str(p.read())
    l= pid.split('\n')
    pidlist = []
    for i in l[2:]:
        x = i.strip().split()
        if x != []:
		    pidlist.append(x)
    pid1 = pidlist[1][1]
    pid2 = pidlist[2][1]
    adminpid = os.getpid()
    if adminpid != pid1:
        taskpid = pid1
    else:
        taskpid = pid2
    return taskpid

if __name__ == '__main__':
    pid = os.getpid()
    #getLastestIpData()

    resultIpArray = []
    tasktime = []
    #nowtaskpid = taskpid()

    #decode data
    logFile = open(sys.path[0] + '/rr.txt','r')
    for line in logFile:
        iparray = []
        ptime = []
        tasktimelist = []
        line = line.strip('\n')
        iparray.append(line.split(' ')[0])
        iparray.append(line.split(' ')[1])
        ptime.append(line.split(' ')[2])
        resultIpArray.append(iparray)
        tasktime.append(ptime)
    for timelist in tasktime:
        timelist2 = timelist
        for timelist3 in timelist2:
            timelist4 = timelist3
            tasktimelist.append(timelist4)
    i = 0
    for list in resultIpArray:
        start,end = list

        timeset = tasktimelist[i]
        i = i + 1
        sleeptime = (float(timeset)/10000)*66
        print timeset
        print '[Note] Will spend '+str(sleeptime)
        p=subprocess.Popen('cmd.exe',shell=True,stdin=subprocess.PIPE)
        p.stdin.write('python F:/python/task/tcpscan4.py '+start+' '+end+ '\n')
        time.sleep(sleeptime)