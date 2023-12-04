const endpointViewProfileData = removeParamFromEndpoint(url.getCurrentEndpoint(), true)
const paramViewProfileData = endpointViewProfileData.pop()

if (endpointViewProfileData.join("/") == "braid-system/profile-data" || endpointViewProfileData.join("/") == "braid-system/company-profile") {
    const btnOpenChat = document.getElementById("btnOpenChat")
    const chatBox = document.getElementById("chatBox")
    const formChatBoxProfileDataView = document.getElementById("formChatBox")

    btnOpenChat.addEventListener("click", function (event) {
        event.preventDefault()
        const headerChatBox = chatBox.firstElementChild.firstElementChild
        const csrfToken = this.dataset.csrf
        formChatBoxProfileDataView.dataset.receiver = paramViewProfileData

        let endpointChat = {
            "localhost": "/braid/braid-system/token",
            "clientes.laborcode.com.br": "/braid/braid-system/token",
            "braid.com.br": "/braid-system/token",
            "www.braid.com.br": "/braid-system/token",
        }
    
        endpointChat = endpointChat[url.getHostName()] || ''
        let requestUrl = url.getUrlOrigin(endpointChat)

        fetch(requestUrl).then(response => response.json())
        .then(function(response) {

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
            form.append("openChat", true)
            form.append("paramProfileData", paramViewProfileData)
    
            fetch(requestUrlChat, {
                method: "POST",
                headers: {
                    Authorization: "Bearer " + tokenData
                },
                body: form
            }).then(response => response.json())
                .then(function (response) {
    
                    if (response.success) {
                        window.location.href = window.location.href
                        window.addEventListener("load", function() {
                            headerChatBox.innerHTML = response.receiverName
                            chatBox.style.display = "block"
                        })
                    }
                })
        })

    })
}