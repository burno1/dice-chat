<?php
require "db_functions.php";
require "authenticate.php";

$error = false;
$password = $name = "";

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
        $user = mysqli_fetch_assoc($result);


        if ($user["roomPassword"] == $password) {

          $_SESSION["name"] = $user["roomName"];
          $_SESSOION["id"] = $user["roomID"];

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
  <meta charset="utf-8">
  <title>[WEB 1] Exemplo Sistema de Login - Registro</title>
</head>
<body>
<h1>Login</h1>

<?php if ($login): ?>
    <h3>Você já está logado!</h3>
  </body>
  </html>
  <?php exit(); ?>
<?php endif; ?>

<?php if ($error): ?>
  <h3 style="color:red;"><?php echo $error_msg; ?></h3>
<?php endif; ?>

<form action="login.php" method="post">
  <label for="text">Nome da Sala: </label>
  <input type="text" name="name" value="<?php echo $name; ?>" required><br>

  <label for="password">Senha: </label>
  <input type="password" name="password" value="" required><br>

  <input type="submit" name="submit" value="Entrar">
</form>

<ul>
  <li><a href="index.php">Voltar</a></li>
</ul>
</p>
</body>
</html>
