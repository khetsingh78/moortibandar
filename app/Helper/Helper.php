<?php

function removeStorageFolderaImage($url)
{
    return explode('/', $url, 2)[1];;
}
