@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Editar dados do(a) Admin: {{$admin->name}}</h1>
        
        @if ($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        
        {!! Form::open(['route'=>['admin.cruds.update'], 'method' => 'put']) !!}
        <div class="form-group">
            {!! Form::label('name', 'Nome:') !!}
            {!! Form::text('name', $admin->name, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('email', 'E-mail:') !!}
            {!! Form::text('email', $admin->email, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-primary']) !!}
        </div>
        
        {!! Form::close() !!}
        
    </div>
@endsection

