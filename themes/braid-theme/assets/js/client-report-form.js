if (url.getCurrentEndpoint() == "braid-system/client-report-form") {
    const remunerationData = document.getElementById("remunerationData")
    const clientReportForm = document.getElementById("clientReportForm")
    const errorMessage = document.getElementById("errorMessage")

    const mask = {
        money: function (value) {
            value = value.replace(/\D/g, '')
            value = parseFloat((value / 100).toFixed(2))
            value = value.toLocaleString('pt-BR', { style: 'currency', currency: "BRL" })
            return value
        }
    }

    remunerationData.addEventListener("input", function () {
        this.value = mask[this.dataset.mask](this.value)
    })

    clientReportForm.addEventListener("submit", function (event) {
        event.preventDefault()
        
        const inputs = Array.from(this.querySelectorAll(".form-control"))
        inputs.forEach(function (elem) {
            try {
                validateRequiredFields(elem, errorMessage)
            } catch (error) {
                throw new Error(error.message)
            }
        })
    })
}