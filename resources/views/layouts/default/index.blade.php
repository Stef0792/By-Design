@extends('layouts.admin')
@section('content')


<!-- Main content -->
<section class="content">
	<div class="main-content">
		<div class="page-title" style="position:fixed; width:100%; z-index:10;">
			<div class="title"></div>
			<div class="sub-title"></div>
		</div>
		<div class="card bg-white m-b" style="margin-top:60px;">
			<div class="card" style="margin-bottom: 0px;">
				<div class="card-header">
					<div class="col-sm-6" style="float: left; height: 1px;"></div>
					<div class="col-sm-6" style="float: left; text-align:right;">
						<a href="{{ url($Area->url.'/form/') }}" class="btn btn-primary btn-sm btn-icon mr5">
							<i class="icon-plus"></i>
							<span>Novo registro</span>
						</a>
					</div>

					<?php if (isset($ConfigFile['extra_buttons'])) : ?>
						<?php foreach ($ConfigFile['extra_buttons'] as $button) : ?>
							<?php

							$data_attr = '';

							if (isset($button['data'])) {
								foreach ($button['data'] as $key => $val) {
									$data_attr .= " data-" . $key . "=" . $val . "";
								}
							}

							?>
							<a href="{{ $button['url'] }}" class="btn btn-sm btn-icon mr5 {{ $button['class'] }}" id="{{ $button['id'] }}" {{ $data_attr }}>
								<i class="{{ $button['icon'] }}"></i>
								<span>{{ $button['titulo'] }}</span>
							</a>
						<?php endforeach; ?>
					<?php endif; ?>

				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								@foreach($ConfigFile['list_fields'] AS $value => $field)
								<th><b>{{ $field }}</b></th>
								@endforeach
								@if($Controller->index_acoes)
								<th><b>Ações</b></th>
								@endif
							</tr>
						</thead>
						<tbody>
							@if($Model)
							@foreach($Model AS $key => $val)
							<tr>
								@foreach($ConfigFile['list_fields'] AS $value => $field)
								<?php

								$method_test = 'get_' . $value;
								// if($method_test == "get_id_fornecedor")
								if (method_exists($val, $method_test)) {
									$value = $val->$method_test($val);
								} else {
									$value = $val->$value;
								}

								?>
								<td>{!! $value !!}</td>
								@endforeach
								@if($Controller->index_acoes)
								<td>
									<!-- Editar -->
									<!-- @if($val->btn_editar)
									<a href="{{ url($Area->url.'/form/'.$val->pk()) }}" class="btn btn-primary btn-xs">Editar</a>
									@endif -->

									<!-- Deletar -->
									<!-- @if($val->btn_deletar)
									<a href="{{ url($Area->url.'/delete/'.$val->pk()) }}" class="btn btn-danger btn-xs DeletarRegistro">Deletar</a>
									@endif -->

									@if($val->botaoVisualizar)
									<a href="#" class="btn btn-info btn-xs visualizarRegistro" id="{{ $val->pk() }}">Visualizar</a>
									@endif
								</td>
								@endif
							</tr>
							@endforeach
							@else
							<tr>
								<td colspan="{{ count($ConfigFile['list_fields'])+1 }}">Nenhum registro encontrado.</td>
							</tr>
							@endif
						</tbody>
					</table>
					<!-- Pagination -->
					<?php

					if ($Model) {

						if (isset($_GET) && $_GET) {
							// echo $Model->appends($_GET)->links();
						} else {
							// echo $Model->links();
						}
					}

					?>
					<!-- /Pagination -->
				</div>
				<!-- /.card-body -->
			</div>
		</div>
	</div>
</section>
<!-- MODALS -->
@if(isset($ConfigFile['modals']) && $ConfigFile)
@foreach($ConfigFile['modals'] AS $modal )
@include("modals.$modal")
@endforeach
@endif

