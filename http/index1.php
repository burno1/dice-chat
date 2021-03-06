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

<!doctype html>
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
				<button  id=createRoom type="button" class="btn btn-primary btn-lg" onclick="window.location.href='register.php'">Criar Sala</button>
			 <!-- <button id=createAcc type="button" class="btn btn-primary btn-lg" onclick="createAcc()">Criar Conta</button>
			 <button id=login type="button" class="btn btn-primary btn-lg" onclick="login()">Login</button>
			 <button id=myRoom type="button" class="btn btn-primary btn-lg" onclick="myRoom()">Minhas Salas</button> -->
		 </div>
		 <div class="space"></div>

		 	<!-- área de atuação do php para acesso ao bd e montagem das salas -->
      <div id="rooms">
        <?php if(mysqli_num_rows($room_set) > 0): ?>
        <?php while ($room = mysqli_fetch_assoc($room_set)): ?>
          <div class="buttons">
  	       <button type="button" class="btn btn-info btn-lg" onclick="window.location.href='login.php'"><?php echo $room["roomName"]?></button>
         </div>
         <?php endwhile;?>
        <?php endif;?>
       </div>
     </div>


		<!-- área de atuação do php para acesso ao bd e montagem das mensagens -->
		<div class="col-sm-10 activeroom">
			<div class="col-sm-12 mensagens">
				<p class="enviado">Mensagem enviada: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
				</p>
				<p class="recebida">Mensagem recebida: Aha</p>
				<p class="recebida">Mensagem recebida: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
				</p>
				<p class="enviado">Mensagem enviada: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
				</p>
				<p class="dado">D18</p>
				<p class="enviado">Mensagem enviada: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
				</p>
				<p class="recebida">Mensagem recebida: Aha</p>
				<p class="recebida">Mensagem recebida: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
				</p>
				<p class="enviado">Mensagem enviada: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
				</p>
				<p class="dado">D18</p>
			</div>

		<!-- área de atuação do javascript/php para envio de mensagens -->
		<div class="sendbox navbar navbar-inverse navbar-fixed-bottom">
			<!-- form action="" -->
 				<div class="col-sm-12">
	 			<input id="msg" type="text" class="teste form-control col-sm-12">
 				<button id=sendTxt onclick="sendTxt()" type="submit" class="btn btn-primary col-sm-2">Enviar</button>
				<button id=sendDice onclick="sendDice()" type="d20" class="btn btn-warning d20">Rolar D20</button>
				</div>
			<!-- /form -->
		</div>
	</div>
</div>
</body>
</html>
