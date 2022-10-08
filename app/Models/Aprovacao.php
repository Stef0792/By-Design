<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Fornecedor;

class Aprovacao extends MyModel
{
    use HasFactory;

    protected $table = 'aprovacao';
    public    $seed  = 'config';
    public    $deletar = true;
    public    $botaoVisualizar = true;
    public    $btn_editar = false;
    
    // const CREATED_AT = 'criado_em';
	// const UPDATED_AT = 'editado_em';

    public function bind($data)
    {
        return $data;
    }

    public function get_fornecedor_id($id){
        $fornecedor = Fornecedor::find($id);        
        return $fornecedor[0]->razao_social;
    }

    public function get_user_solicitacao_id($id){
        $user = User::find($id);        
        return $user[0]->name;
    }

    
}
