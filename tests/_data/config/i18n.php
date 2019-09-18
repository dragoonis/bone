<?php

return [
    'i18n' => [
        'enabled' => false,
        'translations_dir' => 'tests/_data/translations',
        'type' => \Zend\I18n\Translator\Loader\Gettext::class,
        'default_locale' => 'en_GB',
        'supported_locales' => ['en_GB', 'nl_BE', 'fr_BE'],
    ],
];