const skipPopop = document.getElementById("skipPopop")
if (skipPopop) {
    skipPopop.addEventListener('click', function (event) {
        event.preventDefault()
        this.parentElement.parentElement.style.display = "none"

        try {
            const form = new FormData()
            form.append("cookie", JSON.parse(this.dataset.agree))

            fetch(url.getStringUrl() + "cookies/set-cookie", {
                method: "POST",
                body: form
            })

        }catch(e) {
            throw new Error(e)
        }
    })
}