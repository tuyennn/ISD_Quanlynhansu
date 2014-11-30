<?php 
require_once('includes/functions.php');
require_once("includes/initialize.php");
if ( !isset($_SESSION['logged-in']) || $_SESSION['logged-in'] !== true) {
	header('Location: dang_nhap.php');
	exit;
}
$title = get_param('title');
if ($title == "") $title = 'Danh sách nhân viên';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHU THANH VALVE ADMIN PANEL | Powered by GhoSter..,Inc</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link href="css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/jquery.datepick.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/ddaccordion.js" type="text/javascript" charset="utf-8"></script>    
<script type="text/javascript" src="js/jquery.plugin.js"></script> 
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript" src="js/jquery.datepick-vi.js"></script>
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
<script src="js/jquery.jclock-1.2.0.js" type="text/javascript"></script>
<script src="js/jconfirmaction.jquery.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});
	
</script>
<script type="text/javascript">
$(function($) {
    $('.jclock').jclock();
});
</script>

<script src="js/niceforms.js" type="text/javascript" charset="utf-8"></script>

</head>
<body>
<div id="main_container">

	<div class="header">
    <div class="logo"><a href="#"><img src="images/logo.png" alt="" title="" border="0" /></a></div>
    
    <div class="right_header">Kính Chào Admin |<a href="#" class="messages">(3) Tin Nhắn</a>| <a href="dang_xuat.php" class="logout">Đăng xuất</a></div>
    <div class="jclock"></div>
    </div>
    
    <div class="main_content">
    
                    <div class="menu">
                    <ul>
                    <li><a class="current" href="index.php">Admin Home</a></li>
					
					<li><a href="#">Chức Năng<!--[if IE 7]><!--></a><!--<![endif]-->
                    <!--[if lte IE 6]><table><tr><td><![endif]-->
                        <ul>
							<li><a href="#">Quản Lý Nhân Viên</a>
								<ul>
									<li><a href="index.php?require=them_moi_nhan_vien.php&title=Thêm mới nhân viên">Thêm mới nhân viên</a></li>
									<li><a href="index.php?require=danh_sach_nhan_vien.php&title=Danh sách nhân viên">Danh sách nhân viên</a></li>
									<li><a href="index.php?require=danh_sach_nhan_vien_nghi.php&title=Danh sách nghỉ việc">Danh sách nghỉ việc</a></li>
								</ul>
							</li>
							<li><a href="#">Báo cáo</a></li>
						</ul>
                    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                    </li>
					
                    <li><a href="#">Quản Lý<!--[if IE 7]><!--></a><!--<![endif]-->
                    <!--[if lte IE 6]><table><tr><td><![endif]-->
                        <ul>
							<li><a href="index.php?require=them_danh_muc.php&table=tlb_phongban&title=Phòng ban&column=phong_ban&action=new">Quản Lý Phòng ban</a></li>
							<li><a href="index.php?require=them_danh_muc.php&table=tlb_ctcongviec&title=Công việc&column=cong_viec&action=new">Quản Lý Công việc</a></li>
							<li><a href="index.php?require=them_danh_muc.php&table=tlb_chucvu&title=Chức vụ&column=chuc_vu&action=new">Quản Lý Chức vụ</a></li>
							<li><a href="index.php?require=them_danh_muc.php&table=tlb_hocvan&title=Học vấn&column=hoc_van&action=new">Quản Lý Học vấn</a></li>
							<li><a href="index.php?require=them_danh_muc.php&table=tlb_bangcap&title=Bằng cấp&column=bang_cap&action=new">Quản Lý Bằng cấp</a></li>
							<li><a href="index.php?require=them_danh_muc.php&table=tlb_ngoaingu&title=Ngoại ngữ&column=ngoai_ngu&action=new">Quản Lý Ngoại ngữ</a></li>
							<li><a href="index.php?require=them_danh_muc.php&table=tlb_tinhoc&title=Tin học&column=tin_hoc&action=new">Quản Lý Tin học</a></li>
							<li><a href="index.php?require=them_danh_muc.php&table=tlb_dantoc&title=Dân tộc&column=dan_toc&action=new">Quản Lý Dân tộc</a></li>
							<li><a href="index.php?require=them_danh_muc.php&table=tlb_quoctich&title=Quốc tịch&column=quoc_tich&action=new">Quản Lý Quốc tịch</a></li>
							<li><a href="index.php?require=them_danh_muc.php&table=tlb_tongiao&title=Tôn giáo&column=ton_giao&action=new">Quản Lý Tôn giáo</a></li>
							<li><a href="index.php?require=them_danh_muc.php&table=tlb_tinhthanh&title=Tỉnh thành&column=tinh_thanh&action=new">Quản Lý Tỉnh thành</a></li>
                        </ul>
                    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                    </li>
                    <li><a href="#">Công Cụ</a>
						<ul><li><a href="module/backup/backup.php?login=root&pass=vertrigo">Sao lưu</a></li></ul>
					</li>
                    <li><a href="#">Liên Hệ</a></li>
					
					<li><a href="#">Hệ thống<!--[if IE 7]><!--></a><!--<![endif]-->
                    <!--[if lte IE 6]><table><tr><td><![endif]-->
                        <ul>
                        <li><a href="index.php?require=them_nguoi_dung.php&title=Người dùng" title="">Quản Trị Người Dùng</a></li>
                        <li><a href="dang_nhap.php">Đăng nhập</a></li>
						<li><a href="dang_xuat.php">Đăng xuất</a></li>
                        </ul>
                    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                    </li>
					
                    </ul>
                    </div> 
                    
                    
                    
                    
    <div class="center_content">  
    
    
    
    <div class="left_content">
    
    		<div class="sidebar_search">
            <form name="fsearch">
            <input type="text" name="keyword" class="search_input" value="Từ Khóa Tìm Kiếm" onclick="this.value=''" />
            <input type="image" class="search_submit" src="images/search.png" />
            </form>            
            </div>
    
            <div class="sidebarmenu">
            
                <a class="menuitem submenuheader" href="">Chức Năng Quản Lý</a>
                <div class="submenu">
                    <ul>
                    <li><a href="index.php?require=them_moi_nhan_vien.php&title=Thêm mới nhân viên">Thêm mới nhân viên</a></li>
					<li><a href="index.php?require=danh_sach_nhan_vien.php&title=Danh sách nhân viên">Danh sách nhân viên</a></li>
					<li><a href="index.php?require=danh_sach_nhan_vien_nghi.php&title=Danh sách nghỉ việc">Danh sách đã nghỉ việc</a></li>
                    </ul>
                </div>
                <a class="menuitem submenuheader" href="" >Thống Kê Quản Lý</a>
                <div class="submenu">
                    <ul>
                    <li><a href="index.php?require=them_danh_muc.php&table=tlb_phongban&title=Phòng ban&column=phong_ban&action=new">Quản Lý Phòng ban</a></li>
					<li><a href="index.php?require=them_danh_muc.php&table=tlb_ctcongviec&title=Công việc&column=cong_viec&action=new">Quản Lý Công việc</a></li>
					<li><a href="index.php?require=them_danh_muc.php&table=tlb_chucvu&title=Chức vụ&column=chuc_vu&action=new">Quản Lý Chức vụ</a></li>
					<li><a href="index.php?require=them_danh_muc.php&table=tlb_hocvan&title=Học vấn&column=hoc_van&action=new">Quản Lý Học vấn</a></li>
					<li><a href="index.php?require=them_danh_muc.php&table=tlb_bangcap&title=Bằng cấp&column=bang_cap&action=new">Quản Lý Bằng cấp</a></li>
					<li><a href="index.php?require=them_danh_muc.php&table=tlb_ngoaingu&title=Ngoại ngữ&column=ngoai_ngu&action=new">Quản Lý Ngoại ngữ</a></li>
					<li><a href="index.php?require=them_danh_muc.php&table=tlb_tinhoc&title=Tin học&column=tin_hoc&action=new">Quản Lý Tin học</a></li>
					<li><a href="index.php?require=them_danh_muc.php&table=tlb_dantoc&title=Dân tộc&column=dan_toc&action=new">Quản Lý Dân tộc</a></li>
					<li><a href="index.php?require=them_danh_muc.php&table=tlb_quoctich&title=Quốc tịch&column=quoc_tich&action=new">Quản Lý Quốc tịch</a></li>
					<li><a href="index.php?require=them_danh_muc.php&table=tlb_tongiao&title=Tôn giáo&column=ton_giao&action=new">Quản Lý Tôn giáo</a></li>
					<li><a href="index.php?require=them_danh_muc.php&table=tlb_tinhthanh&title=Tỉnh thành&column=tinh_thanh&action=new">Quản Lý Tỉnh thành</a></li>
                    </ul>
                </div>
                <a class="menuitem submenuheader" href="">Tiền Lương & Thưởng</a>
                <div class="submenu">
                    <ul>
                    <li><a href="">Quản Lý Mức Lương</a></li>
                    <li><a href="">Quản Lý Bậc Lương</a></li>
                    <li><a href="">Quản Lý Thưởng</a></li>
                    </ul>
                </div>
                <a class="menuitem" href="">Bảo Hiểm Xã Hội</a>
                
                <a class="menuitem submenuheader" href="">Xuất Dữ Liệu</a>
                <div class="submenu">
                    <ul>
                    <li><a href="">Xuất Dữ Liệu Ra PDF</a></li>
                    <li><a href="">Xuất Dữ Liệu Ra Excel</a></li>
                    </ul>
                </div>
                <a class="menuitem_red" href="">Sao Lưu</a>
                    
            </div>
            
            
            <div class="sidebar_box">
                <div class="sidebar_box_top"></div>
                <div class="sidebar_box_content">
                <h3>User help desk</h3>
                <img src="images/info.png" alt="" title="" class="sidebar_icon_right" />
                <p>
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>                
                </div>
                <div class="sidebar_box_bottom"></div>
            </div>
            
            <div class="sidebar_box">
                <div class="sidebar_box_top"></div>
                <div class="sidebar_box_content">
                <h4>Important notice</h4>
                <img src="images/notice.png" alt="" title="" class="sidebar_icon_right" />
                <p>
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>                
                </div>
                <div class="sidebar_box_bottom"></div>
            </div>
            
            <div class="sidebar_box">
                <div class="sidebar_box_top"></div>
                <div class="sidebar_box_content">
                <h5>Download photos</h5>
                <img src="images/photo.png" alt="" title="" class="sidebar_icon_right" />
                <p>
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>                
                </div>
                <div class="sidebar_box_bottom"></div>
            </div>  
            
            <div class="sidebar_box">
                <div class="sidebar_box_top"></div>
                <div class="sidebar_box_content">
                <h3>To do List</h3>
                <img src="images/info.png" alt="" title="" class="sidebar_icon_right" />
                <ul>
                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                 <li>Lorem ipsum dolor sit ametconsectetur <strong>adipisicing</strong> elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
                  <li>Lorem ipsum dolor sit amet, consectetur <a href="#">adipisicing</a> elit.</li>
                   <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                     <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                </ul>                
                </div>
                <div class="sidebar_box_bottom"></div>
            </div>
              
    
    </div>  
    
    <div class="right_content">            
    
    <!--TITLE of the main table-->    
    <h2><?php echo $title; ?></h2>


    <!--Main table HERE-->  
    <?php
            $require = get_param('require');
            if($require ==""){$require = "danh_sach_nhan_vien.php";}
            require_once $require; 
    ?> 
     
    <div class="pagination">
    <span class="disabled"><< prev</span><span class="current">1</span><a href="">2</a><a href="">3</a><a href="">4</a><a href="">5</a>…<a href="">10</a><a href="">11</a><a href="">12</a>...<a href="">100</a><a href="">101</a><a href="">next >></a>
    </div> 
     
    <h2>Warning Box examples</h2>
      
    <div class="warning_box">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.
    </div>
    <div class="valid_box">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.
    </div>
    <div class="error_box">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.
    </div>  
           
    <h2>Nice Form example</h2>
     
        <div class="form">
        <form action="" method="post" class="niceform">
         
            <fieldset>
                <dl>
                    <dt><label for="email">Email Address:</label></dt>
                    <dd><input type="text" name="" id="" size="54" /></dd>
                </dl>
                    <dl>
                        <dt><label for="password">Password:</label></dt>
                        <dd><input type="text" name="" id="" size="54" /></dd>
                    </dl>
                    
                    
                    <dl>
                        <dt><label for="gender">Select categories:</label></dt>
                        <dd>
                            <select size="1" name="gender" id="">
                                <option value="">Select option 1</option>
                                <option value="">Select option 2</option>
                                <option value="">Select option 3</option>
                                <option value="">Select option 4</option>
                                <option value="">Select option 5</option>
                            </select>
                        </dd>
                    </dl>
                    <dl>
                        <dt><label for="interests">Select tags:</label></dt>
                        <dd>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Web design</label>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Business</label>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Simple</label>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Clean</label>
                        </dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="color">Select type</label></dt>
                        <dd>
                            <input type="radio" name="type" id="" value="" /><label class="check_label">Basic</label>
                            <input type="radio" name="type" id="" value="" /><label class="check_label">Medium</label>
                            <input type="radio" name="type" id="" value="" /><label class="check_label">Premium</label>
                        </dd>
                    </dl>
                    
                    
                    
                    <dl>
                        <dt><label for="upload">Upload a File:</label></dt>
                        <dd><input type="file" name="upload" id="upload" /></dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="comments">Message:</label></dt>
                        <dd><textarea name="comments" id="comments" rows="5" cols="36"></textarea></dd>
                    </dl>
                    
                    <dl>
                        <dt><label></label></dt>
                        <dd>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">I agree to the <a href="#">terms &amp; conditions</a></label>
                        </dd>
                    </dl>
                    
                     <dl class="submit">
                    <input type="submit" name="submit" id="submit" value="Submit" />
                     </dl>
                     
                     
                    
                </fieldset>
                
        </form>
        </div>  
      
     
    </div><!-- end of right content-->
            
                    
</div>   <!--end of center content -->               
                    
                    
    
    
    <div class="clear"></div>
    </div> <!--end of main content-->
	
    
    <div class="footer">
    
    	<div class="left_footer">PHU THANH VALVE ADMIN PANEL | Powered by <a href="http://thinghost.co.vu">GhoSter..,Inc</a></div>
    	<div class="right_footer"><a href="http://thinghost.co.vu"><img src="images/ghoster_logo.png" alt="" title="" border="0" /></a></div>
    
    </div>

</div>
<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/tooltip.js"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>		
</body>
</html>