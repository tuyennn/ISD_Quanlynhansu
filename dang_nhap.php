<?php
require_once('includes/functions.php');
require_once("includes/initialize.php");
$submit = get_param('submit');
if($submit<>""){
	$ten_dang_nhap=get_param('ten_dang_nhap');
	$mat_khau=md5(get_param('mat_khau'));
	mysql_select_db($database_Myconnection, $Myconnection);
	$query_RCNguoidung = "SELECT * FROM tlb_nguoidung WHERE ten_dang_nhap = '".$ten_dang_nhap."' AND mat_khau = '".$mat_khau."'";
	$RCNguoidung = mysql_query($query_RCNguoidung, $Myconnection) or die(mysql_error());
	$row_RCNguoidung = mysql_fetch_assoc($RCNguoidung);
	$totalRows_RCNguoidung = mysql_num_rows($RCNguoidung);
	mysql_free_result($RCNguoidung);
	//nếu đăng nhập thành công
	if ($totalRows_RCNguoidung<>0)
	{
		$_SESSION['logged-in'] = true;
		$_SESSION['user_name'] = $ten_dang_nhap;
		$_SESSION['quyen_them'] = true;
		$_SESSION['quyen_sua'] = true;
		$_SESSION['quyen_xoa'] = true;
		//echo "Đăng nhập thành công";
		//$url = "index.php?require=danh_sach_nhan_vien.php&title=Danh sách nhân viên";
		//location($url);
		$msg="Đăng Nhập  Thành Công! Chào Administrator";
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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHU THANH VALVE ADMIN PANEL | Powered by GhoSter..,Inc</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
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
<script src="js/jconfirmaction.jquery.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});
	
</script>
<script src="js/niceforms.js" type="text/javascript" charset="utf-8"></script>

</head>
<body>
<div id="main_container">

	<div class="header_login">
    <div class="logo"><a href="#"><img src="images/logo.png" alt="" title="" border="0" /></a></div>
    
    </div>

     
         <div class="login_form">
         
         <h3>Admin Panel Login</h3>
         
         <a href="#" class="forgot_pass">Forgot password</a> 
         
         <form action="dang_nhap.php" method="post" class="niceform" name="form1" id="form1">
         
                <fieldset>
                    <dl>
                        <dt><label for="email">Username:</label></dt>
                        <dd><input type="text" name="ten_dang_nhap" id="user" size="54" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="password">Password:</label></dt>
                        <dd><input type="password" name="mat_khau" id="password" size="54" /></dd>
                    </dl>
                    
                    <dl>
                        <dt><label></label></dt>
                        <dd>
                    <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Remember me</label>
                        </dd>
                    </dl>
                    
                     <dl class="submit">
                    <input type="submit" name="submit" id="submit" value="Đăng nhập" />
                     </dl>
                    
                </fieldset>
                
         </form>
         </div>  
          
	
    
    <div class="footer_login">
    
    	<div class="left_footer_login">PHU THANH VALVE ADMIN PANEL | Powered by <a href="http://thinghost.co.vu">GhoSter..,Inc</a></div>
    	<div class="right_footer_login"><a href="http://thinghost.co.vu"><img src="images/ghoster_logo.png" alt="" title="" border="0" /></a></div>
    
    </div>

</div>		
</body>
</html>