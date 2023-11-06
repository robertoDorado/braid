const endpointSystemForm = removeParamFromEndpoint(url.getCurrentEndpoint(), true)
const endpointParamForm = endpointSystemForm.pop()
let elementCreated = false

if (endpointSystemForm.join("/") == "braid-system/project-detail") {
    const makeProposal = document.getElementById("makeProposal")

    let endpoint = {
        "localhost": "/braid/themes/braid-theme/assets/img/loading.gif",
        "clientes.laborcode.com.br": "/braid/themes/braid-theme/assets/img/loading.gif",
        "braid.com.br": "/themes/braid-theme/assets/img/loading.gif",
        "www.braid.com.br": "/themes/braid-theme/assets/img/loading.gif",
    }

    endpoint = endpoint[url.getHostName()] || ''
    const urlLoader = url.getUrlOrigin(endpoint)

    const containerProjectDescription = document.getElementById("containerProjectDescription")
    const row = createNewElement("div")
    const col = createNewElement("div")

    const h3 = createNewElement("h3")
    const contractForm = createNewElement("form")
    const cardBody = createNewElement("div")

    const cardPrimary = createNewElement("div")
    const cardHeader = createNewElement("div")
    const formGroup = createNewElement("div")

    const label = createNewElement("label")
    const textArea = createNewElement("textarea")
    const csrfToken = createNewElement("input")
    const cardFooter = createNewElement("div")

    const buttonSubmit = createNewElement("button")
    const img = createNewElement("img")
    const span = createNewElement("span")

    const alertMessage = createNewElement("div")

    row.style.marginTop = ".9rem"
    label.innerHTML = "Descrições adicionais"
    contractForm.id = "contractForm"
    buttonSubmit.type = "submit"

    textArea.type = "text"
    textArea.name = "additionalDescription"
    textArea.dataset.required = true
    textArea.dataset.error = "Descrições adicionais"
    textArea.id = "additionalDescription"

    csrfToken.name = "csrfToken"
    csrfToken.type = "hidden"
    csrfToken.dataset.required = true
    csrfToken.dataset.error = "Token"
    csrfToken.id = "csrfToken"

    img.style.width = "20px"
    img.style.display = "none"
    img.style.margin = "0 auto"
    img.src = urlLoader
    img.alt = "loader"

    h3.innerHTML = "Fazer uma proposta"
    span.innerHTML = "Enviar proposta"

    alertMessage.style.textAlign = "center"
    alertMessage.style.display = "none"
    alertMessage.id = "alertMessage"

    setAttributesToElement("class", "row", row)
    setAttributesToElement("class", "col", col)
    setAttributesToElement("class", "card card-primary", cardPrimary)
    setAttributesToElement("class", "card-header bg-danger", cardHeader)
    setAttributesToElement("class", "card-title", h3)
    setAttributesToElement("class", "card-body", cardBody)
    setAttributesToElement("class", "form-group", formGroup)
    setAttributesToElement("for", "additionalDescription", label)
    setAttributesToElement("class", "form-control", textArea)
    setAttributesToElement("placeholder", "Descrições adicionais sobre a proposta", textArea)
    setAttributesToElement("class", "card-footer", cardFooter)
    setAttributesToElement("class", "btn bg-danger", buttonSubmit)
    setAttributesToElement("class", "alert alert-danger", alertMessage)
    setAttributesToElement("class", "form-control", csrfToken)

    endpoint = {
        "localhost": "/braid/braid-system/project-detail",
        "clientes.laborcode.com.br": "/braid/braid-system/project-detail",
        "braid.com.br": "/braid-system/project-detail",
        "www.braid.com.br": "/braid-system/project-detail",
    }

    endpoint = endpoint[url.getHostName()] || ''
    const projectDetailUrl = url.getUrlOrigin(endpoint)

    makeProposal.addEventListener("click", function (event) {
        event.preventDefault()

        if (!elementCreated) {
            containerProjectDescription.appendChild(row)
            row.appendChild(col)
            col.appendChild(cardPrimary)
            cardPrimary.append(cardHeader, contractForm)
            cardHeader.appendChild(h3)
            contractForm.append(cardBody, cardFooter, alertMessage)
            cardBody.appendChild(formGroup)
            formGroup.append(label, textArea, csrfToken)
            cardFooter.appendChild(buttonSubmit)
            buttonSubmit.append(img, span)
            window.scrollTo(0, document.body.scrollHeight);

            fetch(projectDetailUrl, { method: "POST", body: JSON.stringify({ request_csrf_token: true }) })
            .then(data => data.json()).then(function (data) {
                csrfToken.value = data.csrf_token
            })
            elementCreated = true
        }
    })

    contractForm.addEventListener("submit", function (event) {
        event.preventDefault()
 
        const inputs = Array.from(this.querySelectorAll(".form-control"))
        inputs.forEach(function (elem) {
            validateRequiredFields(elem, alertMessage)
        })
        
        const form = new FormData(this)
        form.append("jobId", atob(endpointParamForm))
        
        span.style.display = 'none'
        img.style.display = 'block'

        fetch(projectDetailUrl, { method: "POST", body: form })
        .then(data => data.json()).then(function(data) {

            if (data.invalid_job_id) {
                throw new Error(data.msg)
            }

            if (data.contract_success) {
                alertMessage.classList.remove("alert-danger")
                alertMessage.classList.add("alert-success")
                alertMessage.innerHTML = "Candidatura realizada com sucesso"
                alertMessage.style.display = 'block'
                setTimeout(() => {
                    window.location.href = data.url
                }, 2000)
            }

        }).catch(function(error) {
            error = error.toString().replace("Error: ", "")
            span.style.display = 'block'
            img.style.display = 'none'
            alertMessage.style.display = 'block'
            alertMessage.innerHTML = error
        })
    })
}