<?php

namespace App\Http\Cruds;

use App\Helpers\Datatable\Actions\DatatableActionsBuilder;
use App\Http\Cruds\BaseCrud;

class PaisCrud extends BaseCrud
{
    protected $table = 'pais';
    protected $visible = [];
    protected $hidden = ['updated_at', 'created_at'];

    protected function setupDatatableColumns() {
        return [
            'id_pais' => [
                'width' => '15%',
                'label' => 'Sigla'
            ],
            'created_at' => [
                'format' => "datetime:br"
            ],
            'updated_at' => [
                'format' => "datetime:br"
            ]
        ];
    }

    protected function setupFormFields() {
        return [
            'id_pais' => [
                'label' => 'Sigla'
            ],
            'nome_pais' => [
                'label' => 'Nome'
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