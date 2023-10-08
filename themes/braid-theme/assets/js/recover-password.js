if (url.getCurrentEndpoint() == "user/recover-password") {
    const recoverPassword = document.getElementById("recoverPassword")
    const errorMessage = document.getElementById("errorMessage")

    recoverPassword.addEventListener("submit", function (event) {
        event.preventDefault()

        if (!isValidEmail(this.userEmail.value)) {
            errorMessage.style.display = 'block'
            errorMessage.innerHTML = `Campo ${this.userEmail.dataset.error} inválido`
            this.userEmail.style.borderBottom = '1px solid #ff2c2c'
            throw new Error(`invalid ${this.userEmail.name}`)
        }

        let endpoint = {
            "localhost": "/braid/user/recover-password",
            "clientes.laborcode.com.br": "/braid/user/recover-password",
            "braid.com.br": "/user/recover-password",
            "www.braid.com.br": "/user/recover-password",
        }

        const loaderImage = this.getElementsByTagName("button")[0].firstElementChild
        const btnSubmitLogin = this.getElementsByTagName("button")[0].lastElementChild

        loaderImage.style.display = 'block'
        btnSubmitLogin.style.display = 'none'

        endpoint = endpoint[url.getHostName()] || ''
        const form = new FormData(this)
        const requestUrl = url.getUrlOrigin(endpoint)

        fetch(requestUrl, { method: "POST", body: form })
        .then(data => data.json()).then(function (data) {
            
            if (data.email_does_not_exist) {
                loaderImage.style.display = 'none'
                btnSubmitLogin.style.display = 'block'
                errorMessage.style.display = 'block'
                errorMessage.innerHTML = data.msg
                throw new Error(data.msg)
            }

            if (data.invalid_email_value) {
                loaderImage.style.display = 'none'
                btnSubmitLogin.style.display = 'block'
                errorMessage.style.display = 'block'
                errorMessage.innerHTML = data.msg
                throw new Error(data.msg)
            }

            if (data.invalid_recover_password_data) {
                loaderImage.style.display = 'none'
                btnSubmitLogin.style.display = 'block'
                errorMessage.style.display = 'block'
                errorMessage.innerHTML = data.msg
                throw new Error(data.msg)
            }

            if (data.recover_success) {
                if (errorMessage.style.display == 'block') {
                    errorMessage.style.display = 'none'
                }
                window.location.href = data.url
            }
        })
    })
}