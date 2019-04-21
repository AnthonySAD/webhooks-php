# Webhooks-php

该项目是用php编写的脚本。核心功能为：当github上的仓库有新的push时，自动拉取代码。

## 使用方法

1. 拉取本项目

```
git clone git@github.com:AnthonySAD/webhooks-php.git
```

2. 解析一个二级域名到本项目的public目录下

3. 在github上添加webhooks

- 登录你github上的仓库
- 点击settings，然后点击左侧的webhooks，然后点击add webhooks按钮
- Payload URL中填写之前解析的域名地址，content-type选择application/json，填写你的secret
> 如果是多项目或者配置项中关闭了default_project,则需要在URL后添加```?project=project_name_setting_in_config```
- 点击add webhooks，完成添加

4. 配置本项目

- 打开根目录下的config.php，在project=>default下填写你要自动拉取的项目的绝对路径和之前在github上配置的secret

5. 配置php的禁用函数
> 本项目使用shell_exec函数执行shell脚本

打开/usr/local/php/etc/php.ini，找到disable_functions，如果有shell_exec，则删除shell_exec。如：
```disable_functions = shell_exec,exec,system,chroot,chgrp,chown,popen,ini_alter,ini_restore,dl,openlog,syslog,readlink```

5. 修改sudoers中的用户权限
> 必须修改，否则无法git pull，因为git pull需要读取你的ssh秘钥

- 获取php的用户名，apache环境一般为www-data，nginx环境一般为www
- ```vi /etc/sudoers```打开配置文件
- 在文件的最后添加```www ALL=(ALL)   NOPASSWD: /usr/bin/git```，www为你的php的用户名，/usr/bin/git为git的路径

## 其他配置项

#### logs_dir

配置日志的目录地址，请务必使用绝对路径。如果填false，则不记录日志。

#### server_user_name

填写你的web服务器的用户名及用户组，用于自动拉取项目后，自动修改项目的用户名及用户组

#### record_request_data

启用该配置后，日志会记录所有的post payload数据

#### only_pull_master

启用该配置后，只会拉取master分支

#### timezone

配置日志的时区

#### default_project

启用该配置后，当query里没有参数project时，自动识别为````default_project_name```中的项目名

#### projects

可配置多项目，只要在github上webhooks的url配置后加上```?project=project_name_setting_in_config```即可。

配置格式如下:
```
'project_name' => [
            'dir'       => '/root/path/of/your/project',
            'secret'    => 'the secret setting in your repository',
        ],
```