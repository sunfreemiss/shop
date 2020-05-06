<?php
function ignoreXSS($data){
    require_once  './Public/HtmlPurifier/HTMLPurifier.auto.php';
    $_clean_xss_config = HTMLPurifier_Config::createDefault();
    $_clean_xss_config->set('Core.Encoding', 'UTF-8');
    $_clean_xss_config->set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
    $_clean_xss_config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    $_clean_xss_config->set('HTML.TargetBlank', TRUE);
    $_clean_xss_obj = new HTMLPurifier($_clean_xss_config);
    return $_clean_xss_obj->purify($data);
}
/*************显示图片***************/
    function showImage($url){
        $ic=C('IMAGE_CONFIG');
        echo "<img src='{$ic['viewPath']}$url'>";
    }
/************图片上传函数************************/
/*
 *上传图片并生成缩略图
 * 用法及相关数据
 * $res=uploadOne('logo','goods',array(
 *    array(600,600),
 *    array(350,350),
 *    array(100,100),
 * ));
 * 返回的数据
 * if($res['ok']==1)
 * {
 *  $res['image'][0]//原图地址
 *  $res['image'][1]//缩略图地址
 *  $res['image'][2]//缩略图地址
 *  $res['image'][3]//缩略图地址
 * }
 * $imgName  上传图片文件表单的name属性
 * $dirName  二级目录的文件名
 * $thumb    图片最终的压缩比例
*/
 function uploadOne($imgName,$dirName,$thumb=array())
 {
     //上传logo
     if(isset($_FILES[$imgName])&&$_FILES[$imgName]['error']==0)
     {
         //读取图片配置信息
         $ic=C('IMAGE_CONFIG');
         	$upload = new \Think\Upload(array(
			'rootPath' => $ic['rootPath'],
			'maxSize' => $ic['maxSize'],
			'exts' => $ic['exts'],
		));
         //图片的二级目录名称
         $upload->savePath=$dirName.'/';
        $info=$upload->uploadOne($_FILES[$imgName]);
        if(!$info)
        {
            return array(
                'ok'=>0,
                'error'=>$upload->getError()
            );
        }else{
            //上传成功
            //拼接上传文件的路径
            $img_path=$info['savepath'].$info['savename'];
            //返回的image数据就是向数据库中添加的图片二级地址
            $res=array(
                'ok'=>1,
                'images'=>array($img_path)//原始上传的文件路径
            );
            //判断是否生成缩略图
            if($thumb)
            {
                $image = new \Think\Image();
                //说明需要生成缩略图 循环生成
                foreach ($thumb as $k=>$v)
                {
                   //拼接保存的压缩图片的路径
                   $res['images'][$k+1]= $info['savepath'] . 'thumb_'.$k.'_' .$info['savename'];
                   // 打开要处理的图片
                   $image->open($ic['rootPath']. $img_path);
                   $image->thumb($v[0], $v[1])->save($ic['rootPath'].$res['images'][$k+1]);
                }
            }
            return  $res;
        }
     }
 }
