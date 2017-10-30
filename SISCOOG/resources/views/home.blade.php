@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
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
                    Oĺá usuário vc está bem?
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
