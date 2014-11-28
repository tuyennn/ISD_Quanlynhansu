<?php
function page_transfer($msg,$page="index.php")
{
     $showtext = $msg;
     $page_transfer = $page;
     include("transfer_page.php");
     exit();
     }
?>