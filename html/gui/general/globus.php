<?php
require_once __DIR__ . '/../../../configuration/linker.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style type="text/css">
        body, table {
            font-family: arial;
            font-size: 18px;
            color: #00f;
            background-color: #e8e8e8;
        }
        .login_message {
            color: #55f;
            font-size: 14px;
        }
        .error_message{
        color: #f00;
        text-align: center;
        }
    </style>
    <script type="text/javascript">
    function loadPortal() {
        setTimeout(function(){
        parent.location.href = '/index.php';
        }, 2000);
    }
    </script>
    <?php

    ExtJS::loadSupportScripts('../lib');

    ?>
</head>
<body>
    <div id='loginFrm'>
        <label for='login'>Login to XDMOD via Globus Auth: </label>
        <a href='#' id='login'/a>
    </div>

    <script>            
    new Ext.Button({
        text: 'Sign In',
        width: 80,
        handler: function () {
            parent.XDMoD.TrackEvent('Login Window', 'Clicked on Sign In button');
            window.location = '../../simplesaml/module.php/core/as_login.php?AuthId=xdmod-sp&ReturnTo=../../../login.php';
        },
        renderTo: 'login'
    });
    </script>
</body>
</html>