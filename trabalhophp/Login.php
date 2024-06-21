<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trabalho";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["login"])) {
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        $email = $_POST["email"];
        $senha = $_POST["senha"];

        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {

            $row = $result->fetch_assoc();


            if (password_verify($senha, $row['Senha'])) {

                $_SESSION["usuario_id"] = $row["ID"];
                $_SESSION["nome"] = $row["Nome"];
                header("Location: index.php");
                exit;
            } else {
                $msg = "E-mail ou senha inválidos.";
            }
        } else {
            $msg = "E-mail ou senha inválidos.";
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Usuário</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container mt-5 p-4 rounded">
        <h1 class="text-center">Login de Usuário</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if (!empty($msg)): ?>
                    <div class="alert alert-info">
                        <?php echo $msg; ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary">Entrar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

