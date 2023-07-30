function typeWrite(element) {
    const arrayText = element.innerHTML.split('');
    element.innerHTML = ' ';
    arrayText.forEach(function (letter, i) {
        setTimeout(function () {
            element.innerHTML += letter;
        }, 75 * i)
    });
}

typeWrite(document.querySelector('.background-home h1'));

setInterval(() => {
    const firstTitle = document.querySelector('.background-home h1');
    const secondTitle = firstTitle.nextElementSibling;

    if (firstTitle.style.display === 'none') {
        firstTitle.style.display = 'block';
        secondTitle.style.display = 'none';
        typeWrite(firstTitle);
    } else {
        firstTitle.style.display = 'none';
        secondTitle.style.display = 'block';
        typeWrite(secondTitle);
    }
}, 10000)