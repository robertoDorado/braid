const endpointEvaluationCharging = removeParamFromEndpoint(url.getCurrentEndpoint(), true)
const paramEvaluationCharging = endpointEvaluationCharging.pop()

if (endpointEvaluationCharging.join("/") == "braid-system/profile-data") {
    const loadEvaluate = document.getElementById("loadEvaluate")
    let page = 1
    const limit = 3

    if (loadEvaluate) {
        loadEvaluate.addEventListener("click", function (event) {
            event.preventDefault()
    
            const loaderButton = this
            const loaderImage = this.firstElementChild
            const loaderLabel = this.lastElementChild
    
            loaderLabel.style.display = "none"
            loaderImage.style.display = "block"
    
            page++;
            let endpoint = {
                "localhost": "/braid/braid-system/token",
                "clientes.laborcode.com.br": "/braid/braid-system/token",
                "braid.com.br": "/braid-system/token",
                "www.braid.com.br": "/braid-system/token",
            }
    
            endpoint = endpoint[url.getHostName()] || ''
            let requestUrl = url.getUrlOrigin(endpoint)
    
            fetch(requestUrl).then(response => response.json()).then(function (response) {
                if (!response.tokenData) {
                    throw new Error("Erro ao retornar o token do usuário")
                }
    
                response["page"] = page
                response["max"] = limit
                response["profile_id"] = atob(paramEvaluationCharging)
    
                endpoint = {
                    "localhost": "/braid/braid-system/charge-on-demand-evaluation",
                    "clientes.laborcode.com.br": "/braid/braid-system/charge-on-demand-evaluation",
                    "braid.com.br": "/braid-system/charge-on-demand-evaluation",
                    "www.braid.com.br": "/braid-system/charge-on-demand-evaluation",
                }
    
                endpoint = endpoint[url.getHostName()] || ''
                requestUrl = url.getUrlOrigin(endpoint)
    
                const stringBase64 = btoa(JSON.stringify(response))
                fetch(requestUrl + "/" + stringBase64, {
                    method: "GET",
                    headers: {
                        Authorization: "Bearer " + response.tokenData
                    }
                }).then(response => response.json()).then(function (response) {
                    const containerEvaluation = document.getElementById("containerEvaluation")
    
                    loaderImage.style.display = "none"
                    loaderLabel.style.display = "block"
    
                    const totalEvaluation = response.pop()
                    const paginate = Math.ceil(totalEvaluation.total_evaluation / limit)
    
                    if (paginate == page) {
                        loaderButton.style.display = "none"
                    }
    
                    response = Array.from(response)
                    response.forEach(function (data) {
                        const containerDesigner = createNewElement("div")
                        const descriptionDataDesigner = createNewElement("div")
                        const stars = createNewElement("div")
                        const evaluateDescription = createNewElement("p")
        
                        evaluateDescription.innerHTML = data.evaluation_description
        
                        const inputEmpty = createNewElement("input")
                        const inputOne = createNewElement("input")
                        const inputTwo = createNewElement("input")
                        const inputThree = createNewElement("input")
                        const inputFour = createNewElement("input")
                        const inputFive = createNewElement("input")
        
                        const ratingInputs = [inputEmpty, inputOne, inputTwo, inputThree, inputFour, inputFive]
                        for (let i = 0; i < 6; i++) {
                            ratingInputs[i].type = "radio"
                            ratingInputs[i].value = i > 0 ? i : ""
                            if (i > 0) {
                                ratingInputs[i].checked = data.rating_data == i
                            }
                            
                            if (data.rating_data == 0 && ratingInputs[i].value == "") {
                                ratingInputs[i].checked = data.rating_data == i
                            }
                        }
        
                        const labelOne = createNewElement("label")
                        const labelTwo = createNewElement("label")
                        const labelThree = createNewElement("label")
                        const labelFour = createNewElement("label")
                        const labelFive = createNewElement("label")
        
                        setAttributesToElement("class", "callout callout-danger container-designer", containerDesigner)
                        setAttributesToElement("class", "description-data-designer", descriptionDataDesigner)
                        setAttributesToElement("class", "stars", stars)
        
                        const ratingLabels = [labelOne, labelTwo, labelThree, labelFour, labelFive]
                        for (let i = 0; i < 5; i++) {
                            if (i > 0) {
                                ratingLabels[i].style.marginLeft = ".3rem"
                            }
                            const icon = createNewElement("i")
                            setAttributesToElement("class", "fa", icon)
                            ratingLabels[i].appendChild(icon)
                        }
        
                        stars.append(inputEmpty, labelOne, inputOne, labelTwo, inputTwo, labelThree, inputThree, labelFour, inputFour, labelFive, inputFive)
                        descriptionDataDesigner.appendChild(stars)
                        descriptionDataDesigner.appendChild(evaluateDescription)
                        containerDesigner.appendChild(descriptionDataDesigner)
                        containerEvaluation.appendChild(containerDesigner)
                    })
    
                })
            })
        })
    }
}