ISD_Quanlynhansu
================

Publish Repository

+ Các bước chạy trên localhost
  - Clone(Fork) Repository này về máy
  - Cài xampp
  - Tạo thư mục tên ISD_Quanlynhansu (*)
  - Import database
  - Run
  
  (*) Bắt buộc nếu không phải sửa lại includes\initialize.php
  defined('SITE_ROOT') ? null : define ('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'].DS.'ISD_Quanlynhansu');