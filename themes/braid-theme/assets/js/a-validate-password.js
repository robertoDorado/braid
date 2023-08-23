const validatePassword = {
    '0': function (value, elem) {
        if (value.length >= 8) {
            elem.firstChild.innerHTML = "&#10004;"
            elem.firstChild.classList.remove("cross")
            elem.firstChild.classList.add("checkmark")
        }else {
            elem.firstChild.innerHTML = "&#x2718;"
            elem.firstChild.classList.remove("checkmark")
            elem.firstChild.classList.add("cross")
        }
    },

    '1': function (value, elem) {
        if (isCapitalize(value)) {
            elem.firstChild.innerHTML = "&#10004;"
            elem.firstChild.classList.remove("cross")
            elem.firstChild.classList.add("checkmark")
        }else {
            elem.firstChild.innerHTML = "&#x2718;"
            elem.firstChild.classList.remove("checkmark")
            elem.firstChild.classList.add("cross")
        }
    },

    '2': function (value, elem) {
        if (isNumeric(value)) {
            elem.firstChild.innerHTML = "&#10004;"
            elem.firstChild.classList.remove("cross")
            elem.firstChild.classList.add("checkmark")
        }else {
            elem.firstChild.innerHTML = "&#x2718;"
            elem.firstChild.classList.remove("checkmark")
            elem.firstChild.classList.add("cross")
        }
    },

    '3': function (value, elem) {
        if (isSpecialCharacter(value)) {
            elem.firstChild.innerHTML = "&#10004;"
            elem.firstChild.classList.remove("cross")
            elem.firstChild.classList.add("checkmark")
        }else {
            elem.firstChild.innerHTML = "&#x2718;"
            elem.firstChild.classList.remove("checkmark")
            elem.firstChild.classList.add("cross")
        }
    }
}