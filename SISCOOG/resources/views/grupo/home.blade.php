@extends('layouts.app')
<?php
header('X-XSS-Protection:0');
$atribuidas = array();
for($i=0; $i < count($delegados); $i++) {
	# code...
	for ($j=0; $j < count($delegados[$i]); $j++) { 
		echo '
  			<li>'.$delegados[$i][$j]->email.'</li>';
  			array_push($atribuidas, $delegados[$i][$j]->email);
  	}
 }
?>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Grupo - <?php echo $grupo->name;?></div>
                <div class="panel-body">
                	<span>
                		<p>Porcentagem de conclussão de todas as atividades (<?php echo $porcentagemTotal; ?>%)
                		<div id="progress" class="progress">
                			
					        <div class="progress-bar progress-bar-success" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:{{ $porcentagemTotal }}%">{{ $porcentagemTotal }}%</div>
					    </div></p>
					</span>

		    @if(Session::has('success'))
				<div class="alert alert-success">
					{!! Session::get('success') !!}
				</div>
		    @endif
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
                    @if(isset ($okinsertPost))
                    	<div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong>Success!</strong> Nova Tarefa adicionada! <br> Você pode editá-la futuramente.
                        </div>

                    @endif

                     @if(isset ($okTarefaUp))
                    	<div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong>Success!</strong> Dados da Tarefa Atualizado com sucesso.
                        </div>


                      

                    @endif

                    @if(isset ($okTarefaDel))
                    	<div class="alert alert-info alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong>Atenção!</strong> Você removeu uma atividade deste grupo <span class="glyphicon glyphicon-warning-sign"></span>
                        </div>


                    @endif

                    @if(isset($okDelegado))
                        @if ($okDelegado)
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <strong>Success!</strong> Atividades foram atribuidas.
                            </div>
                        @else
                               @if (isset($e))
		                            <div class="alert alert-danger alert-dismissable fade in">
		                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		                                <strong>Erro!</strong> <?php echo mb_strimwidth($e, 0, 50);?>;
		                              </div>
		                        @endif
                        @endif
                        
                    @endif


	                <div class="col-md-3 col-md-offset-0">	
	                	<div class="panel panel-default">
	                		
			                <div class="panel-body">
			                	<div class="navbar-collapse collapse navbar-left">
				                	<ul class="nav nav-pills nav-stacked">
									  <li class="active"><a href="#">Inicio</a></li>
									  <li><a href="<?php echo '/home/group/'.$grupo->id.'/Participantes';?>">Membros <span class="badge"><?php echo count($participantes); ?> </span></a></li>
									  <li><a href="#">Arquivos do Grupo</a></li>
									  <li><a href="#">Atribuidos a mim <span class="badge"><?php echo count($minhasTarefas); ?> </span></a></li>
									   <li><a href="#" data-toggle="modal" data-target="#ModalRelatorio">Dados Gerais do Projeto <span class="glyphicon glyphicon-eye-open"></span></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-9 col-md-offset-0">
						 <div class="panel panel-default">
			                <div class="panel-heading">
			                	<h4><strong><?php echo $grupo->name; ?></strong> 
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
			                </h4>

			                </div>

			                <div class="panel-body">
			                	posts 
			                	<div class="pull-right">
			                		<a href="#" data-toggle="tooltip" data-placement="bottom" title="Criar post">
			                			<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#ModalinsertPost">
									      <span class="glyphicon glyphicon-plus"></span> nova Tarefa
									    </button>
			                		</a>
			                	</div>
			                	<br><br><br>
			                	<p><input class="form-control" id="myInput" type="text" placeholder="Buscar Tarefa.."></p>
			                	<table class="table table-hover" width="95%">
                                    <tbody id="myTable"> 
                                    	<?php $i=0;?>
                                        @foreach ($posts as $post)
                                        	
                                            <tr>
                                            <td>
                                            	<?php
                                    		  	echo '('.mb_strimwidth($post->created_at, 0, 10).') <strong>'.$post->name.'</strong>('.$post->email.') postou uma nova tarefa:<p>Titulo: <strong>'.$post->titulo.'</strong></p><p><strong>Descrição:</strong></p><p>'.$post->mensagem;?>><br>
                                            	<?php 

                                            		echo '<div class="pull-left">
															'.$post->porcentagem.'% concluida
															</div>
                                            			  <div class="pull-right">
															Última atualização  <span class="glyphicon glyphicon-refresh"></span> : '.$post->updated_at.'
															</div><br>
                                            			  <span>
									                		<div id="progress" class="progress">
									                			
														        <div class="progress-bar progress-bar-success" aria-valuenow="'.$post->porcentagem.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$post->porcentagem.'%">'.$post->porcentagem.'% da atividade concluida </div>
														    </div>
														</span>';
                                            	?>
                                            <div class="panel panel-default">
    											<div class="panel-body">

                                            	<div class="dropdown">
													    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Atribuido para
													    <span class="caret"></span></button>
													    <ul class="dropdown-menu">
													    <?php
													    $atribuidas = array();
													    if (count($delegados[$i]) == 0){
													    	echo"<li>Sem atribuição</li>";
													    }
													    else{
													    	for ($j=0; $j < count($delegados[$i]); $j++) { 
													    		echo '
													      			<li>'.$delegados[$i][$j]->email.'</li>';
													      			array_push($atribuidas, $delegados[$i][$j]->email);
													      	}

													    	
													    }
													    echo "</ul>";
													    ?>
													  </div>
                                        	 	@if ($post->email == Auth::guard('user')->user()->email)

                                        	 	<div class="pull-right">

													<a href="#" data-toggle="tooltip" data-placement="bottom" title="Atualizar post">
														<button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalUpdatePost<?php echo $post->id; ?>">
													      <span class="glyphicon glyphicon-pencil"></span> Atualizar
													    </button>
													</a>
													 	
													<a href="#" data-toggle="tooltip" data-placement="bottom" title="Remover post">
														<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalDeletePost<?php echo $post->id; ?>">
													      <span class="glyphicon glyphicon-trash"></span> Remover
													    </button>
													</a>
													<a href="#" data-toggle="tooltip" data-placement="bottom" title="Atribuír essa tarefa">
														<button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalAtribuiPost<?php echo $post->id; ?>">
													      <span class="glyphicon glyphicon-user"></span> 
													      Atribuír&nbsp;&nbsp;
													    </button>
													</a>
													<p></p>
												</div>
		                                         	
												<div class="modal fade" id="ModalUpdatePost<?php echo $post->id; ?>" role="dialog">
												    <div class="modal-dialog">
												    
														<!-- Modal content-->
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Atualizar <?php echo $post->id; ?></h4>
															</div>
															<div class="modal-body">
																<form class="form-horizontal" role="form" method="POST" action="{{ url('/home/group/'.$grupo->id.'/tarefas/update') }}">
																    {{ csrf_field() }}
																	<input type="hidden" name="idGroup" value="<?php echo $grupo->id;?>">
																	<input type="hidden" name="idTarefa" value="<?php echo $post->id;?>">
																	<input type="hidden" name="idUser" value="{{ Auth::guard('user')->user()->id }}">
																	 <div class="form-group">
															        	<label for="name" class="col-md-4 control-label">Titulo</label>

																        <div class="col-md-6">         
													          		 		<input type="text" name="titulo" id="titulo" value="<?php echo $post->titulo;?>">
																        </div>
																    </div>
																	<div class="form-group">
																    	<label for="name" class="col-md-4 control-label">Mensagem</label>
																        <div class="col-md-6">         
																		 		<textarea name="mensagem" id="mensagem" cols="30" rows="6"><?php echo $post->mensagem;?></textarea>
																        </div>
																    </div>
																    <div class="form-group">
																        <label for="name" class="col-md-4 control-label">Porcentagem</label>
																        <div class="col-md-6"> 
																    	 	<input name="porcentagem" id="porcentagem" type="number" min="0" max="100" step="0.01" value="<?php echo $post->porcentagem;?>">
																    	</div>
																    </div>
																    
																    <div class="form-group" class="col-md-4 control-label">
																		<div class="col-md-6"> 
																			<label for="name" class="col-md-4 control-label"></label>
																			<button type="submit" class="btn btn-success">
																				Atualizar post
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


												<div class="modal fade" id="ModalAtribuiPost<?php echo $post->id; ?>" role="dialog">
												    <div class="modal-dialog">
												    
														<!-- Modal content-->
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Atribuir essa Tarefa <?php echo $post->id; ?></h4>
															</div>
															<div class="modal-body">
																<form class="form-horizontal" role="form" method="POST" action="{{ url('/home/group/'.$grupo->id.'/tarefas/atribuir') }}">
																    {{ csrf_field() }}
																	<input type="hidden" name="idGroup" value="<?php echo $grupo->id;?>">
																	<input type="hidden" name="idTarefa" value="<?php echo $post->id;?>">
																	<input type="hidden" name="idUser" value="{{ Auth::guard('user')->user()->id }}">
																	 <div class="form-group">
															        	<label for="name" class="col-md-4 control-label">Paticipantes</label>

																      <select name="delegados[]" class="selectpicker" data-live-search="true" multiple required>
																      	@foreach ($participantes as $p)
																      	  <?php 
																      	  	$testeE = false;
																      	  	for ($k=0; $k < count($atribuidas); $k++) { 
																      	  		if ($p->email == $atribuidas[$k])
																      	  			$testeE = true;

																      	  	}

																      	  	if ($testeE){
																      	  		echo " <option disabled>".$p->email."</option>";
																      	  	}else {
																      	  		echo " <option>".$p->email."</option>";
																      	  	}
																      	  	
																      	  ?>
																		@endforeach
																		</select>
																		

																    </div>

																    
																    <div class="form-group" class="col-md-4 control-label">
																		<div class="col-md-6"> 
																			<label for="name" class="col-md-4 control-label"></label>
																			<button type="submit" class="btn btn-success">
																				Atualizar post
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


												<div class="modal fade" id="ModalDeletePost<?php echo $post->id; ?>" role="dialog">
												    <div class="modal-dialog modal-sm">
												    
												      <!-- Modal content-->
												      <div class="modal-content">
												        <div class="modal-header">
												          <button type="button" class="close" data-dismiss="modal">&times;</button>
												          <h4 class="modal-title">Excluir Atividade do Grupo</h4>
												        </div>
												        <div class="modal-body">
												          <p>Tem certeza que deseja excluir essa atividade? (Essa ação não é reversível)</p>
												        </div>
												        <div class="modal-footer">
												        	<div class="pull-left">
													           <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/group/'.$grupo->id.'/tarefas/delete') }}">
																    {{ csrf_field() }}
																    <input type="hidden" name="idGrupo" value="<?php echo $grupo->id;?>">
													          		 <input type="hidden" name="idPost" value="<?php echo $post->id;?>">



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
		                                         @else
		                                         
		                                         		<?php
		                                         		$testeE = false;
											      	  	for ($k=0; $k < count($atribuidas); $k++) { 
											      	  		if (Auth::guard('user')->user()->email == $atribuidas[$k])
											      	  			$testeE = true;

											      	  	}?>

											      	  	@if ($testeE)
											      	  		<a href="#" data-toggle="tooltip" data-placement="bottom" title="Atualizar post">
																<button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalUpdatePostPorcent<?php echo $post->id; ?>">
															      <span class="glyphicon glyphicon glyphicon-edit"></span> Atualizar
															    </button>
															</a>								
											      	  		<div class="modal fade" id="ModalUpdatePostPorcent<?php echo $post->id; ?>" role="dialog">
												    <div class="modal-dialog">
												    
														<!-- Modal content-->
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Atualizar <?php echo $post->id; ?></h4>
															</div>
															<div class="modal-body">
																<form class="form-horizontal" role="form" method="POST" action="{{ url('/home/group/'.$grupo->id.'/tarefas/updatePorcent') }}">
																    {{ csrf_field() }}
																	<input type="hidden" name="idGroup" value="<?php echo $grupo->id;?>">
																	<input type="hidden" name="idTarefa" value="<?php echo $post->id;?>">
																	<input type="hidden" name="idUser" value="{{ Auth::guard('user')->user()->id }}">
																    <div class="form-group">
																        <label for="name" class="col-md-4 control-label">Porcentagem</label>
																        <div class="col-md-6"> 
																    	 	<input name="porcentagem" id="porcentagem" type="number" min="0" max="100" step="0.01" value="<?php echo $post->porcentagem;?>">
																    	</div>
																    </div>
																    
																    <div class="form-group" class="col-md-4 control-label">
																		<div class="col-md-6"> 
																			<label for="name" class="col-md-4 control-label"></label>
																			<button type="submit" class="btn btn-success">
																				Atualizar post
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
		                                         		@endif
	 		                                        @endif
	 		                                 </div>
                                            </tr> 
                                            <?php $i++; ?>
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

