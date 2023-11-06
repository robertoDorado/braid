if (url.getCurrentEndpoint() == "braid-system/client-report") {
    const deleteProject = Array.from(document.querySelectorAll(".delete-project"))
    const launchSureDeleteModal = document.getElementById("launchSureDeleteModal")
    const calloutModalDeleteProject = document.getElementById("calloutModalDeleteProject")
    const deleteBtnModal = document.getElementById("deleteBtnModal")

    deleteProject.forEach(function(elem) {
        elem.addEventListener("click", function (event) {
            event.preventDefault()
            launchSureDeleteModal.click()
            const projectElement = this.parentElement.parentElement.parentElement
            const dataProject = Array.from(projectElement.children)
            const hashId = this.dataset.hash

            if (calloutModalDeleteProject) {
                const modalDataProject = Array.from(calloutModalDeleteProject.children)
                console.log(dataProject)
                modalDataProject[0].innerHTML = dataProject[0].innerHTML
                modalDataProject[1].innerHTML = dataProject[1].innerHTML
                modalDataProject[2].innerHTML = dataProject[2].innerHTML
                modalDataProject[3].innerHTML = dataProject[3].innerHTML
            }

            let enpointDeleteProject = {
                "localhost": "/braid/braid-system/delete-project",
                "clientes.laborcode.com.br": "/braid/braid-system/delete-project",
                "braid.com.br": "/braid-system/delete-project",
                "www.braid.com.br": "/braid-system/delete-project",
            }

            enpointDeleteProject = enpointDeleteProject[url.getHostName()] || ''
            const requestUrlDeleteProject = url.getUrlOrigin(enpointDeleteProject)

            deleteBtnModal.addEventListener("click", function () {
                const hideModal = this.previousElementSibling
                fetch(requestUrlDeleteProject, { 
                    method: "POST",
                    headers: {
                        Authorization: "Bearer " + hashId
                    } 
                }).then(response => response.json())
                .then(function(response) {
                    if (response.success_delete_project) {
                        projectElement.parentElement.style.display = "none"
                        hideModal.click()
                    }
                })
            })

        })
    })
}