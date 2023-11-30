if (url.getCurrentEndpoint() == "braid-system/chat-panel") {
    const contactsTrigger = document.getElementById("contactsTrigger")
    const seeContacts = document.getElementById("seeContacts")

    seeContacts.addEventListener("click", function () {
        contactsTrigger.click()
    })
}