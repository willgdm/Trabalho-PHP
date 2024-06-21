<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu de Receitas</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px; 
        }
        .card {
            background-color: #343a40; 
            border: none; 
        }
        .card-body {
            border-radius: 0.5rem; 
        }
    </style>
</head>
<body class="bg-dark text-white">
    <div class="container mt-5 p-4 rounded">
        <h1 class="text-center mb-4">Menu de Receitas</h1>
        <?php
        session_start();

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "trabalho";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM receita ORDER BY data_criacao DESC";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card mb-4 bg-secondary text-white'>";
                    echo "<div class='card-body'>";
                    echo "<h2 class='card-title'>" . $row["titulo"] . "</h2>";
                    echo "<p class='card-text'><strong>Ingredientes:</strong> " . $row["ingredientes"] . "</p>";
                    echo "<p class='card-text'><strong>Modo de Preparo:</strong> " . $row["modo_preparo"] . "</p>";
                    echo "<p class='card-text'><strong>Tempo de Preparo:</strong> " . $row["tempo_preparo"] . " minutos</p>";
                    echo "<p class='card-text'><strong>Dificuldade:</strong> " . $row["dificuldade"] . "</p>";
                    echo "<p class='card-text'><strong>Data de Criação:</strong> " . $row["data_criacao"] . "</p>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>Nenhuma receita encontrada.</p>";
            }
        } else {
            echo "<p>Erro na consulta: " . $conn->error . "</p>";
        }

        $conn->close();
        ?>
        <a href="index.php" class="btn btn-primary mt-4">Voltar para o Menu Principal</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
