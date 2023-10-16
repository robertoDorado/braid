if (url.getCurrentEndpoint() == "braid-system") {
    const formAlterProfile = document.getElementById("formAlterProfile")
    const errorMessage = document.getElementById("errorMessage")
    const photoImage = document.getElementById("photoImage")
    const photoPreview = document.getElementById("photoPreview")

    photoImage.addEventListener('change', function () {
        const file = this.files[0];

        if (file) {
            const imageUrl = URL.createObjectURL(file);
            photoPreview.firstElementChild.src = imageUrl;
            photoPreview.style.display = 'block'
        } else {
            photoPreview.style.display = 'none'
        }
    })

    formAlterProfile.addEventListener("submit", function (event) {
        event.preventDefault()

        const inputs = Array.from(this.getElementsByTagName("input"))
        inputs.forEach(function (elem) {
            try {
                validateRequiredFields(elem, errorMessage)
            } catch (error) {
                throw new Error(error.message)
            }
        })

        const userName = this.userName.value.trim().split(" ")
        if (userName.length > 1) {
            errorMessage.style.display = 'block'
            errorMessage.innerHTML = `Campo ${this.userName.dataset.error} não pode ter espaço em branco`
            throw new Error(`invalid ${this.userName.name}`)
        }

        const loaderImage = this.getElementsByTagName("button")[0].firstElementChild
        const btnSubmit = this.getElementsByTagName("button")[0].lastElementChild

        loaderImage.style.display = 'block'
        btnSubmit.style.display = 'none'

        let endpoint = {
            "localhost": "/braid/braid-system",
            "clientes.laborcode.com.br": "/braid/braid-system",
            "braid.com.br": "/braid-system",
            "www.braid.com.br": "/braid-system",
        }

        endpoint = endpoint[url.getHostName()] || ''
        const form = new FormData(this)
        const requestUrl = url.getUrlOrigin(endpoint)

        fetch(requestUrl, { method: "POST", body: form })
            .then(data => data.json()).then(function (data) {

                if (data.invalid_image) {
                    throw new Error(data.msg)
                }
                
                if (data.update_success) {
                    window.location.href = window.location.href
                }
            }).catch(function(error) {
                error = error.toString().replace("Error: ", "")
                btnSubmit.style.display = 'block'
                loaderImage.style.display = 'none'
                errorMessage.style.display = 'block'
                errorMessage.innerHTML = error
            }).finally(() => {
                btnSubmit.style.display = 'block'
                loaderImage.style.display = 'none'
                errorMessage.style.display = 'block'
                errorMessage.innerHTML = "Erro geral ao alterar o perfil do usuário"
            })
    })
}