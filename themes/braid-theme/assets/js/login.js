if (url.getCurrentEndpoint() == 'user/login') {
    const form = document.getElementById("loginForm")
    const eyeIconPassword = document.querySelector("[eye-icon='eyeIconPassword']")
    const email = document.getElementById("email")
    const errorMessage = document.getElementById("errorMessage")

    const validateByColor = {
        'true': '1px solid #63a69d',
        'false': '1px solid #ff2c2c'
    }

    if (email) {
        email.addEventListener('input', function () {
            let color = validateByColor[isValidEmail(this.value)]
            this.style.borderBottom = color
            color = color.split(" ").pop()
            this.nextElementSibling.style.color = color
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

        if (!isValidEmail(this.email.value)) {
            errorMessage.style.display = 'block'
            errorMessage.innerHTML = `Campo ${this.email.dataset.error} inválido`
            throw new Error(`${this.email.dataset.error} inválido`)
        }

        if (!isValidPassword(this.password.value)) {
            errorMessage.style.display = 'block'
            errorMessage.innerHTML = `Campo ${this.password.dataset.error} inválido`
            this.password.style.borderBottom = '1px solid #ff2c2c'
            throw new Error(`invalid ${this.password.name}`)
        }
        
        if (errorMessage.style.display == 'block') {
            errorMessage.style.display = 'none'
        }

        let endpoint = {
            "localhost": "braid/user/login",
            "clientes.laborcode.com.br": "braid/user/login",
            "braid.com.br": "user/login",
            "www.braid.com.br": "user/login",
        }

        endpoint = endpoint[url.getHostName()] || ''
        const form = new FormData(this)

        fetch(url.getUrlOrigin(endpoint), { method: 'POST', body: form })
        .then(data => data.json()).then(function (data) {
            console.log(data)
        })

        const loaderImage = this.getElementsByTagName("button")[0].firstElementChild
        loaderImage.style.display = 'block'
    })
}