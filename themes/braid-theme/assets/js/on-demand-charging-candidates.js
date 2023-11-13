const response = removeParamFromEndpoint(url.getCurrentEndpoint(), true)
const endpointParamValue = response.pop()
const endpointData = response.join("/")

if (endpointData == "braid-system/project-detail") {
    const loadCandidates = document.getElementById("loadCandidates")
    const containerCandidates = document.getElementById("containerCandidates")
    let page = 1
    const limit = 3

    if (loadCandidates) {
        loadCandidates.addEventListener("click", function (event) {
            event.preventDefault()

            const loaderBtn = this
            const imgLoader = this.firstElementChild
            const btnLoader = this.lastElementChild

            imgLoader.style.display = "block"
            btnLoader.style.display = "none"
            page++

            let endpoint = {
                "localhost": "/braid/braid-system/token",
                "clientes.laborcode.com.br": "/braid/braid-system/token",
                "braid.com.br": "/braid-system/token",
                "www.braid.com.br": "/braid-system/token",
            }

            endpoint = endpoint[url.getHostName()] || ''
            let requestUrl = url.getUrlOrigin(endpoint)

            fetch(requestUrl).then(response => response.json())
                .then(function (response) {
                    if (!response.tokenData) {
                        throw new Error("Erro ao retornar o token do usuário")
                    }

                    response["page"] = page
                    response["max"] = limit
                    response["job_id"] = atob(endpointParamValue)

                    endpoint = {
                        "localhost": "/braid/braid-system/charge-on-demand-candidates",
                        "clientes.laborcode.com.br": "/braid/braid-system/charge-on-demand-candidates",
                        "braid.com.br": "/braid-system/charge-on-demand-candidates",
                        "www.braid.com.br": "/braid-system/charge-on-demand-candidates",
                    }

                    endpoint = endpoint[url.getHostName()] || ''
                    requestUrl = url.getUrlOrigin(endpoint)

                    const stringBase64 = btoa(JSON.stringify(response))
                    fetch(requestUrl + "/" + stringBase64, {
                        method: "GET",
                        headers: {
                            Authorization: "Bearer " + response.tokenData
                        }
                    }).then(response => response.json())
                        .then(function (response) {

                            imgLoader.style.display = "none"
                            btnLoader.style.display = "block"

                            const totalJobsObject = response.pop()
                            const paginate = Math.ceil(totalJobsObject.total_contracts / limit)

                            if (paginate == page) {
                                loaderBtn.style.display = "none"
                            }

                            response = Array.from(response)
                            response.forEach(function (item) {
                                endpoint = {
                                    "localhost": "/braid/themes/braid-theme/assets/img/user",
                                    "clientes.laborcode.com.br": "/braid/themes/braid-theme/assets/img/user",
                                    "braid.com.br": "/themes/braid-theme/assets/img/user",
                                    "www.braid.com.br": "/themes/braid-theme/assets/img/user",
                                }

                                endpoint = endpoint[url.getHostName()] || ''
                                requestUrl = url.getUrlOrigin(endpoint)

                                const containerDesigner = createNewElement("div")
                                const designerData = createNewElement("div")
                                const photoDesigner = createNewElement("img")
                                const freelancerName = createNewElement("p")
                                const descriptionDataDesigner = createNewElement("div")
                                const descriptionData = createNewElement("p")
                                const btnSeeProfileCandidate = createNewElement("a")

                                let endpointProfileData = {
                                    "localhost": "/braid/braid-system/profile-data",
                                    "clientes.laborcode.com.br": "/braid/braid-system/profile-data",
                                    "braid.com.br": "/braid-system/profile-data",
                                    "www.braid.com.br": "/braid-system/profile-data",
                                }
            
                                endpointProfileData = endpointProfileData[url.getHostName()] || ''
                                const requestUrlProfileData = url.getUrlOrigin(endpointProfileData)

                                containerDesigner.dataset.hash = btoa(item.designer_id)
                                btnSeeProfileCandidate.innerHTML = "Ver perfil do candidato"
                                btnSeeProfileCandidate.href = requestUrlProfileData + "/" + btoa(item.designer_id)

                                if (item.path_photo == null) {
                                    photoDesigner.src = requestUrl + "/default.png"
                                    photoDesigner.alt = "default.png"
                                } else {
                                    photoDesigner.src = requestUrl + "/" + item.path_photo
                                    photoDesigner.alt = item.path_photo
                                }

                                freelancerName.innerHTML = item.full_name
                                descriptionData.innerHTML = item.additional_description

                                setAttributesToElement("class", "callout callout-danger container-designer", containerDesigner)
                                setAttributesToElement("class", "designer-data", designerData)
                                setAttributesToElement("class", "photo-designer", photoDesigner)
                                setAttributesToElement("class", "description-data-designer", descriptionDataDesigner)
                                setAttributesToElement("class", "btn btn-primary see-profile", btnSeeProfileCandidate)

                                descriptionDataDesigner.appendChild(descriptionData)
                                descriptionDataDesigner.appendChild(btnSeeProfileCandidate)
                                designerData.append(photoDesigner, freelancerName)
                                containerDesigner.append(designerData, descriptionDataDesigner)
                                containerCandidates.appendChild(containerDesigner)
                            })
                        })
                })
        })
    }
}