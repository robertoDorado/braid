if (url.getCurrentEndpoint() == "braid-system/client-report") {
    const formSearchProject = document.getElementById("formSearchProject")
    const rows = Array.from(document.querySelectorAll(".row"))

    formSearchProject.addEventListener("submit", function (event) {
        event.preventDefault()
        const fieldSearch = this.getElementsByTagName("input")[0]
        const formAction = formSearchProject.action.replace("#", "")

        const urlRequest = new URL(formAction)
        urlRequest.searchParams.set(fieldSearch.name, fieldSearch.value)
        window.history.replaceState({}, document.title, urlRequest.href)

        const querySetringParams = new URLSearchParams(urlRequest.search)
        if (querySetringParams.get("searchProject")) {

            let endpoint = {
                "localhost": "/braid/braid-system/token",
                "clientes.laborcode.com.br": "/braid/braid-system/token",
                "braid.com.br": "/braid-system/token",
                "www.braid.com.br": "/braid-system/token",
            }

            endpoint = endpoint[url.getHostName()] || ''
            let requestUrl = url.getUrlOrigin(endpoint)

            fetch(requestUrl).then(response => response.json()).then(function (response) {

                endpoint = {
                    "localhost": "/braid/braid-system/search-project",
                    "clientes.laborcode.com.br": "/braid/braid-system/search-project",
                    "braid.com.br": "/braid-system/search-project",
                    "www.braid.com.br": "/braid-system/search-project",
                }

                endpoint = endpoint[url.getHostName()] || ''
                requestUrl = url.getUrlOrigin(endpoint)

                fetch(requestUrl + urlRequest.search, {
                    method: "GET", headers: {
                        Authorization: "Bearer " + response.tokenData
                    }
                }).then(response => response.json()).then(function (response) {
                    const wrapElement = rows[2].firstElementChild
                    wrapElement.innerHTML = ""

                    const data = Array.from(response)
                    data.forEach(function (item) {
                        const cardBodyElement = createNewElement("div")
                        setAttributesToElement("class", "card-body", cardBodyElement)

                        const callOutInfoElement = createNewElement("div")
                        setAttributesToElement("class", "callout callout-info", callOutInfoElement)

                        const titleProject = createNewElement("h5")
                        const descriptionProject = createNewElement("p")
                        const projectValue = createNewElement("p")
                        const projectDeliveryTime = createNewElement("p")

                        wrapElement.appendChild(cardBodyElement)
                        cardBodyElement.appendChild(callOutInfoElement)

                        const date = formatDate(item.delivery_time)
                        const valueCurrencyFormat = parseFloat(item.remuneration_data).toLocaleString("pt-BR", { style: "currency", currency: "BRL" })

                        titleProject.innerHTML = item.job_name
                        descriptionProject.innerHTML = item.job_description
                        projectValue.innerHTML = `Valor do acordo: ${valueCurrencyFormat}`

                        projectDeliveryTime.innerHTML = `Prazo de entrega: 
                        ${date.day}/${date.month}/${date.year} ${date.hour}:${date.minute}`

                        callOutInfoElement.append(titleProject, descriptionProject, projectValue, projectDeliveryTime)
                    })

                    if (response.empty_request) {
                        const messageContainer = rows[2].firstElementChild
                        const messageWrap = createNewElement("div")
                        setAttributesToElement("class", "warning-empty-registers", messageWrap)
                        messageContainer.appendChild(messageWrap)
    
                        const message = createNewElement("p")
                        message.style.padding = "1rem 0"
                        messageWrap.appendChild(message)
    
                        message.innerHTML = response.msg
                        rows[3].style.display = "none"
                    }
                })
            })
        }
    })
}