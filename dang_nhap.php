<?php
require_once('includes/functions.php');
require_once("includes/initialize.php");
$submit = get_param('submit');
if($submit<>""){
	$ten_dang_nhap=get_param('ten_dang_nhap');
	$mat_khau=md5(get_param('mat_khau'));
	$mydb->setQuery("SELECT * FROM tlb_nguoidung WHERE ten_dang_nhap = '".$ten_dang_nhap."' AND mat_khau = '".$mat_khau."'");
	$result = $mydb->executeQuery();
	$row_RCNguoidung = $mydb->fetch_assoc($result);
	$totalRows_RCNguoidung = $mydb->num_rows($result);


	// Đăng nhập thành công
	if ($totalRows_RCNguoidung<>0)
	{
		$_SESSION['logged-in'] = true;
		$_SESSION['user_name'] = $ten_dang_nhap;
		$_SESSION['quyen_them'] = true;
		$_SESSION['quyen_sua'] = true;
		$_SESSION['quyen_xoa'] = true;
		$msg="Đăng Nhập Thành Công! Chào Administrator";
		$page='index.php?require=danh_sach_nhan_vien.php&title=Danh sách nhân viên';
		page_transfer($msg,$page);
		exit;
	}
	else
	{
		$msg="Đăng Nhập Thất Bại!Bạn không phải Là Administrator";
		$page='dang_nhap.php';
		page_transfer($msg,$page);
	}
}

if($_SESSION['logged-in'] == true) {
	$msg="Bạn đã đăng nhập rồi!";
	$page='index.php?require=danh_sach_nhan_vien.php&title=Danh sách nhân viên';
	page_transfer($msg,$page);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHU THANH VALVE ADMIN PANEL | Powered by GhoSter..,Inc</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/niceforms.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/bootstrap-growl.js"></script>
<script src="js/ddaccordion.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='images/plus.gif' class='statusicon' />", "<img src='images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
</script>
</head>
<body>
<div id="main_container">

	<div class="header_login">
    <div class="logo"><a href="#"><img src="images/logo.png" alt="" title="" border="0" /></a></div>
    
    </div>

     
        <div class="login_form">
         
        <h1><span class="label label-primary">Admin Panel Login</span></h1>
         
        <a href="#lostpassword" class="forgot_pass">Quên mật khẩu</a>
        <script>
        	$(document).on("click", ".forgot_pass", function(e) {
				$.growl("<strong>Quên mật khẩu:</strong> Gọi (+84) <strong>0973874452</strong> để được hỗ trợ! <a href=\"http://thinghost.co.vu\" target=\"_blank\">thinghost76@gmail.com</a>", { 
					type: "warning"
				}); 
			}); 
        </script>  
        <form action="dang_nhap.php" class="form-horizontal" method="post" name="login_form" id="login_form">
        	

         
                <fieldset>
                	<div class="form-group">
    					<label class="col-sm-2 control-label">Tài khoản</label>
    					<div class="col-sm-8">
      						<input type="text" name="ten_dang_nhap" id="user" class="form-control" placeholder="Username" data-validation="length" data-validation-length="min4" data-validation-error-msg="Tên tài khoản phải dài trên 4 ký tự">
    					</div>
  					</div>
					<div class="form-group">
    					<label for="inputEmail3" class="col-sm-2 control-label">Mật khẩu</label>
    					<div class="col-sm-8">
      						<input type="password" class="form-control" name="mat_khau" id="password" placeholder="Password" data-validation="length" data-validation-length="min4" data-validation-error-msg="Mật khẩu phải dài trên 4 ký tự">
    					</div>
  					</div>

                    <dl class="submit">
                    	<input type="submit" class="btn btn-default" name="submit" id="submit" value="Đăng nhập" />
                    </dl>
                    
                </fieldset>
                
        </form>
        <script src="js/form-validator/jquery.form-validator.min.js"></script>
		<script>
		/* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
    		$.validate({
        		modules : 'security'
    		});
		</script>
        </div>   
    <div class="footer_login">
    
    	<div class="left_footer_login">PHU THANH VALVE ADMIN PANEL | Powered by <a href="http://thinghost.co.vu">GhoSter..,Inc</a></div>
    	<div class="right_footer_login"><a href="http://thinghost.co.vu"><img src="images/ghoster_logo.png" alt="" title="" border="0" /></a></div>
    
    </div>

</div>		
</body>
</html>