<?php

header('Content-Type: application/json');

$clearKey = md5('majorapi-web');

if (array_key_exists('clearKey', $_GET) && $_GET['clearKey'] == $clearKey) {
    apc_clear_cache();
    apc_clear_cache('user');
    apc_clear_cache('opcode');

    echo(json_encode(['success' => 1]));
} else {
    echo(json_encode(['success' => 0]));
}

exit(0);
