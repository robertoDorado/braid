function isValidEmail(value) {
    return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)
}

function isValidPassword(value) {
    return /^(?=.*\d)(?=.*[a-zA-Z])(?=.*[@#$%^&+=!]).{8,}$/.test(value)
}

function isCapitalize(value) {
    return /[A-Z]/.test(value)
}

function isNumeric(value) {
    return /[\d]/.test(value)
}

function isSpecialCharacter(value) {
    return /[@#$%^&+=!]/.test(value)
}

function validateRequiredFields(elem, errorMessage) {
    if (elem.dataset.required) {
        const elementBoolean = JSON.parse(elem.dataset.required)
        if (elementBoolean) {
            if (elem.value == '') {
                errorMessage.style.display = 'block'
                errorMessage.innerHTML = `Campo ${elem.dataset.error} não pode estar vazio`
                elem.style.borderBottom = '1px solid #ff2c2c'
                throw new Error(`Campo ${elem.name} não pode estar vazio`)
            } else {
                elem.style.borderBottom = '1px solid #2196f3'
            }
        }
    }
}

function isAtBottomPage() {
    const documentHeight = document.documentElement.scrollHeight;
    const windowHeight = window.innerHeight || document.documentElement.clientHeight;
    const scrollY = window.scrollY;
    return documentHeight - (scrollY + windowHeight) < 10;
}