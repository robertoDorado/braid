if (url.getCurrentEndpoint() == 'user/login') {
    const form = document.getElementById("loginForm")
    const eyeIconPassword = document.querySelector("[eye-icon='eyeIconPassword']")

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

    form.addEventListener('click', function (event) {
        event.preventDefault()

        const inputs = Array.from(this.getElementsByTagName("input"))
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

        const loaderImage = this.getElementsByTagName("button")[0].firstElementChild
        loaderImage.style.display = 'block'
    })
}