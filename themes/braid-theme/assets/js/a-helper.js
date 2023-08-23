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