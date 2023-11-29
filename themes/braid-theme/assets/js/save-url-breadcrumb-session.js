const endpointProjectDetail = removeParamFromEndpoint(url.getCurrentEndpoint(), true)
const paramEndpointProjectDetail = endpointProjectDetail.pop()

if (endpointProjectDetail.join("/") == "braid-system/project-detail") {
    const seeProfile = Array.from(document.querySelectorAll(".see-profile"))

    seeProfile.forEach(function (link) {
        link.addEventListener("click", function (event) {
            event.preventDefault()

            let endpoint = {
                "localhost": "/braid/braid-system/project-detail",
                "clientes.laborcode.com.br": "/braid/braid-system/project-detail",
                "braid.com.br": "/braid-system/project-detail",
                "www.braid.com.br": "/braid-system/project-detail",
            }

            endpoint = endpoint[url.getHostName()] || ''
            const link = url.getUrlOrigin(endpoint) + "/" + paramEndpointProjectDetail
            const linkRedirect = this.href

            endpoint = {
                "localhost": "/braid/braid-system/save-breadcrumb-link",
                "clientes.laborcode.com.br": "/braid/braid-system/save-breadcrumb-link",
                "braid.com.br": "/braid-system/save-breadcrumb-link",
                "www.braid.com.br": "/braid-system/save-breadcrumb-link",
            }

            endpoint = endpoint[url.getHostName()] || ''
            const requestUrl = url.getUrlOrigin(endpoint)
            const form = new FormData()
            form.append("linkBreadCrumbBefore", link)
            form.append("csrfToken", this.dataset.csrf)

            fetch(requestUrl, {
                method: "POST",
                body: form
            }).then(response => response.json())
                .then(function (response) {
                    if (response.success) {
                        window.location.href = linkRedirect
                    }
                })
        })
    })
}