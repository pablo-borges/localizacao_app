<?php
// Ler os dados do arquivo 'dados.txt'
$dados_salvos = file('dados.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if (!$dados_salvos) {
    echo "<h1 class='titulo'>Dados Enviados:</h1>";
    echo "<p class='mensagem'>Nenhum dado encontrado.</p>";
    exit;
}

// Função para obter a data atual no formato "dia, mês, ano"
function formatar_data($data) {
    $meses = [
        "01" => "Janeiro", "02" => "Fevereiro", "03" => "Março", "04" => "Abril", 
        "05" => "Maio", "06" => "Junho", "07" => "Julho", "08" => "Agosto", 
        "09" => "Setembro", "10" => "Outubro", "11" => "Novembro", "12" => "Dezembro"
    ];
    $partes = explode("-", $data);
    return $partes[2] . " de " . $meses[$partes[1]] . " de " . $partes[0];
}

// Inicializar o agrupamento
$data_atual = date("Y-m-d");
$data_formatada = formatar_data($data_atual);

// Inicializar o agrupamento
$dados_por_data = [
    $data_formatada => [], // Agruparemos tudo na data formatada
];

// Processar cada linha do arquivo
foreach ($dados_salvos as $linha) {
    // Verificar se a linha contém "Protocolo" e "Localização"
    if (strpos($linha, "Protocolo:") !== false && strpos($linha, "Localização:") !== false) {
        $dados_por_data[$data_formatada][] = $linha;
    }
}

// Gerar a saída HTML
echo "<h1 class='titulo'>Dados Enviados:</h1>";
foreach ($dados_por_data as $data => $registros) {
    echo "<div class='data-container'>";
    echo "<h2 class='data-title'>Data: $data</h2>";
    echo "<ul class='registro-list'>";
    foreach ($registros as $registro) {
        // Extrair a localização para gerar o botão do Google Maps
        preg_match('/Localização: ([\-0-9.]+), ([\-0-9.]+)/', $registro, $matches);
        $latitude = $matches[1] ?? null;
        $longitude = $matches[2] ?? null;

        echo "<li class='registro-item'>$registro";

        // Adicionar botão do Google Maps se a localização for válida
        if ($latitude && $longitude) {
            $google_maps_url = "https://www.google.com/maps?q=$latitude,$longitude";
            echo " <a href=\"$google_maps_url\" target=\"_blank\" class='map-button'>Ver no Google Maps</a>";
        }
        echo "</li>";
    }
    echo "</ul>";
    echo "</div>";
}
?>

<style>
    /* Definições Globais */
    body {
        font-family: 'Helvetica Neue', Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
        color: #333;
    }

    /* Estilo do título principal */
    .titulo {
        text-align: center;
        font-size: 2.5rem;
        margin-top: 40px;
        color: #1a73e8;
    }

    /* Estilo da mensagem de erro */
    .mensagem {
        text-align: center;
        font-size: 1.3rem;
        color: #e74c3c;
        margin: 20px;
    }

    /* Container da data */
    .data-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin: 30px 20px;
        transition: box-shadow 0.3s ease;
    }

    /* Efeito de hover no container */
    .data-container:hover {
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    /* Estilo do título da data */
    .data-title {
        font-size: 1.8rem;
        color: #2c3e50;
        border-bottom: 2px solid #1a73e8;
        padding-bottom: 8px;
        margin-bottom: 20px;
    }

    /* Estilo da lista de registros */
    .registro-list {
        list-style: none;
        padding-left: 0;
    }

    /* Estilo de cada item de registro */
    .registro-item {
        background-color: #f7f7f7;
        border-radius: 8px;
        padding: 18px;
        margin-bottom: 15px;
        font-size: 1.1rem;
        color: #555;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .registro-item:hover {
        transform: translateY(-5px);
        background-color: #f1f1f1;
    }

    /* Estilo do botão de Google Maps */
    .map-button {
        display: inline-block;
        background-color: #1a73e8;
        color: white;
        padding: 8px 15px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 1rem;
        margin-top: 10px;
        transition: background-color 0.3s ease;
    }

    .map-button:hover {
        background-color: #1558b0;
    }
</style>
