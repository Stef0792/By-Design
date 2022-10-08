<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Solicitacao;
use App\Models\User;

class Solicitacao extends MyModel
{
    use HasFactory;

    protected $table = 'solicitacao';
    public    $seed  = 'responsavel';
    public    $deletar = true;
    public    $botaoVisualizar = true;
    public    $btn_editar = false;
    
    // const CREATED_AT = 'criado_em';
	// const UPDATED_AT = 'editado_em';

    public function bind($data)
    {
        return $data;
    }

    public function get_responsavel($id){
        $user = User::find($id);
        return $user[0]->name;
    }

    
}
