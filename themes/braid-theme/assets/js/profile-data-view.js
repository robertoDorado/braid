const endpointViewProfileData = removeParamFromEndpoint(url.getCurrentEndpoint(), true)
const paramViewProfileData = endpointViewProfileData.pop()

if (endpointViewProfileData.join("/") == "braid-system/profile-data") {
    const btnOpenChat = document.getElementById("btnOpenChat")
    const chatBox = document.getElementById("chatBox")

    btnOpenChat.addEventListener("click", function (event) {
        event.preventDefault()
        const headerChatBox = chatBox.firstElementChild.firstElementChild

        let endpointChat = {
            "localhost": "/braid/braid-system/chat-panel-user",
            "clientes.laborcode.com.br": "/braid/braid-system/chat-panel-user",
            "braid.com.br": "/braid-system/chat-panel-user",
            "www.braid.com.br": "/braid-system/chat-panel-user",
        }

        endpointChat = endpointChat[url.getHostName()] || ''
        const requestUrlChat = url.getUrlOrigin(endpointChat)
        const form = new FormData()

        form.append("csrfToken", this.dataset.csrf)
        form.append("openChat", true)
        form.append("paramProfileData", paramViewProfileData)

        fetch(requestUrlChat, {
            method: "POST",
            body: form
        }).then(response => response.json())
            .then(function (response) {

                if (response.success) {
                    headerChatBox.innerHTML = response.headerChat
                    chatBox.style.display = "block"
                }
            })
    })
}