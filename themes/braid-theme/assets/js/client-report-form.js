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

        const btnSubmit = this.getElementsByTagName("button")[0].lastElementChild
        const loaderImage = this.getElementsByTagName("button")[0].firstElementChild
        
        loaderImage.style.display = 'block'
        btnSubmit.style.display = 'none'

        let endpoint = {
            "localhost": "/braid/braid-system/client-report-form",
            "clientes.laborcode.com.br": "/braid/braid-system/client-report-form",
            "braid.com.br": "/braid-system/client-report-form",
            "www.braid.com.br": "/braid-system/client-report-form",
        }

        endpoint = endpoint[url.getHostName()] || ''
        const form = new FormData(this)
        const requestUrl = url.getUrlOrigin(endpoint)

        fetch(requestUrl, { method: "POST", body: form })
        .then(data => data.json()).then(function (data) {

            if (data.invalid_datetime) {
                throw new Error(data.msg)
            }
            
            if (data.general_error) {
                throw new Error(data.msg)
            }

            if (data.success_create_job) {
                window.location.href = data.url
            }

        }).catch(function(error) {
            error = error.toString().replace("Error: ", "")
            btnSubmit.style.display = 'block'
            loaderImage.style.display = 'none'
            errorMessage.style.display = 'block'
            errorMessage.innerHTML = error
        })
    })
}