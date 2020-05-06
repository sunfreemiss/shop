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

<div class="form-div">
    <form action="/index.php/Admin/Goods/lst" method='GET' >
		<p>
			商品名称:
			<input type="text" name='gn' value='<?php echo I("get.gn");?>'/>
		</p>
		<p>
			商品价格:
			从<input type="text" name='fp' size='15' value='<?php echo I("get.fp");?>'/>
			到<input type="text" name='tp' size='15' value='<?php echo I("get.tp");?>'/>
		</p>
		<p>
			是否上架:
			<input type="radio" name='ios' value='' <?php echo I("get.ios")==""?'checked="checked"':"" ;?>/>全部
			<input type="radio" name='ios' value='是' <?php echo I("get.ios")=="是"?'checked="checked"':"" ;?>/>是
			<input type="radio" name='ios' value='否'  <?php echo I("get.ios")=="否"?'checked="checked"':"" ;?>/>否
		</p>
		<p>
			添加时间:
			从<input type="text"  id="fa" name='fa' size='30' value='<?php echo I("get.fa");?>'/>
			到<input type="text" id='ta' name='ta' size='30' value='<?php echo I("get.ta");?>'/>
		</p>
		<?php $obdy=I('get.odby','id_desc');?>
		<input onclick='this.parentNode.submit();' type="radio" name='odby' value='id_desc' <?php echo I("get.odby")=="id_desc"?'checked="checked"':"" ;?>/>以时间降序
		<input onclick='this.parentNode.submit();' type="radio" name='odby' value='id_asc' <?php echo I("get.odby")=="id_asc"?'checked="checked"':"" ;?>/>以时间升序
		<input onclick='this.parentNode.submit();' type="radio" name='odby' value='price_desc' <?php echo I("get.odby")=="price_desc"?'checked="checked"':"" ;?>/>以价格降序
		<input onclick='this.parentNode.submit();' type="radio" name='odby' value='price_asc' <?php echo I("get.odby")=="price_asc"?'checked="checked"':"" ;?>/>以价格升序
		<input type="submit" value='搜索' />
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>商品名称</th>
                <th>logo</th>
                <th>市场价格</th>
                <th>本店价格</th>
                <th>上架</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            <?php foreach($data as $v):?>
            <tr class="tron">
                <td align="center"><?php echo $v['id'];?></td>
                <td align="center" class="first-cell"><span><?php echo $v['goods_name'];?></span></td>
                <td align="center"><span onclick=""><?php showImage($v["sm_logo"]);?></span></td>
                <td align="center"><span><?php echo $v['market_price'];?></span></td>
                <td align="center"><span><?php echo $v['shop_price'];?></span></td>
                <td align="center"><span><?php echo $v['is_on_sale'];?></span></td>
                <td align="center"><span><?php echo $v['addtime'];?></span></td>

                <td align="center">
                	<a href="<?php echo U('edit?id='.$v['id']);?>">修改</a>
                	<a onclick="return confirm('确定要删除吗?);')" href="<?php echo U('delete?id='.$v['id']);?>">删除</a>
                </td>
            </tr>
         <?php endforeach;?>
        </table>

    <!-- 分页开始 -->
        <table id="page-table" cellspacing="0">
            <tr>
                <td width="80%">&nbsp;</td>
                <td align="center" nowrap="true">
                    <?php echo $page; ?>
                </td>
            </tr>
        </table>
    <!-- 分页结束 -->
    </div>
</form>

<script type="text/javascript" src="/Public/umeditor/third-party/jquery.min.js"></script>
<link href="/Public/datetimepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8" src="/Public/datetimepicker/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/datetimepicker/datepicker-zh_cn.js"></script>
<link rel="stylesheet" media="all" type="text/css" href="/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.css" />
<script type="text/javascript" src="/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="/Public/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script>
$.timepicker.setDefaults($.timepicker.regional['zh-CN']);
$("#fa").datepicker({ dateFormat: "yy-mm-dd" });

$("#ta").datepicker({ dateFormat: "yy-mm-dd" });
</script>
<script typr="text/javascript" src="/Public/Admin/Js/tr.js"></script>
<div id="footer">

版权所有 &copy; 志学网络公司权限所有</div>
</body>
</html>