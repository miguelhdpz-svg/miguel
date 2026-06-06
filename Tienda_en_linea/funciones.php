<?php

function redirigir($url){
    echo "<script>location.href='$url';</script>";
}

function alerta($msg){
    return "<div id='aviso'>$msg</div>";
}

?>