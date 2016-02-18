<?php

namespace App\Http\Cruds;

use DB;

class TipoCulinariaCrud extends BaseCrud {

    protected $table = 'culinaria';
    protected $hidden = ['updated_at', 'created_at'];

    protected function setupDatatableColumns() {
        return [
            'id_culinaria' => [
                'width' => '10%',
                'label' => 'Código'
            ],
            'nome_culinaria' => [
                'width' => '50%',
                'label' => 'Nome Culinária',
                'align' => 'left'
            ]
        ];
    }

    protected function setupFormFields() {
        return [
            'id_culinaria' => [
                'insert' => [
                    'disabled' => true
                ],
                'update' => [
                    'readonly' => true
                ]
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

        $validMenu = DB::table('menu_culinaria')->where("fk_culinaria", '=', $data['id_culinaria']);
        $validCurso = DB::table('curso_culinaria')->where("fk_culinaria", '=', $data['id_culinaria']);

        if ($validMenu->count() || $validCurso->count()) {
            throw new \Exception("Não é possível deletar o registro pois o mesmo já possui vinculos com outras informações.");
        }

    }

}