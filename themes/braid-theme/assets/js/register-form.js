if (url.getCurrentEndpoint() == "user/register") {
    const form = document.getElementById("registerForm")
    const email = document.getElementById("email")
    const password = document.getElementById("password")
    const confirmPassword = document.getElementById("confirmPassword")
    const conditions = document.querySelectorAll("#conditions li")
    const eyeIconPassword = document.getElementById("eyeIconPassword")
    const eyeIconConfirmPassword = document.getElementById("eyeIconConfirmPassword")
    const photoImage = document.getElementById("photoImage")
    const photoPreview = document.getElementById("photoPreview")

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

    let endpoint = {
        "localhost": "braid/framework-php/user/register",
        "clientes.laborcode.com.br": "user/register",
        "braid.com.br": "user/register",
        "www.braid.com.br": "user/register",
    }
    
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault()

            const inputs = Array.from(this.getElementsByTagName('input'))

            inputs.forEach(function (elem) {
                try {
                    if (elem.dataset.required) {
                        const elementBoolean = JSON.parse(elem.dataset.required)
                        if (elementBoolean) {
                            if (elem.value == '') {
                                elem.style.borderBottom = '1px solid #ff2c2c'
                                throw new Error(`empty data ${elem.name}`)
                            } else {
                                elem.style.borderBottom = '1px solid #2196f3'
                            }
                        }
                    }
                }catch(error) {
                    throw new Error(`Erro ao converter dataset em booleano: ${error}`)
                }
            })

            if (!isValidPassword(this.password.value)) {
                throw new Error("invalid password")
            }

            if (!isValidEmail(this.email.value)) {
                throw new Error("invalid email")
            }

            if (this.confirmPassword.value != this.password.value) {
                throw new Error("invalid confirm password")
            }

            this.lastElementChild.lastElementChild.style.display = 'none'
            this.lastElementChild.firstElementChild.style.display = 'block'
            const form = new FormData(this)

            endpoint = endpoint[url.getHostName()] || ''

            fetch(url.getUrlOrigin(endpoint), { method: 'POST', body: form })
            .then(data => data.json()).then(function (data) {
                console.log(data)
            })
        })
    }
}