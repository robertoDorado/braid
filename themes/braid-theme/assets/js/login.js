if (url.getCurrentEndpoint() == 'user/login') {
    const form = document.getElementById("loginForm")
    const eyeIconPassword = document.querySelector("[eye-icon='eyeIconPassword']")
    const userName = document.getElementById("username")
    const errorMessage = document.getElementById("errorMessage")

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

    form.addEventListener('submit', function (event) {
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

        const loaderImage = this.getElementsByTagName("button")[0].firstElementChild
        const btnSubmitLogin = this.getElementsByTagName("button")[0].lastElementChild

        loaderImage.style.display = 'block'
        btnSubmitLogin.style.display = 'none'

        let endpoint = {
            "localhost": "braid/user/login",
            "clientes.laborcode.com.br": "braid/user/login",
            "braid.com.br": "user/login",
            "www.braid.com.br": "user/login",
        }

        endpoint = endpoint[url.getHostName()] || ''
        const form = new FormData(this)
        const requestUrl = url.getUrlOrigin(endpoint)

        fetch(requestUrl, { method: 'POST', body: form })
        .then(data => data.json()).then(function (data) {

            if (data.invalid_email) {
                loaderImage.style.display = 'none'
                btnSubmitLogin.style.display = 'block'
                errorMessage.style.display = 'block'
                errorMessage.innerHTML = data.msg
                throw new Error(data.msg)
            }

            if (data.invalid_password) {
                loaderImage.style.display = 'none'
                btnSubmitLogin.style.display = 'block'
                errorMessage.style.display = 'block'
                errorMessage.innerHTML = data.msg
                throw new Error(data.msg)
            }
            
            if (data.access_denied) {
                loaderImage.style.display = 'none'
                btnSubmitLogin.style.display = 'block'
                errorMessage.style.display = 'block'
                errorMessage.innerHTML = data.msg
                throw new Error(data.msg)
            }

            if (data.success_login) {
                errorMessage.style.display = 'none'
                window.location.href = data.url
            }
        })
    })
}