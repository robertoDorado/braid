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
        const btnSubmit = this.getElementsByTagName("button")[0].lastElementChild

        loaderImage.style.display = 'block'
        btnSubmit.style.display = 'none'

        endpoint = endpoint[url.getHostName()] || ''
        const form = new FormData(this)
        const requestUrl = url.getUrlOrigin(endpoint)

        fetch(requestUrl, { method: "POST", body: form })
        .then(data => data.json()).then(function (data) {
            
            if (data.email_does_not_exist) {
                throw new Error(data.msg)
            }

            if (data.invalid_email_value) {
                throw new Error(data.msg)
            }

            if (data.invalid_recover_password_data) {
                throw new Error(data.msg)
            }

            if (data.recover_success) {
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