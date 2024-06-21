<?php
session_start();


include_once "conexao.php";

$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);


    if ($conn) {
        
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, DataCadastro) VALUES (?, ?, ?, NOW())");
        
        if ($stmt) {
            $stmt->bind_param("sss", $nome, $email, $senhaHash);

            if ($stmt->execute()) {
                $msg = "Usuário cadastrado com sucesso!";
                
                
                header("Location: index.php");
                exit; 
            } else {
                $msg = "Erro ao cadastrar usuário: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $msg = "Erro ao preparar a consulta: " . $conn->error;
        }
    } else {
        $msg = "Falha na conexão com o banco de dados.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <h1 class="text-center">Cadastro de Usuário</h1>
        <div class="row justify-content-center">
            <div class="col-md-6 bg-dark p-4 rounded">
                <?php if (!empty($msg)): ?>
                    <div class="alert alert-info">
                        <?php echo $msg; ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


