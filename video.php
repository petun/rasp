<? include('_header.php'); ?>
  <div id='content' class="container">    
      <div class='row'>  
        <div class='span12'>
          <h2>Видео</h2>
          <?
            $content = scandir (VIDEO_PATH);
            if ($content) {
              echo '<ul>';
              foreach ($content as $key => $file) {
                $info = pathinfo(VIDEO_PATH.$file);
                if ( in_array($info['extension'],$allowedExtensions)) {
                    echo '<li><a href="'.VIDEO_URL.$file.'">'.$file.'</a></li>';
                }
              }
              echo '</ul>';
              
            }

          ?>
        </div>        
      </div>    
  </div>

<?  include('_footer.php'); ?>