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
/********************添加数据的时候接收的数据 create方法* 要接收的数据***********************/
  protected  $insertFields='goods_name,market_price,shop_price,is_on_sale,goods_desc';
  /************************修改的时候create方法需要接收的数据*************************************/
protected  $updateFields='id,goods_name,market_price,shop_price,is_on_sale,goods_desc';

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
  public function _before_update(&$data, $options){
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
          /***********删除原来的图片*************/
          //获取原始图片的路径
          $oldData=$this->field('logo,mbig_logo,big_logo,mid_logo,sm_logo')->find(I('post.id'));
          //删除原图
          unlink('./Public/Uploads/'.$oldData['logo']);
          unlink('./Public/Uploads/'.$oldData['sm_logo']);
          unlink('./Public/Uploads/'.$oldData['mbig_logo']);
          unlink('./Public/Uploads/'.$oldData['big_logo']);
          unlink('./Public/Uploads/'.$oldData['mid_logo']);
      }

      //商品描述信息在存入数据库时候会将数据进行标签的实体转化导致数据回显到页面的时候显示的是转换之后的原始标签无法实现页面的详细信息展示
      //因此在这里需要对不需要转换的的标签进行忽略操作
      $data['goods_desc']=ignoreXSS($_POST['goods_desc']);
      //插入的时间没有生成
      $data['addtime']=date('Y-m-d H:i:s',time());

  }
  /****************删除之前*******************************/
  public function _before_delete($options)
  {
      $id=$options['where']['id'];
      $oldData=$this->field('logo,mbig_logo,big_logo,mid_logo,sm_logo')->find($id);
      //删除原图
      unlink('./Public/Uploads/'.$oldData['logo']);
      unlink('./Public/Uploads/'.$oldData['sm_logo']);
      unlink('./Public/Uploads/'.$oldData['mbig_logo']);
      unlink('./Public/Uploads/'.$oldData['big_logo']);
      unlink('./Public/Uploads/'.$oldData['mid_logo']);
  }
  /*
   * 实现 分页搜索排序
   */
  public function search($perpage=5)
  {
      /**************接收搜索条件******************/
      $gn=I('get.gn');
      $where=array();//空的where条件
      if($gn)
      {
           $where['goods_name'] =array('like',"%$gn%");

      }
      $fp=I('get.fp');
      $tp=I('get.tp');
      if($fp && $tp )
      {
          $where['shop_price']=array('between',array($fp,$tp));
      }else if($fp)
      {
          $where['shop_price']=array('egt',$fp);
      }else if($tp)
      {
          $where['shop_price']=array('elt',$tp);
      }
      $ios=I('ios');
      if($ios)
      {
          $where['is_on_sale']=array('eq',$ios);
      }
      $fa=I('get.fa');
      $ta=I('get.ta');
      if($fa && $ta )
      {
          $where['addtime']=array('between',array($fa,$ta));
      }else if($fa)
      {
          $where['addtime']=array('egt',$fa);
      }else if($ta)
      {
          $where['addtime']=array('elt',$ta);
      }
      /**************分页功能**********************/
      $count=$this->where($where)->count();
      //生成分页类对象
      $pageObj= new \Think\Page($count,$perpage);// 实例化分页类 传入总记录数和每页显示的记录数(25)
      $pageObj->setConfig('next', '下一页');
      $pageObj->setConfig('prev', '上一页');
      //分页字符串
      $page=$pageObj->show();
      /************排序***************/
        $odby='id';
        $odway='desc';
        $oby=I('get.odby');
        if($oby)
        {
            switch($oby)
            {
                case 'id_asc';
                $odway='asc';
                break;
                case 'price_desc';
                $odby='shop_price';
                break;
                case 'price_asc';
                $odby='shop_price';
                $odway='asc';
                break;
            }
        }
      /**************取出按要求的数据***********************/
      $data=$this->where($where)->order("$odby $odway")->limit($pageObj->firstRow.','.$pageObj->listRows)->select();

      /**************返回数据和对应的分页字符串********************/
      return array(
          'data'=>$data,//数据
          'page'=>$page//分页字符串
      );
  }
}

