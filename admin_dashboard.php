<!-- admin_dashboard.php -->
<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['nivel_acesso'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$user = $_SESSION['user'];

echo "Bem-vindo à área restrita de administração, {$user['email']}!<br>";
echo "<a href='logout.php'>Logout</a>";

// Inclui o arquivo de conexão
require_once 'db.php';
require_once 'loja.php';

// Cria uma instância da classe Database
$database = new Database();
$db = $database->getPDO();

// Obtém todas as lojas usando a classe Loja
$lojas = Loja::getAllLojas($db);

// Exibe a tabela de lojas
echo "<br><br><b>Lista de Lojas:</b><br>";
echo "<table border='1'>";
echo "<tr><th>ID Loja</th><th>Nome da Loja</th><th>CNPJ</th><th>Email</th></tr>";


foreach ($lojas as $loja) {
    echo "<tr>";
    echo "<td>" . $loja['id_loja'] . "</td>";
    echo "<td>" . $loja['nome_loja'] . "</td>";
    echo "<td>" . $loja['cnpj'] . "</td>";
    echo "<td>" . $loja['email'] . "</td>";
    // Adiciona um link para editar a loja correspondente
    echo "<td><a href='editar_loja.php?id_loja=" . $loja['id_loja'] . "'>Editar</a></td>";
   
    echo "</tr>";
}

echo "</table>";
?>
