@extends('layouts.app3')

@section('content')
<div class="container-full">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if(isset($_POST['primeiro']))
                        <div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong>Success!</strong> Sua conta foi criada com sucesso<br>seja bem vindo a cumunidade SISCOOG.
                        </div>                  
                    @endif


                    @if(isset($okGrupo))
                        @if ($okGrupo)
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <strong>Success!</strong> Grupo Criado com sucesso.
                            </div>
                        @endif                        
                    @endif
                     @if(isset($ok))
                        @if ($ok)
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <strong>Success!</strong> Dados Atualizados com sucesso.
                            </div>
                        @endif
                        @if (isset($e))
                            <div class="alert alert-danger alert-dismissable fade in">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Erro!</strong> {{mb_strimwidth($e, 0, 145, "...")}}
                              </div>
                        @endif
                        
                    @endif
                    @if (isset($okAutoDelete))
                      <div class="alert alert-warning alert-dismissable fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Atenção!</strong> você saiu de um grupo de trabalho! Agora você não tem mais acesso aos dados (Tarefas, status, participantes e arquivos) do grupo. E tudo o que você fez não está mais disponível 
                      </div>
                    @endif
                    @if (isset($removidoG))
                      <div class="alert alert-warning alert-dismissable fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Atenção!</strong> você removeu um grupo de trabalho! Todos os seus dados (Tarefas, status, participantes e arquivos foram perdidos). 
                      </div>
                    @endif
                    <div class="panel panel-default">
                      <div class="container">
                          <div class="panel-heading">
                              <div class="btn-group">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalnewGrupo">Novo Grupo</button>

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalMeusGrupos">Meus Grupos <span class="badge"><?php echo count($grupos); ?></span></button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalMinhasTarefas">Minhas Tarefas <span class="badge"><?php echo count($grupos); ?></span></button>
                              </div>
                              
                          </div>
                      </div>

                    </div>

                    Oĺá usuário vc está bem?
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal -->
  <div class="modal fade" id="ModalnewGrupo" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Novo Grupo</h4>
        </div>
        <div class="modal-body">
           <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/group/create') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

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

<div class="modal fade" id="ModalMeusGrupos" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Meus Grupo</h4>
      </div>
      <div class="list-group">
        <?php
          for ($i=0; $i < count($grupos); $i++) { 
            echo '<a href="/home/group/'.$grupos[$i]->idGrupo.'" class="list-group-item">'.$grupos[$i]->name.'</a>';
          }
        ?>
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
        <h4 class="modal-title">Meus Grupo</h4>
      </div>
      <div class="list-group">
        <?php
          for ($i=0; $i < count($grupos); $i++) { 
            echo '<a href="/home/group/'.$grupos[$i]->idGrupo.'" class="list-group-item">'.$grupos[$i]->name.'</a>';
          }
        ?>
      </div> 
    </div>
  </div>
</div>
  