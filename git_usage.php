<?php

/**
 * Git版本管理工具的使用
 * @date 2017-10-13
 */

/**********************************************************************************************
 * 1.安装Git [msysgit是 windows版的Git]
 * 参考：http://blog.jobbole.com/78960/
 */
    #1.1配置账号：开始菜单里面找到 “Git –> Git Bash”，进入命令窗口。
        // $ git config --global user.name "chen"

        // chineon@chineon-PC MINGW64 ~
        // $ git config --global user.email "602129398@qq.com"

    #因为Git是分布式版本控制系统，所以需要填写用户名和邮箱作为一个标识。
    # 注意：git config --global 参数，有了这个参数，表示你这台机器上所有的Git仓库都会使用这个配置，当然你也可以对某个仓库指定的不同的用户名和邮箱。


/**********************************************************************************************
 * 2.创建版本库
 */
    # 2.1指定存放版本库的目录
    // $ cd /d/www/Chen

    # 2.2创建版本管理仓库[.git]
    // $ git init

    # 2.3添加文件到暂存区[‘.’表示当前仓库目录下的所有文件]
    // $ git add .

    # 2.4把文件提交到仓库[‘-m '第一次提交Git'’表示备注]
    // $ git commit -m '第一次提交Git'

    # 2.5一步提交修改的文件、并备注[新建文件还是需要‘git add 'newfile.txt'’]
    // $ git commit -am '一步提交修改的文件'

    # 2.6查看是否还有文件未提交
    // $ git status

    # 2.7比较文件被修改的内容
    // $ git diff workNote/git_usage.php                            #提交前
    // $ git diff [commit-id(git log获取)] workNote/git_usage.php   #提交后

    # 2.8复制到’E‘盘[GitClone目录] chineon@chineon-PC MINGW64 /e
    // $ git clone /d/www/Chen GitClone


/**********************************************************************************************
 * 3.退回版本
 */
    # 3.1查看提交的历史记录[作者、日期、备注]
    // $ git log

    # 3.2查看提交的历史记录版本号[‘30ed2d2’]
    // $ git reflog

    # 3.3把当前的版本回退到上一个版本[‘git reset --hard HEAD~100’表示退回到前100个版本]
    // $ git reset --hard HEAD^

    # 3.4退回到指定版本号[‘30ed2d2’]
    // $ git reset --hard 30ed2d2


/**********************************************************************************************
 * 4.理解工作区与暂存区的区别
 */
    # 4.1使用Git提交文件到版本库有两步：
    // 第一步：是使用 git add 把文件添加进去，实际上就是把文件添加到暂存区。
    // 第二步：使用git commit提交更改，实际上就是把暂存区的所有内容提交到当前分支上。

    # 4.2通过命令[status、add、status、commit]查看比较打印信息
    // $ git status
    // $ git add
    // $ git status
    // $ git commit
    // $ git status



/**********************************************************************************************
 * 5.Git撤销修改和删除文件操作
 */
    # 5.1撤销修改[‘git checkout -- file’丢弃工作区的修改]
    // $ git checkout -- readme.txt

    # 命令意思就是，把readme.txt文件在工作区做的修改全部撤销，这里有2种情况
    # 1）readme.txt自动修改后，还没有放到暂存区，使用 撤销修改就回到和版本库一模一样的状态。
    # 2）另外一种是readme.txt已经放入暂存区了，接着又作了修改，撤销修改就回到添加暂存区后的状态。

    #注意：命令git checkout -- readme.txt 中的 -- 很重要，如果没有 -- 的话，那么命令变成创建分支了。

    # 5.2删除文件[先删除、后提交]
    // $ rm read.txt
    // $ git commit



