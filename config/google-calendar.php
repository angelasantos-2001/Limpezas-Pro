<?php

return [

    /*
     * O perfil de autenticação por defeito a usar.
     */
    'default_auth_profile' => 'service_account',

    /*
     * Os perfis de autenticação disponíveis.
     */
    'auth_profiles' => [

        /*
         * Autenticação via Conta de Serviço (Service Account).
         */
        'service_account' => [
            'credentials_json' => storage_path('app/google-calendar/service-account-credentials.json'),
        ],

        /*
         * Autenticação via OAuth (se aplicável).
         */
        'oauth' => [
            'credentials_json' => storage_path('app/google-calendar/oauth-credentials.json'),
            'token_json' => storage_path('app/google-calendar/oauth-token.json'),
        ],
    ],

    /*
     * O ID do calendário que a aplicação vai gerir por defeito.
     * Pode definir o ID diretamente aqui ou no seu ficheiro .env
     */
    'calendar_id' => env('GOOGLE_CALENDAR_ID'),
];