<div class="modal" tabindex="-1" role="dialog" id="modalVisualiza">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content bg-white">
			<div class="modal-header">
				<h5 class="modal-title">Aprovação</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form id="FormContent" class="form-horizontal" role="form" method="POST" action="http://impacta.test/fornecedor/form" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-12">
							<label for="razao_social" class="lblForm">Razão Social</label><input type="text" readonly name="razao_social" placeholder="Razão Social" id="razao_social" class="form-control " value="" />
						</div>
					</div>

					<div class='row' style='margin-top: 10px;'>
						<div class="col-md-3">
							<label for="cnpj" class="lblForm">Cnpj</label><input type="text" readonly name="cnpj" placeholder="Cnpj" id="cnpj" class="form-control " value="" />
						</div>
						<div class="col-md-3">
							<label for="responsavel" class="lblForm">Responsavel</label><input type="text" readonly name="responsavel" placeholder="Responsavel" id="responsavel" class="form-control " value="" />
						</div>
						<div class="col-md-3">
							<label for="responsavel_celular" class="lblForm">Responsavel Celular</label><input type="text" readonly name="responsavel_celular" placeholder="Responsavel Celular" id="responsavel_celular" class="form-control " value="" />
						</div>
						<div class="col-md-3">
							<label for="responsavel_email" class="lblForm">Responsavel Email</label><input type="text" readonly name="responsavel_email" placeholder="Responsavel Email" id="responsavel_email" class="form-control " value="" />
						</div>
					</div>
					<div class='row' style='margin-top: 10px;'>
						<div class="col-md-2">
							<label for="cep" class="lblForm">Cep</label><input type="text" readonly name="cep" placeholder="Cep" id="cep" class="form-control " value="" />
						</div>


						<div class="col-md-6">
							<label for="logradouro" class="lblForm">Logradouro</label><input type="text" readonly name="logradouro" placeholder="Logradouro" id="logradouro" class="form-control " value="" />
						</div>


						<div class="col-md-2">
							<label for="numero" class="lblForm">Numero</label><input type="text" readonly name="numero" placeholder="Numero" id="numero" class="form-control " value="" />
						</div>


						<div class="col-md-2">
							<label for="complemento" class="lblForm">Complemento</label><input type="text" readonly name="complemento" placeholder="Complemento" id="complemento" class="form-control " value="" />
						</div>

					</div>
					<div class='row' style='margin-top: 10px;'>
						<div class="col-md-3">
							<label for="bairro" class="lblForm">Bairro</label><input type="text" readonly name="bairro" placeholder="Bairro" id="bairro" class="form-control " value="" />
						</div>


						<div class="col-md-3">
							<label for="cidade" class="lblForm">Cidade</label><input type="text" readonly name="cidade" placeholder="Cidade" id="cidade" class="form-control " value="" />
						</div>


						<div class="col-md-1">
							<label for="estado" class="lblForm">Estado</label><input type="text" readonly name="estado" placeholder="Estado" id="estado" class="form-control " value="" />
						</div>

					</div>
					<div class='row' style='margin-top: 10px;'>
						<div class="col-md-12">							
							<style>
								.labelSec {
									font-weight: 400 !important;
								}

								.mTop {
									margin-top: 30px;
								}

								.row {
									margin-left: -4px !important;
								}

								.spanVisualiza{
									font-weight: bold;
								}
							</style>

							<hr />
							<h3>Questionário de controle </h3>
							<div class="row mTop">
								<div class="col-md-12">
									<label> Em linhas gerais, indique o nome do processo/atividade de tratamento do dado pessoal. </label>
									<div class="row">
										<div class="col-md-2">
											<div class="row">
												<label class="labelSec"> Devolutiva </label>
											</div>
											<div class="row">
												<span class="spanVisualiza" id="devolutiva_1"></span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="row">
												<label class="labelSec"> Comentários </label>
											</div>
											<div class="row">
												<span class="spanVisualiza" id="coment_1"></span>
											</div>
										</div>
										<div class="col-md-3">
											<div class="row">
												<label class="labelSec"> Evidência </label>
											</div>
											<div class="row">
												<span class="spanVisualiza" id="link_1"></span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<hr />
							<div class="row mTop">
								<div class="col-md-12">
									<label> Agora descreva de forma detalhada todo o processo, indicando quais dados pessoais, dados pessoais sensíveis e/ou de menores são tratados; de que pessoas são estes dados; quem tem acesso a estes dados e se são compartilhados; quais os sistemas e etapas da coleta, armazenamento, tratamento, etc destes dados. </label>
									<div class="row">
										<div class="col-md-2">
											<div class="row">
												<label class="labelSec"> Devolutiva </label>
											</div>

											<div class="row">
												<span class="spanVisualiza" id="devolutiva_2"></span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="row">
												<label class="labelSec"> Comentários </label>
											</div>
											<div class="row">
												<span class="spanVisualiza" id="coment_2"></span>
											</div>
										</div>
										<div class="col-md-3">
											<div class="row">
												<label class="labelSec"> Evidência </label>
											</div>
											<div class="row">
												<span class="spanVisualiza" id="link_2"></span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<hr />
							<div class="row mTop">
								<div class="col-md-12">
									<label> Por fim, indique o motivo pelo qual estes dados são tratados. </label>
									<div class="row">
										<div class="col-md-2">
											<div class="row">
												<label class="labelSec"> Devolutiva </label>
											</div>

											<div class="row">
												<span class="spanVisualiza" id="devolutiva_3"></span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="row">
												<label class="labelSec"> Comentários </label>
											</div>
											<div class="row">
												<span class="spanVisualiza" id="coment_3"></span>
											</div>
										</div>
										<div class="col-md-3">
											<div class="row">
												<label class="labelSec"> Evidência </label>
											</div>
											<div class="row">
												<span class="spanVisualiza" id="link_3"></span>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<hr />
							<h3>Parecer Final </h3>
							<div class="row mTop">
								<div class="col-md-12">
									<input type="hidden" id="idAprovacalModal" />
									<textarea cols=80 rows=4 id="parecer_final"></textarea>
								</div>
							</div>
						</div>
					</div>					
				</form>
			</div>
			<div class="modal-footer">
				<div id="btnControl">
					<button type="button" class="btn btn-primary btnModal" data-action="Aprovada">Aprovar</button>
					<button type="button" class="btn btn-danger btnModal" data-action="Reprovada">Reprovar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /MODALS -->

