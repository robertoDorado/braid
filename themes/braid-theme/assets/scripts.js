function animateCounter(selector){const target=document.querySelector(selector)
let counter=parseInt(target.innerHTML)
let current=0;if(!target){throw new Error("invalid count element")}
const increment=counter/(2000/16);const interval=setInterval(()=>{current+=increment;const roundedCurrent=Math.round(current);document.querySelector(selector).innerHTML=roundedCurrent.toLocaleString("pt-BR");if(current>=counter){clearInterval(interval);document.querySelector(selector).innerHTML=counter.toLocaleString("pt-BR")}},50)}
window.addEventListener('load',function(){animateCounter(".freelancers-register span");animateCounter(".businessman-register span")});function typeWrite(text){const arrayText=text.split('');document.querySelector('.background-home h1').innerHTML=' ';arrayText.forEach(function(letter,i){setTimeout(function(){document.querySelector('.background-home h1').innerHTML+=letter},75*i)})}
const texts=[{title:"Potencialize seus projetos com a nossa plataforma para designers freelancers!",},{title:"Encontre projetos com a nossa plataforma para designers freelancers!",}]
let currentIndex=0;const intervalTime=10000;typeWrite(texts[currentIndex].title);setInterval(()=>{currentIndex++;currentIndex=currentIndex>=texts.length?0:currentIndex
typeWrite(texts[currentIndex].title)},intervalTime)