<!-- loja.php -->
<?php
require_once 'db.php';

class Loja
{
    private $id_loja;
    private $nome_loja;
    private $cnpj;
    private $email;
    private $senha;  // Adicione mais propriedades conforme necessário

    public function __construct($id_loja, $nome_loja, $cnpj, $email, $senha)
    {
        $this->id_loja = $id_loja;
        $this->nome_loja = $nome_loja;
        $this->cnpj = $cnpj;
        $this->email = $email;
        $this->senha = $senha;
    }

    // Getter methods
    public function getIdLoja()
    {
        return $this->id_loja;
    }

    public function getNomeLoja()
    {
        return $this->nome_loja;
    }

    public function getCnpj()
    {
        return $this->cnpj;
    }

    public function getEmail()
    {
        return $this->email;
    }

    // Método para obter todas as lojas
    public static function getAllLojas($db)
    {
        $query = "SELECT * FROM loja";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para editar uma loja
    public function editarLoja($novoNome, $novoCnpj, $novoEmail, $novaSenha, $db)
    {
        // Adicionar lógica de validação se necessário

        $query = "UPDATE loja SET nome_loja = :novo_nome, cnpj = :novo_cnpj, email = :novo_email, senha = :nova_senha WHERE id_loja = :id_loja";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':novo_nome', $novoNome);
        $stmt->bindParam(':novo_cnpj', $novoCnpj);
        $stmt->bindParam(':novo_email', $novoEmail);
        $stmt->bindParam(':nova_senha', $novaSenha);
        $stmt->bindParam(':id_loja', $this->id_loja);
        $stmt->execute();
    }
}
?>
