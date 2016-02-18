<?php

namespace App\Http\Cruds;

use App\Helpers\Datatable\Actions\DatatableActionsBuilder;
use App\Http\Cruds\BaseCrud;
use App\Helpers\Datatable\Filter\Select;
use DB;

class ChefCrud extends BaseCrud
{
    protected $table = 'chef';
    protected $primaryKeys = ['id_chef'];
    protected $visible = [];
    protected $hidden = [];

    protected function setupDatatableColumns() {
        return [
            'id_chef' => [
                'label' => 'Código',
                'width' => '7%',
            ],
            'name' => [
                'label' => 'Nome'
            ],
            'cpf' => [
                'label' => 'CPF'
            ],
            'sexo' => [
                'width' => '10%',
                'type' => selectTable('sexo', 'descricao')->defaultText("Todos")
            ],
            'link' => [
                'label' => "",
                "order" => false,
                "filter" => false,
                'align' => 'center',
                'width' => '10%',
                'format' => function($value) {
                    return sprintf('<a href="%s" target="_blank" class="btn btn-default btn-xs heading-btn">
                        <i class="fa fa-arrow-circle-o-left position-left"></i> Ver Detalhes
                    </a>', route("chef.detalhes", ['id' => $value]));
                }
            ]
        ];
    }

    protected function setupDatatableQuery() {
        return DB::table('chef')
            ->join('sexo', 'sexo.id_sexo', '=', 'chef.fk_sexo')
            ->join('users', 'users.id', '=', 'chef.id_chef')
            ->select('chef.id_chef', 'users.name', 'chef.sobrenome', 'users.email', 'chef.cpf', 'sexo.descricao as sexo')
            ->addSelect('chef.slug as link');
    }

    protected function setupActions(DatatableActionsBuilder $builder) {}

}