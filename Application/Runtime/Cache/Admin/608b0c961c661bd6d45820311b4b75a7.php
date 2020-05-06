<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - <?php echo $pageTitle;?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo $pageLink;?>"><?php echo $pageButton;?></a>
    </span>
    <span class="action-span1"><a href="/index.php/Admin">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $pageTitle;?> </span>
    <div style="clear:both"></div>
</h1>


<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" id="general-tab">通用信息</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/index.php/Admin/Goods/edit" method="post">
        <input type="hidden" name='id' value='<?php echo I("get.id");?>'/>
            <table width="90%" id="general-table" align="center">
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value="<?php echo $data['goods_name'];?>"size="30" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="<?php echo $data['shop_price'];?>" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="是"  <?php echo $data['is_on_sale']=='是'?"checked='checked'":''; ?>/> 是
                        <input type="radio" name="is_on_sale" value="否" <?php echo $data['is_on_sale']=='否'?"checked='checked'":'';?>/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="<?php echo $data['market_price'];?>" size="20" />
                    </td>
                </tr>


                  <tr>
                    <td class="label">商品图片：</td>
                    <td>
                    <img src="/Public/Uploads/<?php echo $data['sm_logo']?>" alt="" />
                        <input type="file" name="logo" size="35" />
                    </td>
                </tr>

                <tr>
                    <td class="label">商品简单描述：</td>
                    <td>
                        <textarea name="goods_desc" id='goods_desc'>
                        <?php echo $data['goods_desc'];?>
                        </textarea>
                    </td>
                </tr>
            </table>
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</div>

    <link href="/Public/umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="/Public/umeditor/third-party/jquery.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/umeditor/umeditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/umeditor/umeditor.min.js"></script>
    <script type="text/javascript" src="/Public/umeditor/lang/zh-cn/zh-cn.js"></script>
    <script>
    var um = UM.getEditor('goods_desc');
    </script>
<div id="footer">

版权所有 &copy; 志学网络公司权限所有</div>
</body>
</html>