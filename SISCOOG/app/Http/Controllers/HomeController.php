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
use App\Delega;
use Exception;
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
        $delegados = array();
        $participantes = DB::table('users')
                          ->join('participas','participas.idUsuario','=','users.id')   
                          ->where('participas.idGrupo', '=',$idGrupo)    
                          ->get();
         $posts = DB::table('users')
                          ->join('tarefas','tarefas.idUsuario','=','users.id')
                          ->where('tarefas.idGrupo', '=',$idGrupo)  
                           ->orderBy('tarefas.created_at', 'desc')           
                          ->get();
        foreach ($posts as $post) {
            $delegado = DB::table('users')
                          ->join('delegas','delegas.idUsuario','=','users.id')
                          ->where([
                                ['idGrupo', '=',$idGrupo],
                                ['idTarefa', '=', $post->id]
                            ])  
                           ->orderBy('delegas.created_at', 'desc')           
                          ->get();
            array_push($delegados, $delegado);
            
        }
        $user = Auth::guard('user')->user();
        
        $porcentagemTotal = DB::table('tarefas') 
                          ->where('tarefas.idGrupo', '=',$idGrupo)      
                          ->avg('porcentagem');
        $minhasTarefas = DB::table('tarefas')
                          ->join('delegas','tarefas.idUsuario','=','delegas.idUsuario')
                          ->where([['delegas.idGrupo', '=',$idGrupo],
                                   ['delegas.idUsuario', '=', $user->id],])  
                           ->orderBy('delegas.created_at', 'desc')           
                          ->get();

        return view('grupo.home', compact('minhasTarefas', 'grupo', 'delegados','participantes', 'posts', 'porcentagemTotal'));
    }

    public function ShowMember ($idGrupo) {
        $grupo = Grupo::find($idGrupo);
        $participantes = DB::table('users')
                          ->join('participas','participas.idUsuario','=','users.id')   
                          ->where('participas.idGrupo', '=',$idGrupo)                                    
                          ->get();
        $user = Auth::guard('user')->user();
        $minhasTarefas = DB::table('tarefas')
                          ->join('delegas','tarefas.idUsuario','=','delegas.idUsuario')
                          ->where([['delegas.idGrupo', '=',$idGrupo],
                                   ['delegas.idUsuario', '=', $user->id],])  
                           ->orderBy('delegas.created_at', 'desc')           
                          ->get();
       
        return view ('grupo.participantes', compact('minhasTarefas', 'participantes', 'grupo'));
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
            $delegados = array();
            foreach ($posts as $post) {
                $delegado = DB::table('users')
                              ->join('delegas','delegas.idUsuario','=','users.id')
                              ->where([
                                    ['idGrupo', '=',$idGrupo],
                                    ['idTarefa', '=', $post->id]
                                ])  
                               ->orderBy('delegas.created_at', 'desc')           
                              ->get();
                array_push($delegados, $delegado);
            }
            $user = Auth::guard('user')->user();
            $minhasTarefas = DB::table('tarefas')
                          ->join('delegas','tarefas.idUsuario','=','delegas.idUsuario')
                          ->where([['delegas.idGrupo', '=',$idGrupo],
                                   ['delegas.idUsuario', '=', $user->id],])  
                           ->orderBy('delegas.created_at', 'desc')           
                          ->get();
            return view('grupo.home', compact('minhasTarefas', 'delegados', 'okNome', 'grupo', 'participantes', 'posts', 'porcentagemTotal'));
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
            $delegados = array();
            foreach ($posts as $post) {
                $delegado = DB::table('users')
                              ->join('delegas','delegas.idUsuario','=','users.id')
                              ->where([
                                    ['idGrupo', '=',$idGrupo],
                                    ['idTarefa', '=', $post->id]
                                ])  
                               ->orderBy('delegas.created_at', 'desc')           
                              ->get();
                array_push($delegados, $delegado);
            }
            $user = Auth::guard('user')->user();
            $minhasTarefas = DB::table('tarefas')
                          ->join('delegas','tarefas.idUsuario','=','delegas.idUsuario')
                          ->where([['delegas.idGrupo', '=',$idGrupo],
                                   ['delegas.idUsuario', '=', $user->id],])  
                           ->orderBy('delegas.created_at', 'desc')           
                          ->get();
            return view( 'grupo.home', compact('minhasTarefas','delegados', 'okNome', 'grupo', 'participantes', 'posts', 'porcentagemTotal'));
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
      $idGrupo = $request->idGroup;
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
                $user = Auth::guard('user')->user();
                $minhasTarefas = DB::table('tarefas')
                          ->join('delegas','tarefas.idUsuario','=','delegas.idUsuario')
                          ->where([['delegas.idGrupo', '=',$idGrupo],
                                   ['delegas.idUsuario', '=', $user->id],])  
                           ->orderBy('delegas.created_at', 'desc')           
                          ->get();
                return view ( 'grupo.participantes', compact( 'minhasTarefas','ok', 'grupo', 'participantes'));
            }
            Participa::create($inputP);
            $grupo = Grupo::find($request->idGroup);
            $participantes = DB::table('users')
                          ->join('participas','participas.idUsuario','=','users.id')   
                          ->where('participas.idGrupo', '=',$request->idGroup)                                    
                          ->get();
            $ok = true;

            $user = Auth::guard('user')->user();
            $minhasTarefas = DB::table('tarefas')
                          ->join('delegas','tarefas.idUsuario','=','delegas.idUsuario')
                          ->where([['delegas.idGrupo', '=',$idGrupo],
                                   ['delegas.idUsuario', '=', $user->id],])  
                           ->orderBy('delegas.created_at', 'desc')           
                          ->get();
            return view ('grupo.participantes', compact('minhasTarefas', 'ok', 'grupo', 'participantes'));
        } catch (\Illuminate\Database\QueryException $e) {
            $okNome = false;
            $grupo = Grupo::find($request->idGroup);
            $participantes = DB::table('users')
                          ->join('participas','participas.idUsuario','=','users.id')   
                          ->where('participas.idGrupo', '=',$request->idGroup)                                    
                          ->get();
            $user = Auth::guard('user')->user();
            $minhasTarefas = DB::table('tarefas')
                          ->join('delegas','tarefas.idUsuario','=','delegas.idUsuario')
                          ->where([['delegas.idGrupo', '=',$idGrupo],
                                   ['delegas.idUsuario', '=', $user->id],])  
                           ->orderBy('delegas.created_at', 'desc')           
                          ->get();
            return view ('grupo.participantes', compact('minhasTarefas','ok', 'e', 'grupo', 'participantes'));
        }
    }


    public function removeMember (Request $request) {
        $Participas = DB::table('participas')
                          ->where([
                                ['idGrupo', '=',$request->idGrupo],
                                ['idUsuario', '=', $request->idParicipante]
                            ])                                    
                          ->delete();
        $delegas = DB::table('delegas')
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
        $user = Auth::guard('user')->user();
        $minhasTarefas = DB::table('tarefas')
                          ->join('delegas','tarefas.idUsuario','=','delegas.idUsuario')
                          ->where([['delegas.idGrupo', '=',$request->idGrupo],
                                   ['delegas.idUsuario', '=', $user->id],])  
                           ->orderBy('delegas.created_at', 'desc')           
                          ->get();
        return view ( 'grupo.participantes', compact('minhasTarefas','okDelete', 'e', 'grupo', 'participantes'));
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
      $delegados = array();
            foreach ($posts as $post) {
                $delegado = DB::table('users')
                              ->join('delegas','delegas.idUsuario','=','users.id')
                              ->where([
                                    ['idGrupo', '=',$idGrupo],
                                    ['idTarefa', '=', $post->id]
                                ])  
                               ->orderBy('delegas.created_at', 'desc')           
                              ->get();
                array_push($delegados, $delegado);
            }
      $user = Auth::guard('user')->user();
      $minhasTarefas = DB::table('tarefas')
                          ->join('delegas','tarefas.idUsuario','=','delegas.idUsuario')
                          ->where([['delegas.idGrupo', '=',$idGrupo],
                                   ['delegas.idUsuario', '=', $user->id],])  
                           ->orderBy('delegas.created_at', 'desc')           
                          ->get();
      return view('grupo.home', compact('minhasTarefas', 'delegados', 'okinsertPost', 'grupo', 'participantes', 'posts', 'porcentagemTotal'));
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
        $delegados = array();
            foreach ($posts as $post) {
                $delegado = DB::table('users')
                              ->join('delegas','delegas.idUsuario','=','users.id')
                              ->where([
                                    ['idGrupo', '=',$idGrupo],
                                    ['idTarefa', '=', $post->id]
                                ])  
                               ->orderBy('delegas.created_at', 'desc')           
                              ->get();
                array_push($delegados, $delegado);
            }
          $user = Auth::guard('user')->user();
          $minhasTarefas = DB::table('tarefas')
                          ->join('delegas','tarefas.idUsuario','=','delegas.idUsuario')
                          ->where([['delegas.idGrupo', '=',$idGrupo],
                                   ['delegas.idUsuario', '=', $user->id],])  
                           ->orderBy('delegas.created_at', 'desc')           
                          ->get();
        return view('grupo.home', compact('minhasTarefas', 'delegados', 'okTarefaUp', 'grupo', 'participantes', 'posts', 'porcentagemTotal'));
        
    }

    
    public function updatePorcent (Request $request) {
      $t = Tarefa::find($request->idTarefa)->update(['porcentagem' => $request->porcentagem]);
      $idGrupo = $request->idGroup; 
       $grupo = Grupo::find($idGrupo);
        $delegados = array();
        $participantes = DB::table('users')
                          ->join('participas','participas.idUsuario','=','users.id')   
                          ->where('participas.idGrupo', '=',$idGrupo)    
                          ->get();
         $posts = DB::table('users')
                          ->join('tarefas','tarefas.idUsuario','=','users.id')
                          ->where('tarefas.idGrupo', '=',$idGrupo)  
                           ->orderBy('tarefas.created_at', 'desc')           
                          ->get();
        foreach ($posts as $post) {
            $delegado = DB::table('users')
                          ->join('delegas','delegas.idUsuario','=','users.id')
                          ->where([
                                ['idGrupo', '=',$idGrupo],
                                ['idTarefa', '=', $post->id]
                            ])  
                           ->orderBy('delegas.created_at', 'desc')           
                          ->get();
            array_push($delegados, $delegado);
        }
        $porcentagemTotal = DB::table('tarefas') 
                          ->where('tarefas.idGrupo', '=',$idGrupo)      
                          ->avg('porcentagem');
        
        $okTarefaUp = true;
        $user = Auth::guard('user')->user();
        $minhasTarefas = DB::table('tarefas')
                          ->join('delegas','tarefas.idUsuario','=','delegas.idUsuario')
                          ->where('tarefas.idGrupo', '=',$idGrupo)  
                           ->orderBy('tarefas.created_at', 'desc')           
                          ->get();

        return view('grupo.home', compact('minhasTarefas','okTarefaUp','grupo', 'delegados','participantes', 'posts', 'porcentagemTotal'));
        
    }


    public function removePost (Request $request) {
      $tarefa = Tarefa::find($request->idPost);
      $tarefa->delete();
      $idGrupo = $request->idGrupo;
      $grupo = Grupo::find($idGrupo);
      $delegados = array();
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
        foreach ($posts as $post) {
          $delegado = DB::table('users')
                        ->join('delegas','delegas.idUsuario','=','users.id')
                        ->where([
                              ['idGrupo', '=',$idGrupo],
                              ['idTarefa', '=', $post->id]
                          ])  
                         ->orderBy('delegas.created_at', 'desc')           
                        ->get();
          array_push($delegados, $delegado);
      }
        $okTarefaDel = true;
        $user = Auth::guard('user')->user();
        $minhasTarefas = DB::table('tarefas')
                          ->join('delegas','tarefas.idUsuario','=','delegas.idUsuario')
                          ->where([['delegas.idGrupo', '=',$idGrupo],
                                   ['delegas.idUsuario', '=', $user->id],])  
                           ->orderBy('delegas.created_at', 'desc')           
                          ->get();
        return view('grupo.home', compact('minhasTarefas', 'okTarefaDel', 'delegados', 'grupo', 'participantes', 'posts', 'porcentagemTotal'));
    }

    public function jaDelegado ($idGroup, $idTarefa, $id){
      $errado = DB::table('delegas')
                          ->where([
                                ['idGrupo', '=', $idGroup],
                                ['idTarefa', '=', $idTarefa],
                                ['idUsuario', '=', $id],
                            ])                                    
                          ->get();
      if (count($errado) > 0)
        throw new Exception('Participante já é delegado dessa tarefa.');
      return true;
    }

    public function atribuiPost (Request $request) {
       try {
          foreach ($request->delegados as $delegado) {
            $Participa = DB::table('users')
                          ->where([
                                ['email', '=',$delegado],
                            ])                                    
                          ->get();

            $inputP = array('idGrupo' => $request->idGroup, 'idTarefa' => $request->idTarefa, 'idUsuario' => $Participa[0]->id,);
            $this->jaDelegado($request->idGroup, $request->idTarefa, $Participa[0]->id);
            Delega::create($inputP);
          }
            
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
          $delegados = array();
          foreach ($posts as $post) {
              $delegado = DB::table('users')
                            ->join('delegas','delegas.idUsuario','=','users.id')
                            ->where([
                                  ['idGrupo', '=',$idGrupo],
                                  ['idTarefa', '=', $post->id]
                              ])  
                             ->orderBy('delegas.created_at', 'desc')           
                            ->get();
              array_push($delegados, $delegado);
          }
          $okDelegado = true;
          $user = Auth::guard('user')->user();
          $minhasTarefas = DB::table('tarefas')
                          ->join('delegas','tarefas.idUsuario','=','delegas.idUsuario')
                          ->where([['delegas.idGrupo', '=',$idGrupo],
                                   ['delegas.idUsuario', '=', $user->id],])  
                           ->orderBy('delegas.created_at', 'desc')           
                          ->get();
          return view('grupo.home', compact('minhasTarefas', 'okDelegado', 'delegados', 'grupo', 'participantes', 'posts', 'porcentagemTotal'));
        } catch (Exception $e) {
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
            $delegados = array();
            foreach ($posts as $post) {
                $delegado = DB::table('users')
                              ->join('delegas','delegas.idUsuario','=','users.id')
                              ->where([
                                    ['idGrupo', '=',$idGrupo],
                                    ['idTarefa', '=', $post->id]
                                ])  
                               ->orderBy('delegas.created_at', 'desc')           
                              ->get();
                array_push($delegados, $delegado);
            }
            $okDelegado = false;
            $user = Auth::guard('user')->user();
            $minhasTarefas = DB::table('tarefas')
                          ->join('delegas','tarefas.idUsuario','=','delegas.idUsuario')
                          ->where([['delegas.idGrupo', '=',$idGrupo],
                                   ['delegas.idUsuario', '=', $user->id],])  
                           ->orderBy('delegas.created_at', 'desc')           
                          ->get();
            return view ('grupo.home', compact('minhasTarefas', 'e', 'delegados', 'okDelegado', 'grupo', 'participantes', 'posts', 'porcentagemTotal'));
        }
    }
}
 
