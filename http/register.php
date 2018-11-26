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
	<title>Dice & Chat - Registro</title>
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
    <h1>NOVA SALA</h1>
  </div>

<?php if ($success): ?>
  <h1>Sala criado com sucesso!</h1>
  <button type="button" class="btn btn-info btn-lg col-sm-2" onclick="window.location.href='index.php'">Segui para Chat</button>
<?php endif; ?>

<?php if ($error): ?>
  <h3 style="color:red;"><?php echo $error_msg; ?></h3>
<?php endif; ?>

<form id="login" action="register.php" method="post">
  <label class="col-sm-2"  for="name">NOME DA SALA:</label>
  <input type="text" name="name" value="<?php echo $name; ?>" required><br>

  <label class="col-sm-2"  for="password">SENHA:</label>
  <input type="password" name="password" value="" required><br>

  <label class="col-sm-2"  for="confirm_password">CONFIRME SENHA:</label>
  <input type="password" name="confirm_password" value="" required><br>

  <div class="row">
  <input type="submit" class="btn btn-primary btn-lg col-sm-2" name="submit" value="CRIAR SALA">
</form>

<button type="button" class="btn btn-info btn-lg col-sm-2" onclick="window.location.href='index.php'">VOLTAR</button>
</div>
</body>
</html>
