<?php 
    require_once('includes/initialize.php'); 
?>

<?php
    $title = get_param('title');
    $action = get_param('action');
    $user_name = $_SESSION['user_name'];

    $chkbox = array('add', 'edit', 'delete');

    // Get the permission
    $checkSQL="SELECT quyen_them, quyen_sua, quyen_xoa FROM `tlb_nguoidung` WHERE ten_dang_nhap = '{$user_name}'";
    $mydb->setQuery($checkSQL);
    $RCCheckpermission = $mydb->executeQuery();
    $row_RCCheckpermission = $mydb->fetch_assoc($RCCheckpermission);
    $totalRows_RCcheckpermission = $mydb->num_rows($RCCheckpermission);

    // Get the action and delete if user execute the action
    if ($action=="del" && $row_RCCheckpermission['quyen_xoa'] == 1)
    {
    	$user = $_GET['catID'];
    	$deleteSQL = "DELETE FROM tlb_nguoidung WHERE id='$user'";                     
    	
        $mydb->setQuery($deleteSQL);
        $result_e = $mydb->executeQuery();
        if($result_e) {
            $message = "Thao tác xóa thành công!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $url = "index.php?require=them_nguoi_dung.php&title=Người dùng";
            location($url);
        }
        else {
            $message = "Thao tác xóa thất bại!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $url = "index.php?require=them_nguoi_dung.php&title=Người dùng";
            location($url);
        }

        $deleteGoTo = "them_danh_muc.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
            $deleteGoTo .= $_SERVER['QUERY_STRING'];
        }
        sprintf("location: %s", $deleteGoTo);
    }

    $editFormAction = htmlspecialchars($_SERVER["PHP_SELF"]);
    if (isset($_SERVER['QUERY_STRING'])) {
      $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
    }

    // Add new User when checked permission and got the checkboc values
    if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_user_form") && $row_RCCheckpermission['quyen_them'] == 1) {
        if (isset($_POST['permit'])) {
            $values = array();
            foreach ($chkbox as $selection) {
                if(in_array($selection, $_POST['permit'])) {
                    $values[$selection] = 1;
                }
                else {
                    $values[$selection] = 0;
                }
            }
        }
        else {
            $values = array();
            foreach ($chkbox as $selection) {
                $values[$selection] = 0;
            }
        }
        

        // Apply the sql command
        $insertSQL = sprintf("INSERT INTO tlb_nguoidung(ten_dang_nhap, mat_khau, quyen_them, quyen_sua, quyen_xoa) VALUES ('%s', '%s', '{$values['add']}', '{$values['edit']}', '{$values['delete']}')", get_param('username'), md5(get_param('pass_confirmation')));
        $mydb->setQuery($insertSQL);
        $result_c = $mydb->executeQuery();

        // Display the result to screen
        if($result_c) {
            $message = "Thao tác thêm mới thành công!";
            //$message = implode("|",$permit);
            echo "<script type='text/javascript'>alert('$message');</script>";
            $url = "index.php?require=them_nguoi_dung.php&title=Người dùng";
            location($url);
        }
        else {
            $message = "Thao tác thêm mới thất bại!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $url = "index.php?require=them_nguoi_dung.php&title=Người dùng";
            location($url);
        }

    }

    // Get All Administrator Users
    $mydb->setQuery("SELECT id, ten_dang_nhap FROM tlb_nguoidung");
    $RCDanhmuc_TM = $mydb->executeQuery();
    $row_RCDanhmuc_TM = $mydb->fetch_assoc($RCDanhmuc_TM);
    $totalRows_RCDanhmuc_TM = $mydb->num_rows($RCDanhmuc_TM);
