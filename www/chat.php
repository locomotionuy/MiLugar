<?php 
include 'inc-conn.php';

$mod = 'chat';
include 'inc-header.php';
?>

<div class="body">
  <div id="secciones">
    <div class="nombre_seccion">
      <div class="center">
        <div class="content">Chatbot</div>
      </div>
    </div>
    <div class="center">
      <div class="content">
		<button class="open-button" onclick="openForm()">Iniciar Chat</button>

<div class="chat-popup" id="myForm">
  <form action="/action_page.php" class="form-container">
<!-- Carga el codigo de ChatBot de Dialogflow -->
  <iframe
    allow="microphone;"
    width="350"
    height="430"
    src="https://console.dialogflow.com/api-client/demo/embedded/56feb9f8-4d72-4733-90ad-af78ea96b993">
</iframe>
<!-- Aquí termina el codigo de ChatBot de Dialogflow -->
    <button type="button" class="btn cancel" onclick="closeForm()">Cerrar Chat</button>
  </form>
</div>

<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>
   </div>
    </div>
  </div>
</div>
<?php include 'inc-footer.php'; ?>

<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/* Boton para abrir el chat si está cerrado - estático al pie de la página */
.open-button {
  background-color: #0084ff;
  color: white;
  padding: 16px 20px;
  border: none;
  box-shadow: 1px 1px 30px 2px rgba(0, 0, 0, 0.22);
  border-radius: 10px;
  cursor: pointer;
  opacity: 0.8;
  position: fixed;
  bottom: 23px;
  right: 28px;
  width: 280px;
}

/* El Cuadro Emergente de Chat - se muestra por defecto*/
.chat-popup {
  display: content;
  position: fixed;
  bottom: 20px;
  right: 15px;
  border: 4px solid #0084ff;
  box-shadow: 1px 1px 30px 2px rgba(0, 0, 0, 0.22);
  border-radius: 5px;
  z-index: 9;
  opacity: 0.98;
  }

/* Estilos del contenedor del formulario */
.form-container {
  max-width: 370px;
  padding: 10px;
  background-color: white;
}

/* Area de Texto de Ancho completo */
.form-container textarea {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
  resize: none;
  min-height: 435px;
}


/* Color de fondo verde aqua para el botón que minimiza el Cuadro Emergente del Chat */
.form-container .cancel {
  background-color: #2ECC71;
}

/* Efectos Hover generales sobre los botones */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
</style>
