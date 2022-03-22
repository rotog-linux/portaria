<?php

namespace Src\Controller;

use Src\Model\Funcoes\Portarias;
use Src\Model\Funcoes\Unidades;

class PortariaController extends Controller
{
    /**
     * Selecionar a portaria que o usuário está logando
     */
    public static function selecionar()
    {
        // Carregar todas as portarias cadastradas, anexando os nomes das unidades
        $portarias = new Portarias();
        if (!$portarias->listar()){
            parent::view('index', ['mensagem' => $portarias->mensagem]);
            exit;
        }

        parent::view('portaria.selecionar', ['portarias' => $portarias->objeto()]);
    }

    public static function portarias(array $post, array $get, string $mensagem = '')
    {
        // Só poderá cadastrar novas portarias se pelo menos uma unidade
        // estiver cadastrada no sistema
        $unidades = new Unidades();
        if ($unidades->contar() > 0){
            $botaoNovo = true;

            $portarias = new Portarias();
            $portarias->listar();
        }

        criarCsrf();

        parent::view('portaria.lista', 
            ['portarias' => $portarias->obter() ?? false, 
             'mensagem'  => $mensagem,
             'botaoNovo' => $botaoNovo]);
    }

     /**
     * Criação de um nova portaria
     */
    public static function novo(array $post, array $get, string $mensagem = '')
    {
        criarCsrf();

        $unidades = new Unidades();
        $unidades->listar();

        parent::view('portaria.novo', ['mensagem' => $mensagem, 'unidades' => $unidades->obter()]);
    }

    public static function gravar(array $post, array $get)
    {
        self::persistir($post, $get, true);
    }

    public static function atualizar(array $post, array $get)
    {
        self::persistir($post, $get, false);
    }

    private static function persistir(array $post, array $get, bool $novo)
    {
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        $view = ($novo) ? 'novo' : 'alterar';

        $portaria = new Portarias();
        if (!$portaria->dados($post)){
            criarCsrf();
            parent::view('portaria.' . $view, ['mensagem' => $portaria->mensagem, 'portaria' => $portaria->objeto()]);
            exit;
        }

        if ($portaria->gravar()){
            self::portarias([], [], 'Portaria gravada com sucesso.');
        } else {
            criarCsrf();
            parent::view('portaria.' . $view, ['mensagem' => $portaria->mensagem, 'portaria' => $portaria->objeto()]);
        }
    }

    public static function alterar(array $post, array $get, string $mensagem = '')
    {
        criarCsrf();
        $id = filter_var($post['portaria_id'], FILTER_VALIDATE_INT);
        $portaria = new Portarias();
        $portaria->carregar($id);

        $unidades = new Unidades();
        $unidades->listar();

        parent::view('portaria.alterar', ['portaria' => $portaria->objeto(), 'mensagem' => $mensagem, 'unidades' => $unidades->obter()]);
    }

    public static function ativar(array $post, array $get)
    {
        self::alterarStatus($post, $get, 0);
    }

    public static function inativar(array $post, array $get)
    {
        self::alterarStatus($post, $get, 1);
    }

    private static function alterarStatus(array $post, array $get, int $status)
    {
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        $id = filter_var($post['portaria_id'], FILTER_VALIDATE_INT);

        $portaria = new Portarias();
        $portaria->carregar($id);
        $portaria->alterarStatus($status);

        self::portarias([], []);
    }
}