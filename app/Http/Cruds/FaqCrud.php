<?php

namespace App\Http\Cruds;

use App\Helpers\Datatable\Actions\DatatableActionsBuilder;
use App\Http\Cruds\BaseCrud;
use DB;

class FaqCrud extends BaseCrud
{
    protected $table = 'faq';
    protected $visible = [];
    protected $hidden = [''];

    protected function setupDatatableColumns() {
        return [
            'id_faq' => [
                'label' => "Código"
            ],
            'descricao' => [
                'label' => 'Tipo',
                'type' => selectTable('faq_tipo', 'descricao')->defaultText('Todos')
            ]
        ];
    }

    protected function setupFormFields() {
        $textarea = new Textarea();
        $textarea->addCustomAttribute('rows', 4);

        return [
            'id_faq' => [
                'insert' => [
                    'disabled' => true
                ],
                'update' => [
                    'readonly' => true
                ]
            ],
            'resposta' => [
                'type' => $textarea
            ],
            'fk_tipo' => [
                'type' => selectTable('faq_tipo', 'id_faq_tipo', 'descricao')->defaultText("Selecione um tipo...")
            ],
            'updated_at' => [
                'hidden' => true
            ],
            'created_at' => [
                'hidden' => true
            ]
        ];
    }

    protected function setupDatatableQuery() {
        return DB::table('faq')
            ->join('faq_tipo', 'faq_tipo.id_faq_tipo', '=', 'faq.fk_tipo')
            ->select('faq.id_faq', 'faq.pergunta', 'faq.resposta', 'faq_tipo.descricao');
    }

    protected function setupActions(DatatableActionsBuilder $builder) {
        parent::setupActions($builder);

    }

}