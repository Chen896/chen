#!/usr/bin/python
# -*- coding: utf-8 -*-

#1.这是单行注释
'''这是多行注释
    第1行是告诉操作系统执行这个脚本的时候，调用 /usr/bin 下的 python 解释器。
    [#!/usr/bin/env python]会去环境变量寻找 python 目录,推荐这种写法。
    第2行用来申明编码，中文必须。

    #-----------------------------------------------------------------------
    #创建Sublime Text编译环境2017-12-29
        #1）【Tools】->【Build System】->【选中Python、或者Automatic】
        #2）或点击【New Build System...】创建 /Packages/User/Python.sublime-build 文件，内容如下
            {"cmd":["python", "$file"], "file_regex":"py$", "selector":"source.python"}
    #-----------------------------------------------------------------------

    # 正则表达式字符串的开头字母“r”。 它告诉Python这是个原始字符串，不需要处理里面的反斜杠（转义字符）。
'''

#2.导入模块[os.py]
import os

#3.定义函数[函数代码块以 def 关键词开头，内容以冒号起始，并且缩进]
def main():
    #4.在Python 3.x中，打印的内容a必须带括号
    #print 'Hello World!'
    print ('Hello World!')

    #5.申明单行字符串，单/双引号都可以，注意对字符串中的引号转义
    print ("这是Alice\'的问候.")
    print ('这是Bob\'的问候.')

    #6.调用函数加法运算
    foo(5, 10)

    print ('=' * 10)
    # print ('这将直接执行'+os.getcws())

    counter = 0
    counter += 1

    food = {'苹果', '杏子', '李子', '梨'}
    for i in food:
        print ('俺就爱整只:'+i)

    print ('数到10')
    for i in range(10):
        print (i)

def foo(param1, secondParam):
    res = param1 + secondParam
    print ('%s 加 %s 等于 %s' % (param1, secondParam, res))
    if res < 50:
        print ('这个')
    elif (res>=50) and ((param1==42) or (secondParam==24)):
        print ('那个')
    else:
        print ('嗯...')

    return res

if __name__=='__main__':
    main()
