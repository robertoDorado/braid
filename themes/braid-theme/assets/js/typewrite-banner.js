function typeWrite(text) {
    const arrayText = text.split('');
    document.querySelector('.background-home h1').innerHTML = ' ';
    arrayText.forEach(function (letter, i) {
        setTimeout(function () {
            document.querySelector('.background-home h1').innerHTML += letter;
        }, 75 * i)
    });
}

const texts = [
    {
        title: "Potencialize seus projetos com a nossa plataforma para designers freelancers!",
    },
    {
        title: "Encontre projetos com a nossa plataforma para designers freelancers!",
    }
]

let currentIndex = 0;
const intervalTime = 10000;

typeWrite(texts[currentIndex].title);

setInterval(() => {
    currentIndex++;
    currentIndex = currentIndex >= texts.length ? 0 : currentIndex
    typeWrite(texts[currentIndex].title);
}, intervalTime);