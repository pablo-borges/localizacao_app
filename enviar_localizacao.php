<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $protocolo = $_POST['protocolo'] ?? '';
    $localizacao = $_POST['localizacao'] ?? '';

    if ($protocolo && $localizacao) {
        // Salvar os dados em arquivo
        $dados = "Protocolo: $protocolo, Localização: $localizacao\n";
        file_put_contents('dados.txt', $dados, FILE_APPEND);

        echo "Dados recebidos com sucesso!";
    } else {
        echo "Dados incompletos.";
    }
} else {
    echo "Requisição inválida.";
}
?>
