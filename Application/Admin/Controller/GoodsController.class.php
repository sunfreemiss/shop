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
    $this->assign('pageTitle','添加商品');
    $this->assign('pageButton','商品列表');
    $this->assign('pageLink',U('lst'));
    $this->display();
   }
   public function lst(){
       //生成商品模型
       $model=D('goods');
       //调用模型中的查询方法返回数据和翻页(二维数组)
       $data=$model->search();
       $this->assign($data);
       $this->assign('pageTitle','商品列表');
       $this->assign('pageButton','商品列表');
       $this->assign('pageLink',U('lst'));
       $this->display();
   }

   public function edit(){
       //接收要修改的商品id
       $id=I('get.id');
       $model=D('goods');
       //判断是否提交了post数据
       if(IS_POST)
       {
           //提交了post数据就需要对数据进行过滤和实例化模型对象
           $data=I('post.');


           //根据表单传输的数据保存到模型中方便后期进行验证
           if($model->create($data,2))
           {
               //插入数据
               if(FALSE!==$model->save())
               {
                   $this->success('修改成功',U('lst'));
                   exit;
               }

           }
           //插入失败
           //获取失败信息
           $error=$model->getError();
           //显示错误
           $this->error($error);
       }
       //根据id取出商品的信息
       $data=$model->find($id);
       $this->assign('data',$data);
       $this->assign('pageTitle','编辑商品信息');
       $this->assign('pageButton','商品列表');
       $this->assign('pageLink',U('lst'));
       $this->display();
   }
   public function delete(){
       $model=D('goods');
       $rec=$model->delete(I('get.id'));
       if(false!==$rec)
       {
           $this->success('删除成功',U('lst'));
           exit;
       }
       $this->error('删除失败'.$model->getError());
   }

}