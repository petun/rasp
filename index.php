<?
require_once ('config.php');

$checked_cameras = !empty($_GET['camera']) ? $_GET['camera'] : array_keys($cameras);
$checked_events = !empty($_GET['event']) ? $_GET['event'] : array('MOTION');

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Rasp Cameras</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/fotorama.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" media="screen">
  </head>
  <body>
  <header class="jumbotron subhead" id="overview">
    <div class="container">
      <h1>Rasp Camera</h1>
      <p class="lead">Fundamental HTML elements styled and enhanced with extensible classes.</p>
    </div>
  </header>
  <div id='content'>
    <div class="container">
      <div class='row'>        
        <div class='span12'><h2>Фильтр по камерам и событиям</h2> </div>
        <form>
          <fieldset>

            
            <div class='span6'>

                <legend>Выберите камеры из списка</legend>
                <?
                $checked = count($checked_cameras) == count($cameras) ? 'checked="1"' : '';
                echo '<label class="checkbox"><input '.$checked.' type="checkbox" id="camera_toggle" /> <strong>Все камеры</strong></label>';
                ?>

                <?
                
                foreach ($cameras as $alias => $name) {

                  $checked = in_array($alias, $checked_cameras) ? 'checked="1"' : '';

                  echo '<label class="checkbox"><input '.$checked.' class="input-camera" type="checkbox" name="camera[]" value="'.$alias.'" /> '.$name.'</label>';
                }


                ?>

            </div>


            <div class='span6'>
                <legend>События</legend>

                <?
                $checked = count($checked_events) == count($events) ? 'checked="1"' : '';
                echo '<label class="checkbox"><input '.$checked.' type="checkbox" id="event_toggle" /><strong>Все события</strong> </label>';
                ?>

                <?
                
                foreach ($events as $alias => $name) {

                  $checked = in_array($alias, $checked_events) ? 'checked="1"' : '';

                  echo '<label class="checkbox"><input '.$checked.' class="input-event" type="checkbox" name="event[]" value="'.$alias.'" /> '.$name.'</label>';
                }


                ?>


                   <button type="submit" class="btn btn-success pull-right">Показать</button>

            </div>




          </fieldset>
        </form>
      </div>

      <div class='row'>        
        <div class='span12'>
            <h2>Результаты</h2>
            <?
              $files = scandir(IMAGE_PATH);

              // все регулярки по имени файла в соответствии с выбраными событиями и камерами
              $cams = implode('|',$checked_cameras);
              $events = implode('|',$checked_events);

              $pattern = "/^($cams)-($events).+$/i";

              //echo $cams . $events;

              if ($files) {
                foreach ($files as $file) {
                  //echo $pattern . $file . "\n\n";
                    if (preg_match($pattern, $file)) {
                      $result_file[filemtime(IMAGE_PATH.$file)] = $file;
                    }
                }
              }

              if ($result_file) {
                ksort($result_file);
                

                echo '<div class="fotorama" data-width="100%">';

                foreach ($result_file as $file) {
                  echo "<img src='".IMAGE_URL.$file."' alt='' />";
                }

                echo '</div>';
              }


            ?>
        </div>
      </div>


      
    </div>

  </div>

  <footer class="footer">
      <div class="container">
        <p>2013 @ petun911@gmail.com</p>
      </div>
    </footer>




    <script src="js/jquery.min.js"></script>    
    <script src="js/bootstrap.min.js"></script>
    <script src="js/fotorama.js"></script>

    <script type='text/javascript'>
    $(function () {
       $('#camera_toggle').on('click', function () {
          $('.input-camera').prop('checked', this.checked);
       });
       
       $('#event_toggle').on('click', function () {
          $('.input-event').prop('checked', this.checked);
        });
    });
    </script>
  </body>
</html>