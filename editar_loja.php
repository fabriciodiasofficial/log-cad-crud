<!-- editar_loja.php -->
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
require_once 'loja.php'; // Inclui a classe Loja

// Cria uma instância da classe Database
$database = new Database();
$db = $database->getPDO();

// Verifica se o ID da loja foi passado pela URL
if (isset($_GET['id_loja'])) {
    $idLoja = $_GET['id_loja'];

    // Obtém as informações da loja pelo ID
    $query = "SELECT * FROM loja WHERE id_loja = :id_loja";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id_loja', $idLoja, PDO::PARAM_INT);
    $stmt->execute();
    $lojaInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se a loja foi encontrada
    if ($lojaInfo) {
        // Cria uma instância da classe Loja
        $loja = new Loja($lojaInfo['id_loja'], $lojaInfo['nome_loja'], $lojaInfo['cnpj'], $lojaInfo['email'], $lojaInfo['senha']);

        // Verifica se o formulário foi enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtém os dados do formulário
            $novoNome = $_POST['novo_nome'];
            $novoCnpj = $_POST['novo_cnpj'];
            $novoEmail = $_POST['novo_email'];
            $novaSenha = $_POST['nova_senha'];

            // Executa a edição da loja
            $loja->editarLoja($novoNome, $novoCnpj, $novoEmail, $novaSenha, $db);

            echo "Loja editada com sucesso!";
        }
        ?>
        <!-- Formulário para editar a loja -->
        <form method="post" action="">
            <label for="novo_nome">Novo Nome:</label>
            <input type="text" name="novo_nome" value="<?php echo $loja->getNomeLoja(); ?>" required><br>

            <label for="novo_cnpj">Novo CNPJ:</label>
            <input type="text" name="novo_cnpj" value="<?php echo $loja->getCnpj(); ?>" required><br>

            <label for="novo_email">Novo Email:</label>
            <input type="email" name="novo_email" value="<?php echo $loja->getEmail(); ?>" required><br>

            <label for="nova_senha">Nova Senha:</label>
            <input type="password" name="nova_senha" required><br>

            <input type="submit" value="Editar Loja">
        </form>
        <?php
    } else {
        echo "Loja não encontrada.";
    }
} else {
    echo "ID da loja não especificado.";
}
?>
