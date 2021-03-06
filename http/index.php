<?php
require_once "credentials.php";
require "authenticate.php";
require "sanitize.php";

$page = $_SERVER['PHP_SELF'];
$sec = "10";

$conn = mysqli_connect($servername,$username,"",$dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") { //INCICIO IF
  if (isset($_POST["message"])) {

    $message = mysqli_real_escape_string($conn,$_POST["message"]);
    $message = verify_field($message);
    $ID = $_SESSION["id"];

    $sql = "INSERT INTO $table (message,roomID)
            VALUES ('$message',$ID);";

		$var = mysqli_query ($conn,$sql);
			if (!$var){
				die( "deu ruim" . mysqli_error($var));
			}
		}
} elseif ($_SERVER["REQUEST_METHOD"] == "GET"){ //Fim do IF
  if (isset($_GET["acao"])) {
    $sql = "";
    $dado_value = rand(1,20);
    $ID = $_SESSION["id"];

    if($_GET["acao"] == "dado"){
      $sql = "INSERT INTO $table (message,dado,roomID)
              VALUES ('$dado_value',1,$ID)";

        }
    if ($sql != ""){
      if(!($dado_set = mysqli_query($conn,$sql))){
        die("deu ruim " . mysqli_error($conn));
      }
    }
    }
  }

if ($login){
$ID = $_SESSION ["id"];


	$sql = "SELECT message,dado,roomID
          FROM messages
          WHERE (roomID=$ID);";
	if(!($message_set = mysqli_query($conn,$sql))){
	  die("Problemas para carregar msgs do BD!<br>".
	       mysqli_error($conn));

}
}
  $sql_rooms = "SELECT roomID,roomName FROM $table1";
  if (!($room_set= mysqli_query($conn,$sql_rooms))){
    die ("deu ruim no bd <br>" . mysqli_error ($conn));
  }


	mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<title>Dice & Chat</title>
	<meta charset="utf-8">
   <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/css.css">
	<script src=js/jquery.js></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/check_register.js"></script>
</head>
<body>
  <div class="container-fluid">
  <!-- Banner -->
	<div class="row banner">
 		<div class="col-sm-12">
			<img src="images/banner1.jpg">
		</div>
	</div>
  <!-- Banner -->


	<!--corpo do site -->
	<div class="row body">

		<!-- menu -->
		<div class="col-sm-2 side">
			<div class="buttons">
        <button type="button" id=createRoom  class="btn btn-primary btn-lg" onclick="window.location.href='register.php'">Criar Sala</button>
		 </div>
     <!-- fim do menu -->

		 <div class="space"></div>

		 	<!-- área de atuação do php para acesso ao bd e montagem das salas -->
		 <div id="rooms">
       <div class="buttons">
       <?php if($login): ?>
         	<button type="button" class="btn btn-info btn-lg" onclick=""><?php echo "Conectado: " . $roomName ?> </button>
          <button type="button" class="btn btn-danger btn-lg" onclick="window.location.href='logout.php'"><?php echo "Logout: " . $roomName ?> </button>
        <?php elseif(mysqli_num_rows($room_set) > 0): ?>
          <?php while ($room = mysqli_fetch_assoc($room_set)): ?>
             <button type="button" class="btn btn-info btn-lg" onclick="window.location.href='login.php'"><?php echo $room["roomName"]?></button>
           <?php endwhile;?>
         <?php endif;?>
         </div>
      </div>
		</div>

    <!-- Fim da area de acesso as rooms -->

<!-- área de atuação do php para acesso ao bd e montagem das mensagens -->
    <div class="col-sm-10 activeroom">
<!-- Envio de mensagem, dado = 1 estiliza o dado -->
			<div id=chatArea class="col-sm-12 mensagens">
        <?php if($login) : ?>
          <!-- rola mensagens para baixo-->
            <script>$("#chatArea").animate({ scrollTop: $('#chatArea').prop("scrollHeight")}, 500);</script>
				<?php if(mysqli_num_rows($message_set) > 0): ?>
					<?php while($message = mysqli_fetch_assoc($message_set)): ?>
            <?php if($message["dado"] == 0): ?>
				          <p class="enviado"><?php echo $message["message"] ?></p>
                 <?php else: ?>
		                  <p class="dado"><?php echo $message["message"] ?> </p>
              <?php endif; ?>
			     <?php endwhile;?>
			  <?php endif; ?>
      <?php endif; ?>
    </div>
<!-- Fim da área de mensagens -->

		<!-- área de atuação do javascript/php para envio de mensagens -->
		<div class="sendbox navbar navbar-inverse navbar-fixed-bottom">

			<!-- form action="ENVIAR MENSAGEM PRO BD" -->
 				<div class="col-sm-12">

        <?php if($login): ?> <!-- Desativa a barra de chat e dado caso não haja sessão -->
				<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
					<div class="form-group">
						<input required type="text" name="message" class="form-control" id="inputMessage" placeholder="Enviar nova mensagem">
					</div>
				</form>
        <!-- fim do form -->

        <!-- Botão de rolagem de dados, metodo GET -->
        <a href="<?php echo $_SERVER["PHP_SELF"] . "?id=" . "" . "&" . "acao=dado" ?>">
          <button aria-label="Feito" class="btn btn-warning d20" type="d20">
            <span class="glyphicon glyphicon-ok"></span> Rolar D20!
          </button>
        </a>
        <!-- Fim área do botão -->
          <?php endif; ?> <!-- Desativa barra de chat e dado caso não haja sessão -->
				  </div>
		    </div>
    <!-- /form -->

    </div>
  </div>
</div>
</body>

</html>