/**********************************************************************************************
 * 6.远程仓库
 */
    # 6.1创建SSH Key[‘ssh-keygen -t rsa’生成密钥的文件]
    // $ ssh-keygen -t rsa -C "602129398@qq.com"

    #注意：该命令需要回车两次，然后输两次密码[‘passphrase’可直接回车忽略]，生成密钥。
    #[/c/Users/chineon/.ssh/id_rsa]密钥分成两个文件，一个私钥（id_rsa）、一个公钥（id_rsa.pub）。私钥保存在自己的电脑上，公钥交项目负责人添加到服务器上。用户必须拥有与服务器公钥所配对的私钥，才能访问服务器上的代码库。

    # 6.2连接Github账号
    // 登录github.com，在右上角找到Settings->SSH keys-> Add SSH key ->填上任意title -> 拷贝在公钥（id_rsa.pub）文件中的所有的文本->完成了对GitHub上SSH Key公钥的添加。

    # 6.3创建Github代码仓库
    // 登录github.com，在右上角找到 “New repository” -> “Create repository” 创建Git仓库（与本地仓库名称相同即可）。

    # 6.4”首次“把本地仓库代码，推送到 Github 远程仓库
    // $ git remote add origin git@github.com:Chen896/chen.git        #http方式
    // $ git remote add origin https://github.com/Chen896/chen.git    #ssh方式(需要验证github用户名和密码)

        #错误提示：fatal: remote origin already exists.
        #解决办法(1)：把本地仓库分支master内容推送到远程仓库。
        // $ git push -u origin master
            #继续报错：‘origin’ does not to be a git repository
            #解决办法(1.1)：如下两个命令
                // $ git remote add origin git@github.com:Chen896/chen.git
                // $ git push -u origin master

        #解决办法(2)：先删除远程 Git 仓 -> 再添加远程 Git 仓库
        // $ git remote rm origin
        // $ git remote add origin 仓库地址
            #依然报错：把 [remote “origin”] 那一行删掉。
                // $ vi .git/config

    # 6.5远程仓库的提交与更新
    // $ git push origin master   #提交修改
    // $ git pull origin master   #拉取更新

    #错误提示：error:failed to push som refs to…….
    #解决办法：先更新 -> 再提交。

    # 6.6克隆远程仓库到本地（从 Git 仓库中拷贝项目）[‘git clone’类似 svn checkout]
    // $ git clone <repo> <directory>  #克隆到指定目录
    // $ git clone git@github.com:Chen896/chen.git addon

    # 6.7 Git避免每次远程交互都需要输入密码[因为使用了https的方式，速度还慢]
    // $ git remote -v    #查看使用的传输协议

    #重新设置成ssh的方式：
    // $ git remote rm origin
    // $ git remote add origin git@github.com:Chen896/chen.git
    // $ git push -u origin master

    # 6.8在github中删除已经同步过的commit[多人协作时谨慎操作，相当于版本回退]
    // $ git reset --soft HEAD~1        #删除最近的一个commit[可重复]
    // $ git push origin HEAD --force   #将本地的HEAD文件强制覆盖github上的HEAD文件


/**********************************************************************************************
 * 7.Git忽略规则、与“LF will be replaced by CRLF”问题的解决
 */
    # 7.1关于 LF will be replaced by CRLF 问题出现的原因以及解决方式：
        #原因：Windows中的换行符为’CRLF‘，而在Linux下的换行符为’LF‘，CRLF和LF是两种不同的换行格式。
        #git工作区默认为CRLF来作为换行符，所以当我们项目文件里有用的地方使用LF作为换行符，这个时候我们再继续git add 或 git commit 的时候就会弹出警告，
        #当最终push到远程仓库的时候git会统一格式全部转化为用CRLF作为换行符。

        #建议：遇到了这种问题可以直接忽略，对我们整体工作不会造成影响！
        // $ rm -rf .git  #删除.git
        // $ git config --global core.autocrlf false  #禁用自动转换
        // $ git init     #初始化git库
        // $ git add .    #提交所有修改到暂存区

    # 7.2 Git 忽略规则 .gitignore【git命令行下 ’vim gitignore‘ 命令编辑忽略规则】
        #常用的规则：
        // 1）/mtk/              过滤整个文件夹
        // 2）*.zip              过滤所有.zip文件
        // 3）/mtk/do.c          过滤某个具体文件

        #只需要管理/mtk/目录中的one.txt文件
        // 1）/mtk/              过滤整个文件夹
        // 2）!/mtk/one.txt      不过滤one.txt文件

        #最后需要强调的一点是，如果你不慎在创建.gitignore文件之前就push了项目，那么即使你在.gitignore文件中写入新的过滤规则，这些规则也不会起作用，因此一定要养成在项目开始就创建.gitignore文件的习惯，否则一旦push，处理起来会非常麻烦。

        #1）配置语法：
        // 以斜杠“/”  开头表示目录；
        // 以星号“*”  通配多个字符；
        // 以问号“?”  通配单个字符
        // 以方括号“[]”  包含单个字符的匹配列表；
        // 以叹号“!”     表示不忽略(跟踪)匹配到的文件或目录；

        #2）示例说明
        // a）规则：fd1/*    说明：忽略’所有目录‘ fd1 下的全部内容；
        // b）规则：/fd1/*   说明：忽略’根目录‘下的 /fd1/ 目录的全部内容；

        #c）规则：
        // /*
        // !.gitignore
        // !/fw/bin/
        // !/fw/sf/
        #说明：忽略全部内容，但是不忽略 .gitignore 文件、根目录下的 /fw/bin/ 和 /fw/sf/ 目录；

/**
 * ***END***************************************************************************************
 */