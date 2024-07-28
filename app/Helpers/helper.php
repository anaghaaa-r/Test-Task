<?php


function getRole($index)
{
    $roles = [
        0 => 'User',
        1 => 'Admin'
    ];

    return $roles[$index];
}


function acceptance($index)
{
    $status = [
        0 => 'Waiting to accept',
        1 => 'Accepted'
    ];

    return $status[$index];
}

function status($index)
{
    $status = [
        0 => 'Incomplete',
        1 => 'Completed'
    ];

    return $status[$index];
}