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

    
 
}