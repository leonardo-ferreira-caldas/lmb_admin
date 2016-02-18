<?php

namespace App\Http\Cruds;

use DB;

class TipoRefeicaoCrud extends BaseCrud {

    protected $table = 'tipo_refeicao';
    protected $hidden = ['updated_at', 'created_at'];

    protected function setupDatatableColumns() {
        return [
            'id_tipo_refeicao' => [
                'width' => '5%',
                'label' => "Código"
            ],
            'nome_tipo_refeicao' => [
                'label' => 'Descrição'
            ]
        ];
    }

    protected function setupFormFields() {
        return [
            'id_tipo_refeicao' => [
                'insert' => [
                    'disabled' => true
                ],
                'update' => [
                    'readonly' => true
                ],
                'label' => 'Código'
            ],
            'nome_tipo_refeicao' => [
                'label' => 'Descrição'
            ],
            'updated_at' => [
                'hidden' => true
            ],
            'created_at' => [
                'hidden' => true
            ]
        ];
    }

    protected function beforeDelete($data) {

        $validMenu = DB::table('menu_refeicao')->where("fk_tipo_refeicao", '=', $data['id_tipo_refeicao']);
        $validCurso = DB::table('curso_refeicao')->where("fk_tipo_refeicao", '=', $data['id_tipo_refeicao']);

        if ($validMenu->count() || $validCurso->count()) {
            throw new \Exception("Não é possível deletar o registro pois o mesmo já possui vinculos com outras informações.");
        }

    }

}