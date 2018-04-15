<?php

require_once '../include/layout.inc';



$base = new Layout;

$base->link = '../include/style.css';



$base->LayoutMain();



unset($_SESSION['id']);

unset($_SESSION['permit']);

session_destroy();



echo "<script>alert('로그아웃 되었습니다.');location.replace('/')</script>";

?>