?>


    <script type="text/javascript" src="js/jquery.min.js"></script>
    <!-- Check Administrator Exist Function -->
    <script type="text/javascript">
    pic1 = new Image(16, 16); 
    pic1.src = "images/loader.gif";
    $(document).ready(function(){
        $('#username').change(function(){ // Keyup function for check the user action in input
            var username = document.getElementById("username").value;
            //alert(username);
            var adminAvailResult = $('#admin_avail_result'); // Get the ID of the result where we gonna display the results
            if(username.length >= 4) { // check if greater than 4 (minimum 4)

                adminAvailResult.html('<img src="images/loader.gif" align="absmiddle">&nbsp;Đang kiểm tra khả dụng...'); // Preloader, use can use loading animation here
                var UrlToPass = 'action=admin_availability&username='+username;
                $.ajax({ // Send the ma_nhan_vien val to another includes/checker.php using Ajax in POST menthod
                    type : 'POST',
                    data : UrlToPass,
                    url  : 'includes/checker.php',
                    success: function(responseText){ // Get the result and asign to each cases
                        if(responseText == 0){
                            $("#username").removeClass('object_error'); // if necessary
                            $("#username").addClass("object_ok");
                            adminAvailResult.html('<span class="success">&nbsp;<img src="images/tick.gif" align="absmiddle"></span>');
                            $('#addUser').removeAttr('disabled');
                        }
                        else if(responseText > 0){
                            $("#username").removeClass('object_ok'); // if necessary
                            $("#username").addClass("object_error");
                            adminAvailResult.html('<span class="error">Tài khoản này đã sử dụng</span>');
                            $('#addUser').attr('disabled','disabled');
                        }

                        else{
                            alert('Lỗi cơ sở dữ liệu');
                        }
                    }
                });
            }else{
                adminAvailResult.html('<span class="error">Tài khoản dài hơn 4 ký tự</span>');
                $("#username").removeClass('object_ok'); // if necessary
                $("#username").addClass("object_error");
            }
            if(username.length == 0) {
                adminAvailResult.html('');
            }
        });
    
        $('#username').keydown(function(e) { // Dont allow users to enter spaces for admin and passwords
            if (e.which == 32) {
                return false;
            }
        });
    });
    </script>

    <!-- Check Permission Function -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('.editLink').click(function(e) {
                e.preventDefault();
                var ma_nguoi_dung = '<?php echo $_SESSION['user_name']; ?>';
                var quyen_sua = '<?php echo $row_RCCheckpermission['quyen_sua']; ?>'; // Get the edit permision
                var catID = $(this).attr('id'); // Get the CatID
                var title = '<?php echo $title; ?>'; // Get the title
                $.ajax({
                    type : 'POST',
                    url  : 'includes/checker.php',
                    data : {
                        action : 'quyen_sua_availability',
                        ma_nguoi_dung : ma_nguoi_dung,
                        quyen_sua : quyen_sua
                    },
                    success: function(result){
                        if (result == 0) {
                            alert('Bạn không có quyền sửa tài khoản!');
                        }
                        else if (result > 0){
                            var url = '?require=cap_nhat_nguoi_dung.php&table=tlb_nguoidung&catID='+catID+'&title='+title+'&action=edit';
                            window.location.href = url;
                        }
                        else {
                            alert('Database error!!!');
                        }
                    }
                });
            });

            $('.delLink').click(function(e) {
                e.preventDefault();
                var ma_nguoi_dung = '<?php echo $_SESSION['user_name']; ?>';
                var quyen_xoa = '<?php echo $row_RCCheckpermission['quyen_xoa']; ?>'; // Get the edit permision
                var catID = $(this).attr('id'); // Get the CatID
                var title = '<?php echo $title; ?>'; // Get the title
                $.ajax({
                    type : 'POST',
                    url  : 'includes/checker.php',
                    data : {
                        action : 'quyen_xoa_availability',
                        ma_nguoi_dung : ma_nguoi_dung,
                        quyen_xoa : quyen_xoa
                    },
                    success: function(result){
                        if (result == 0) {
                            alert('Bạn không có quyền sửa tài khoản!');
                        }
                        else if (result > 0){
                            if (confirm("Bạn có chắc chắn thao tác xóa!!")){
                                var url = 'index.php?require=them_nguoi_dung.php&table=tlb_nguoidung&catID='+catID+'&title='+title+'&action=del';
                                window.location.href = url;
                            }
                        }
                        else {
                            alert('Database error!!!');
                        }
                    }
                });
            });
        });
    </script>

    <table id="rounded-corner" width="750">
        <thead>
            <tr>
                <th width="25" class="rounded-content">STT</th>
                <th width="100">Mã</th>
                <th width="480">Tài khoản</th>
                <th width="100" colspan="2" align="center" class="rounded-q4">Thao tác</th>
            </tr>
        </thead>

        <?php 
        $stt = 1;
        

        do { ?>
            <tr>
                <td align="center"><?php echo $stt;?></td>
                <td><?php echo sprintf("%03d", $row_RCDanhmuc_TM['id']); ?></td>
                <td><?php echo $row_RCDanhmuc_TM['ten_dang_nhap']; ?></td>
                <td align="center">
                    <?php 
                        echo '<a href="#" class="editLink" id="' .$row_RCDanhmuc_TM['id'] .'">' 
                    ?>
                        <img src="images/user_edit.png" alt="Sửa" title="" border="0" />
                    </a>
                </td>

                <td align="center">
                        <?php
                            echo '<a href="#" class="delLink" id="' .$row_RCDanhmuc_TM['id'] .'">'
                        ?>
                        <img src="images/trash.png" alt="Xóa" title="" border="0" />
                    </a>

                </td>
            </tr>
        <?php 
        $stt++;
            } while ($row_RCDanhmuc_TM = $mydb->fetch_assoc($RCDanhmuc_TM)); ?>
    </table>

    <form action="<?php echo $editFormAction; ?>" method="post" name="new_user_form" id="new_user_form">
        <table id="rounded-corner" width="750" cellpadding="2" cellspacing="2" bgcolor="#66CCFF">
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Tên tài khoản:</td>
                <td><input type="text" name="username" id="username" value="" size="30" data-validation="required"/></td>
                <td><div class="admin_avail_result" id="admin_avail_result"></div></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Mật khẩu:</td>
                <td><input type="password" name="pass_confirmation" value="" size="30" data-validation="length" data-validation-length="min4" data-validation-error-msg="Mật khẩu dài trên 4 ký tự"/></td>
                <td width="500"></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Xác nhận Mật khẩu:</td>
                <td><input type="password" name="pass" value="" size="30" data-validation="confirmation"/></td>
                <td width="500"></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Quyền hạn:</td>
                <td>
                    <input type="checkbox" name="permit[]" value="add"><label>Thêm</label><br/>
                    <input type="checkbox" name="permit[]" value="edit"><label>Sửa</label><br/>
                    <input type="checkbox" name="permit[]" value="delete"><label>Xóa</label><br/>
                </td>
                <td colspan="2" width="500"></td>
            </tr>
            <tr>
                <td colspan="3" align="right">
                    <button class="btn btn-default" onclick="new_user_form.reset();">Làm lại</button>
                    <input type="submit" onClick="ConfirmCreate()" class="btn btn-default" name="submit" id="addUser" value="Thêm mới người dùng" />
                    <script type="text/javascript">
                    function ConfirmCreate()
                    {   
                        var addpermission = <?php echo $row_RCCheckpermission['quyen_them']; ?>;
                        if (addpermission == 0) {
                            alert('Bạn không có quyền thêm tài khoản người dùng!');
                        }
                        if (addpermission == 1) {
                            if (confirm("Bạn có chắc chắn thao tác thêm mới!"))
                            {
                                new_user_form.submit();
                                return false;
                            }
                        }
                    }
                    </script>
                </td>
            </tr>
            <input type="hidden" name="MM_insert" value="new_user_form" />
        </table>
    </form>
    <script src="js/form-validator/jquery.form-validator.min.js"></script>
    <script src="js/form-validator/locale.vi.js"></script>
    <script>
    /* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
        $.validate({
            modules : 'security',
            language : enErrorDialogs
        });
    </script>
