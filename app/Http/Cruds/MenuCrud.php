<?php

namespace App\Http\Cruds;

use App\Helpers\Datatable\Actions\DatatableActionsBuilder;
use App\Http\Cruds\BaseCrud;

class MenuCrud extends BaseCrud
{
    protected $table = 'menu';
    protected $visible = ['id_menu', 'titulo', 'preco', 'ind_ativo'];
    protected $hidden = [];

    protected function setupDatatableColumns() {
        return [
            'id_menu' => [
                'label' => 'Código',
                'width' => '10%'
            ],
            'ind_ativo' => [
                'label' => "Status",
                "filter_select" => ["Ativo", "Inativo"],
                'format' => function($value) {
                    return $value ? '<span class="label label-success">Ativo</span>' : '<span class="label label-danger">Inativo</span>';
                }
            ],
            'preco' => [
                'format' => 'currency:br',
                'format_prefix' => "R$ "
            ]
        ];
    }

    protected function setupActions(DatatableActionsBuilder $builder) {
        parent::setupActions($builder);

    }

}