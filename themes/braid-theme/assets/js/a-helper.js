function formatDate(stringDate) {
    const date = new Date(stringDate);

    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();
    let hour = date.getHours();
    let minute = date.getMinutes();

    if (day < 10) day = "0" + day;
    if (month < 10) month = "0" + month;
    if (hour < 10) hour = "0" + hour;
    if (minute < 10) minute = "0" + minute;

    return { day, month, year, hour, minute }
}

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

function createNewElement(elementName) {
    const element = document.createElement(elementName)
    return element
}

function setAttributesToElement(attributeName, attributeValue, element) {
    element.setAttribute(attributeName, attributeValue)
}

function removeParamFromEndpoint(endpoint, getEndpointParam=false) {
    endpoint = endpoint.split("/")
    
    if (!getEndpointParam) {
        endpoint.pop()
        return endpoint.join("/")
    }else {
        return endpoint
    }
}

function isBase64(str) {
    try {
      const decodedString = atob(str);
      const base64String = btoa(decodedString);
      
      return base64String === str;
    } catch (error) {
      return false;
    }
  }