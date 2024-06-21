<?php
session_start();


include_once "conexao.php";

$msg = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["titulo"], $_POST["ingredientes"], $_POST["modo_preparo"], $_POST["tempo_preparo"], $_POST["dificuldade"])) {
        
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        $titulo = $_POST["titulo"];
        $ingredientes = $_POST["ingredientes"];
        $modo_preparo = $_POST["modo_preparo"];
        $tempo_preparo = $_POST["tempo_preparo"];
        $dificuldade = $_POST["dificuldade"];
        $usuario_id = $_SESSION["usuario_id"]; 

        
        $sql = "INSERT INTO receita (titulo, ingredientes, modo_preparo, tempo_preparo, dificuldade, data_criacao) 
                VALUES ('$titulo', '$ingredientes', '$modo_preparo', $tempo_preparo, '$dificuldade', NOW())";

        if ($conn->query($sql) === TRUE) {
            $msg = "Receita cadastrada com sucesso!";
            header("Location: index.php");
            exit; 
        } else {
            $msg = "Erro ao cadastrar receita: " . $conn->error;
        }

        $conn->close();
    } else {
        $msg = "Por favor, preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Receita</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 50px; 
        }
        .msg {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body class="bg-dark text-white">
    <div class="container mt-5 p-4 rounded">
        <h1 class="text-center mb-4">Cadastro de Receita</h1>
        <?php if (!empty($msg)): ?>
            <div class="alert alert-info msg">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="ingredientes">Ingredientes:</label>
                <textarea class="form-control" id="ingredientes" name="ingredientes" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="modo_preparo">Modo de Preparo:</label>
                <textarea class="form-control" id="modo_preparo" name="modo_preparo" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="tempo_preparo">Tempo de Preparo (minutos):</label>
                <input type="number" class="form-control" id="tempo_preparo" name="tempo_preparo" required>
            </div>
            <div class="form-group">
                <label for="dificuldade">Dificuldade:</label>
                <select class="form-control" id="dificuldade" name="dificuldade" required>
                    <option value="">Selecione...</option>
                    <option value="Fácil">Fácil</option>
                    <option value="Médio">Médio</option>
                    <option value="Difícil">Difícil</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block">Cadastrar Receita</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
