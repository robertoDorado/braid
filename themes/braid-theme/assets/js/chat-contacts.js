if (/braid-system/.test(url.getCurrentEndpoint())) {
    const btnOpenChatHeader = Array.from(document.querySelectorAll(".btnOpenChatHeader"))

    let endpointChatGlobal = {
        "localhost": "/braid/braid-system/token",
        "clientes.laborcode.com.br": "/braid/braid-system/token",
        "braid.com.br": "/braid-system/token",
        "www.braid.com.br": "/braid-system/token",
    }

    endpointChatGlobal = endpointChatGlobal[url.getHostName()] || ''
    let requestUrlGlobal = url.getUrlOrigin(endpointChatGlobal)

    btnOpenChatHeader.forEach(function (elem) {
        elem.addEventListener("click", function (event) {
            event.preventDefault()
            const csrfToken = this.dataset.csrf
            const paramProfileData = this.dataset.hash

            fetch(requestUrlGlobal).then(response => response.json())
                .then(function (response) {

                    if (!response.tokenData) {
                        throw new Error("usuário não autenticado")
                    }

                    const tokenData = response.tokenData
                    endpointChatGlobal = {
                        "localhost": "/braid/braid-system/chat-panel-user",
                        "clientes.laborcode.com.br": "/braid/braid-system/chat-panel-user",
                        "braid.com.br": "/braid-system/chat-panel-user",
                        "www.braid.com.br": "/braid-system/chat-panel-user",
                    }

                    endpointChatGlobal = endpointChatGlobal[url.getHostName()] || ''
                    requestUrlGlobal = url.getUrlOrigin(endpointChatGlobal)
                    const form = new FormData()
                    form.append("csrfToken", csrfToken)
                    form.append("paramProfileData", paramProfileData)
                    form.append("updateIsRead", true);

                    fetch(requestUrlGlobal, {
                        method: "POST",
                        body: form,
                        headers: {
                            Authorization: "Bearer " + tokenData
                        }
                    }).then(response => response.json()).then(function (response) {
                        if (response.success) {
                            window.location.href = window.location.href
                        }
                    })
                })
        })
    })

}