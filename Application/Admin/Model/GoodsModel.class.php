<?php
namespace Admin\Model;
use Think\Model;

class GoodsModel extends Model
{
  //要做数据验证
  protected  $_validate=array(
      array('goods_name','require','商品名称不能为空',1),
      array('shop_price','currency','本店价格必须是货币型',1),
      array('market_price','currency','市场价格必须是货币型',1)
  );
  //在数据插入之前进行的操作
  public function _before_insert(&$data, $options){
       /*
        * 图片上传解决步骤
        * 1 判断是否有图片上传
        * 2 对图片进行压缩处理
        * 3 将图片上传的地址保存到数据库中即可
        */
       if($_FILES['logo']['error']==0)
       {
            // 说明有图片上传
            $upload = new \Think\Upload(); // 实例化上传类
            $upload->maxSize = 1024 * 1024; // 设置附件上传大小
            $upload->exts = array(
                'jpg',
                'gif',
                'png',
                'jpeg'
            ); // 设置附件上传类型
            $upload->rootPath = './Public/Uploads/'; // 设置附件上传目录
            $upload->savePath='Goods/';  // 上传文件
            $info = $upload->upload();
            if (! $info)
            {
                // 上传错误提示错误信息
                $this->error=$upload->getError();
                return false;
            }

            //开始拼接上传地址
            $logo=$info['logo']["savepath"].$info['logo']["savename"];
            $mbiglogo = $info['logo']['savepath'] .'mbig_'. $info['logo']['savename'];
            $biglogo = $info['logo']['savepath'] .'big_'. $info['logo']['savename'];
            $midlogo = $info['logo']['savepath'] .'mid_'. $info['logo']['savename'];
            $smlogo = $info['logo']['savepath'] .'sm_'. $info['logo']['savename'];
            //对上传的图片进行压缩处理
            $image = new \Think\Image();
            $image->open('./Public/Uploads/'.$logo);
            //拼接不同缩略等级的图片
            $image->thumb(700, 700)->save('./Public/Uploads/'.$mbiglogo);
            $image->thumb(350, 350)->save('./Public/Uploads/'.$biglogo);
            $image->thumb(130, 130)->save('./Public/Uploads/'.$midlogo);
            $image->thumb(50, 50)->save('./Public/Uploads/'.$smlogo);
            $image->thumb(150, 150)->save('./thumb.jpg');

            $data['logo'] = $logo;
            $data['mbig_logo'] = $mbiglogo;
            $data['big_logo'] = $biglogo;
            $data['mid_logo'] = $midlogo;
            $data['sm_logo'] = $smlogo;
       }

      //商品描述信息在存入数据库时候会将数据进行标签的实体转化导致数据回显到页面的时候显示的是转换之后的原始标签无法实现页面的详细信息展示
      //因此在这里需要对不需要转换的的标签进行忽略操作
      $data['goods_desc']=ignoreXSS($_POST['goods_desc']);
      //插入的时间没有生成
      $data['addtime']=date('Y-m-d H:i:s',time());

  }
}

