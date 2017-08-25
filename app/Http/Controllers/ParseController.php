<?php

namespace App\Http\Controllers;

use App\Title;
use App\Price;

use Illuminate\Http\Request;

class ParseController extends Controller
{
    public function index(){
      return view('index');
    }

    public function catalog(Request $request){
      $titles = Title::get();
      $prices = Price::get();
      $url = $request['url'];
      $reverse = strrev($url);
      preg_match('#moc\.(.*?)\.#', $reverse, $matches);
      $name = ucfirst(strrev($matches[1]));

      $conteudo = file_get_contents($url);
      $resposta = preg_replace('/href="(.*?)"/', '' , $conteudo);

      return view('catalog')->with('url', $url)
                            ->with('name', $name)
                            ->with('titles', $titles)
                            ->with('resposta', $resposta)
                            ->with('prices', $prices);
    }

    public function onlyTitle(Request $request){
      $titulo = ($request['textTitle']);
      $newTitulo = "#class=\".*?".$titulo."\".*?>(.*?)<#";
      $title = new Title();
      $title->regex = $newTitulo;
      $title->save();

      return redirect()->route('index');
    }

    public function onlyPrice(Request $request){
      $preco = ($request['textPrice']);
      var_dump($preco);
      $newPreco = "#class=\".*?".$preco.".*?\".*?>(.*?)<#";
      $price = new Price();
      $price->regex = $newPreco;
      $price->save();

      return redirect()->route('index');
    }

    public function titleAndPrice(Request $request){
      $titulo = ($request['textTitle']);
      $newTitulo = "#class=\".*?".$titulo.".*?\".*?>(.*?)<#";
      //var_dump($newTitulo);
      $title = new Title();
      $title->regex = $newTitulo;
      $title->save();

      $preco = ($request['textPrice']);
      $newPreco = "#class=\".*?".$preco."\".*?>([0-9\.\,]+)<#";
      //var_dump($newPreco);
      $price = new Price();
      $price->regex = $newPreco;
      $price->save();

      return redirect()->route('index');
    }
}
