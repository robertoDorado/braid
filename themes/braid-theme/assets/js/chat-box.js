const btnRemoveChat = document.getElementById("btnRemoveChat")
const chatBox = document.getElementById("chatBox")

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