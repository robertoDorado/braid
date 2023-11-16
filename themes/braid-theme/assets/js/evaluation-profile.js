const endpointProfileData = removeParamFromEndpoint(url.getCurrentEndpoint(), true)
const paramProfileData = endpointProfileData.pop()

if (endpointProfileData.join("/") == "braid-system/profile-data") {
    const evaluationProfileForm = document.getElementById("evaluationProfile")

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
            }
        })
    })
}