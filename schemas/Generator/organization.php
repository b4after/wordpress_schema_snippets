<?php

$config = [
    'name' => 'Organization',
    'schema' => array(
        [
            'name' => '@context',
            'default' => 'http://schema.org',
            'placeholder' => 'http://schema.org',
            'blocked' => true,
            'type' => 'text',
        ],
        [
            'name' => '@type',
            'default' => 'Organization',
            'placeholder' => 'Organization',
            'blocked' => true,
            'type' => 'text',
        ],
        [
            'name' => 'url',
            'default' => '',
            'placeholder' => 'http://www.example.com',
            'type' => 'text',
        ],
        [
            'name' => 'name',
            'default' => '',
            'placeholder' => 'Your Company name',
            'type' => 'text',
        ],
        [
            'type' => 'array',
            'name' => 'contactPoint',
            'placeholder' => 'Contact Point',
            'options' =>
            [
                [
                    'name' => '@type',
                    'default' => 'ContactPoint',
                    'placeholder' => 'ContactPoint',
                    'type' => 'text',
                    'blocked' => true,
                ],
                [
                    'name' => 'telephone',
                    'default' => '',
                    'placeholder' => 'Telephone',
                    'type' => 'text',
                ],
                [
                    'name' => 'contactType',
                    'default' => '',
                    'placeholder' => 'Contact type',
                    'type' => 'select',
                    'options' => [
                        'LocalBusiness',
                        'AnimalShelter',
                        'AutomotiveBusiness',
                    ]
                ],
            ],
        ],
    )
];
