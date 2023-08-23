if (url.getCurrentEndpoint() == "user/register") {
    const form = document.getElementById("registerForm")
    const email = document.getElementById("email")
    const password = document.getElementById("password")
    const confirmPassword = document.getElementById("confirmPassword")
    const conditions = document.querySelectorAll("#conditions li")
    const eyeIconPassword = document.getElementById("eyeIconPassword")
    const eyeIconConfirmPassword = document.getElementById("eyeIconConfirmPassword")

    if (eyeIconPassword) {
        eyeIconPassword.addEventListener('click', function () {
            if (this.classList.contains("fa-eye-slash")) {
                this.classList.remove("fa-eye-slash")
                this.classList.add("fa-eye")
                this.parentElement.firstElementChild.setAttribute('type', 'text')
            }else {
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
            }else {
                this.classList.remove("fa-eye")
                this.classList.add("fa-eye-slash")
                this.parentElement.firstElementChild.setAttribute('type', 'password')
            }
        })
    }

    const validateByColor = {
        'true': '2px solid #4ae000',
        'false': '2px solid #ff2c2c'
    }

    const getPassword = {
        password: ''
    }

    if (password) {
        password.addEventListener('input', function () {
            const value = this.value
            let color = validateByColor[isValidPassword(value)]
            this.style.borderBottom = color

            conditions.forEach(function (elem, index) {
                validatePassword[index](value, elem)
            })
            getPassword.password = value
        })
    }

    if (confirmPassword) {
        confirmPassword.addEventListener('input', function () {
            if (this.value != getPassword.password) {
                this.style.borderBottom = '2px solid #ff2c2c'
            }else {
                this.style.borderBottom = '2px solid #4ae000'
            }
        })
    }

    if (email) {
        email.addEventListener('input', function () {
            let color = validateByColor[isValidEmail(this.value)]
            this.style.borderBottom = color
        })
    }

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault()

            if (!isValidPassword(this.password.value)) {
                throw new Error("invalid password")
            }
            
            if (!isValidEmail(this.email.value)) {
                throw new Error("invalid email")
            }
            
            if (this.confirmPassword.value != this.password.value) {
                throw new Error("invalid confirm password")
            }

            const form = new FormData(this)
            console.log(form)
        })
    }
}