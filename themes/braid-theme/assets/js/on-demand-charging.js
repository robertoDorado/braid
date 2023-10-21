if (url.getCurrentEndpoint() == "braid-system/client-report") {
    const loadNewProjects = document.getElementById("loadNewProjects")
    const rows = Array.from(document.querySelectorAll(".row"))
    let page = 1

    loadNewProjects.addEventListener("click", function (event) {
        event.preventDefault()

        const loaderButton = this
        const loaderImage = this.firstElementChild
        const loaderLabel = this.lastElementChild

        loaderImage.style.display = "block"
        loaderLabel.style.display = "none"

        page++;
        let endpoint = {
            "localhost": "/braid/braid-system/token",
            "clientes.laborcode.com.br": "/braid/braid-system/token",
            "braid.com.br": "/braid-system/token",
            "www.braid.com.br": "/braid-system/token",
        }

        endpoint = endpoint[url.getHostName()] || ''
        let requestUrl = url.getUrlOrigin(endpoint)

        fetch(requestUrl).then(function (response) {
            if (!response.ok) {
                throw new Error("Erro na requisição do token")
            }

            return response.json()
        }).then(function (response) {
            if (!response.tokenData) {
                throw new Error("Erro ao retornar o token do usuário")
            }

            response["page"] = page
            response["max"] = 3

            endpoint = {
                "localhost": "/braid/braid-system/charge-on-demand",
                "clientes.laborcode.com.br": "/braid/braid-system/charge-on-demand",
                "braid.com.br": "/braid-system/charge-on-demand",
                "www.braid.com.br": "/braid-system/charge-on-demand",
            }

            endpoint = endpoint[url.getHostName()] || ''
            requestUrl = url.getUrlOrigin(endpoint)

            const stringBase64 = btoa(JSON.stringify(response))
            fetch(requestUrl + "/" + stringBase64, {
                method: "GET",
                headers: {
                    Authorization: "Bearer: " + response.tokenData
                }
            }).then(function (response) {
                if (!response.ok) {
                    throw new Error("Erro na requisição de carregamento")
                }

                return response.json()
            }).then(function (response) {
                loaderImage.style.display = "none"
                loaderLabel.style.display = "block"
                const wrapElement = rows[1].firstElementChild
                
                response = Array.from(response)
                response.forEach(function (item) {
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

                if (response.length == 0) {
                    loaderButton.style.display = "none"
                }
            })
        })
    })
}