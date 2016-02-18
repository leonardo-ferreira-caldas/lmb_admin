<?php

return [

    'routes' => [

        'crud' => [

            'list'   => 'listar-registros',
            'insert' => 'adicionar',
            'update' => 'editar',
            'delete' => 'deletar'

        ]

    ],

    'formatters' => [

        'currency' => App\Helpers\Formatters\Currency::class,
        'date'     => App\Helpers\Formatters\Date::class,
        'datetime' => App\Helpers\Formatters\Datetime::class

    ]

];