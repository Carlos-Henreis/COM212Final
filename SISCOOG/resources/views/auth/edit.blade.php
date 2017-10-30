@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Editar dados do(a) Usuário: {{$user->name}}</h1>
        
        @if ($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        
        {!! Form::open(['route'=>['cruds.update'], 'method' => 'put']) !!}
        <div class="form-group">
            {!! Form::label('name', 'Nome:') !!}
            {!! Form::text('name', $user->name, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('email', 'E-mail:') !!}
            {!! Form::text('email', $user->email, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('nascimento', 'Data de nascimento:') !!}
            {!! Form::date('nascimento', $user->nascimento, ['class'=>'form-control']) !!}
        </div>

        
        <div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">Sexo</label>

            <div class="col-md-2">
                <select class="form-control" name="sexo" value="{{$user->sexo}}">
                    @if ($user->sexo == "M")
                        <option  selected="selected" value="M">M</option>
                    @else
                        <option value="M">M</option>
                    @endif

                    @if ($user->sexo == "F")
                        <option  selected="selected" value="F">F</option>
                    @else
                        <option value="F">F</option>
                    @endif

                </select>                
                @if ($errors->has('sexo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('sexo') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('ocupation') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">Ocupação</label>

            <div class="col-md-2">
                <select class="form-control" name="ocupation">
                    @if ($user->ocupation == "Estudante")
                        <option  selected="selected" value="Estudante">Estudante</option>
                    @else
                        <option value="Estudante">Estudante</option>
                    @endif

                    @if ($user->ocupation == "Professor")
                        <option  selected="selected" value="Professor">Professor</option>
                    @else
                        <option value="Professor">Professor</option>
                    @endif

                    @if ($user->ocupation == "outro")
                        <option  selected="selected" value="outro">outro</option>
                    @else
                        <option value="aluno">outro</option>
                    @endif
                </select>                
                @if ($errors->has('sexo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('sexo') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        
        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-primary']) !!}
        </div>
        
        {!! Form::close() !!}
        
    </div>
@endsection

 