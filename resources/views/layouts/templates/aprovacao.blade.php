<style>
    .labelSec{
        font-weight: 400 !important;
    }

    .mTop{
        margin-top: 30px;
    }

    .row{
        margin-left: -4px !important;
    }
    
</style>

<hr />
<h3>Questionário de controle </h3>
<?php $count = 1; ?>
<?php foreach($viewConfig["fields"] as $field){ ?>
    <div class="row mTop">
        <div class="col-md-12">
            <label> <?php echo $field; ?> </label>
            <div class="row">
                <div class="col-md-2">
                    <div class="row">
                        <label class="labelSec"> Devolutiva </label>
                    </div>
                    
                    <div class="row">
                        <input type="checkbox" name="data[<?php echo $count; ?>][devolutiva]" data-bootstrap-switch data-off-color="danger" data-on-text="SIM" data-off-text="NÃO">                        
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="labelSec"> Comentários </label>
                    <textarea class="form-control" rows=1 name="data[<?php echo $count; ?>][coment]" id="coment_p_<?php echo $count; ?>" ></textarea>
                </div> 
                <div class="col-md-3">
                    <div class="row">
                        <label class="labelSec"> Evidência </label>
                    </div>
                    <div class="row linkAnex" id="link_p_<?php echo $count; ?>" >
                        <input type="text" placeholder="Link da evidencia" name="data[<?php echo $count; ?>][link]" class="form-control" />                    
                    </div>                    
                </div>                         
            </div>        
        </div>
    </div>
    <hr/>
    <?php $count++; ?>
<?php } ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(){        
        $(".lblForm").remove();
        $("#cnpj").mask('00.000.000/0000-00', {reverse: true});
        $("#responsavel_celular").mask('(00) 00000-0000');
        $("#cep").mask('00000-000');

        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch();
        });

       
        $('.switchLink').on('switchChange.bootstrapSwitch', function (e, state) {
            var state = e.target.checked;
            var position = $(this).data("position");
            if(state){            
                $("#anexo_p_"+position).hide();
                $("#link_p_"+position).show();
            }else{                
                $("#anexo_p_"+position).show();
                $("#link_p_"+position).hide();
            }
        }); 
        
        $("#enviarForm").on("click", function(){
            
            var datastring = $("#FormContent").serialize();
            console.log(datastring);
            $.ajax({
                url: "/fornecedor/sendForm",
                type: "post",
                dataType: "json",
                data: datastring,
                beforeSend: function (data) {
                    // $('#loading').modal('show');
                },
                success: function (data) {
                    // $('#loading').modal('hide');
                    if (data.status) {
                        alert("Cadastrado com sucesso!");
                        // window.location.href = "/aprovacao";
                        // swalMensagem(data.status, data.title, data.message, data.redirect, false, false);
                    } else {
                        // swalMensagem(data.status, data.title, data.message, false, false, false);
                    }
                },
                error: function (data) {
                    // $('#loading').modal('hide');
                    // swalMensagem(false, "Erro ao adicionar", "Tivemos um problema, favor tentar novamente", false, false, false);
                }
            });

            return false;
        });

        //Quando o campo cep perde o foco.
        $("#cep").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');
            //Verifica se campo cep possui valor informado.
            if (cep != "") {
                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if(validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#rua").val("...");
                    $("#bairro").val("...");
                    $("#cidade").val("...");
                    $("#uf").val("...");
                    $("#ibge").val("...");

                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#logradouro").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                            $("#estado").val(dados.uf);                            
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.                            
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            
        });
    });
</script>