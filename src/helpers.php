<?php

function getJson($body, $status = 200)
{
    return json_encode([
        'status' => $status,
        'body' => $body
    ]);
}