<!-- jQuery -->
<script src="AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="AdminLTE/plugins/jszip/jszip.min.js"></script>
<script src="AdminLTE/plugins/pdfmake/pdfmake.min.js"></script>
<script src="AdminLTE/plugins/pdfmake/vfs_fonts.js"></script>
<script src="AdminLTE/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="AdminLTE/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="AdminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
	$(function() {
		// $("#example1").DataTable({
		//   "responsive": true, 
		//   "lengthChange": false, 
		//   "autoWidth": false,
		//   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
		// }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		$('#example2').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": false,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": true,
		});
	});

	$(document).ready(function() {
		$(document).on("click", ".btnModal", function(){
			var action = $(this).data("action");
			var obs = $("#parecer_final").val();
			var id = $("#idAprovacalModal").val();

			if(obs == ""){
				alert("Favor preencher as considerações finais.");
				return false;
			}

			$.ajax({
				url: "/aprovacao/finalizaAprovacao",
				type: "post",
				dataType: "json",
				data: {
					id: id,
					obs: obs,
					action: action
				},
				success: function(data) {
					if(data){	
						alert("Solicitação de aprovação encerrada com sucesso.");
						location.reload();					
					}
				},
				error: function(xhr, status, error) {
					alert(erro);
				}
			});



		});

		$(document).on('click', '.visualizarRegistro', function() {
			var id = this.id;
			$("#idAprovacalModal").val(id);

			$.ajax({
				url: "/aprovacao/getAprovacao",
				type: "post",
				dataType: "json",
				data: {
					id: id
				},
				success: function(data) {
					if(data){
						$("#razao_social").val(data.fornecedor.razao_social);
						$("#cnpj").val(data.fornecedor.cnpj);
						$("#responsavel").val(data.fornecedor.responsavel);
						$("#responsavel_celular").val(data.fornecedor.responsavel_celular);
						$("#responsavel_email").val(data.fornecedor.responsavel_email);
						$("#cep").val(data.fornecedor.cep);
						$("#logradouro").val(data.fornecedor.logradouro);
						$("#numero").val(data.fornecedor.numero);
						$("#complemento").val(data.fornecedor.complemento);
						$("#bairro").val(data.fornecedor.bairro);
						$("#cidade").val(data.fornecedor.cidade);
						$("#estado").val(data.fornecedor.estado);
						
						$("#devolutiva_1").html(data.respostas[1].devolutiva);
						$("#coment_1").html(data.respostas[1].coment);
						$("#link_1").html(data.respostas[1].link);

						$("#devolutiva_2").html(data.respostas[2].devolutiva);
						$("#coment_2").html(data.respostas[2].coment);
						$("#link_2").html(data.respostas[2].link);

						$("#devolutiva_3").html(data.respostas[3].devolutiva);
						$("#coment_3").html(data.respostas[3].coment);
						$("#link_3").html(data.respostas[3].link);

						$("#parecer_final").html(data.parecer);
						
						alert(data.status_aprovacao);
						if(data.status_aprovacao == "Aprovada" || data.status_aprovacao == "Reprovada"){
							$("#btnControl").hide();
							$("#parecer_final").prop('readonly', true);
						}else{
							$("#btnControl").show();
							$("#parecer_final").prop('readonly', false);
						}
					}
				},
				error: function(xhr, status, error) {
					alert(erro);
				}
			});

			$("#modalVisualiza").modal();
		});
	});
</script>

@endsection