if (url.getCurrentEndpoint() == "braid-system/additional-data") {
    const additionalDataForm = document.getElementById("additionalDataForm")
    const documentData = document.getElementById("documentData")
    const registerNumber = document.getElementById("registerNumber")
    const errorMessage = document.getElementById("errorMessage")

    const mask = {
        cpf: function (value) {
            value = value.replace(/\D/g, '')
                .replace(/(\d{3})(\d)/, "$1.$2")
                .replace(/(\d{3})(\d)/, "$1.$2")
                .replace(/(\d{3})(\d)/, "$1-$2")
            return value.slice(0, 14)
        },

        cnpj: function (value) {
            value = value.replace(/\D/g, '')
                .replace(/(\d{2})(\d)/, "$1.$2")
                .replace(/(\d{3})(\d)/, "$1.$2")
                .replace(/(\d{3})(\d)/, "$1/$2")
                .replace(/(\d{4})(\d)/, "$1-$2")
            return value.slice(0, 18)
        }
    }

    documentData?.addEventListener("input", function () {
        this.value = mask[this.dataset.mask](this.value)
    })

    registerNumber?.addEventListener("input", function () {
        this.value = mask[this.dataset.mask](this.value)
    })

    additionalDataForm.addEventListener("submit", function (event) {
        event.preventDefault()

        const inputs = Array.from(this.querySelectorAll(".form-control"))
        inputs.forEach(function (elem) {
            try {
                validateRequiredFields(elem, errorMessage)
            } catch (error) {
                throw new Error(error.message)
            }
        })

        if (this.documentData) {
            if (!/^(\d{3})\.(\d{3})\.(\d{3})-(\d{2})$/.test(this.documentData.value)) {
                errorMessage.style.display = 'block'
                errorMessage.innerHTML = "Valor do cpf inválido"
                throw new Error("Valor do cpf inválido")
            }
        }

        const btnSubmit = this.getElementsByTagName("button")[0].lastElementChild
        const loaderImage = this.getElementsByTagName("button")[0].firstElementChild

        loaderImage.style.display = 'block'
        btnSubmit.style.display = 'none'

        let endpoint = {
            "localhost": "/braid/braid-system/token",
            "clientes.laborcode.com.br": "/braid/braid-system/token",
            "braid.com.br": "/braid-system/token",
            "www.braid.com.br": "/braid-system/token",
        }

        endpoint = endpoint[url.getHostName()] || ''
        let requestUrl = url.getUrlOrigin(endpoint)
        const form = new FormData(this)

        fetch(requestUrl).then(response => response.json())
            .then(function (response) {

                if (!response.tokenData) {
                    throw new Error("requisição inválida")
                }

                endpoint = {
                    "localhost": "/braid/braid-system/additional-data",
                    "clientes.laborcode.com.br": "/braid/braid-system/additional-data",
                    "braid.com.br": "/braid-system/additional-data",
                    "www.braid.com.br": "/braid-system/additional-data",
                }

                endpoint = endpoint[url.getHostName()] || ''
                requestUrl = url.getUrlOrigin(endpoint)

                fetch(requestUrl, {
                    method: "POST",
                    body: form,
                    headers: {
                        Authorization: "Bearer " + response.tokenData
                    }
                }).then(response => response.json()).then(function (response) {

                    if (response.invalid_length) {
                        throw new Error(response.msg)
                    }

                    if (response.invalid_document) {
                        throw new Error(response.msg)
                    }

                    if (response.success) {
                        errorMessage.style.display = 'none'
                        setTimeout(() => {
                            window.location.href = response.url
                        }, 2000)
                    }

                }).catch(function (error) {
                    error = error.toString().replace("Error: ", "")
                    btnSubmit.style.display = 'block'
                    loaderImage.style.display = 'none'
                    errorMessage.style.display = 'block'
                    errorMessage.innerHTML = error
                })
            })
    })
}