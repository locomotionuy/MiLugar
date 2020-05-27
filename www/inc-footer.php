<div id="footer">
  <div class="footer_bg_color">
    <div class="center">
      <div class="content">
        <ul class="social">
          <li><a class="color_facebook" href="https://www.facebook.com/milugar.portalinmobiliario"><i class="fab fa-facebook-f fa-fw"></i></a></li>
          <!--<li><a class="color_twitter" href="https://twitter.com/gallito_uy"><i class="fab fa-twitter fa-fw"></i></a></li>
          <li><a class="color_in" href="https://www.linkedin.com/company/gallito"><i class="fab fa-linkedin-in fa-fw"></i></a></li>
          <li><a class="color_email" href="https://www.youtube.com/user/Gallitopuntocom/"><i class="fab fa-youtube fa-fw"></i></a></li>
          <li><a class="color_instagram" href="https://www.instagram.com/gallito_uy/"><i class="fab fa-instagram fa-fw"></i></a></li>-->
        </ul>
        <ul class="menu">
          <?php 
          foreach ($menu_footer as $links_footer)
          {
              if($links_footer[0]==1) echo '<li class="text">'; else echo '<li>';
              echo '<a href="'.$links_footer[1].'" ';
              if($links_footer[2]==0) echo '>'; else echo 'target="_blank">';
              echo $links_footer[4].'</a></li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </div>
  <div class="center">
    <div class="content">
      <ul class="info">
      <strong>Email:</strong> ciu@ciu.org.uy<br />
<strong>Tel:</strong> (+598) 2901 0485 - 2902 8266<br />
<strong>milugar inmobiliario</strong> es un portal de la Cámara Inmobiliaria Uruguaya
      </ul>
      <ul class="logo">
        <li><a href="index.php"><img src="images/logo_pie.png" alt="<?php echo $_SERVER['SERVER_NAME'] ?>" /></a></li>
      </ul>
    </div>
  </div>
</div>
<script type="text/javascript" src="js/custom-select.js"></script>
<!--<div id="chat">
  <button class="open-button" onclick="openForm()"><i class="fas fa-comment-dots"></i></button>
  <div class="chat-popup" id="myForm">
    <form action="/action_page.php" class="form-container">
      <iframe
    allow="microphone;"
    width="100%"
    height="350"
    src="https://console.dialogflow.com/api-client/demo/embedded/01771cdd-7a3f-4681-a281-963215185cdb">
  </iframe>
      <button type="button" class="btn cancel" onclick="closeForm()">Cerrar Chat</button>
    </form>
  </div>
</div>-->
<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>
</body></html>