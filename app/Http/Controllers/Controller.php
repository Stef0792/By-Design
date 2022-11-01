<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Area;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $view = null;
    public $index_acoes = true;
    public $novo_registro = true;
    public $Area = [];
    public $ModelString = '';
    public $Model = [];
    public $OverwriteModel = [];
    public $pagination = 20;
    public $botaoVisualizar = false;
    public $viewConfig = [];

    public function __construct() {
        $segments = explode('/', $_SERVER['REQUEST_URI']);
        // print_r($segments); exit;
        $uri = parse_url($segments[1])['path'];      

        
        if (!$this->Area)
            $this->setArea($uri);

        
        $this->setModel($uri);
    }

    public function getIndex() {
        $view = 'layouts.default.index';

        if ($this->view)
            $view = $this->view;
        // print_r($this->Model); exit;
        return view($view)
                        ->with('Area', $this->Area)
                        ->with('Model', $this->Model)
                        ->with('ConfigFile', $this->getConfigFile())
                        ->with('Controller', $this);
                        // ->with('title', $this->Area->titulo);
    }

    /**
     * Form
     *
     * FunÃ§Ã£o que adiciona ou edita registros dependendo do
     * parametro enviado na URL ou nÃ£o.
     *
     * OBS: o prefixo get no nome da funÃ§Ã£o Ã© uma exigÃªncia do framework
     *
     * @param  int
     * @return view
     */
    public function getForm($id = false) {
        //print_r($this->Area); exit;
        $Model = $this->Area->controller;
        $Model = app("App\Models\\$Model");

      //  echo $Model; exit;

        if (\Request::isMethod('post')) {
            $request = \Request::all();
            foreach($request as $key=>$valor){
                if(strpos($key, "/form") !== false){
                    unset($request[$key]);
                }
            }            
                
            $Model = $this->save($Model, $request);

            if (isset($Model->return)) {
                return $Model;
            }

            //return redirect(url($this->Area->url.'/form/'.$Model->id));
            //echo url($this->Area->url);
            return redirect(url($this->Area->url));
        } else {

            if ($id) {
               // print_r($Model); exit;
                $Model = $Model::where($Model->pk, $id)->first();
               // print_r($Model); exit;
                $this->Model = $Model;
            }
        }

        if ($id && !$Model) {
            return response()->view('errors.404', [], 404);
        }

        return view('layouts.default.form')
                        ->with('Area', $this->Area)
                        ->with('Model', $Model)
                        ->with('ConfigFile', $this->getConfigFile())
                        ->with('viewConfig', $this->viewConfig)
                        ->with('title', $this->Area->titulo);
    }

    /**
     * save
     *
     * FunÃ§Ã£o que executa a requisição POST de um formulÃ¡rio
     *
     *
     * @param  object, obj
     * @return int
     */
    public function save($Model, $data) {

        if (method_exists($Model, 'bind')) {
            $data = $Model->bind($data);

            if (!$data) {
                return $Model;
            }
        }

        unset($data['_token']);

        if (isset($data['id']) && $data['id']) {
            //Registro essa ediçao no log
            // Logs::gerarLog(\Auth::user(), $this->Area, 2, $data['id']);
            $Model = $Model->find($data['id']);
        } else {
            //Registro essa inserçao no log
            // Logs::gerarLog(\Auth::user(), $this->Area, 1);
        }

        if (isset($data['ativo'])) {
            if ($data['ativo'] == 'on') {
                $data['ativo'] = 1;
            }
        } else {

            if (isset($Model->ativo))
                $data['ativo'] = 0;
        }

        foreach ($data AS $key => $val) {
            if (!is_array($val)) {
                $Model->$key = utf8_decode(utf8_encode($val));
            }
        }

        // print_r($Model); exit;

        $Model->save();         

        /*
         * Executa uma funÃ§Ã£o com o
         * retorno do objeto inserido
         */
        if (method_exists($Model, 'afterSave')) {
            $Model->afterSave($Model, $data);
        }

        return $Model;
    }

    /**
     * getConfigFile
     *
     * Captura o arquivo json de configuração baseado na pasta da view e arquivo
     * e hidrata a variÃ¡vel caso o arquivo exista.
     *
     * @param  boolean
     * @return array
     */
    public static function getConfigFile($return_json = false) {
        $json = '';
        $MethodName = explode('@', \Route::currentRouteAction());
        // print_r( $MethodName ); exit;
        $ViewFolderName = explode("\\", $MethodName[0]);
        $ViewFolderName = strtolower(str_replace('Controller', '', $ViewFolderName[3]));
        
        $viewPath = \Config::get('view.paths')[0];
        
        if (!isset($MethodName[1]) || !file_exists($viewPath . '/' . $ViewFolderName . '/config.json')) {
            var_dump(file_exists($viewPath . '/' . $ViewFolderName . '/config.json'));
            exit;
            return array();
        }

        $MethodName = strtolower(str_replace('get', '', $MethodName[1]));
        
        $JsonFile = file_get_contents($viewPath . '/' . $ViewFolderName . '/config.json');
        $json = json_decode($JsonFile, true);
        // print_r($json); exit;
        if (!$json) {
            exit(utf8_decode('Ops! Arquivo de configuração inválido ou inexistente.'));
        }

        if (!isset($json[$MethodName]))
            return null;

        if ($return_json) {
            echo json_encode($json[$MethodName]);
            return false;
        } else {
            $json = $json[$MethodName];
        }
        
        return $json;
    }

    /**
     * setArea
     *
     * Define a area solicitada
     *
     * @param string
     * @return boolean
     */
    private function setArea($uri) {
        return $this->Area = Area::where('url', $uri)->first();
    }

    /**
     * setModel
     *
     * Define a quais valores o controller deverÃ¡ olhar
     *
     * @param null
     * @return boolean
     */
    public function setModel() {

        if (count($this->Model))
            return true;

        if (!$this->Area) {
            return [];
        }

       // print_r($this->Area); exit;

        $Model = $this->Area->controller;
        

        if (!class_exists("App\Models\\$Model")) {
            $this->Model = new \StdClass();
            return true;
        }

        $Model = app("App\Models\\$Model");

        $excluido = '';


        if (isset($Model->orderListBy) && is_array($Model->orderListBy)) {
            $this->Model = $Model->orderBy($Model->orderListBy[0], $Model->orderListBy[1])->paginate($this->pagination);
        } else {
            $this->Model = $Model->paginate($this->pagination);
        }
    }

    public function getFormFields(){
        $return = [];
        $return[] = 'Em linhas gerais, indique o nome do processo/atividade de tratamento do dado pessoal.';
        $return[] = 'Agora descreva de forma detalhada todo o processo, indicando quais dados pessoais, dados pessoais sensíveis e/ou de menores são tratados; de que pessoas são estes dados; quem tem acesso a estes dados e se são compartilhados; quais os sistemas e etapas da coleta, armazenamento, tratamento, etc destes dados.';
        $return[] = 'Por fim, indique o motivo pelo qual estes dados são tratados.';
        // $return[] = 'O fornecedor realiza Backup da aplicação? Qual a frequência e política de backup?';
        // $return[] = 'Os dados em repouso e em transito, são criptografados?';
        // $return[] = 'Existe processo de gestão de vulnerabilidades para servidores e banco de dados?';
        // $return[] = 'O fornecedor realiza testes de penetração (Pentest) em seu ambiente regularmente? Se sim, Com que frequência?';
        // $return[] = 'Há documentação sobre a arquitetura de segurança do aplicativo? Se sim, apresentar.';
        // $return[] = 'Os servidores possuem segmentação de rede para garantir o não acesso de outros clientes?';
        // $return[] = 'Certificações visíveis para clientes (SOC, ISO, etc.). Detalhar quais.';
        // $return[] = 'Existe processo de gestão de vulnerabilidades?';
        // $return[] = 'É possivel integração da solução através de API? Se sim, qual(is) tipo(s)?';
        // $return[] = 'A solução prevê um plano para recuperação de desastres em seu ambiente?';
        
        return $return;
    }


    public function getFormFieldsPrivacy(){
        $return = [];
        $return[] = 'Alguma senha que seja gravada no código-fonte do produto/sistema ("hardcoded")?';
        $return[] = 'A solução possui trilha de auditoria? Se sim, detalhe. (exemplo: Last Logon, Log de acessos, Log de transações...)';
        $return[] = 'A solução possui a gestão granular dos perfis (RBAC)?';
        // $return[] = 'O fornecedor realiza Backup da aplicação? Qual a frequência e política de backup?';
        // $return[] = 'Os dados em repouso e em transito, são criptografados?';
        // $return[] = 'Existe processo de gestão de vulnerabilidades para servidores e banco de dados?';
        // $return[] = 'O fornecedor realiza testes de penetração (Pentest) em seu ambiente regularmente? Se sim, Com que frequência?';
        // $return[] = 'Há documentação sobre a arquitetura de segurança do aplicativo? Se sim, apresentar.';
        // $return[] = 'Os servidores possuem segmentação de rede para garantir o não acesso de outros clientes?';
        // $return[] = 'Certificações visíveis para clientes (SOC, ISO, etc.). Detalhar quais.';
        // $return[] = 'Existe processo de gestão de vulnerabilidades?';
        // $return[] = 'É possivel integração da solução através de API? Se sim, qual(is) tipo(s)?';
        // $return[] = 'A solução prevê um plano para recuperação de desastres em seu ambiente?';
        
        return $return;
    }
}
