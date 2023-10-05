if (url.getCurrentEndpoint() == "user/register") {
    const form = document.getElementById("registerForm")
    const email = document.getElementById("email")
    const password = document.getElementById("password")
    const confirmPassword = document.getElementById("confirmPassword")
    const conditions = document.querySelectorAll("#conditions li")
    const eyeIconPassword = document.querySelector("[eye-icon='eyeIconPassword']")
    const eyeIconConfirmPassword = document.querySelector("[eye-icon='eyeIconConfirmPassword']")
    const photoImage = document.getElementById("photoImage")
    const photoPreview = document.getElementById("photoPreview")
    const errorMessage = document.getElementById("errorMessage")

    if (photoImage) {
        photoImage.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                const imageUrl = URL.createObjectURL(file);
                photoPreview.firstElementChild.src = imageUrl;
                photoPreview.style.display = 'block'
            } else {
                photoPreview.style.display = 'none'
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

    const validateByColor = {
        'true': '1px solid #63a69d',
        'false': '1px solid #ff2c2c'
    }

    const getPassword = {
        password: ''
    }

    if (password) {
        password.addEventListener('input', function () {
            const value = this.value
            let color = validateByColor[isValidPassword(value)]
            this.style.borderBottom = color
            color = color.split(" ").pop()
            this.nextElementSibling.style.color = color

            conditions.forEach(function (elem, index) {
                validatePassword[index](value, elem)
            })
            getPassword.password = value
        })
    }

    if (confirmPassword) {
        confirmPassword.addEventListener('input', function () {
            if (this.value != getPassword.password) {
                this.nextElementSibling.style.color = "#ff2c2c"
                this.style.borderBottom = '1px solid #ff2c2c'
            } else {
                this.nextElementSibling.style.color = "#63a69d"
                this.style.borderBottom = '1px solid #63a69d'
            }
        })
    }

    if (email) {
        email.addEventListener('input', function () {
            let color = validateByColor[isValidEmail(this.value)]
            this.style.borderBottom = color
            color = color.split(" ").pop()
            this.nextElementSibling.style.color = color
        })
    }
    
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault()

            const inputs = Array.from(this.getElementsByTagName('input'))

            inputs.forEach(function (elem) {
                try {
                    validateRequiredFields(elem, errorMessage)
                }catch(error) {
                    throw new Error(error.message)
                }
            })

            const userName = this.userName.value.trim().split(" ")
            if (userName.length > 1) {
                errorMessage.style.display = 'block'
                errorMessage.innerHTML = `Campo ${this.userName.dataset.error} não pode ter espaço`
                throw new Error(`invalid ${this.userName.name}`)
            }

            if (!isValidEmail(this.email.value)) {
                errorMessage.style.display = 'block'
                errorMessage.innerHTML = `Campo ${this.email.dataset.error} inválido`
                this.email.style.borderBottom = '1px solid #ff2c2c'
                throw new Error(`invalid ${this.email.name}`)
            }

            if (!isValidPassword(this.password.value)) {
                errorMessage.style.display = 'block'
                errorMessage.innerHTML = `Campo ${this.password.dataset.error} inválido`
                this.password.style.borderBottom = '1px solid #ff2c2c'
                throw new Error(`invalid ${this.password.name}`)
            }

            if (this.confirmPassword.value != this.password.value) {
                errorMessage.style.display = 'block'
                errorMessage.innerHTML = `Campo ${this.confirmPassword.dataset.error} inválido`
                this.confirmPassword.style.borderBottom = '1px solid #ff2c2c'
                throw new Error(`invalid ${this.confirmPassword.name}`)
            }

            const btnSubmit = this.lastElementChild.lastElementChild
            const loaderImage = this.lastElementChild.firstElementChild

            btnSubmit.style.display = 'none'
            loaderImage.style.display = 'block'

            let endpoint = {
                "localhost": "braid/user/register",
                "clientes.laborcode.com.br": "braid/user/register",
                "braid.com.br": "user/register",
                "www.braid.com.br": "user/register",
            }

            const form = new FormData(this)
            endpoint = endpoint[url.getHostName()] || ''
            const requestUrl = url.getUrlOrigin(endpoint)

            fetch(requestUrl, { method: 'POST', body: form })
            .then(data => data.json()).then(function (data) {

                if (data.email_already_exists) {
                    btnSubmit.style.display = 'block'
                    loaderImage.style.display = 'none'
                    errorMessage.style.display = 'block'
                    errorMessage.innerHTML = data.msg
                    throw new Error(data.msg)
                }

                if (data.nickname_already_exists) {
                    btnSubmit.style.display = 'block'
                    loaderImage.style.display = 'none'
                    errorMessage.style.display = 'block'
                    errorMessage.innerHTML = data.msg
                    throw new Error(data.msg)
                }

                if (data.invalid_image) {
                    btnSubmit.style.display = 'block'
                    loaderImage.style.display = 'none'
                    errorMessage.style.display = 'block'
                    errorMessage.innerHTML = data.msg
                    throw new Error(data.msg)
                }
                
                if (data.register_success) {
                    if (errorMessage.style.display == 'block') {
                        errorMessage.style.display = 'none'
                    }
                    setTimeout(() => {
                        window.location.href = data.url_login
                    }, 1000)
                }
            })
        })
    }
}