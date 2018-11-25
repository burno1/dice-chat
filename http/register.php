<?php
require "db_functions.php";
require "sanitize.php";

$error = false;
$success = false;
$name = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["name"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {

    $conn = connect_db();

    $name = mysqli_real_escape_string($conn,$_POST["name"]);
    $password = mysqli_real_escape_string($conn,$_POST["password"]);
    $confirm_password = mysqli_real_escape_string($conn,$_POST["confirm_password"]);

    $name = verify_field($name);
    $password = verify_field($password);
    $confirm_password = verify_field($confirm_password);

    if ($password == $confirm_password) {
      $password = md5($password);

      $sql = "INSERT INTO $table1
              (roomName, roomPassword) VALUES
              ('$name', '$password');";

      if(mysqli_query($conn, $sql)){
        $success = true;
      }
      else {
        $error_msg = mysqli_error($conn);
        $error = true;
      }
    }
    else {
      $error_msg = "Senha não confere com a confirmação.";
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
<h1>Dados para registro de nova Sala</h1>

<?php if ($success): ?>
  <h3 style="color:lightgreen;">Sala criado com sucesso!</h3>
  <p>
    Seguir para <a href="index.php">Chat</a>.
  </p>
<?php endif; ?>

<?php if ($error): ?>
  <h3 style="color:red;"><?php echo $error_msg; ?></h3>
<?php endif; ?>

<form action="register.php" method="post">

  <label for="name">Nome da Sala: </label>
  <input type="text" name="name" value="<?php echo $name; ?>" required><br>

  <label for="password">Senha: </label>
  <input type="password" name="password" value="" required><br>

  <label for="confirm_password">Confirmação da Senha: </label>
  <input type="password" name="confirm_password" value="" required><br>

  <input type="submit" name="submit" value="Criar usuário">
</form>

<ul>
  <li><a href="index.php">Voltar</a></li>
</ul>
</p>
</body>
</html>
