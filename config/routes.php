<?php
// config/routes.php

return [
    'POST' => [
        '/admin/login' => ['AdminController', 'login'],
    ],
    'GET' => [
        '/admin/dashboard' => ['AdminController', 'dashboard'],
    ],
];
