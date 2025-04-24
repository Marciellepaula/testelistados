<?php

require_once 'config/database.php';

class Imovel
{

    public function criar($titulo,  $preco, $descricao, $endereco, $garagem,  $imagem)
    {
        try {

            $pdo = Database::connect();


            $sql = "INSERT INTO imoveis (titulo, preco, descricao, endereco, garagem, imagem) 
                    VALUES (:titulo, :preco, :descricao,  :endereco, :garagem, :imagem)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':endereco', $endereco);
            $stmt->bindParam(':garagem', $garagem);
            $stmt->bindParam(':imagem', $imagem);



            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {

            echo "Erro: " . $e->getMessage();
            return false;
        } finally {

            $pdo = null;
        }
    }


    public function obterTodos()
    {
        try {

            $pdo = Database::connect();


            $sql = "SELECT * FROM imoveis";
            $stmt = $pdo->query($sql);


            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            echo "Erro: " . $e->getMessage();
            return [];
        } finally {

            $pdo = null;
        }
    }


    public function obterPorId($id)
    {
        try {

            $pdo = Database::connect();


            $sql = "SELECT * FROM imoveis WHERE id = :id";
            $stmt = $pdo->prepare($sql);


            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            echo "Erro: " . $e->getMessage();
            return null;
        } finally {

            $pdo = null;
        }
    }


    public function atualizar($id, $titulo, $preco, $descricao, $endereco, $garagem)
    {
        try {

            $pdo = Database::connect();


            $sql = "UPDATE imoveis SET titulo = :titulo, preco = :preco,  descricao = :descricao , garagem= :garagem, 
                    endereco = :endereco WHERE id = :id";
            $stmt = $pdo->prepare($sql);


            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':endereco', $endereco);
            $stmt->bindParam(':garagem', $garagem);


            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {

            echo "Erro: " . $e->getMessage();
            return false;
        } finally {

            $pdo = null;
        }
    }

    // Método para deletar um imóvel
    public function deletar($id)
    {
        try {
            // Conectar ao banco de dados
            $pdo = Database::connect();

            // Preparar a consulta SQL
            $sql = "DELETE FROM imoveis WHERE id = :id";
            $stmt = $pdo->prepare($sql);

            // Vincular o parâmetro
            $stmt->bindParam(':id', $id);

            // Executar a consulta e verificar se foi bem-sucedida
            if ($stmt->execute()) {
                return true; // Sucesso
            } else {
                return false; // Falha na execução
            }
        } catch (PDOException $e) {
            // Tratar erros
            echo "Erro: " . $e->getMessage();
            return false;
        } finally {
            // Garantir que a conexão seja fechada após a operação
            $pdo = null;
        }
    }
}
