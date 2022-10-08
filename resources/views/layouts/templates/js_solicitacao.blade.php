<script>
    $(document).ready(function(){        
        $(".lblForm").remove();
              
        $('#departamento').on('change', function () {
            var val = $(this).val();
             
            $.ajax({
                url: "/solicitacao/getUsers",
                type: "post",
                dataType: "json",
                data: {"departamento": val},
                beforeSend: function (data) {
                    // $('#loading').modal('show');
                },
                success: function (data) {
                    // $('#loading').modal('hide');                        
                        $("#responsavel").html(data);
                        // window.location.href = "/aprovacao";
                        // swalMensagem(data.status, data.title, data.message, data.redirect, false, false);
                    
                },
                error: function (data) {
                    // $('#loading').modal('hide');
                    // swalMensagem(false, "Erro ao adicionar", "Tivemos um problema, favor tentar novamente", false, false, false);
                }

            }); 
        });
        
        // $("#enviarForm").on("click", function(){
            
        //     var datastring = $("#FormContent").serialize();
            
        //     $.ajax({
        //         url: "/solicitacao/sendForm",
        //         type: "post",
        //         dataType: "json",
        //         data: datastring,
        //         beforeSend: function (data) {
        //             // $('#loading').modal('show');
        //         },
        //         success: function (data) {
        //             // $('#loading').modal('hide');
        //             if (data.status) {
        //                 alert("Enviado com sucesso!");
        //                 // window.location.href = "/aprovacao";
        //                 // swalMensagem(data.status, data.title, data.message, data.redirect, false, false);
        //             } else {
        //                 // swalMensagem(data.status, data.title, data.message, false, false, false);
        //             }
        //         },
        //         error: function (data) {
        //             // $('#loading').modal('hide');
        //             // swalMensagem(false, "Erro ao adicionar", "Tivemos um problema, favor tentar novamente", false, false, false);
        //         }
        //     });

        //     return false;
        // });
    });     
       
</script>