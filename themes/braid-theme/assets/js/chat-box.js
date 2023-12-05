const btnRemoveChat = document.getElementById("btnRemoveChat")
const chatBox = document.getElementById("chatBox")
const formChatBox = document.getElementById("formChatBox")

window.addEventListener("load", function () {
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
                throw new Error("erro ao conectar usuário")
            }

            const tokenData = response.tokenData
            endpointChat = {
                "localhost": "/braid/braid-system/profile-data-json",
                "clientes.laborcode.com.br": "/braid/braid-system/profile-data-json",
                "braid.com.br": "/braid-system/profile-data-json",
                "www.braid.com.br": "/braid-system/profile-data-json",
            }

            endpointChat = endpointChat[url.getHostName()] || ''
            requestUrl = url.getUrlOrigin(endpointChat)
            
            if (formChatBox.dataset.receiver) {
                fetch(requestUrl + "/" + formChatBox.dataset.receiver, {
                    method: "GET",
                    headers: {
                        Authorization: "Bearer " + tokenData
                    }
                }).then(response => response.json())
                    .then(function (response) {

                        if (response.success) {
                            formChatBox.addEventListener("submit", function (event) {
                                event.preventDefault()
                                const messageData = this.messageData.value

                                this.messageData.value = ""
                                delete response.success

                                endpointChat = {
                                    "localhost": "/braid/braid-system/chat-messages",
                                    "clientes.laborcode.com.br": "/braid/braid-system/chat-messages",
                                    "braid.com.br": "/braid-system/chat-messages",
                                    "www.braid.com.br": "/braid-system/chat-messages",
                                }

                                endpointChat = endpointChat[url.getHostName()] || ''
                                requestUrl = url.getUrlOrigin(endpointChat)

                                const form = new FormData()
                                form.append("messageData", messageData)
                                form.append("csrfToken", this.csrfToken.value)

                                const endpointChatMessage = JSON.stringify(response)
                                fetch(requestUrl + "/" + btoa(endpointChatMessage), {
                                    method: "POST",
                                    body: form,
                                    headers: {
                                        Authorization: "Bearer " + tokenData
                                    }
                                })
                            })
                        }
                    })
            }
        })
})

btnRemoveChat?.addEventListener("click", function () {
    let endpointChat = {
        "localhost": "/braid/braid-system/chat-panel",
        "clientes.laborcode.com.br": "/braid/braid-system/chat-panel",
        "braid.com.br": "/braid-system/chat-panel",
        "www.braid.com.br": "/braid-system/chat-panel",
    }

    endpointChat = endpointChat[url.getHostName()] || ''
    const requestUrlChat = url.getUrlOrigin(endpointChat)
    const form = new FormData()

    form.append("csrfToken", chatBox.dataset.csrf)
    form.append("closeChat", true)

    fetch(requestUrlChat, {
        method: "POST",
        body: form
    })
})