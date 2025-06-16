<?php
include("connection.php");
session_start();

// Função para medir o tempo de resposta do banco de dados
function testDatabaseResponse() {
    global $conn;
    $start = microtime(true);
    
    // Teste de SELECT
    $query = "SELECT * FROM users LIMIT 1";
    mysqli_query($conn, $query);
    
    // Teste de INSERT
    $test_name = "test_user_" . time();
    $test_email = "test_" . time() . "@test.com";
    $test_password = "test123";
    $test_type = "user";
    
    $insert_query = "INSERT INTO users (name, email, password, user_type) VALUES ('$test_name', '$test_email', '$test_password', '$test_type')";
    mysqli_query($conn, $insert_query);
    
    // Teste de DELETE
    $delete_query = "DELETE FROM users WHERE email = '$test_email'";
    mysqli_query($conn, $delete_query);
    
    $end = microtime(true);
    return round(($end - $start) * 1000, 2); // Retorna em milissegundos
}

// Função para medir o tempo de resposta do servidor
function testServerResponse() {
    $start = microtime(true);
    
    // Simula processamento
    for($i = 0; $i < 1000; $i++) {
        $result = $i * $i;
    }
    
    $end = microtime(true);
    return round(($end - $start) * 1000, 2); // Retorna em milissegundos
}

// Executa os testes se solicitado
$results = [];
if(isset($_POST['run_test'])) {
    $results['database'] = testDatabaseResponse();
    $results['server'] = testServerResponse();
    $results['timestamp'] = date('Y-m-d H:i:s');
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste de Performance</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        .performance-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 2rem;
            margin: 2rem auto;
            max-width: 800px;
            box-shadow: 0 10px 25px var(--shadow-color);
        }

        .performance-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .performance-header h2 {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .performance-metrics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .metric-card {
            background-color: var(--background-color);
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
        }

        .metric-card h3 {
            color: var(--text-color);
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .metric-value {
            font-size: 2rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .metric-unit {
            font-size: 0.9rem;
            color: var(--text-color);
            opacity: 0.8;
        }

        .performance-status {
            text-align: center;
            margin-top: 1rem;
        }

        .status-good {
            color: var(--success-color);
        }

        .status-warning {
            color: #f59e0b;
        }

        .status-bad {
            color: var(--error-color);
        }

        .test-button {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            margin: 2rem auto;
            width: fit-content;
        }

        .test-button:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px var(--shadow-color);
        }

        .test-history {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--input-border);
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            padding: 1rem;
            background-color: var(--background-color);
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }

        .history-timestamp {
            color: var(--text-color);
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <button class="theme-toggle" aria-label="Toggle theme">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z"/>
        </svg>
    </button>

    <div class="performance-card">
        <div class="performance-header">
            <h2>Teste de Performance do Sistema</h2>
            <p>Este teste mede o tempo de resposta do banco de dados e do servidor</p>
        </div>

        <form method="post">
            <button type="submit" name="run_test" class="test-button">Executar Teste</button>
        </form>

        <?php if(!empty($results)): ?>
        <div class="performance-metrics">
            <div class="metric-card">
                <h3>Tempo de Resposta do Banco de Dados</h3>
                <div class="metric-value"><?php echo $results['database']; ?></div>
                <div class="metric-unit">milissegundos</div>
                <div class="performance-status">
                    <?php
                    if($results['database'] < 100) {
                        echo '<span class="status-good">Excelente</span>';
                    } elseif($results['database'] < 300) {
                        echo '<span class="status-warning">Bom</span>';
                    } else {
                        echo '<span class="status-bad">Lento</span>';
                    }
                    ?>
                </div>
            </div>

            <div class="metric-card">
                <h3>Tempo de Resposta do Servidor</h3>
                <div class="metric-value"><?php echo $results['server']; ?></div>
                <div class="metric-unit">milissegundos</div>
                <div class="performance-status">
                    <?php
                    if($results['server'] < 50) {
                        echo '<span class="status-good">Excelente</span>';
                    } elseif($results['server'] < 150) {
                        echo '<span class="status-warning">Bom</span>';
                    } else {
                        echo '<span class="status-bad">Lento</span>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="test-history">
            <h3>Último Teste</h3>
            <div class="history-item">
                <span class="history-timestamp"><?php echo $results['timestamp']; ?></span>
                <span>DB: <?php echo $results['database']; ?>ms | Server: <?php echo $results['server']; ?>ms</span>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script src="js/theme.js"></script>
</body>
</html>