<?php
return array(
	//'配置项'=>'配置值'
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'shop',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'sp_',    // 数据库表前缀
    'DEFAULT_FILTER'        =>  'trim,htmlspecialchars', // 默认参数过滤方法 用于I函数...
    /**************图片相关的配置********************/
    'IMAGE_CONFIG'=>array(
        'maxSize'=>1024*1024,
        'exts'=>array('jpg','gif','png','jpeg'),
        'rootPath'=>'./Public/Uploads/',//上传图片的保存路径
        'viewPath'=>'/Public/Uploads/',//显示图片的路径

    ),
);