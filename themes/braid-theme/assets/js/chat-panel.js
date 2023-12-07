if (url.getCurrentEndpoint() == "braid-system/chat-panel") {
    const contactsTrigger = document.getElementById("contactsTrigger")
    const seeContacts = document.getElementById("seeContacts")
    const btnOpenChat = Array.from(document.querySelectorAll(".btnOpenChat"))
    const formChatPanel = document.getElementById("formChatPanel")

    let endpointChat = {
        "localhost": "/braid/braid-system/token",
        "clientes.laborcode.com.br": "/braid/braid-system/token",
        "braid.com.br": "/braid-system/token",
        "www.braid.com.br": "/braid-system/token",
    }

    endpointChat = endpointChat[url.getHostName()] || ''
    let requestUrl = url.getUrlOrigin(endpointChat)

    formChatPanel.addEventListener("submit", function (event) {
        event.preventDefault()
        const messageData = this.messageData.value
        const csrfToken = this.csrfToken.value
        const receiverEmail = atob(this.dataset.hash)
        this.messageData.value = ""

        fetch(requestUrl).then(response => response.json())
            .then(function (response) {

                if (!response.tokenData) {
                    throw new Error("usuário não autenticado")
                }

                const tokenData = response.tokenData
                endpointChat = {
                    "localhost": "/braid/braid-system/chat-messages",
                    "clientes.laborcode.com.br": "/braid/braid-system/chat-messages",
                    "braid.com.br": "/braid-system/chat-messages",
                    "www.braid.com.br": "/braid-system/chat-messages",
                }

                endpointChat = endpointChat[url.getHostName()] || ''
                requestUrl = url.getUrlOrigin(endpointChat)

                let receiverData = { receiverEmail }
                receiverData = JSON.stringify(receiverData)

                const form = new FormData()
                form.append("messageData", messageData)
                form.append("csrfToken", csrfToken)

                fetch(requestUrl + "/" + btoa(receiverData), {
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
    })

    btnOpenChat.forEach(function (elem) {
        elem.addEventListener("click", function (event) {
            event.preventDefault()
            const csrfToken = this.dataset.csrf
            const paramProfileData = this.dataset.hash

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