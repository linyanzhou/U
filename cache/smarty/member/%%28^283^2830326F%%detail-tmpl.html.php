<?php /* Smarty version 2.6.26, created on 2014-01-17 02:47:26
         compiled from sell_de/detail-tmpl.html */ ?>
<!DOCTYPE html>
<html>
<head>
<title>会员后台——add sell</title>
<meta charset="UTF-8">
 <link rel="stylesheet" type="text/css" href="/U/UI/css/bootstrap.min.css" />
 <link rel="stylesheet" type="text/css" href="/U/UI/css/bootstrap-responsive.css"/>
 <link rel="stylesheet" type="text/css" href="/U/UI/css/style.css" />
 <link rel="stylesheet" type="text/css" href="/U/UI/css/bootstrap-datetimepicker.min.css"/>
 <script type="text/javascript" src="/U/UI/js/jquery.js"></script>  
 <script type="text/javascript" src="/U/UI/js/cate_de.js"></script>
 <script type="text/javascript" src="/U/UI/js/DropDownListBox.js"></script>
 <script type="text/javascript" src="/U/UI/js/bootstrap.js"></script>
 <script type="text/javascript" src="/U/UI/js/ajaxfileupload.js"></script>   
 <script type="text/javascript" src="/U/UI/js/bootstrap-datetimepicker.min.js"></script>  
</head>

<body>

<form  action=""  method="post" enctype="multipart/form-data">
<table class="table table-bordered table-hover definewidth m10">
	<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
	<?php if ($this->_tpl_vars['product_img']): ?>
  <input type="hidden" name="f" value="change">
  <?php else: ?>
   <input type="hidden" name="f" value="add">
  <?php endif; ?>
	<tr>
		  <td width="10%" class="tableleft">商品名称</td>
		<td>
		<input type="text"  name="product_name" value="<?php echo $this->_tpl_vars['product_name']; ?>
">
   	</td>
	</tr>
	
	<tr>
		  <td width="10%" class="tableleft">商品分类</td>
		<td>
		          <select id="c1" name="c1"></select>
						  <select id="c2" name="c2"></select>	  
						  <input type="hidden" id="category" name="category" value="<?php echo $this->_tpl_vars['cate_id']; ?>
"><br />
   	</td>
	</tr>
	
	
	<tr>
		<td width="10%" class="tableleft">商品图片</td>
		<td>
			<?php if ($this->_tpl_vars['product_img']): ?>
			<span> <img src=/U/Upload/images/<?php echo $this->_tpl_vars['product_img']; ?>
 maxwidth=300px> <input type="hidden" name="product_img" value="<?php echo $this->_tpl_vars['product_img']; ?>
"></span>
			<?php else: ?>
		        <div style="position:relative;width:360px;">
        	  <input type='test' name='textfield' id='textfield' style="height:22px; border:1px solid #cdcdcd;"/> 
        	  <input type='button' style="background-color:#FFF; border:1px solid #CDCDCD;height:24px; width:70px;" value='浏览...' />
        	  <input type="file"  id="product_img" style=" position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:260px" name="product_img" size="28" onchange="document.getElementById('textfield').value=this.value" >
        	  <input type="button" style="background-color:#FFF; border:1px solid #CDCDCD;height:24px; width:70px;" value="上传" onclick="return ajaxFileUpload();" />
        		<span  id="img"> </span>   
            </div>	
     <?php endif; ?>
   	</td>
	</tr>
	
	
   <tr id="pro_list1">
        <td width="10%" class="tableleft"> 添加时间 </td>
        
        <td>
  <div id="datetimepicker1" class="input-append date form_datetime"> <input data-format="yyyy/MM/dd" type="text" name="create_time" value="<?php echo $this->_tpl_vars['create_time']; ?>
"> </input> <span class="add-on"><i class="icon-calendar"></i></span></div>
       </td>
 
    </tr>
    
     <tr>
        <td class="tableleft"></td>
        <td>
            <button type="submit" id="submit" class="btn btn-primary" type="button">保存</button>&nbsp;&nbsp;<button type="button" class="btn btn-success" id="back_id">返回列表</button>
        </td>
    </tr>
 


</table>
</form>
</body>
</html>
<script type="text/javascript">
    $(function() {
    	
    set_category('', 1, ''); 

    $("#back_id").click(function(){
    	
    window.location.href="/U/html/buy";    	
    });
    $('#datetimepicker1').datetimepicker({
      language: 'pt-BR',
       autoclose: true,
       todayBtn: true,
       pickerPosition: "bottom-left"
    });
  });
  
  function ajaxFileUpload()
{
	//图片及时显示
    $.ajaxFileUpload
    (
        {
            url:'/U/html/upload/?_a=upload&f=upload_product',
            secureuri:false,
            fileElementId:'product_img',
            dataType: 'json',         
            success: function (data, status)
            {
          
     	      if(data.img_error){
     	      $("#img").html("<span><font color=\"red\">上传失败，请检查图片大小或类型！</font></span>");
     	      }else{   
            $("#img").html("<img src=/U/Upload/images/"+data.picname+">");
            $("#img").append("<input type=hidden name=g_image value="+data.picname+">");
           }   
            },
            error: function (data, status, e)
            {  
                $("#img").html("<span>图片加载失败</span>");
            }
        }
    )
    return false;
}
 
</script>
   