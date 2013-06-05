<? include('_header.php'); ?>
  <div id='content' class='container'>    
      <div class='row'>        
        <?
          $checked_cameras = !empty($_GET['camera']) ? $_GET['camera'] : array_keys($cameras);
          $checked_events = !empty($_GET['event']) ? $_GET['event'] : array('TIMER');
        ?>
        <div class='span12'><h2>Фильтр по камерам и событиям</h2> </div>
         <div class='span12'><form>
          <fieldset>

            
            <div class='span4'>

                <legend>Камеры</legend>
                <?
                $checked = count($checked_cameras) == count($cameras) ? 'checked="1"' : '';
                echo '<label class="checkbox"><input '.$checked.' type="checkbox" id="camera_toggle" /> <strong>Все камеры</strong></label>';
                ?>

                <?
                
                foreach ($cameras as $alias => $name) {

                  $checked = in_array($alias, $checked_cameras) ? 'checked="1"' : '';

                  echo '<label class="checkbox"><input '.$checked.' class="input-camera" type="checkbox" name="camera[]" value="'.$alias.'" /> '.$name.' ('.$alias.')</label>';
                }


                ?>

            </div>

            <div class='span4'> 
              <legend>Дата и время</legend>
              <label>От</label>
              <input type="text" id="from" name="from" class='input-small' value="<?=$_GET['from']?>">
              <input type="text" name="from_time" id='from_time' class='input-small' value="<?=$_GET['from_time']?>">

              <label>До</label>
              <input type="text" id="to" name='to' class='input-small' value="<?=$_GET['to']?>" />
              <input type="text" name="to_time" id='to_time' class='input-small' value="<?=$_GET['to_time']?>">


            </div>


            <div class='span3'>
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
        </form></div> <!-- / span12 -->
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


              // date from request
              $to = 9999999999;
              if ($_GET['to'] && $_GET['to_time']) {
                $to = strtotime ($_GET['to']  . ' ' . $_GET['to_time']);                
              }

              $from = 0;
              if ($_GET['from'] && $_GET['from_time']) {
                $from = strtotime ($_GET['from']  . ' ' . $_GET['from_time']);
              }

              if ($result_file) {
                ksort($result_file);                
                

                echo '<div class="fotorama" data-width="100%" data-hash="true"  data-nav="none" data-startImg="'.(count($result_file)-1).'">';

                foreach ($result_file as $time => $file) {
                  if ($time >= $from && $time <= $to) {
                    echo "<a href='".IMAGE_URL.$file."' rel='".$time."' data-date='".strftime('%Y-%m-%d %T',$time)."'><img src='' alt='' /></a> \n";  
                  }                  
                }

                echo '</div>';
              }


            ?>
        </div>
      </div>

  </div>

<?  include('_footer.php'); ?>