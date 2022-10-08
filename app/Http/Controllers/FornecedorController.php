<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fornecedor;
use App\Models\Aprovacao;


class FornecedorController extends Controller
{

    public function getIndex(){        
        return parent::getIndex();
    }

    public function getForm($id = false){  
        $this->viewConfig['fields'] = $this->getFormFields();      
        return parent::getForm();
    }

    public function sendForm(){
        $request = (object) \Request::all();
        
        $fornecedor = new Fornecedor;
        $fornecedor->razao_social = $request->razao_social;
        $fornecedor->cnpj = $request->cnpj;
        $fornecedor->responsavel = $request->responsavel;
        $fornecedor->responsavel_celular = $request->responsavel_celular;
        $fornecedor->responsavel_email = $request->responsavel_email;
        $fornecedor->cep = $request->cep;
        $fornecedor->logradouro = $request->logradouro;
        $fornecedor->numero = $request->numero;
        $fornecedor->complemento = $request->complemento;
        $fornecedor->bairro = $request->bairro;
        $fornecedor->cidade = $request->cidade;
        $fornecedor->estado = $request->estado;
        $fornecedor->status = "Em análise";
        $save = $fornecedor->save();        

        $dataSave = json_encode($request->data);
        $aprovacao = new Aprovacao;
        $aprovacao->fornecedor_id = $fornecedor->id;
        $aprovacao->status = "Em análise";
        $aprovacao->user_solicitacao_id = \Auth::user()->id;
        $aprovacao->config = $dataSave;
        $aprovacao->save();
        
        echo json_encode(["status" => 1]);
    }

    public function getFormFields(){
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