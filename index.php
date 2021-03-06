<?php 
    require_once('includes/functions.php');
    require_once("includes/initialize.php");
    if ( !isset($_SESSION['logged-in']) || $_SESSION['logged-in'] !== true) {
    	header('location: dang_nhap.php');
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
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.min.nav.js"></script>
<script src="js/niceforms.js" type="text/javascript" charset="utf-8"></script>
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

	<div class="header">
    <div class="logo"><a href="#"><img src="images/logo.png" alt="" title="" border="0" /></a></div>
    
    <div class="right_header">Kính Chào Administrator: <?php echo $_SESSION['user_name'] ;?> || <a href="dang_xuat.php" class="logout">Đăng xuất</a></div>
        <script>
            $(document).on("click", ".logout", (function() {
                $.growl("<strong>Đăng xuất thành công</strong>", { 
                    type: "success"
                });
            }); 
        </script> 
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
						</ul>
                    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                    </li>
					
                    <li><a href="#">Thống Kê<!--[if IE 7]><!--></a><!--<![endif]-->
                    <!--[if lte IE 6]><table><tr><td><![endif]-->
                        <ul>
							<li><a href="index.php?require=them_danh_muc.php&table=tlb_phongban&title=Thống kê Phòng ban&column=phong_ban&action=new">Thống kê Phòng ban</a></li>
                            <li><a href="index.php?require=them_danh_muc.php&table=tlb_ctcongviec&title=Thống kê Mảng công việc&column=cong_viec&action=new">Thống kê Mảng công việc</a></li>
                            <li><a href="index.php?require=them_danh_muc.php&table=tlb_chucvu&title=Thống kê Chức vụ&column=chuc_vu&action=new">Thống kê Chức vụ</a></li>
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
                <a class="menuitem submenuheader" href="" >Thống Kê</a>
                <div class="submenu">
                    <ul>
                    <li><a href="index.php?require=them_danh_muc.php&table=tlb_phongban&title=Thống kê Phòng ban&column=phong_ban&action=new">Thống kê Phòng ban</a></li>
					<li><a href="index.php?require=them_danh_muc.php&table=tlb_ctcongviec&title=Thống kê Mảng công việc&column=cong_viec&action=new">Thống kê Mảng công việc</a></li>
					<li><a href="index.php?require=them_danh_muc.php&table=tlb_chucvu&title=Thống kê Chức vụ&column=chuc_vu&action=new">Thống kê Chức vụ</a></li>
                    </ul>
                </div>
                
                <a class="menuitem submenuheader" href="">Xuất Dữ Liệu</a>
                <div class="submenu">
                    <ul>
                    <li><a href="index.php?require=them_moi_tai_lieu.php&title=Quản lý tài liệu">Quản Lý Mẫu Biểu Công Ty</a></li>
                    </ul>
                </div>
                <a class="menuitem_red" href="">Sao Lưu</a>
                    
            </div>
            
            <div class="sidebar_box">
                <div class="sidebar_box_top"></div>
                <div class="sidebar_box_content">
                <h4>Ghi Chú</h4>
                <img src="images/notice.png" alt="" title="" class="sidebar_icon_right" />
                <p>
                    Thông báo họp giao ban công ty vào....
                </p>                
                </div>
                <div class="sidebar_box_bottom"></div>
            </div>
            
            <div class="sidebar_box">
                <div class="sidebar_box_top"></div>
                <div class="sidebar_box_content">
                <h5>Kho tài liệu</h5>
                <img src="images/photo.png" alt="" title="" class="sidebar_icon_right" />
                <ul>
                <?php
                    $upload_dir = 'uploads/documents/';
                    $sql="SELECT * FROM tlb_tailieu ORDER BY id LIMIT 4";
                    $rs=mysql_query($sql) or die('Cannot select document');
                    while($row=mysql_fetch_array($rs)){
                        echo '<li><a href="../'.FOLDER.'/'.$upload_dir.$row['filename'].'">'.$row['title'].'</a></li>';
                    }
                ?>
                </ul>              
                </div>
                <div class="sidebar_box_bottom"></div>
            </div>

            <div class="sidebar_box">
                <div class="sidebar_box_top"></div>
                <div class="sidebar_box_content">
                <h3>Cần trợ giúp?</h3>
                <img src="images/info.png" alt="" title="" class="sidebar_icon_right" />
                <p>
                    Hãy gọi số (+84)0973874452 để được tư vấn và bảo trì phần mềm. Hoặc gửi thư về địa chỉ mail: <a href="mailto:thinghost76@gmail.com?Subject=[Bảo Trì Quản Lý Nhân Sự]" target="_top">thinghost76@gmail.com</a>  
                </p>
                              
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
        <span class="disabled"><< prev</span><span class="current">1</span><a href="#">2</a><a href="#">3</a><a href="#">4</a><a href="#">5</a>…<a href="#">10</a><a href="#">11</a><a href="#">12</a>...<a href="#">100</a><a href="#">101</a><a href="#">next >></a>
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
    <script src="js/bootstrap.min.js"></script>
</body>
</html>