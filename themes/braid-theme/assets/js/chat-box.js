const btnRemoveChat = document.getElementById("btnRemoveChat")
const chatBox = document.getElementById("chatBox")
const formChatBox = document.getElementById("formChatBox")

if (/braid-system/.test(url.getCurrentEndpoint())) {
    window.addEventListener("load", function () {

        document.querySelector(".direct-chat-messages").scrollTo(0, document.querySelector(".direct-chat-messages").scrollHeight)
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

                if (formChatBox?.dataset.receiver) {
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
                                    }).then(response => response.json())
                                        .then(function (response) {

                                            if (response.success) {
                                                const baseMessage = document.querySelector(".direct-chat-messages")

                                                const directChatMsgRight = createNewElement("div")
                                                const directChatInfo = createNewElement("div")
                                                const directChatNameFloatRight = createNewElement("span")
                                                const directChatTimestampFloatLeft = createNewElement("span")
                                                const directChatImage = createNewElement("img")
                                                const directChatText = createNewElement("div")

                                                setAttributesToElement("class", "direct-chat-msg right", directChatMsgRight)
                                                setAttributesToElement("class", "direct-chat-infos clearfix", directChatInfo)
                                                setAttributesToElement("class", "direct-chat-name float-right", directChatNameFloatRight)
                                                setAttributesToElement("class", "direct-chat-timestamp float-left", directChatTimestampFloatLeft)
                                                setAttributesToElement("class", "direct-chat-img", directChatImage)
                                                setAttributesToElement("class", "direct-chat-text", directChatText)

                                                let endpointChatImage = {
                                                    "clientes.laborcode.com.br": "/braid/themes/braid-theme/assets/img/user",
                                                    "localhost": "/braid/themes/braid-theme/assets/img/user",
                                                    "braid.com.br": "/themes/braid-theme/assets/img/user",
                                                    "www.braid.com.br": "/themes/braid-theme/assets/img/user"
                                                }

                                                endpointChatImage = endpointChatImage[url.getHostName()]
                                                const requestUrl = url.getUrlOrigin(endpointChatImage)

                                                if (response.pathPhoto == null) {
                                                    directChatImage.src = requestUrl + "/default.png"
                                                    directChatImage.alt = "default.png"
                                                } else {
                                                    directChatImage.src = requestUrl + "/" + response.pathPhoto
                                                    directChatImage.alt = response.pathPhoto
                                                }

                                                response.fullName = response.fullName.split(" ")[0]
                                                directChatNameFloatRight.innerHTML = response.fullName
                                                directChatTimestampFloatLeft.innerHTML = response.dateTime
                                                directChatText.innerHTML = response.content

                                                baseMessage.appendChild(directChatMsgRight)
                                                directChatMsgRight.append(directChatInfo, directChatImage, directChatText)
                                                directChatInfo.append(directChatNameFloatRight, directChatTimestampFloatLeft)
                                                document.querySelector(".direct-chat-messages").scrollTo(0, document.querySelector(".direct-chat-messages").scrollHeight)
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
}
