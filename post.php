<?php
session_start();
if(isset($_SESSION['name'])){
    $text = $_POST['text'];
    $url = $_POST['url'];
    $text_message = "<p class='chatTime'><strong>".$_SESSION['name']."</strong>&nbsp|&nbsp".date("g:i A")."</p><div class='chatTextSelf'><p>".stripslashes(htmlspecialchars($text))."</p></div>";

    if($text != ''){file_put_contents($url, $text_message, FILE_APPEND | LOCK_EX);}
}
?>