<div class="modal fade" id="ModalRelatorio" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Relatório Geral do Grupo</h4>
        </div>
        <br>
        <div class="modal-body">
		     <div class="panel-body" id="conteudo">


		     	<?php
		     	$maior = -1;
		     	$concluidas = 0;
		     	$zero = 0;
		     	$vc = 0;
		     	$cq = 0;
		     	$sc = 0;
		     	$cem = 0;
		      	$contr = "Nenhum contribuidor";?>
		     	@foreach ($participantes as $p)
		      	  <?php
		      	  	$testeE = 0;
		      	  	for ($k=0; $k < count($atribuidas); $k++) { 
		      	  		if ($p->email == $atribuidas[$k])
		      	  			$testeE ++;

		      	  	}

		      	  	if ($testeE > $maior){
		      	  		$maior = $testeE;
		      	  		$contr = $p->email;
		      	  	}


		      	  ?>
				@endforeach
				@foreach ($posts as $post)
				<?php 
					if ($post->porcentagem < 10){
		      	  			$zero++;
	      	  		}else{
	      	  			if ($post->porcentagem < 25){
	      	  				$vc++;
	      	  			}else{
	      	  				if ($post->porcentagem < 50){
	      	  					$cq++;
	      	  				}else{
	      	  					if ($post->porcentagem < 75){
		      	  					$sc++;
		      	  				}else{
		      	  					$cem++;
		      	  				}
		      	  			}

	      	  			}
	      	  		}
					if ($post->porcentagem == 100)
						$concluidas++;
				?>
				@endforeach
		     	<div><p>Total de tarefas: <?php echo count($posts); ?></p>
		     	<p>Membro que mais contribuiu: <?php echo $contr;?><br>
		     		(quantidade de tarefas:{{$maior}})
		     	</p>
		     	<p>Total de participantes: <?php echo count($participantes); ?></p>
		     	<p>Quantidade de tarefas concluidas: <?php echo count($concluidas); ?> (<?php if (count($posts)) echo (100*($concluidas/count($posts))); ?>%)</p>
		     	<table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody id="myTable"> 
                       
                        @foreach ($participantes as $participa)
                            <tr>
                             <td> {{ $participa->idUsuario }}</td>
                            <td>{{ $participa->email }}</td>
                            </tr> 
                          
                        @endforeach
                    </tbody>
                </table>
            </div>
                <p>
                <div id="barchart_values"></div>
                <p>Total conc<p>
                <div id="timeline1"></div>
                <div id="piechart"></div>                
               

		     </div>
				    
        </div>
        <div class="modal-footer">
         <div class="pull-left">
         	<input type="button" onclick="cont();" value="Imprimir relatório">
         </div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

        </div>
      </div>
      
    </div>
  </div>



