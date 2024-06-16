<?php
    include "../connect/session.php";

    unset($_SESSION["memberID"]);
    unset($_SESSION["youID"]);

    Header("Location: ../index.php")
?>