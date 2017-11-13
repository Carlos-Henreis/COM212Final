<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Grupo;
use App\Participa;
use App\Tarefa;
Use input;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function index()
    {   
        $user = Auth::guard('user')->user();
        $grupos = $this->myGroups($user->id);
        return view('home', compact('grupos'));
    }

    public function edit() {
        $user = Auth::guard('user')->user();
        return view('auth.edit', compact('user'));
    }
    
    public function update(Request $request) {
        $user = Auth::guard('user')->user();
        $grupos = $this->myGroups($user->id);
        try {
            $User = User::find(Auth::guard('user')->user()->id)->update($request->all());
            $ok = true;
            return view ('home', compact('ok', 'grupos'));
        } catch (\Illuminate\Database\QueryException $e) {
            $ok = false;
            return view ('home', compact('ok', 'e', 'grupos'));
        }
        
    }

    public function myGroups ($id) {
        $Todosgrupos = DB::table('grupos')
              ->join('participas','participas.idGrupo','=','grupos.id')   
              ->where('participas.idUsuario', '=',$id)                                    
              ->get();
        return $Todosgrupos;
    }

    public function removeGrupo (Request $request) {
        $grupo = Grupo::find($request->idGroup);
        $grupo->delete();
        $user = Auth::guard('user')->user();
        $grupos = $this->myGroups($user->id);
        $removidoG = true;
        return view('home', compact('grupos', 'removidoG'));
    }

    public function CreateGroups (Request $request) {
        $input = array('name' => $request->name, 'data'=> date('Y-m-d'),);
        Grupo::create($input);
        $grupo = DB::table('grupos')->where('name', '=', $request->name)->get();
        $user = Auth::guard('user')->user(); 
        $inputP = array('idGrupo' => $grupo[0]->id, 'idUsuario' => $user->id,);
        Participa::create($inputP);
        $okGrupo = true;
        $grupos = $this->myGroups ($user->id);
        return view ('home', compact('okGrupo', 'grupos'));
    }

    public function ShowGroup ($idGrupo) {
        $grupo = Grupo::find($idGrupo);
        $delegado = array();
        $participantes = DB::table('users')
                          ->join('participas','participas.idUsuario','=','users.id')   
                          ->where('participas.idGrupo', '=',$idGrupo)                                    
                          ->get();
         $posts = DB::table('users')
                          ->join('tarefas','tarefas.idUsuario','=','users.id')   
                          ->where('tarefas.idGrupo', '=',$idGrupo)                                    
                          ->get();
        $porcentagemTotal = DB::table('tarefas') 
                          ->where('tarefas.idGrupo', '=',$idGrupo)                                    
                          ->avg('porcentagem');
        return view('grupo.home', compact('grupo', 'participantes', 'posts', 'porcentagemTotal'));
    }

    public function ShowMember ($idGrupo) {
        $grupo = Grupo::find($idGrupo);
        $participantes = DB::table('users')
                          ->join('participas','participas.idUsuario','=','users.id')   
                          ->where('participas.idGrupo', '=',$idGrupo)                                    
                          ->get();
       
        return view ('grupo.participantes', compact('participantes', 'grupo'));
    }

    public function updateNome(Request $request) {
        
        try {
            $t = Grupo::find($request->idGroup)->update(['name' => $request->name]);
            $grupo = Grupo::find($request->idGroup);
            $idGrupo = $request->idGroup;
            $participantes = DB::table('users')
                          ->join('participas','participas.idUsuario','=','users.id')   
                          ->where('participas.idGrupo', '=',$request->idGroup)                                    
                          ->get();
            $okNome = true;

            $posts = DB::table('users')
                          ->join('tarefas','tarefas.idUsuario','=','users.id')   
                          ->where('tarefas.idGrupo', '=',$idGrupo)                                    
                          ->get();
            $porcentagemTotal = DB::table('tarefas') 
                              ->where('tarefas.idGrupo', '=',$idGrupo)                                    
                              ->avg('porcentagem');
            return view('grupo.home', compact('okNome', 'grupo', 'participantes', 'posts', 'porcentagemTotal'));
        } catch (\Illuminate\Database\QueryException $e) {
            $okNome = false;
            $grupo = Grupo::find($request->idGrupo);
            $participantes = DB::table('users')
                          ->join('participas','participas.idUsuario','=','users.id')   
                          ->where('participas.idGrupo', '=',$request->idGroup)                                    
                          ->get();
            $posts = DB::table('users')
                          ->join('tarefas','tarefas.idUsuario','=','users.id')   
                          ->where('tarefas.idGrupo', '=',$idGrupo)                                    
                          ->get();
            $porcentagemTotal = DB::table('tarefas') 
                              ->where('tarefas.idGrupo', '=',$idGrupo)                                    
                              ->avg('porcentagem');
            return view('grupo.home', compact('okNome', 'grupo', 'participantes', 'posts', 'porcentagemTotal'));
        }
        
    }

    public function dataAjax(Request $request){
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("users")
                    ->select("id","email")
                    ->where('email','LIKE',"%$search%")
                    ->get();
        }

        return response()->json($data);
    }

    public function insertMember (Request $request) {
        try {

            $inputP = array('idGrupo' => $request->idGroup, 'idUsuario' => $request->itemName,);
            $jaParticipa = DB::table('participas')
                          ->where([
                                ['idGrupo', '=',$request->idGroup],
                                ['idUsuario', '=', $request->itemName]
                            ])                                    
                          ->get();
            if (count($jaParticipa)> 0) {
                $ok = false;
                 $grupo = Grupo::find($request->idGroup);
                $participantes = DB::table('users')
                              ->join('participas','participas.idUsuario','=','users.id')   
                              ->where('participas.idGrupo', '=',$request->idGroup)                                    
                              ->get();
                return view ('grupo.participantes', compact('ok', 'grupo', 'participantes'));
            }
            Participa::create($inputP);
            $grupo = Grupo::find($request->idGroup);
            $participantes = DB::table('users')
                          ->join('participas','participas.idUsuario','=','users.id')   
                          ->where('participas.idGrupo', '=',$request->idGroup)                                    
                          ->get();
            $ok = true;
            return view ('grupo.participantes', compact('ok', 'grupo', 'participantes'));
        } catch (\Illuminate\Database\QueryException $e) {
            $okNome = false;
            $grupo = Grupo::find($request->idGroup);
            $participantes = DB::table('users')
                          ->join('participas','participas.idUsuario','=','users.id')   
                          ->where('participas.idGrupo', '=',$request->idGroup)                                    
                          ->get();
            return view ('grupo.participantes', compact('ok', 'e', 'grupo', 'participantes'));
        }
    }


    public function removeMember (Request $request) {
        $Participas = DB::table('participas')
                          ->where([
                                ['idGrupo', '=',$request->idGrupo],
                                ['idUsuario', '=', $request->idParicipante]
                            ])                                    
                          ->delete();
        $Participas = DB::table('tarefas')
                          ->where([
                                ['idGrupo', '=',$request->idGrupo],
                                ['idUsuario', '=', $request->idParicipante]
                            ])                                    
                          ->delete();
        $okDelete = true; 
        $grupo = Grupo::find($request->idGrupo);
        $participantes = DB::table('users')
                      ->join('participas','participas.idUsuario','=','users.id')   
                      ->where('participas.idGrupo', '=',$request->idGrupo)                                    
                      ->get();
        return view ('grupo.participantes', compact('okDelete', 'e', 'grupo', 'participantes'));
    }


     public function autoremoveMember (Request $request) {
        $Participas = DB::table('participas')
                          ->where([
                                ['idGrupo', '=',$request->idGrupo],
                                ['idUsuario', '=', $request->idParicipante]
                            ])                                    
                          ->delete();
        $Participas = DB::table('tarefas')
                          ->where([
                                ['idGrupo', '=',$request->idGrupo],
                                ['idUsuario', '=', $request->idParicipante]
                            ])                                    
                          ->delete();
        $okAutoDelete = true; 
        $user = Auth::guard('user')->user(); 
        $grupos = $this->myGroups ($user->id);
        return view ('home', compact('okAutoDelete', 'grupos'));
    }



    public function insertPost (Request $request) {
      
      $inputP = array('idGrupo' => $request->idGroup, 'mensagem' => $request->mensagem, 'idUsuario' => $request->idUser, 'porcentagem' => 0, 'titulo' => $request->titulo);
      Tarefa::create($inputP);
      $idGrupo = $request->idGroup;
      $grupo = Grupo::find($idGrupo);
      $participantes = DB::table('users')
                        ->join('participas','participas.idUsuario','=','users.id')   
                        ->where('participas.idGrupo', '=',$idGrupo)                                    
                        ->get();
       $posts = DB::table('users')
                        ->join('tarefas','tarefas.idUsuario','=','users.id')   
                        ->where('tarefas.idGrupo', '=',$idGrupo)                                    
                        ->get();
      $porcentagemTotal = DB::table('tarefas') 
                        ->where('tarefas.idGrupo', '=',$idGrupo)                                    
                        ->avg('porcentagem');
      $okinsertPost = true;
      return view('grupo.home', compact('grupo', 'participantes', 'posts', 'porcentagemTotal', 'okinsertPost'));



      self::ShowGroup($request->idGroup);
    }


    public function updatePost(Request $request) {
      $t = Tarefa::find($request->idTarefa)->update(['titulo' => $request->titulo, 'mensagem' => $request->mensagem, 'porcentagem' => $request->porcentagem]);
      $idGrupo = $request->idGroup; 
      $grupo = Grupo::find($idGrupo);
        $participantes = DB::table('users')
                          ->join('participas','participas.idUsuario','=','users.id')   
                          ->where('participas.idGrupo', '=',$idGrupo)                                    
                          ->get();
         $posts = DB::table('users')
                          ->join('tarefas','tarefas.idUsuario','=','users.id')   
                          ->where('tarefas.idGrupo', '=',$idGrupo)                                    
                          ->get();
        $porcentagemTotal = DB::table('tarefas') 
                          ->where('tarefas.idGrupo', '=',$idGrupo)                                    
                          ->avg('porcentagem');
        $okTarefaUp = true;
        return view('grupo.home', compact('okTarefaUp', 'grupo', 'participantes', 'posts', 'porcentagemTotal'));
        
    }


    public function removePost (Request $request) {
      $tarefa = Tarefa::find($request->idPost);
      $tarefa->delete();
      $idGrupo = $request->idGrupo;
      $grupo = Grupo::find($idGrupo);
      $participantes = DB::table('users')
                          ->join('participas','participas.idUsuario','=','users.id')   
                          ->where('participas.idGrupo', '=',$idGrupo)                                    
                          ->get();
         $posts = DB::table('users')
                          ->join('tarefas','tarefas.idUsuario','=','users.id')   
                          ->where('tarefas.idGrupo', '=',$idGrupo)                                    
                          ->get();
        $porcentagemTotal = DB::table('tarefas') 
                          ->where('tarefas.idGrupo', '=',$idGrupo)                                    
                          ->avg('porcentagem');
        $okTarefaDel = true;
        return view('grupo.home', compact('okTarefaDel', 'grupo', 'participantes', 'posts', 'porcentagemTotal'));
    }

    public function atribuiPost (Request $request) {
      dd($request);
    }
}
 
