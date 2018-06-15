<?php

$config = array(
    'name' => 'Article',
    'schema' =>
    array(
        [
            'name' => '@context',
            'default' => 'Auto-generated',
            'placeholder' => 'Auto-generated',
            'blocked' => true,
            'type' => 'text',
        ],
        [
            'name' => 'publisher',
            'default' => 'Organization',
           
            'blocked' => true,
            'options' => [
                'CreativeWork',
                'Organization',
                'Person',
            ],
            'type' => 'select',
        ]
    ),
);


