<meta charset="utf-8">
<!DOCTYPE html>
<html>
  <head>
    <title>CATALOG</title>

    <script type="text/javascript">

    window.onload = function(){
    var eTitle = document.getElementById('divTitle');
    var ePrice = document.getElementById('divPrice');
    eTitle.addEventListener('click', function(et){
      et.preventDefault();
      document.getElementById('textTitle').value = et.target.className;
    });

    ePrice.addEventListener('click', function(ep){
      ep.preventDefault();
      document.getElementById('textPrice').value = ep.target.className;
    });
  }
    </script>
  </head>
  <body>

    <style media="screen">
      .divTitle{
        position: absolute;
        top: 350px;
        left: 5px;
        width: 675px;
        height: 321px;
        overflow: auto;
        display: none;
      }

      .divPrice{
        position: absolute;
        top: 350px;
        left: 685px;
        width: 675px;
        height: 321px;
        overflow: auto;
        display: none;
      }

      #table{
        position: absolute;
        top: 0px;
        left: 0px;
      }

      #formTitleAndPrice{
        display: none;
      }

      #formTitle{
        display: none;
      }
      #formPrice{
        display: none;
      }
    </style>

    <?php

/*IMPORTANTE REGEX PEGA PREÇO

    //preg_match_all('#class=".*?value.*?">([0-9\.\,]+)<#', $la, $bosta);

    echo "0";
    echo"<br>";
    foreach ($bosta[0] as $key => $b) {
      echo"<pre>$key = $b</pre>";
    }

    echo"<br>";
    echo"<br>";
    echo"<br>";
    echo"1";
    echo"<br>";
    foreach ($bosta[1] as $key => $b) {
      echo "<pre>$key = $b</pre>";
    }
    */

  if(!empty($titles) && !empty($prices)){
    $arrayRightPrice = array();
    $arrayRightTitle = array();
    $arrayPrePrice = array();
    $showDivTitle = 0;
    $showDivPrice = 0;

    //$conteudo = file_get_contents($url);
/*TESTE
    $meta = preg_replace('/<meta(.*?)\/>/', ' ' , $conteudo);
    //$corpo = preg_replace('/<head>(.*?)<\/head>/', ' ' , $conteudo);
    //$resposta = preg_replace('/<script(.*?)</', ' ' , $corpo);
    //$resposta1 = preg_replace('/<a.*?href="(.*?)"/', ' ' , $resposta);*/
    //$resposta = preg_replace('/href="(.*?)"/', /*"href=\"#\""*/"" , $conteudo);

    //
    preg_match_all('#class=".*?value.*?">([0-9\.\,]+)<#', $resposta, $matchesPrice);

    //preg_match_all('#class=".*?card-product-name.*?">(.*?)<#', $resposta, $matches);

    foreach ($titles as $title) {
      preg_match_all($title->regex, $resposta, $matchesTitle);
      if (count($matchesTitle[1])!= 0){
        $arrayRightTitle = $matchesTitle[1];
        $showDivTitle = 1;
        break;
      }
    }

    foreach ($prices as $price) {
      preg_match_all($price->regex, $resposta, $matchesPrice);
      if (!empty($matchesPrice[1])){
        $arrayPrePrice = $matchesPrice[1];
        $showDivPrice = 1;
        break;
      }
    }

    $i = 0;
    foreach($arrayPrePrice as $app){

       //if (is_numeric($newArp)){
       if(strpbrk($app, '0123456789')){
         if(strpbrk($app, 'R$')){
           $arrayRightPrice[$i] = preg_replace('#(R\$|$)#', "", $app);
           $i++;
         }else{
           $arrayRightPrice[$i] = $app;
           $i++;
         }
       }
       else{
         continue;
       }
     }

    /*foreach ($prices as $price) {
      echo $price->regex;
    }*/

/*
    if($showDivTitle == 1 && $showDivPrice == 1){
    echo"<table id = \"table\">";
    echo"<th>Nome</th>";
    echo"<th>Preço</th>";
    foreach ($arrayRightTitle as $key => $arn) {
      echo"<tr>";
      echo "<td>$arn</td>";
      if(ctype_alpha($arrayRightPrice[$key])){
        echo"é letra";
        $new_key = $key + 1;
        echo "<td>$arrayRightPrice[$new_key]</td>";
        echo "<br>";
        echo"</tr>";
      }
      else{
        echo "É numero";
        echo "<td>$arrayRightPrice[$key]</td>";
        echo "<br>";
        echo"</tr>";
      }
    }
    echo"</table>";
  }*/

    //novo foreach
/*
    if($showDivTitle == 1 && $showDivPrice == 1){
    echo"<table id = \"table\">";
    echo"<th>Nome</th>";
    echo"<th>Preço</th>";
    foreach ($arrayRightTitle as $arn) {
      echo"<tr>";
      echo "<td>$arn</td>";
    }

      foreach ($arrayRightPrice as $arp) {
        if(!ctype_alpha($arp){
          echo "<td>$arp</td>";
          echo"</tr>";
        }
      }
      echo"</table>";
    }
    //end novo foreach
*/

  if($showDivTitle == 1 && $showDivPrice == 1){
    echo"<table id = \"table\">";
    echo"<th>Nome</th>";
    echo"<th>Preço</th>";
  foreach ($arrayRightTitle as $key => $arn) {
    echo"<tr>";
    echo "<td>$arn</td>";
    echo "<td>$arrayRightPrice[$key]</td>";
    echo "</tr>";
  }

 /* foreach($arrayRightPrice as $arp){

    //if (is_numeric($newArp)){
    if(strpbrk($arp, '0123456789')){
      //echo "entrou aqui";
      echo "<td>$$arp</td>";
      echo"</tr>";
    }
    else{
      continue;
    }
  }*/
  echo"</table>";
  }
}
    ?>

   <div class="divTitle" id="divTitle">
     <?php

      //$conteudo = file_get_contents($url);
      //$resposta = preg_replace('/href="(.*?)"/', 'href=""' , $conteudo);

      echo $resposta;
      ?>
   </div>

   <div class="divPrice" id="divPrice">
     <?php

            //$conteudo = file_get_contents($url);
            //$resposta = preg_replace('/href="(.*?)"/', '' , $conteudo);

           echo $resposta;
     ?>
   </div>

    <form class="" id="formTitle" action="{{ action('ParseController@onlyTitle') }}" method="post">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
    <?php //titulo

    if($showDivTitle == 0 && $showDivPrice == 1){

       echo"<style media=\"screen\">
         .divTitle{
           display: inline;
         }

         #formTitle{
           display: inline;
         }
       </style>
       ";
       echo'<input type="text" name="textTitle" id="textTitle" placeholder="Title" readonly="true">';
       echo'<input type="submit" name="btnChoice" id="btnChoice" value="OK">';
     }
    ?>
    </form>


    <form class="" id="formPrice" action="{{ action('ParseController@onlyPrice') }}" method="post">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
    <?php //preço
      echo $showDivPrice;
      echo $showDivTitle;
    if($showDivTitle == 1 && $showDivPrice == 0){
       echo"<style media=\"screen\">
         .divPrice{
           display: inline;
         }

         #formPrice{
           display: inline;
         }
       </style>
       ";
       echo'<input type="text" name="textPrice" id="textPrice" placeholder="Price" readonly="true">';
       echo'<input type="submit" name="btnChoice" id="btnChoice" value="OK">';
     }
    ?>
    </form>

    <form class="" id="formTitleAndPrice" action="{{ action('ParseController@titleAndPrice') }}" method="post">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
    <?php //titulo e preço
    if(($showDivTitle == 0 && $showDivPrice == 0)||(empty($titles) && empty($prices))){
      echo"<style media=\"screen\">
        .divTitle{
          display:inline;

        }

        .divPrice{
          display: inline;
        }

        #formTitleAndPrice{
          display: inline;
        }

      </style>
      ";

      echo'<input type="text" name="textTitle" id="textTitle" placeholder="Title" readonly="true">';
      echo'<input type="text" name="textPrice" id="textPrice" placeholder="Price" readonly="true">';
      echo'<input type="submit" name="btnChoice" id="btnChoice" value="OK">';
    }
    ?>
    </form>

  </body>
</html>
