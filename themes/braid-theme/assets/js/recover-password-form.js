if (url.getCurrentEndpoint() == "user/recover-password-form") {
    const formRecoverPassword = document.getElementById("formRecoverPassword")
    const errorMessage = document.getElementById("errorMessage")
    const eyeIconPassword = document.querySelector("[eye-icon='eyeIconPassword']")
    const eyeIconConfirmPassword = document.querySelector("[eye-icon='eyeIconConfirmPassword']")

    if (eyeIconConfirmPassword) {
        eyeIconConfirmPassword.addEventListener('click', function () {
            if (this.classList.contains("fa-eye-slash")) {
                this.classList.remove("fa-eye-slash")
                this.classList.add("fa-eye")
                this.parentElement.firstElementChild.setAttribute('type', 'text')
            } else {
                this.classList.remove("fa-eye")
                this.classList.add("fa-eye-slash")
                this.parentElement.firstElementChild.setAttribute('type', 'password')
            }
        })
    }

    if (eyeIconPassword) {
        eyeIconPassword.addEventListener('click', function () {
            if (this.classList.contains("fa-eye-slash")) {
                this.classList.remove("fa-eye-slash")
                this.classList.add("fa-eye")
                this.parentElement.firstElementChild.setAttribute('type', 'text')
            } else {
                this.classList.remove("fa-eye")
                this.classList.add("fa-eye-slash")
                this.parentElement.firstElementChild.setAttribute('type', 'password')
            }
        })
    }
    
    formRecoverPassword.addEventListener('submit', function (event) {
        event.preventDefault()

        const inputs = Array.from(this.getElementsByTagName("input"))
        inputs.forEach(function (elem) {
            try {
                validateRequiredFields(elem, errorMessage)
            }catch(error) {
                throw new Error(error.message)
            }
        })

        if (!isValidPassword(this.password.value)) {
            errorMessage.style.display = 'block'
            errorMessage.innerHTML = `Campo ${this.password.dataset.error} inválido`
            this.password.style.borderBottom = '1px solid #ff2c2c'
            throw new Error(`invalid ${this.password.name}`)
        }

        if (!isValidPassword(this.confirmPassword.value)) {
            errorMessage.style.display = 'block'
            errorMessage.innerHTML = `Campo ${this.confirmPassword.dataset.error} inválido`
            this.confirmPassword.style.borderBottom = '1px solid #ff2c2c'
            throw new Error(`invalid ${this.confirmPassword.name}`)
        }

        const loaderImage = this.getElementsByTagName("button")[0].firstElementChild
        const btnSubmit = this.getElementsByTagName("button")[0].lastElementChild

        loaderImage.style.display = 'block'
        btnSubmit.style.display = 'none'

        let endpoint = {
            "localhost": "/braid/user/recover-password-form",
            "clientes.laborcode.com.br": "/braid/user/recover-password-form",
            "braid.com.br": "/user/recover-password-form",
            "www.braid.com.br": "/user/recover-password-form",
        }

        endpoint = endpoint[url.getHostName()] || ''
        const form = new FormData(this)
        const requestUrl = url.getUrlOrigin(endpoint)

        fetch(requestUrl, { method: 'POST', body: form })
        .then(data => data.json()).then(function (data) {

            if (data.invalid_passwords_value) {
                throw new Error(data.msg)
            }

            if (data.expired_link) {
                window.location.href = data.url
            }

            if (data.general_error) {
                throw new Error(data.msg)
            }

            if (data.invalid_password_value) {
                throw new Error(data.msg)
            }

            if (data.success_password_change) {
                if (errorMessage.style.display == 'block') {
                    errorMessage.style.display = 'none'
                }
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