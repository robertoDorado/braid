const endpointProfileData = removeParamFromEndpoint(url.getCurrentEndpoint(), true)
const paramProfileData = endpointProfileData.pop()

if (endpointProfileData.join("/") == "braid-system/profile-data") {
    const evaluationProfileForm = document.getElementById("evaluationProfile")

    evaluationProfileForm.addEventListener("submit", function (event) {
        event.preventDefault()

        if (this.evaluateDescription.value.length > 1000) {
            this.evaluateDescription.style.borderColor = "#ff0000"
            throw new Error("Descrição da avaliação está acima de 1000 caracteres")
        }else {
            this.evaluateDescription.style.borderColor = "#ced4da"
        }

        if (this.fb.value > 5) {
            throw new Error("Avaliação de estrelas não pode ser acima de 5")
        }
    })
}