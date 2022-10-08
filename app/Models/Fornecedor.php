<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends MyModel
{
    use HasFactory;

    protected $table = 'fornecedor';
    public    $seed  = 'razao_social';
    public    $deletar = true;
    

    public function bind($data)
    {
        $data['status'] = "Em analise";
        return $data;
    }

    public function afterSave($model, $data){        
        $aprovacao = app('App\Models\Aprovacao');
        $fornecedor_id = $model->id;

        $aprovacao->fornecedor_id = $fornecedor_id;
        $aprovacao->user_solicitacao_id = \Auth::user()->id;
        $aprovacao->tipo_solicitacao = "Homologação de Fornecedor";

        $aprovacao->save();        
    }

    
}
