@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-heading">Dashboard
                    

                </div>
                 <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        
                        <!-- Authentication Links -->
                            <li><a href="#">Meus Grupos</a></li>
                            <li><a href="#">Amigos</a></li>
                    </ul>   
                 </div>
                    <div class="panel-body">
                        
                    Vc está Logado 🙂
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection