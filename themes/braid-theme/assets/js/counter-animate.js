if (url.getCurrentEndpoint() == "/") {
    function animateCounter(selector) {
        const target = document.querySelector(selector)
        let counter = parseInt(target.innerHTML)
        let current = 0;
    
        if (!target) {
            throw new Error("invalid count element")
        }
        
        const increment = counter / (2000 / 16);
    
        const interval = setInterval(() => {
            current += increment;
    
            const roundedCurrent = Math.round(current);
            document.querySelector(selector).innerHTML = roundedCurrent.toLocaleString("pt-BR");
    
            if (current >= counter) {
                clearInterval(interval);
                document.querySelector(selector).innerHTML = counter.toLocaleString("pt-BR");
            }
        }, 50);
    }
    window.addEventListener('load', function () {
        animateCounter(".freelancers-register span");
        animateCounter(".businessman-register span");
    })
}
