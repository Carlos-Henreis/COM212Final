<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class TesteController extends Controller
{
    public function upload()
    {
    	return view ('teste');
    }

    public function move()
    {
    	$file = \Input::file('photo'); // retorna o objeto em questão
    	dd($file);
        $destinationPath = public_path().DIRECTORY_SEPARATOR.'files';
        $fileName = '01.'.pathinfo('Hearthstone.desktop')['extension'];

        //var_dump($file->move($destinationPath.DIRECTORY_SEPARATOR.'tmp'));
        var_dump($file->move($destinationPath, $fileName));
    }
}