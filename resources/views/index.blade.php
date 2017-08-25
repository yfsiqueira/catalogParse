<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>URL</title>
  </head>
  <body>

    <form class="" action="{{ action('ParseController@catalog') }}" method="post">
      <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
      <input type="text" name="url" value="" placeholder="Digite a URL">
      <input type="submit" name="submit" value="OK" >
    </form>

  </body>
</html>
