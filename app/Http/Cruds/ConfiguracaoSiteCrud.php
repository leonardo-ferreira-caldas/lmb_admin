<?php

namespace App\Http\Cruds;

use App\Helpers\Datatable\Actions\DatatableActionsBuilder;
use App\Helpers\Forms\Fields\Textarea;
use App\Helpers\Renderer\CrudRenderer;

class ConfiguracaoSiteCrud extends BaseCrud
{
    protected $table = 'configuracao_site';
    protected $visible = [];
    protected $hidden = [];

    protected function setupDatatableColumns() {
        return [
            'chave' => [
                'width' => '30%'
            ]
        ];
    }

    protected function setupFormFields() {
        $textarea = new Textarea();
        $textarea->addCustomAttribute('rows', 8);

        return [
            'valor' => [
                'type' => $textarea
            ]
        ];
    }

    protected function setupActions(DatatableActionsBuilder $builder) {
        $builder->action('Editar Registro', "icon-database-edit2", function($primaryKeys) {
            return CrudRenderer::getUpdateRoute($primaryKeys);
        });
    }

}