<?php
    if(!isset($_SESSION['memberID'])){
        echo "<script>alert('로그인을 해주세요!!')</script>";
        echo "<script>window.location.href='../index.php';</script>";
    }
?>
