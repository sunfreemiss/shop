<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends Controller {
   //添加商品页面展示
   public function add(){
    //判断是否提交了post数据
    if(IS_POST)
    {
        //提交了post数据就需要对数据进行过滤和实例化模型对象
        $data=I('post.');
        $model=D('goods');

        //根据表单传输的数据保存到模型中方便后期进行验证
        if($model->create($data,1))
        {
            //插入数据
            if($model->add())
            {
            $this->success('数据插入成功',U('lst'));
                exit;
            }

        }
            //插入失败
            //获取失败信息
            $error=$model->getError();
            //显示错误
            $this->error($error);
    }
    $this->display();
   }
   public function lst(){
       echo 'success';
   }
}