const skipPopop = document.getElementById("skipPopop")

skipPopop?.addEventListener('click', function (event) {
    event.preventDefault()
    this.parentElement.parentElement.style.display = "none"

    try {
        const form = new FormData()
        form.append("cookie", JSON.parse(this.dataset.agree))

        let endpoint = {
            "localhost": "/braid/cookies/set-cookie",
            "clientes.laborcode.com.br": "/braid/cookies/set-cookie",
            "braid.com.br": "/cookies/set-cookie",
            "www.braid.com.br": "/cookies/set-cookie",
        }

        endpoint = endpoint[url.getHostName()] || ''

        fetch(url.getUrlOrigin(endpoint), {
            method: "POST",
            body: form
        })

    } catch (e) {
        throw new Error(e)
    }
})