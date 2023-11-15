<?php

function passgen1($nbChar)
{
    $chaine = "ABCDEFGHIJKLMONOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789&é'(-è_çà)=$^*ù!:;,~#{[|`\^@]}¤€";
    $pass = '';
    $len = strlen($chaine);
    for ($i = 0; $i < $nbChar; $i++) {
        $rnd = random_int(0,$len-1);
        $char = $chaine[$rnd];
        $pass .= $char;
    }
    return mb_convert_encoding($pass,"UTF-8");
}
