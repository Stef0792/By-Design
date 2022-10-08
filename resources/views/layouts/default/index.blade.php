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
						
					<?php if(isset($ConfigFile['extra_buttons'])): ?>
					<?php foreach($ConfigFile['extra_buttons'] AS $button): ?>
					<?php

						$data_attr = '';

						if(isset($button['data'])){
							foreach( $button['data'] AS $key => $val ){
								$data_attr.=" data-".$key."=".$val."";
							}
						}

					?>
					<a href="{{ $button['url'] }}" class="btn btn-sm btn-icon mr5 {{ $button['class'] }}" id="{{ $button['id'] }}" {{ $data_attr }}>
					<i class="{{ $button['icon'] }}"></i>
					<span>{{ $button['titulo'] }}</span>
					</a>
					<?php endforeach;?>
					<?php endif;?>
					
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

											$method_test = 'get_'.$value;
											// if($method_test == "get_id_fornecedor")
											if(method_exists($val, $method_test)){
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
											@if($val->btn_editar)
											<a href="{{ url($Area->url.'/form/'.$val->pk()) }}" class="btn btn-primary btn-xs">Editar</a>
											@endif

											<!-- Deletar -->
											@if($val->btn_deletar)
											<a href="{{ url($Area->url.'/delete/'.$val->pk()) }}" class="btn btn-danger btn-xs DeletarRegistro">Deletar</a>
											@endif

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

					if($Model){

						if(isset($_GET) && $_GET){
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
  $(function () {
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
</script>

@endsection
