if (url.getCurrentEndpoint() == 'braid-system') {
    const exit = document.getElementById("exit")

    exit.addEventListener('click', function (event) {
        event.preventDefault()

        let endpoint = {
            "localhost": "braid-system/exit",
            "clientes.laborcode.com.br": "braid-system/exit",
            "braid.com.br": "braid-system/exit",
            "www.braid.com.br": "braid-system/exit",
        }

        const requestUrl = endpoint[url.getHostName()] || ''
        fetch(requestUrl, { 
            method: "POST", 
            body: JSON.stringify({ action: "logout" }),
            headers: {
                "Content-Type": "application/json"
            } 
        })
        .then(data => data.json())
        .then(function (data) {

            if (!data.logout_success) {
                throw new Error("Erro geral ao tentar sair do sistema.")
            }

            if (data.logout_success) {
                window.location.href = data.url
            }
        })
        .catch(error => {
            console.error("Erro na requisição: ", error)
        })

    })
}