<?php

namespace App\Http\Cruds;

use App\Helpers\Datatable\Actions\DatatableActionsBuilder;
use App\Helpers\Datatable\DatatableAjaxRequest;
use App\Helpers\Renderer\CrudRenderer;
use App\Helpers\Validation\Validation;
use App\Http\Controllers\Controller;
use App\Helpers\Datatable\Datatable;
use App\Helpers\Providers\CrudProvider as Provider;
use App\Helpers\Forms\Form;
use Illuminate\Http\Request;

abstract class BaseCrud extends Controller {

    use Provider, Datatable, Form, Validation;

    private $request;

    public function __construct(Request $request) {
        CrudRenderer::inicialize(static::class);
        $this->request = $request;
    }

    public function getList() {
        if ($this->request->ajax()) {
            return $this->getDatatableAjaxRows(new DatatableAjaxRequest($this->request->all()));
        }

        return view('crud.list', [
            'page_title'        => CrudRenderer::getPageTitle(),
            'breadcrumb'        => CrudRenderer::getPageBreadcrumb(),
            'route'             => [
                'list'   => CrudRenderer::getListRoute(),
                'insert' => CrudRenderer::getInsertRoute()
            ],
            'datatable'         => [
                'columns' => $this->getDatatableColumns(),
                'rows'    => $this->getDatatableNonAjaxRows(),
                'actions' => $this->getDatatableActions(),
                'ajax'    => $this->hasAjaxEnabled(),
                'order'   => $this->hasOrderEnabled(),
                'filter'  => $this->hasFilterEnabled()
            ]
        ]);
    }

    public function getInsert() {
        return view('crud.insert', [
            'page_title'        => CrudRenderer::getPageTitle(),
            'breadcrumb'        => CrudRenderer::getPageBreadcrumb(),
            'fields'            => $this->getInsertFields(),
            'route'             => [
                'list'   => CrudRenderer::getListRoute(),
                'insert' => CrudRenderer::getInsertRoute()
            ],
        ]);
    }

    public function postInsert() {
        $this->processInsert($this->request->all());
        return redirect()->back()->with('success', 'Registro inserido com sucesso.');
    }

    public function postUpdate() {
        $this->processUpdate($this->request->all());
        return redirect()->back()->with('success', 'Registro atualizado com sucesso.');
    }

    public function getUpdate() {
        return view('crud.update', [
            'page_title'        => CrudRenderer::getPageTitle(),
            'breadcrumb'        => CrudRenderer::getPageBreadcrumb(),
            'fields'            => $this->getUpdateFields($this->request->all()),
            'route'             => [
                'list'   => CrudRenderer::getListRoute(),
                'insert' => CrudRenderer::getInsertRoute(),
                'update' => CrudRenderer::getUpdateRoute($this->request->all())
            ],
        ]);
    }

    public function getDelete() {
        $userData = $this->request->all();
        $canDelete = $this->validateDelete($userData);

        if ($canDelete !== true) {
            return redirect()->back()->with('error', $canDelete);
        }

        $this->processDelete($userData);
        return redirect()->back()->with('success', 'Registro deletado com sucesso.');
    }

    protected function setupActions(DatatableActionsBuilder $builder) {
        $builder->action('Editar Registro', "icon-database-edit2", function($primaryKeys) {
            return CrudRenderer::getUpdateRoute($primaryKeys);
        });

        $builder->action('Deletar', 'icon-trash', function($primaryKeys) {
            return CrudRenderer::getDeleteRoute($primaryKeys);
        });
    }
}