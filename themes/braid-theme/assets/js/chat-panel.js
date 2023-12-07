if (url.getCurrentEndpoint() == "braid-system/chat-panel") {
    const contactsTrigger = document.getElementById("contactsTrigger")
    const seeContacts = document.getElementById("seeContacts")
    const btnOpenChat = Array.from(document.querySelectorAll(".btnOpenChat"))

    btnOpenChat.forEach(function (elem) {
        elem.addEventListener("click", function (event) {
            event.preventDefault()
            const csrfToken = this.dataset.csrf
            const paramProfileData = this.dataset.hash

            let endpointChat = {
                "localhost": "/braid/braid-system/token",
                "clientes.laborcode.com.br": "/braid/braid-system/token",
                "braid.com.br": "/braid-system/token",
                "www.braid.com.br": "/braid-system/token",
            }

            endpointChat = endpointChat[url.getHostName()] || ''
            let requestUrl = url.getUrlOrigin(endpointChat)

            fetch(requestUrl).then(response => response.json())
                .then(function (response) {

                    if (!response.tokenData) {
                        throw new Error("usuário não autenticado")
                    }

                    const tokenData = response.tokenData
                    endpointChat = {
                        "localhost": "/braid/braid-system/chat-panel-user",
                        "clientes.laborcode.com.br": "/braid/braid-system/chat-panel-user",
                        "braid.com.br": "/braid-system/chat-panel-user",
                        "www.braid.com.br": "/braid-system/chat-panel-user",
                    }

                    endpointChat = endpointChat[url.getHostName()] || ''
                    let requestUrlChat = url.getUrlOrigin(endpointChat)
                    const form = new FormData()
                    form.append("csrfToken", csrfToken)
                    form.append("paramProfileData", paramProfileData)

                    fetch(requestUrlChat, {
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

    seeContacts.addEventListener("click", function () {
        contactsTrigger.click()
    })
}