<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
</head>
<body>
<?php if (!empty($_GET)) {?>
    <div style="text-align: center">
        <?php
        date_default_timezone_set('PRC');
        # 接收用户的登录信息
        $username = trim($_GET['username']);
        $password = trim($_GET['password']);
        if (empty($username))
        {
            unset($_GET);
            echo '用户名不能为空';
            echo "<meta http-equiv='refresh' content='1;url=index.php'>";
            exit;
        }
        if (empty($password))
        {
            unset($_GET);
            echo '密码不能为空';
            echo "<meta http-equiv='refresh' content='1;url=index.php'>";
            exit;
        }
        $file_handle = fopen("password.txt","r");
        if ($file_handle){
            //接着采用 while 循环一行行地读取文件，然后输出每行的文字
            $i = 0;
            $user_data = array();
            while (!feof($file_handle)) { //判断是否到最后一行
                $line = fgets($file_handle); //读取一行文本
                $arr = explode('*',$line);
                $user_data[$i]['username'] = trim($arr['0']);
                $user_data[$i]['password'] = trim($arr['1']);
                $user_data[$i]['img_url'] = trim($arr['2']);
                $i++;
            }
        }
        fclose($file_handle);//关闭文件
        $res = false;
        foreach ($user_data as $k => $v)
        {
            if ($v['username'] == $username)
            {
                if ($v['password'] == $password)
                {
                    $res = true;
                    break;
                }
            }
        }
        if (!$res)
        {
            unset($_GET);
            echo '用户名或密码不正确！';
            echo "<meta http-equiv='refresh' content='1;url=index.php'>";
            exit;
        }
        $date = date ('Y-m-d');
        $time = date ('H:i');
        file_put_contents ( "log.csv", "$username;$date;$time\n",FILE_APPEND);
        ?>
        <?php foreach ($user_data as $k => $v) {?>
            <?php if ($v['username'] == $_GET['username']) {?>
                <spanv>我最喜欢的宠物是：</spanv>
                <span><img style="width:750px;height:530px;object-fit: contain;" src="<?php echo $v['img_url'];?>" /></span>
            <?php } ?>
        <?php } ?>
    </div>
<?php } ?>
<?php if (empty($_GET)) {?>
    <form action="" method="get">
        <fieldset style="text-align: center">
            <legend>User Login</legend>
            <p>
                <label>username:</label>
                <input type="text" name="username">
            </p>
            <p>
                <label>password:</label>
                <input type="password" name="password">
            </p>
            <p>
                <label> </label>
                <input type="submit" name="login" value="登录">
            </p>
        </fieldset>
    </form>
<?php } ?>
</body>
</html>