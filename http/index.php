<?php
require_once "credentials.php";

$conn = mysqli_connect($servername,$username,"",$dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") { //INCICIO IF
  if (isset($_POST["message"])) {

    $message = ($_POST["message"]);

    $sql = "INSERT INTO $table (message)
            VALUES ('$message');";

		$var = mysqli_query ($conn,$sql);
			if (!$var){
				die( "deu ruim" . mysqli_error($var));
			}
		}
} //Fim do IF

	$sql = "SELECT message FROM $table ";
	if(!($message_set = mysqli_query($conn,$sql))){
	  die("Problemas para carregar tarefas do BD!<br>".
	       mysqli_error($conn));

}
  $sql_rooms = "SELECT roomID,roomName FROM $table1";
  if (!($room_set= mysqli_query($conn,$sql_rooms))){
    die ("deu ruim no bd <br>" . mysqli_error ($conn));
  }


	mysqli_close($conn);

?>

<html lang="pt">
<head>
	<title>Dice & Chat</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/css.css">
	<script src=js/jquery.js></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/js.js"></script>
</head>

<body>
	<div class="row banner">
 		<div class="col-sm-12">
			<img src="images/banner1.jpg">
		</div>
	</div>
	<!--corpo do site -->
	<div class="row body">

		<!-- menu -->
		<div class="col-sm-2 side">
			<div class="buttons">
			<a href="register.php"	<button id=createRoom type="button" class="btn btn-primary btn-lg">Criar Sala</button>> </a>
		 </div>
		 <div class="space"></div>

		 	<!-- área de atuação do php para acesso ao bd e montagem das salas -->
		 <div id="rooms">
       <?php if(mysqli_num_rows($room_set) > 0): ?>
       <?php while ($room = mysqli_fetch_assoc($room_set)): ?>

 		<a href="login.php"	<button type="button" class="btn btn-info btn-lg"><?php echo $room["roomName"] ?> </button> </a>
    <?php endwhile;?>
  <?php endif;?>
      </div>
		</div>

		<!-- área de atuação do php para acesso ao bd e montagem das mensagens -->
		<div class="col-sm-10 activeroom">

			<div id=chatArea class="col-sm-12 mensagens">
				<?php if(mysqli_num_rows($message_set) > 0): ?>
					<?php while($message = mysqli_fetch_assoc($message_set)): ?>
				<p class="enviado"><?php echo $message["message"] ?></p>
			<!-- <p class="recebido> </p> -->
			<?php endwhile;?>
			<?php endif; ?>

      </div>

		<!-- área de atuação do javascript/php para envio de mensagens -->
		<div class="sendbox navbar navbar-inverse navbar-fixed-bottom">

			<!-- form action="ENVIAR MENSAGEM PRO BD" -->
 				<div class="col-sm-12">

				<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
					<div class="form-group">
						<input required type="text" name="message" class="form-control" id="inputMessage" placeholder="Enviar nova mensagem">
					</div>
				</form>

				<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
					<div class="form-group">
						<button id=sendDice name="sendDice" type="d20" class="btn btn-warning d20">Rolar D20</button>
					</div>
				</form>

				</div>
		</div>
<!-- /form -->

	</div>
</div>
</body>

</html>
