<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Database\Queries;
use DB;

class PageController extends Controller
{
    public function getDashboard()
    {
        return view('dashboard');
    }

    public function getChefDetalhes($slug, Request $request)
    {
        $chef = DB::table('chef')
            ->where("slug", "=", $slug)
            ->join("users", "users.id", "=", "chef.id_chef")
            ->join("cidade", "cidade.id_cidade", "=", "chef.fk_cidade")
            ->join("chef_status", "chef_status.id_chef_status", "=", "chef.fk_status")
            ->select('*', DB::raw('chef.created_at as membro_desde'))
            ->first();

        $agenda = DB::table("chef_agenda")
            ->where("fk_chef", "=", $chef->id_chef)
            ->select('data',
                DB::raw("TIME_FORMAT(hora_de, '%H:%i') as hora_de"),
                DB::raw("TIME_FORMAT(hora_ate, '%H:%i') as hora_ate"),
                DB::raw("IF(hora_de <= '12:00:00', 'a.m.', 'p.m.') as horario_de_marcacao"),
                DB::raw("IF(hora_ate <= '12:00:00', 'a.m.', 'p.m.') as horario_ate_marcacao"))
            ->get();

        $contasBancarias = DB::table("chef_conta_bancaria")
            ->join("banco", "banco.id_banco", "=", "chef_conta_bancaria.fk_banco")
            ->where("fk_chef", "=", $chef->id_chef)
            ->get();

        $menus = DB::table("menu")
            ->where("fk_chef", "=", $chef->id_chef)
            ->get();

        $cursos = DB::table("curso")
            ->where("fk_chef", "=", $chef->id_chef)
            ->get();

        foreach ($menus as &$menu) {
            $menu->imagens = DB::table('menu_imagem')->where("fk_menu", "=", $menu->id_menu)->get();
            $menu->precos = DB::table('menu_preco')->where("fk_menu", "=", $menu->id_menu)->get();
            $menu->tipo_refeicao = DB::table('menu_refeicao')
                ->where("fk_menu", "=", $menu->id_menu)
                ->join("tipo_refeicao", "tipo_refeicao.id_tipo_refeicao", "=", "menu_refeicao.fk_tipo_refeicao")
                ->get();
            $menu->tipo_culinaria = DB::table('menu_culinaria')->where("fk_menu", "=", $menu->id_menu)
                ->join("culinaria", "culinaria.id_culinaria", "=", "menu_culinaria.fk_culinaria")
                ->get();
        }

        foreach ($cursos as &$curso) {
            $curso->imagens = DB::table('curso_imagem')->where("fk_curso", "=", $curso->id_curso)->get();
            $curso->precos = DB::table('curso_preco')->where("fk_curso", "=", $curso->id_curso)->get();
            $curso->tipo_refeicao = DB::table('curso_refeicao')->where("fk_curso", "=", $curso->id_curso)
                ->join("tipo_refeicao", "tipo_refeicao.id_tipo_refeicao", "=", "curso_refeicao.fk_tipo_refeicao")
                ->get();
            $curso->tipo_culinaria = DB::table('curso_culinaria')->where("fk_curso", "=", $curso->id_curso)
                ->join("culinaria", "culinaria.id_culinaria", "=", "curso_culinaria.fk_culinaria")
                ->get();
        }

        $status = [
            '1' => "border-success text-success-600",
            '2' => "border-info text-info-600",
            '3' => "border-warning text-warning-600",
            '4' => "border-danger text-danger-600"
        ];

        return view('chef_detalhes', [
            'chef' => $chef,
            'contas_bancarias' => $contasBancarias,
            'agenda' => $agenda,
            'menus' => $menus,
            'cursos' => $cursos,
            'classStatus' => $status[$chef->fk_status],
            'perfilAprovado' => $request->has('perfil_aprovado')
        ]);
    }
}
