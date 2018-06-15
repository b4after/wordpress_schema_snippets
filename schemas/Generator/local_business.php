<?php

$config = array(
    'name' => 'LocalBusiness',
    'schema' =>
    array(
        [
            'name' => '@context',
            'default' => 'http://schema.org',
            'placeholder' => 'http://schema.org',
            'blocked' => true,
            'type' => 'text',
        ],
        [
            'name' => '@type',
            'options' => [
                'LocalBusiness',
                'AnimalShelter',
                'AutomotiveBusiness',
                'ChildCare',
                'Dentist',
                'DryCleaningOrLaundry',
                'EmergencyService',
                'EmploymentAgency',
                'EntertainmentBusiness',
                'FinancialService',
                'FoodEstablishment',
                'GovernmentOffice',
                'HealthAndBeautyBusiness',
                'HomeAndConstructionBusiness',
                'InternetCafe',
                'LegalService',
                'Library',
                'LodgingBusiness',
                'ProfessionalService',
                'RadioStation',
                'RealEstateAgent',
                'RecyclingCenter',
                'SelfStorage',
                'ShoppingCenter',
                'SportsActivityLocation',
                'Store',
                'TelevisionStation',
                'TouristInformationCenter',
                'TravelAgency',
            ],
            'default' => 'LocalBusiness',
            'placeholder' => 'Schema Type',
            'type' => 'select',
        ],
        [
            'name' => 'name',
            'default' => '',
            'placeholder' => 'Business name',
            'type' => 'text',
        ],
        [
            'name' => 'image',
            'default' => '',
            'placeholder' => 'Image URL',
            'type' => 'text',
        ],
        [
            'name' => '@id',
            'default' => '',
            'placeholder' => '@id URL',
            'type' => 'text',
        ],
        [
            'name' => 'url',
            'default' => '',
            'placeholder' => 'Website url',
            'type' => 'text',
        ],
        [
            'name' => 'telephone',
            'default' => '',
            'placeholder' => 'Phone',
            'type' => 'text',
        ],
        [
            'name' => 'faxNumber',
            'default' => '',
            'placeholder' => 'FAX',
            'type' => 'text',
        ],
        [
            'name' => 'email',
            'default' => '',
            'placeholder' => 'Mail address',
            'type' => 'text',
        ],
        [
            'type' => 'array',
            'name' => 'address',
            'placeholder' => 'Address',
            'options' => [
                [
                    'name' => '@type',
                    'default' => 'PostalAddress',
                    'placeholder' => 'PostalAddress',
                    'type' => 'text',
                    'blocked' => true,
                ],
                [
                    'name' => 'streetAddress',
                    'default' => '',
                    'placeholder' => 'Street',
                    'type' => 'text',
                ],
                [
                    'name' => 'addressLocality',
                    'default' => '',
                    'placeholder' => 'City',
                    'type' => 'text',
                ],
                [
                    'name' => 'postalCode',
                    'default' => '',
                    'placeholder' => 'Zip Code',
                    'type' => 'text',
                ],
                [
                    'name' => 'addressCountry',
                    'default' => 'PL',
                    'placeholder' => 'Code for Country',
                    'type' => 'text',
                ],
                [
                    'name' => 'addressRegion',
                    'default' => '',
                    'placeholder' => 'Code for Region',
                    'type' => 'text',
                ],
            ]
        ],
        [
            'type' => 'array',
            'name' => 'openingHoursSpecification',
            'placeholder' => 'Open hours',
            'options' =>
            [
                [
                    'name' => 'dayOfWeek',
                    'default' => '',
                    'placeholder' => 'ex. Monday',
                    'type' => 'array',
                    'options' => [
                        [
                            'name' => 'opens',
                            'default' => '',
                            'placeholder' => 'Open hour',
                            'type' => 'text',
                        ],
                        [
                            'name' => 'closes',
                            'default' => '',
                            'placeholder' => 'Closes hour',
                            'type' => 'text',
                        ],
                    ]
                ],
            ],
        ]
    ),
);


