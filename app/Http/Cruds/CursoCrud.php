<?php

namespace App\Http\Cruds;

use App\Helpers\Datatable\Actions\DatatableActionsBuilder;
use App\Http\Cruds\BaseCrud;
use DB;

class CursoCrud extends BaseCrud
{
    protected $table = 'curso';
    protected $visible = ['id_curso', 'titulo', 'preco', 'ind_ativo'];
    protected $hidden = [];

    protected function setupDatatableColumns() {
        return [
            'id_curso' => [
                'width' => '10%',
                'label' => "Código"
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

    protected function setupDatatableQuery() {
        return DB::table('curso')
            ->join('chef', 'chef.id_chef', '=', 'curso.fk_chef')
            ->join('users', 'users.id', '=', 'chef.id_chef');
//            ->select('curso.id_curso', DB::raw("CONCAT(users.name, ' ', chef.sobrenome) as chef"), 'curso.titulo', 'curso.preco', 'curso.ind_ativo');
    }

    protected function setupActions(DatatableActionsBuilder $builder) {
        parent::setupActions($builder);

    }

}