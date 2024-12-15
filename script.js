function capturarLocalizacao() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                document.getElementById("localizacao").value = `${latitude}, ${longitude}`;
            },
            function () {
                alert("Erro ao capturar a localização.");
            }
        );
    } else {
        alert("A geolocalização não é suportada neste navegador.");
    }
}

function enviarDados() {
    const protocolo = document.getElementById("protocolo").value;
    const localizacao = document.getElementById("localizacao").value;

    if (protocolo === "" || localizacao === "") {
        alert("Preencha o número do protocolo e capture a localização.");
        return;
    }

    fetch('enviar_localizacao.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `protocolo=${encodeURIComponent(protocolo)}&localizacao=${encodeURIComponent(localizacao)}`
    })
        .then((response) => response.text())
        .then((data) => {
            alert('Dados enviados com sucesso!');
            console.log(data); // Exibe a resposta do servidor
        })
        .catch((error) => {
            alert('Erro ao enviar dados.');
            console.error('Error:', error);
        });
}
