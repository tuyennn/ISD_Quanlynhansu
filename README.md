ISD_Quanlynhansu
================

Publish Repository

+ Các bước chạy trên localhost
  - Clone(Fork) Repository này về máy
  - Cài xampp
  - Tạo thư mục tên ISD_Quanlynhansu(*) bên trong htdocs
  - Tạo database tên: phuthanh_quanlynhansu
  - Import database
  - Run
  
  (*) Bắt buộc nếu không phải sửa lại includes\initialize.php dòng:

  defined('SITE_ROOT') ? null : define ('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'].DS.'ISD_Quanlynhansu');
