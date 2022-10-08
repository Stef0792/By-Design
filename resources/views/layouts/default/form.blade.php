@extends('layouts.admin')
@section('content')

<?php

$pk = $Model->pk;

?>
<style>
    #FormContent{
        padding: 2%;
    }

    .form-control{
        background-color: #FFF !important;
        color: #000 !important;
    }

    .select2{
        background-color: #FFF !important;
        color: #000 !important;
    }
    
</style>

    <!-- Main content -->
<section class="content">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-primary bg-white">
                    <div class="card-header">
                        {{ isset($Model->$pk)?'Editando registro':'Novo registro' }}
                        <div style="float: right;">			  		
                            @if(isset($ConfigFile['langs']))
                                @foreach($ConfigFile['langs'] AS $lang )
                                <a href="#" class="btnLang" id="{{ $lang }}"> {{ $lang }} </a>
                                @endforeach
                            @endif					
                        </div>
                    </div>
                
                    <form id="FormContent" class="form-horizontal" role="form" method="POST" action="{{ url($Area->url.'/form') }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">

                        @if(isset($Model->$pk))
                        <input type="hidden" name="{{ $pk }}" id="{{ $pk }}" value="{{ $Model->$pk }}" />
                        @endif
                        <div class="row">
                            <?php $row = 1; $cont = 1;?>
                            @foreach($ConfigFile['fields'] AS $field)
                                <?php 
                                    if($cont > 1 && ($field['row'] > $row)){
                                        $row = $field['row'];
                                        echo "</div>";
                                        echo "<div class='row' style='margin-top: 10px;'>";
                                    }
                                ?>   
                                <div class="col-md-<?= $field['size']; ?>"> 
                                    <?php 
                                        $ModelId = isset($Model)?$Model->$pk:null;
                                        $col_sm  = isset($field['col-sm'])?$field['col-sm']:2;
                                    ?>
                                    {{ FormHelper::getInput($field, $ModelId, $col_sm, $viewConfig) }}
                                </div>
                                <?php 
                                    $cont++;
                                ?>                        
                            @endforeach
                        </div>
                        @if( !isset($Model) || $Model->send_form_button)
                        <div class="form-group">
                            <input type="submit" data-lang="PT" value="Enviar" id="enviarForm" class="btn btn-primary" style="float:right;" />
                        </div>
                        @endif
                    </form>                   
                </div>
            </div>        
        </div>
    </div>
</section>
@endsection