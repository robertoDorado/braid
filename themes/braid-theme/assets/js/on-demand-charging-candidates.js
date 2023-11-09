const response = removeParamFromEndpoint(url.getCurrentEndpoint(), true)
const endpointParamValue = response.pop()
const endpointData = response.join("/")

if (endpointData == "braid-system/project-detail") {
    const loadCandidates = document.getElementById("loadCandidates")
    let page = 2

    if (loadCandidates) {
        loadCandidates.addEventListener("click", function (event) {
            event.preventDefault()

            const loaderBtn = this
            const imgLoader = this.firstElementChild
            const btnLoader = this.lastElementChild

            imgLoader.style.display = "block"
            btnLoader.style.display = "none"
            page++

            let endpoint = {
                "localhost": "/braid/braid-system/token",
                "clientes.laborcode.com.br": "/braid/braid-system/token",
                "braid.com.br": "/braid-system/token",
                "www.braid.com.br": "/braid-system/token",
            }

            endpoint = endpoint[url.getHostName()] || ''
            let requestUrl = url.getUrlOrigin(endpoint)

            fetch(requestUrl).then(response => response.json())
                .then(function (response) {
                    if (!response.tokenData) {
                        throw new Error("Erro ao retornar o token do usuário")
                    }

                    response["page"] = page
                    response["max"] = 3
                    response["job_id"] = atob(endpointParamValue)

                    endpoint = {
                        "localhost": "/braid/braid-system/charge-on-demand-candidates",
                        "clientes.laborcode.com.br": "/braid/braid-system/charge-on-demand-candidates",
                        "braid.com.br": "/braid-system/charge-on-demand-candidates",
                        "www.braid.com.br": "/braid-system/charge-on-demand-candidates",
                    }

                    endpoint = endpoint[url.getHostName()] || ''
                    requestUrl = url.getUrlOrigin(endpoint)

                    const stringBase64 = btoa(JSON.stringify(response))
                    fetch(requestUrl + "/" + stringBase64, {
                        method: "GET",
                        headers: {
                            Authorization: "Bearer " + response.tokenData
                        }
                    }).then(response => response.json())
                        .then(function (response) {

                            imgLoader.style.display = "none"
                            btnLoader.style.display = "block"

                            if (!response.length) {
                                loaderBtn.style.display = "none"
                            }
                            console.log(response)
                        })
                })
        })
    }
}