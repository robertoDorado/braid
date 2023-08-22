class Url{endpoint;queryString;stringUrl;constructor(){this.endpoint=window.location.pathname.split("/")
this.queryString=window.location.search
this.stringUrl=window.location.origin+window.location.pathname}
stringfyQueryStringData(object){const params=[];for(const key in object){if(object.hasOwnProperty(key)){const value=object[key];params.push(`${encodeURIComponent(key)}=${encodeURIComponent(value)}`)}}
return params.join('&')}
parseQueryStringData(){const params=new URLSearchParams(this.queryString);const queryObject={};for(const[key,value]of params){queryObject[key]=value}
return queryObject}
getCurrentEndpoint(){this.endpoint=this.endpoint.filter((value)=>value!=""&&value!="framework-php"&&value!="braid")
this.endpoint=this.endpoint.length==0?'/':this.endpoint.join('/')
return this.endpoint}};if(new Url().getCurrentEndpoint()=="/"){function animateCounter(selector){const target=document.querySelector(selector)
let counter=parseInt(target.innerHTML)
let current=0;if(!target){throw new Error("invalid count element")}
const increment=counter/(2000/16);const interval=setInterval(()=>{current+=increment;const roundedCurrent=Math.round(current);document.querySelector(selector).innerHTML=roundedCurrent.toLocaleString("pt-BR");if(current>=counter){clearInterval(interval);document.querySelector(selector).innerHTML=counter.toLocaleString("pt-BR")}},50)}
window.addEventListener('load',function(){animateCounter(".freelancers-register span");animateCounter(".businessman-register span")})};const url=new Url()
if(url.getCurrentEndpoint()=="user/register"){const registerType=document.getElementById("registerType")
const form=document.getElementById("genericForms")
const launchGenericModal=document.getElementById("launchGenericModal")
const titleNewMembership=document.getElementById("titleNewMembership")
let type=registerType.dataset.register
let obs={generic:(elem)=>elem.click(),businessman:'Cadastre-se como empresa',designer:'Cadastre-se como designer'}
window.addEventListener('load',function(){obs=typeof obs[type]=='function'?obs[type](launchGenericModal):obs[type]
titleNewMembership.innerHTML=obs||''})
form.addEventListener('submit',function(ev){ev.preventDefault()
let params=url.parseQueryStringData()
obs={changeParam:(params,option)=>{params.userType=option
return params}}
params=obs.changeParam(params,this.option.value)
params=url.stringfyQueryStringData(params)
window.location.href=url.stringUrl+"?"+params})};if(new Url().getCurrentEndpoint()=="/"){function typeWrite(text){const arrayText=text.split('');document.querySelector('.background-home h1').innerHTML=' ';arrayText.forEach(function(letter,i){setTimeout(function(){document.querySelector('.background-home h1').innerHTML+=letter},75*i)})}
const texts=[{title:"Potencialize seus projetos com a nossa plataforma para designers freelancers!",},{title:"Encontre projetos com a nossa plataforma para designers freelancers!",}]
let currentIndex=0;const intervalTime=10000;typeWrite(texts[currentIndex].title);setInterval(()=>{currentIndex++;currentIndex=currentIndex>=texts.length?0:currentIndex
typeWrite(texts[currentIndex].title)},intervalTime)}