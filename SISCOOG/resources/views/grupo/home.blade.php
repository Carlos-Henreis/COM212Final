@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Grupo</div>
                <div class="panel-body">
                	<span>
                		<p>Porcentagem das atividades concluidas
                		<div id="progress" class="progress">
                			
					        <div class="progress-bar progress-bar-success" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:{{ $porcentagemTotal }}%">{{ $porcentagemTotal }}%</div>
					    </div></p>
					</span>

		    @if(Session::has('success'))
				<div class="alert alert-success">
					{!! Session::get('success') !!}
				</div>
		    @endif

		    <div class="alert alert-success hide" id="upload-success">
				Upload realizado com sucesso!
			</div>
                	</span>
                     @if(isset($okNome))
                        @if ($okNome)
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <strong>Success!</strong> Nome do Grupo atualizado.
                            </div>
                        @endif
                        @if (isset($e))
                            <div class="alert alert-danger alert-dismissable fade in">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Erro!</strong> {{mb_strimwidth($e, 0, 145, "...")}}
                              </div>
                        @endif
                        
                    @endif
	                <div class="col-md-3 col-md-offset-0">	
	                	<div class="panel panel-default">
	                		
			                <div class="panel-body">
			                	<div class="navbar-collapse collapse navbar-left">
				                	<ul class="nav nav-pills nav-stacked">
									  <li class="active"><a href="#">Inicio</a></li>
									  <li><a href="<?php echo '/home/group/'.$grupo->id.'/Participantes';?>">Participantes <span class="badge"><?php echo count($participantes); ?> </span></a></li>
									  <li><a href="#">Arquivos do Grupo</a></li>
									  <li><a href="#">Tarefa em que participo</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-9 col-md-offset-0">
						 <div class="panel panel-default">
			                <div class="panel-heading">
			                	<?php echo $grupo->name; ?> 
			                	<a href="#">
			                		<span class="glyphicon glyphicon-pencil" data-toggle="modal" data-target="#ModalMinhasTarefas"></span>
			                	</a> 
			                	<div class="pull-right">
			                		<a href="#" data-toggle="tooltip" data-placement="bottom" title="Grupo criado em <?php echo $grupo->data; ?>">
			                			<span class="glyphicon glyphicon-info-sign"></span>
			                		</a>
			                		<a href="#" data-toggle="tooltip" data-placement="bottom" title="deletar Grupo">
			                			<span class="glyphicon glyphicon-trash" data-toggle="modal" data-target="#ModalExcluirGrupo"></span>
			                		</a>
			                	</div>

			                </div>

			                <div class="panel-body">
			                	posts 
			                	<div class="pull-right">
			                		<a href="#" data-toggle="tooltip" data-placement="bottom" title="Criar post">
			                			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalinsertPost">
									      <span class="glyphicon glyphicon-plus"></span> novo Post
									    </button>
			                		</a>
			                	</div>
			                	<table class="table table-hover">
                                    <tbody> 
                                        @foreach ($posts as $post)
                                            <tr>
                                            <td><?php echo '('.mb_strimwidth($post->created_at, 0, 10).') <strong>'.$post->name.'</strong> postou uma nova tarefa:<br>'; ?>{{ mb_strimwidth($post->mensagem, 0, 145, "...") }} <br>
                                            	<?php 
                                            		echo '<span>
									                		<div id="progress" class="progress">
									                			
														        <div class="progress-bar progress-bar-success" aria-valuenow="'.$post->porcentagem.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$post->porcentagem.'%">'.$post->porcentagem.'% da atividades concluida </div>
														    </div>
														</span>';
                                            	?>
                                            </td>
                                            <td>
                                            	 @if ($post->email == Auth::guard('user')->user()->email)
		                                              <form>
		                                                <div class='form-group'>
		                                                  <div>
		                                                      <button class="btn-sm btn-primary">
		                                                          Atualizar
		                                                        </button>
		                                                      <button type="button" class="btn-sm btn-danger">
		                                                          Remover
		                                                        </button>
		                                                  </div>
		                                                </div>
		                                              </form>
		                                         @else
		                                             
		                                         @endif
                                            </td>
                                            </tr> 
                                        @endforeach
                                    </tbody>
                                </table>
			            </div>
			        </div>	
                </div>
            </div>
       	</div>
  	</div>
</div>

@endsection

<div class="modal fade" id="ModalinsertPost" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Criar um novo post</h4>
        </div>
        <div class="modal-body">
		     <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/group/'.$grupo->id.'/tarefas/insert') }}">
				    {{ csrf_field() }}
	          		 <input type="hidden" name="idGroup" value="<?php echo $grupo->id;?>">
	          		 <input type="hidden" name="idUser" value="{{ Auth::guard('user')->user()->id }}">
	          		 
	          		<div class="form-group">
			        	<label for="name" class="col-md-4 control-label">Mensagem</label>

				        <div class="col-md-6">         
	          		 		{{ Form::textarea('mensagem', null, ['size' => '30x3']) }}
				        </div>
				    </div>
				    <div class="form-group" class="col-md-4 control-label">
				    	 <div class="col-md-6"> 
				    	 	<label for="name" class="col-md-4 control-label"></label>
			          		 <button type="submit" class="btn btn-success">
				                Adicionar post
				            </button>
				        </div>
			         </div>
	          </form>
				    
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

        </div>
      </div>
      
    </div>
  </div>



<div class="modal fade" id="ModalExcluirGrupo" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Excluir Esse Grupo</h4>
        </div>
        <div class="modal-body">
          <p>Tem certeza que deseja excluir esse grupo (todos suas tarefas, dados, arquivos serão excluidos)</p>
        </div>
        <div class="modal-footer">
        	<div class="pull-left">
	           <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/group/delete') }}">
				    {{ csrf_field() }}
	          		 <input type="hidden" name="idGroup" value="<?php echo $grupo->id;?>">

	          		 <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
			        <label for="name" class="col-md-4 control-label">Name</label>

				        <div class="col-md-6">
				            <input id="name" type="text" class="form-control" name="name" value="<?php echo $grupo->name;?>" required autofocus>

				            @if ($errors->has('name'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('name') }}</strong>
				                </span>
				            @endif
				        </div>
				    </div>


	          		 <button type="submit" class="btn btn-danger">
		                Excluir
		            </button>
	          </form>
	         </div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

        </div>
      </div>
      
    </div>
  </div>




<div class="modal fade" id="ModalMinhasTarefas" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<h4 class="modal-title">Mudar nome do Grupo</h4>
      	</div>
      	<div class="modal-body">
    		 <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/group/updateNome') }}">
			    {{ csrf_field() }}
			    <input type="hidden" name="idGroup" value="<?php echo $grupo->id;?>">
			    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
			        <label for="name" class="col-md-4 control-label">Name</label>

			        <div class="col-md-6">
			            <input id="name" type="text" class="form-control" name="name" value="<?php echo $grupo->name;?>" required autofocus>

			            @if ($errors->has('name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('name') }}</strong>
			                </span>
			            @endif
			        </div>
			    </div>

			    <div class="form-group">
			        <div class="col-md-6 col-md-offset-4">
			            <button type="submit" class="btn btn-primary">
			                Register
			            </button>
			        </div>
			    </div>
			</form>
      	</div> 
    </div>
  </div>
</div>
