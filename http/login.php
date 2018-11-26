<?php
require "db_functions.php";
require "authenticate.php";

$error = false;
$password = $ID = $name = "";

if (!$login && $_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["name"]) && isset($_POST["password"])) {

    $conn = connect_db();

    $name = mysqli_real_escape_string($conn,$_POST["name"]);
    $password = mysqli_real_escape_string($conn,$_POST["password"]);
    $password = md5($password);

    $sql = "SELECT roomID,roomName,roomPassword FROM rooms
            WHERE roomName = '$name';";

    $result = mysqli_query($conn, $sql);
    if($result){
      if (mysqli_num_rows($result) > 0) {
        $room = mysqli_fetch_assoc($result);


        if ($room["roomPassword"] == $password) {

          $_SESSION["name"] = $room["roomName"];
          $_SESSION["id"] = $room["roomID"];

          header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php");
          exit();
        }
        else {
          $error_msg = "Senha incorreta!";
          $error = true;
        }
      }
      else{
        $error_msg = "Usuário não encontrado!";
        $error = true;
      }
    }
    else {
      $error_msg = mysqli_error($conn);
      $error = true;
    }
  }
  else {
    $error_msg = "Por favor, preencha todos os dados.";
    $error = true;
  }
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Dice & Chat - Login</title>
	<meta charset="utf-8">
   <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/css.css">
	<script src=js/jquery.js></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/check_register.js"></script>
</head>
<body>

<div class="col-sm-4">
  <h1>LOGIN</h1>
</div>

<?php if ($login): ?>
    <h3>Você já está logado!</h3>
    <?php echo $_SESSION["id"] ?>
  </body>
  </html>
  <?php exit(); ?>
<?php endif; ?>

<?php if ($error): ?>
  <h3 style="color:red;"><?php echo $error_msg; ?></h3>
<?php endif; ?>

<form id="login" action="login.php" method="post">
  <label class="col-sm-2"  for="text">NOME DA SALA: </label>
  <input class="logintext" type="text" name="name" value="" required><br>

  <label class="col-sm-2" for="password">SENHA: </label>
  <input type="password" name="password" value="" required><br>

    <div class="row">
  <input type="submit" class="btn btn-primary btn-lg col-sm-2" name="submit" value="ENTRAR">

</form>

  <button type="button" class="btn btn-info btn-lg col-sm-2" onclick="window.location.href='index.php'">VOLTAR</button>
</div>
</body>
</html>
