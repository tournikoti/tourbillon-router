<?php

return array(
    'home' => array(
        'url' => '',
        'controller' => 'Index',
        'action' => 'index'
    ),
    'profil' => [
        'url' => 'profil/(:username)',
        'controller' => 'Utilisateur',
        'action' => 'profil',
        'params' => [
            'username' => "[a-z0-9]+"
        ]
    ]
);
