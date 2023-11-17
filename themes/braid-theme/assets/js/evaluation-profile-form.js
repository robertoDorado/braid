const endpointProfileData = removeParamFromEndpoint(url.getCurrentEndpoint(), true)
const paramProfileData = endpointProfileData.pop()

if (endpointProfileData.join("/") == "braid-system/profile-data") {
    const evaluationProfileForm = document.getElementById("evaluationProfile")
    const containerEvaluation = document.getElementById("containerEvaluation")

    evaluationProfileForm.addEventListener("submit", function (event) {
        event.preventDefault()

        const submitBtn = this.getElementsByTagName("button")[0]
        const loaderImg = submitBtn.firstElementChild
        const spanBtn = submitBtn.lastElementChild

        loaderImg.style.display = "block"
        spanBtn.style.display = "none"

        if (this.evaluateDescription.value == "") {
            this.evaluateDescription.style.borderColor = "#ff0000"
            loaderImg.style.display = "none"
            spanBtn.style.display = "block"
            throw new Error("Descrição da avaliação é obrigatório")
        } else {
            this.evaluateDescription.style.borderColor = "#ced4da"
        }

        if (this.evaluateDescription.value.length > 1000) {
            this.evaluateDescription.style.borderColor = "#ff0000"
            loaderImg.style.display = "none"
            spanBtn.style.display = "block"
            throw new Error("Descrição da avaliação é obrigatório")
        } else {
            this.evaluateDescription.style.borderColor = "#ced4da"
        }

        if (this.fb.value > 5) {
            throw new Error("Avaliação de estrelas não pode ser acima de 5")
        }

        let endpoint = {
            "localhost": "/braid/braid-system/profile-data",
            "clientes.laborcode.com.br": "/braid/braid-system/profile-data",
            "braid.com.br": "/braid-system/profile-data",
            "www.braid.com.br": "/braid-system/profile-data",
        }

        endpoint = endpoint[url.getHostName()] || ''
        const requestUrl = url.getUrlOrigin(endpoint)
        const form = new FormData(this)

        fetch(requestUrl, {
            method: "POST",
            body: form,
            headers: {
                Authorization: "Bearer " + paramProfileData
            }
        }).then(data => data.json()).then(function (data) {
            if (data.success) {
                this.evaluateDescription.value = ""
                loaderImg.style.display = "none"
                spanBtn.style.display = "block"

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
                for (let i = 0; i <= 5; i++) {
                    ratingInputs[i].type = "radio"
                    ratingInputs[i].value = i > 0 ? i : ""
                    if (i > 0) {
                        ratingInputs[i].checked = data.rating == i
                    }
                    
                    if (data.rating == 0 && ratingInputs[i].value == "") {
                        ratingInputs[i].checked = data.rating == i
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
                for (let i = 0; i <= 4; i++) {
                    const icon = createNewElement("i")
                    setAttributesToElement("class", "fa", icon)
                    ratingLabels[i].appendChild(icon)
                }

                stars.append(inputEmpty, labelOne, inputOne, labelTwo, inputTwo, labelThree, inputThree, labelFour, inputFour, labelFive, inputFive)
                descriptionDataDesigner.appendChild(stars)
                descriptionDataDesigner.appendChild(evaluateDescription)
                containerDesigner.appendChild(descriptionDataDesigner)

                if (containerEvaluation.children) {
                    if (containerEvaluation.children.length >= 3) {
                        containerEvaluation.removeChild(containerEvaluation.lastElementChild)
                    }

                    containerEvaluation.insertBefore(containerDesigner, containerEvaluation.firstElementChild)
                } else {
                    containerEvaluation.appendChild(containerDesigner)
                }

            }
        })
    })
}