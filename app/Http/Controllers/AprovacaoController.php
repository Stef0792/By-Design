<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Aprovacao;
use App\Models\Fornecedor;


class AprovacaoController extends Controller
{

    public function getIndex(){             
        return parent::getIndex();
    }

    public function getForm($id = false){
        $this->viewConfig['fields'] = $this->getFormFields();
        return parent::getForm();
    }

    public function sendForm(){
        $request = \Request::all();

        $dataSave = json_encode($request['data']);
        $aprovacao = new Aprovacao;
        $aprovacao->config = $dataSave;
        $aprovacao->save();
        
        echo json_encode(["status" => 1]);
    }    

    public function getAprovacao(){
        $request = \Request::all();
        $id = $request['id'];
        
        $aprovacao = Aprovacao::find($id);
        $respostas = json_decode($aprovacao->config);
        $resp = [];

        foreach($respostas as $key=>$value){
            foreach($value as $a=>$b){
                if($a == "devolutiva" && $b == "on") $resp[$key][$a] = "SIM";
                if($a == "devolutiva" && $b == "off") $resp[$key][$a] = "NAO";
                if($a != "devolutiva") $resp[$key][$a] = $b;
            }
        }        

        $fornecedor = Fornecedor::find($aprovacao->fornecedor_id);
        $forn = $fornecedor->getAttributes();        

        $fields = $this->getFormFields();

        $retorno               = [];
        $retorno["status"]     = 1;
        $retorno["fornecedor"] = $forn;
        $retorno["respostas"]  = $resp;

        echo json_encode($retorno);
    }

    public function finalizaAprovacao(){
        $request = \Request::all();
        $status = $request["action"];
        $id = $request["id"];
        $obs = $request["obs"];

        $fornecedor = Fornecedor::where('id', $id)->update(['status' => $status]);
        $aprovacao  = Aprovacao::where ('id', $id)->update(['status' => $status, 'observacoes' => $obs]);

        echo json_encode(["status" => 1]);
    }

    












 
}