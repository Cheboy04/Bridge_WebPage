<?php

return [
    'roles' => [
        'admin' => 'Administrador',
        'editor' => 'Editor',
    ],
    'users' => [
        'model' => 'usuario',
        'plural' => 'usuarios',
        'fields' => [
            'name' => 'Nombre',
            'email' => 'Correo electrónico',
            'password' => 'Contraseña',
            'password_help' => 'Déjela en blanco para conservar la actual.',
            'role' => 'Rol',
            'created_at' => 'Creado',
        ],
    ],
];
