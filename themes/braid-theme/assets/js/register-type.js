const url = new Url()
if (url.getCurrentEndpoint() == "user/register") {
    
    const registerType = document.getElementById("registerType")
    const form = document.getElementById("genericForms")
    const launchGenericModal = document.getElementById("launchGenericModal")
    const titleNewMembership = document.getElementById("titleNewMembership")
    let type = registerType.dataset.register

    let obs = {
        generic: (elem) => elem.click(),
        businessman: 'Cadastre-se como empresa',
        designer: 'Cadastre-se como designer'
    }

    window.addEventListener('load', function () {
        obs = typeof obs[type] == 'function' ? obs[type](launchGenericModal) : obs[type]
        titleNewMembership.innerHTML = obs || ''
    })

    form.addEventListener('submit', function (ev) {
        ev.preventDefault()
        
        let params = url.parseQueryStringData()

        obs = {
            changeParam: (params, option) => {
                params.userType = option
                return params
            }
        }

        params = obs['changeParam'](params, this.option.value)
        params = url.stringfyQueryStringData(params)
        window.location.href = url.stringUrl + "?" + params
    })
}