<div class="modal fade" id="ModalinsertPost" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Criar uma nova Tarefa</h4>
        </div>
        <br>
        <div class="modal-body">
		     <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/group/'.$grupo->id.'/tarefas/insert') }}">
				    {{ csrf_field() }}
				    
				    <input type="hidden" name="okinsertPost" value="true">
	          		 <input type="hidden" name="idGroup" value="<?php echo $grupo->id;?>">
	          		 <input type="hidden" name="idUser" value="{{ Auth::guard('user')->user()->id }}">

	          		 <div class="form-group">
			        	<label for="name" class="col-md-4 control-label">Titulo</label>

				        <div class="col-md-6">         
	          		 		{{ Form::text('titulo')}}
				        </div>
				    </div>
	          		 
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Porcentagem", "Quantidade", { role: "style" } ],
        ["0%", {{$zero}}, "#b87333"],
        ["25%", {{$vc}}, "silver"],
        ["50%", {{$cq}}, "gold"],
        ["75%", {{$sc}}, "color: #e5e4e2"],
        ["100%", {{$cem}}, "color: #47d147"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Porcentagem das tarefas",
        width: 820,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
      chart.draw(view, options);
  }
  </script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script type="text/javascript">
    	      google.charts.load('current', {'packages':['timeline']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var container = document.getElementById('timeline1');
        var chart = new google.visualization.Timeline(container);
        var dataTable = new google.visualization.DataTable();

        dataTable.addColumn({ type: 'string', id: 'President' });
        dataTable.addColumn({ type: 'date', id: 'Start' });
        dataTable.addColumn({ type: 'date', id: 'End' });
        dataTable.addRows([
        <?php
        foreach ($posts as $post) {
        	echo "[ 'Tarefa:".$post->id."', new Date(\"".$post->created_at."\"), new Date(\"".$post->updated_at."\") ],";
        }
        ?>
         ]);
         var options = {
	        title: "Porcentagem das tarefas",
	        width: 820,
	        height: 400,
	        bar: {groupWidth: "95%"},
	        legend: { position: "none" },
	      };
        chart.draw(dataTable, options);
      }
    </script>

<script>
function cont(){
   var conteudo = document.getElementById('print').innerHTML;
   tela_impressao = window.open('about:blank');
   tela_impressao.document.write(conteudo);
   tela_impressao.window.print();
   tela_impressao.window.close();
}
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
  ['Concluida', 'Porcentagem'],
  ['Concluida', {{$porcentagemTotal/10}}],
  ['Em andamento', {{10-($porcentagemTotal/10)}}],
]);


        // Optional; add a title and set the width and height of the chart
  var options = {'title':'Procentagem Geral concluida', 'width':800, 'height':400, 'pieHole': 0.4};

  // Display the chart inside the <div> element with id="piechart"

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>