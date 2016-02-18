<?php

$menu->page('PageController@getDashboard')->label('Dashboard')->name('pages.home')->icon('fa-home')->route('/');

$menu->submenu(function($builder) {

    $builder->crud('TipoCulinariaCrud')->label('Tipos de Culinária')->route('cadastros/tipos-de-culinaria')->name('cadastros.tipo_culinaria')->icon('fa-fire');
    $builder->crud('TipoRefeicaoCrud')->label('Tipos de Refeição')->route('cadastros/tipos-de-refeicao')->name('cadastros.tipo_refeicao')->icon('fa-cutlery');
    $builder->crud('InclusoPrecoCrud')->label('Incluso no Preço')->route('cadastros/incluso-preco')->name('cadastros.incluso_preco')->icon('fa-flag');
    $builder->crud('FaqCrud')->label('FAQ')->route('cadastros/faq')->name('cadastros.faq')->icon('fa-flag');

})->icon('fa-sitemap')->label('Cadastros');

$menu->submenu(function($builder) {

    $builder->crud('PaisCrud')->label('Países')->route('localizacao/paises')->name('localizacao.paises')->icon('fa-globe');
    $builder->crud('EstadoCrud')->label('Estados')->route('localizacao/estados')->name('localizacao.estados')->icon('fa-globe');
    $builder->crud('CidadeCrud')->label('Cidades')->route('localizacao/cidades')->name('localizacao.cidades')->icon('fa-globe');

})->icon('fa-globe')->label('Localização');

$menu->submenu(function($builder) {

    $builder->crud('ChefCrud')->label('Chefs')->route('chefs')->name('chefs')->icon('fa-globe');
//    $builder->crud('MenuCrud')->label('Menus')->route('chefs/menus')->name('chefs.menus')->icon('fa-globe');
//    $builder->crud('CursoCrud')->label('Cursos')->route('chefs/cursos')->name('chefs.cursos')->icon('fa-globe');

})->icon('fa-users')->label('Chefs');

$menu->crud('ConfiguracaoSiteCrud')->label('Configurações do Sistema')->route('configuracoes')->name('configuraoes')->icon('fa-cogs');