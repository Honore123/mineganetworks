<?php

function setActive($path, $active = 'active')
{
    return call_user_func_array('Request::is', (array) $path) ? $active : '';
}

function showCollapse($path, $active = 'show')
{
    return call_user_func_array('Request::is', (array) $path) ? $active : '';
}
