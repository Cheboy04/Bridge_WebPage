<?php

return [
    'roles' => [
        'admin' => 'Administrador',
        'editor' => 'Editor',
    ],
    'modes' => [
        'documento' => 'Documento (traducción)',
        'cabina' => 'Cabina (interpretación)',
    ],
    'services' => [
        'model' => 'servicio',
        'plural' => 'servicios',
        'fields' => [
            'title' => 'Título',
            'slug' => 'Slug (URL)',
            'mode' => 'Modo',
            'summary' => 'Resumen',
            'body' => 'Contenido',
            'icon' => 'Icono',
            'icon_help' => 'Nombre del icono del sistema, p. ej. stamp o headphones.',
            'image' => 'Imagen',
            'turnaround' => 'Plazo de entrega',
            'featured' => 'Destacado',
            'published' => 'Publicado',
            'seo_title' => 'Título SEO',
            'seo_description' => 'Descripción SEO',
        ],
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
