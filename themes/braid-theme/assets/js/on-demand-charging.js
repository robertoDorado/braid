if (url.getCurrentEndpoint() == "braid-system/client-report") {
    const deleteBtnModal = document.getElementById("deleteBtnModal")
    const launchSureDeleteModal = document.getElementById("launchSureDeleteModal")
    const calloutModalDeleteProject = document.getElementById("calloutModalDeleteProject")
    const loadNewProjects = document.getElementById("loadNewProjects")
    const rows = Array.from(document.querySelectorAll(".row"))
    const cardBody = document.getElementById("cardBody")
    const userType = cardBody.dataset.user
    let page = 1
    const limit = 3

    if (loadNewProjects) {
        loadNewProjects.addEventListener("click", function (event) {
            event.preventDefault()

            const loaderButton = this
            const loaderImage = this.firstElementChild
            const loaderLabel = this.lastElementChild

            loaderImage.style.display = "block"
            loaderLabel.style.display = "none"

            page++;
            let endpoint = {
                "localhost": "/braid/braid-system/token",
                "clientes.laborcode.com.br": "/braid/braid-system/token",
                "braid.com.br": "/braid-system/token",
                "www.braid.com.br": "/braid-system/token",
            }

            endpoint = endpoint[url.getHostName()] || ''
            let requestUrl = url.getUrlOrigin(endpoint)

            fetch(requestUrl).then(response => response.json()).then(function (response) {
                if (!response.tokenData) {
                    throw new Error("Erro ao retornar o token do usuário")
                }

                response["page"] = page
                response["max"] = limit

                endpoint = {
                    "localhost": "/braid/braid-system/charge-on-demand",
                    "clientes.laborcode.com.br": "/braid/braid-system/charge-on-demand",
                    "braid.com.br": "/braid-system/charge-on-demand",
                    "www.braid.com.br": "/braid-system/charge-on-demand",
                }

                endpoint = endpoint[url.getHostName()] || ''
                requestUrl = url.getUrlOrigin(endpoint)

                const stringBase64 = btoa(JSON.stringify(response))
                fetch(requestUrl + "/" + stringBase64, {
                    method: "GET",
                    headers: {
                        Authorization: "Bearer " + response.tokenData
                    }
                }).then(response => response.json()).then(function (response) {

                    loaderImage.style.display = "none"
                    loaderLabel.style.display = "block"
                    const wrapElement = rows[2].firstElementChild

                    let endpointEditProject = {
                        "localhost": "/braid/braid-system/edit-project",
                        "clientes.laborcode.com.br": "/braid/braid-system/edit-project",
                        "braid.com.br": "/braid-system/edit-project",
                        "www.braid.com.br": "/braid-system/edit-project",
                    }

                    endpointEditProject = endpointEditProject[url.getHostName()] || ''
                    const requestUrlEditProject = url.getUrlOrigin(endpointEditProject)

                    let enpointDeleteProject = {
                        "localhost": "/braid/braid-system/delete-project",
                        "clientes.laborcode.com.br": "/braid/braid-system/delete-project",
                        "braid.com.br": "/braid-system/delete-project",
                        "www.braid.com.br": "/braid-system/delete-project",
                    }

                    enpointDeleteProject = enpointDeleteProject[url.getHostName()] || ''
                    const requestUrlDeleteProject = url.getUrlOrigin(enpointDeleteProject)

                    
                    const totalJobsObject = response.pop()
                    const paginate = Math.ceil(totalJobsObject.total_jobs / limit)

                    if (paginate == page) {
                        loaderButton.style.display = "none"
                    }

                    response = Array.from(response)
                    response.forEach(function (item) {
                        const cardBodyElement = createNewElement("div")
                        setAttributesToElement("class", "card-body", cardBodyElement)
                        setAttributesToElement("data-hash", btoa(item.id), cardBodyElement)

                        const callOutInfoElement = createNewElement("div")
                        setAttributesToElement("class", "callout callout-info", callOutInfoElement)

                        const titleProject = createNewElement("h5")
                        const descriptionProject = createNewElement("p")
                        const projectValue = createNewElement("p")
                        const projectDeliveryTime = createNewElement("p")
                        const viewProject = createNewElement("a")
                        const tooltipCandidatesFreelancer = createNewElement("div")
                        const faIconUser = createNewElement("i")
                        const totalCandidates = createNewElement("span")
                        const containerFooterCallout = createNewElement("div")
                        const buttonsCalloutProjects = createNewElement("div")
                        const editLink = createNewElement("a")
                        const deleteLink = createNewElement("a")

                        editLink.innerHTML = "Editar dados do projeto"
                        deleteLink.innerHTML = "Excluir projeto"
                        deleteLink.style.marginLeft = ".2rem"
                        viewProject.style.marginLeft = ".2rem"

                        setAttributesToElement("class", "tooltip-candidates-freelancer", tooltipCandidatesFreelancer)
                        setAttributesToElement("class", "fa-solid fa-user", faIconUser)
                        setAttributesToElement("class", "total-candidates", totalCandidates)
                        setAttributesToElement("class", "container-footer-callout", containerFooterCallout)
                        setAttributesToElement("class", "buttons-callout-projects", buttonsCalloutProjects)
                        
                        setAttributesToElement("href", `${requestUrlEditProject}/${btoa(item.id)}`, editLink)
                        setAttributesToElement("href", "#", deleteLink)
                        setAttributesToElement("class", "btn btn-primary sample-format-link", editLink)
                        setAttributesToElement("class", "btn btn-danger sample-format-link delete-project", deleteLink)

                        totalCandidates.innerHTML = item.total_candidates
                        tooltipCandidatesFreelancer.append(faIconUser, totalCandidates)

                        let endpointViewProject = {
                            "localhost": `/braid/braid-system/project-detail/${btoa(item.id)}`,
                            "clientes.laborcode.com.br": `/braid/braid-system/project-detail/${btoa(item.id)}`,
                            "braid.com.br": `/braid-system/project-detail/${btoa(item.id)}`,
                            "www.braid.com.br": `/braid-system/project-detail/${btoa(item.id)}`,
                        }

                        endpointViewProject = endpointViewProject[url.getHostName()] || ''
                        const requestUrlViewProject = url.getUrlOrigin(endpointViewProject)

                        setAttributesToElement("href", requestUrlViewProject, viewProject)
                        setAttributesToElement("class", "btn btn-primary project-detail", viewProject)

                        wrapElement.appendChild(cardBodyElement)
                        cardBodyElement.appendChild(callOutInfoElement)

                        const date = formatDate(item.delivery_time)
                        const valueCurrencyFormat = parseFloat(item.remuneration_data).toLocaleString("pt-BR", { style: "currency", currency: "BRL" })

                        titleProject.innerHTML = item.job_name
                        descriptionProject.innerHTML = item.job_description
                        projectValue.innerHTML = `Valor do acordo: ${valueCurrencyFormat}`
                        viewProject.innerHTML = "Ver detalhes do projeto"

                        projectDeliveryTime.innerHTML = `Prazo de entrega: 
                            ${date.day}/${date.month}/${date.year} ${date.hour}:${date.minute}`

                        if (userType == "businessman") {
                            buttonsCalloutProjects.append(editLink, viewProject, deleteLink)
                        }else {
                            buttonsCalloutProjects.appendChild(viewProject)
                        }
                            
                        containerFooterCallout.append(buttonsCalloutProjects, tooltipCandidatesFreelancer)

                        if (deleteLink) {
                            deleteLink.addEventListener("click", function (event) {
                                event.preventDefault()
                                launchSureDeleteModal.click()
                                const dataProject = Array.from(this.parentElement.parentElement.parentElement.children)
                                setAttributesToElement("data-hash", btoa(item.id), deleteBtnModal)

                                if (calloutModalDeleteProject) {
                                    const modalDataProject = Array.from(calloutModalDeleteProject.children)
                                    modalDataProject[0].innerHTML = dataProject[0].innerHTML
                                    modalDataProject[1].innerHTML = dataProject[1].innerHTML
                                    modalDataProject[2].innerHTML = dataProject[2].innerHTML
                                    modalDataProject[3].innerHTML = dataProject[3].innerHTML
                                }
                            })
                        }

                        callOutInfoElement.append(titleProject, descriptionProject, projectValue, projectDeliveryTime, containerFooterCallout)
                    })

                    deleteBtnModal.addEventListener("click", function () {
                        const hideModalBtn = this.previousElementSibling

                        fetch(requestUrlDeleteProject, {
                            method: "POST",
                            headers: {
                                Authorization: "Bearer " + this.dataset.hash
                            }
                        }).then(response => response.json())
                            .then(function (response) {
                                if (response.success_delete_project) {

                                    let allDataProject = Array.from(document.querySelectorAll(".card-body"))
                                    allDataProject = allDataProject.filter((elem) => elem.dataset.hash != null)

                                    allDataProject.forEach(function (elem) {
                                        const projectId = atob(elem.dataset.hash)

                                        if (!/^\d+$/.test(projectId)) {
                                            throw new Error("Data hash inválido")
                                        }

                                        if (response.id == projectId) {
                                            elem.style.display = "none"
                                            hideModalBtn.click()
                                        }
                                    })
                                }
                            })
                    })
                })
            })
        })
    }
}