@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Grupo</div>

                <div class="panel-body">

                  @if(isset($okDelete))
                        @if ($okDelete)
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <strong>Success!</strong> Participante não faz mais parte do Grupo. Todas as suas atividades também foram removidas.
                            </div>
                        @else
                              <div class="alert alert-danger alert-dismissable fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Erro!</strong> Não foi possível remove-lo
                              </div>
                        @endif
                        
                    @endif


                  @if(isset($ok))
                        @if ($ok)
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <strong>Success!</strong> Novo participante adicionado.
                            </div>
                        @else
                              <div class="alert alert-danger alert-dismissable fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Erro!</strong> Usuário já participa no grupo
                              </div>
                        @endif
                        @if (isset($e))
                            <div class="alert alert-danger alert-dismissable fade in">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Erro!</strong> Em delegar essa tarefas (<?php echo $e;?>)
                              </div>
                        @endif
                        
                    @endif
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-body">
                              <div class="navbar-collapse collapse navbar-left">
                                <ul class="nav nav-pills nav-stacked">
                          <li><a href="<?php echo '/home/group/'.$grupo->id;?>">Inicio</a></li>
                          <li class="active"><a href="<?php echo '/home/group/'.$grupo->id.'/Participantes';?>">Participantes <span class="badge"><?php echo count($participantes); ?></span></a></li>
                          <li><a href="#">Minhas Tarefas</a></li>
                          <li><a href="#">Todas Tarefas</a></li>
                        </ul>
                      </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <p><input class="form-control" id="myInput" type="text" placeholder="Buscar Tarefa.."></p>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Email</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable"> 
                                        
                                        <?php $i = 1; ?>
                                        @foreach ($participantes as $participa)
                                          @if ($i == 1)
                                            <tr>
                                             <td> {{ $participa->idUsuario }}</td>
                                            <td>{{ $participa->email }}</td>
                                            <td>
                                              <form>
                                                <div class='form-group'>
                                                  <div class='col-md-6 col-md-offset-4'>
                                                     <a href="#" data-toggle="tooltip" data-placement="bottom" title="Criar post">
                                                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ModalErroRemove">
                                                        Remover
                                                      </button>
                                                    </a>
                                                  </div>
                                                </div>
                                              </form>
                                            </td>
                                            </tr> 
                                          @else
                                            @if ($participa->idUsuario == Auth::guard('user')->user()->id)
                                                <tr>
                                                  <td> {{ $participa->idUsuario }}</td>
                                                  <td>{{ $participa->email }}</td>
                                                  <td>
                                                    <form>
                                                      <div class='form-group'>
                                                        <div class='col-md-6 col-md-offset-4'>
                                                           <a href="#" data-toggle="tooltip" data-placement="bottom" title="Criar post">
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalAutoRemove">
                                                              Sair
                                                            </button>
                                                          </a>
                                                        </div>
                                                      </div>
                                                    </form>
                                                  </td>
                                              </tr>

                                            @else
                                              <tr>
                                                  <td> {{ $participa->idUsuario }}</td>
                                                  <td>{{ $participa->email }}</td>
                                                  <td>
                                                    <form>
                                                      <div class='form-group'>
                                                        <div class='col-md-6 col-md-offset-4'>
                                                           <a href="#" data-toggle="tooltip" data-placement="bottom" title="Criar post">
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalRemove">
                                                              Remover
                                                            </button>
                                                          </a>
                                                        </div>
                                                      </div>
                                                    </form>
                                                  </td>
                                              </tr>
                                            @endif
                                          @endif
                                          <?php $i += 1; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="container">
                                  <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/group/insertmember')}}">
                                      {{ csrf_field() }}
                                      <input type="hidden" name="idGroup" value="<?php echo $grupo->id;?>">
                                      <select class="itemName form-control" style="width:35%;" name="itemName"></select>
                                              <button type="submit" class="btn btn-primary">
                                                  Adicionar Participante
                                              </button>
                                  </form>
  

                              </div>

                              <script type="text/javascript">

                                    $('.itemName').select2({
                                      placeholder: 'Select an item',
                                      ajax: {
                                        url: '/select2-autocomplete-ajax',
                                        dataType: 'json',
                                        delay: 250,
                                        processResults: function (data) {
                                          return {
                                            results:  $.map(data, function (item) {
                                                  return {
                                                      text: item.email,
                                                      id: item.id
                                                  }
                                              })
                                          };
                                        },
                                        cache: true
                                      }
                                    });

                              </script>
                                                          
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<div class="modal fade" id="ModalRemove" role="dialog">
  <div class="modal-dialog modal-sm">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Erro ao remover o usuário</h4>
      </div>
      <div class="modal-body">
        <p>deseja mesmo Remover o usuário do grupo?</p>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/group/'.$grupo->id.'/Participantes/remove') }}">
          {{ csrf_field() }}
          <input type="hidden" name= "idParicipante" value="{{ $participa->idUsuario }}">
           <input type="hidden" name= "idGrupo" value="{{ $grupo->id }}">
          <div class='form-group'>
              <div class='col-md-6 col-md-offset-4'>
                  <button type='submit' class='btn btn-danger'>
                      Remover
                  </button>
              </div>
          </div>
        </form>
        
      </div>
    </div>
    
  </div>
</div>

<div class="modal fade" id="ModalAutoRemove" role="dialog">
  <div class="modal-dialog modal-sm">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Erro ao remover o usuário</h4>
      </div>
      <div class="modal-body">
        <p>deseja mesmo sair do grupo?</p>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/group/'.$grupo->id.'/Participantes/autoremove') }}">
          {{ csrf_field() }}
          <input type="hidden" name= "idParicipante" value="{{ $participa->idUsuario }}">
           <input type="hidden" name= "idGrupo" value="{{ $grupo->id }}">
          <div class='form-group'>
              <div class='col-md-6 col-md-offset-4'>
                  <button type='submit' class='btn btn-success'>
                      Sair
                  </button>
              </div>
          </div>
        </form>
        
      </div>
     
    </div>
    
  </div>
</div>

<div class="modal fade" id="ModalErroRemove" role="dialog">
  <div class="modal-dialog modal-sm">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Erro ao remover o usuário</h4>
      </div>
      <div class="modal-body">
        <p>Esse usuário não pode ser removido, precisamos de pelo menos um participante para que o grupo faça sentido (se não vai usar o grupo você pode excluí-lo)</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

      </div>
    </div>
    
  </div>
</div>