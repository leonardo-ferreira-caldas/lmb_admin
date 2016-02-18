<?php

namespace App\Http\Cruds;

use App\Helpers\Datatable\Actions\DatatableActionsBuilder;
use App\Http\Cruds\BaseCrud;
use DB;

class CidadeCrud extends BaseCrud
{
    protected $table = 'cidade';
    protected $ajax = true;
    protected $hidden = ['created_at', 'updated_at'];

    protected function setupDatatableColumns() {
        return [
            'id_cidade' => [
                'width' => '5%',
                'label' => 'Código'
            ],
            'fk_estado' => [
                'width' => '10%',
                'type' => selectTable('estado', 'id_estado')->defaultText('Todos')
            ]
        ];
    }

    protected function setupFormFields() {
        return [
            'id_cidade' => [
                'insert' => [
                    'disabled' => true
                ],
                'update' => [
                    'readonly' => true
                ]
            ],
            'fk_estado' => [
                'type' => selectTable('estado', 'id_estado', 'nome_estado')->defaultText("Selecione um estado...")
            ],
            'updated_at' => [
                'hidden' => true
            ],
            'created_at' => [
                'hidden' => true
            ]
        ];
    }

    protected function setupActions(DatatableActionsBuilder $builder) {
        parent::setupActions($builder);

    }

}