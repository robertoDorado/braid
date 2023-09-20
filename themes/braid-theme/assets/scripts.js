function isValidEmail(value){return/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)}
function isValidPassword(value){return/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[@#$%^&+=!]).{8,}$/.test(value)}
function isCapitalize(value){return/[A-Z]/.test(value)}
function isNumeric(value){return/[\d]/.test(value)}
function isSpecialCharacter(value){return/[@#$%^&+=!]/.test(value)};class Url{endpoint;queryString;stringUrl;urlOrigin;host;getHostName(){this.host=window.location.host
return this.host}
getUrlOrigin(endpoint=''){endpoint=endpoint.split('/').filter(value=>value!='').join('/')
endpoint=endpoint.length>0?"/"+endpoint:''
this.urlOrigin=window.origin+endpoint
return this.urlOrigin}
getStringUrl(){this.stringUrl=window.location.origin+window.location.pathname
return this.stringUrl}
stringfyQueryStringData(object){const params=[];for(const key in object){if(object.hasOwnProperty(key)){const value=object[key];params.push(`${encodeURIComponent(key)}=${encodeURIComponent(value)}`)}}
return params.join('&')}
parseQueryStringData(){this.queryString=window.location.search
const params=new URLSearchParams(this.queryString);const queryObject={};for(const[key,value]of params){queryObject[key]=value}
return queryObject}
getCurrentEndpoint(){this.endpoint=window.location.pathname.split("/")
if(Array.isArray(this.endpoint)){this.endpoint=this.endpoint.filter((value)=>value!=""&&value!="framework-php"&&value!="braid")
this.endpoint=this.endpoint.length==0?'/':this.endpoint.join('/')
return this.endpoint}}}
const url=new Url();const validatePassword={'0':function(value,elem){if(value.length>=8){elem.firstChild.innerHTML="&#10004;"
elem.firstChild.classList.remove("cross")
elem.firstChild.classList.add("checkmark")}else{elem.firstChild.innerHTML="&#x2718;"
elem.firstChild.classList.remove("checkmark")
elem.firstChild.classList.add("cross")}},'1':function(value,elem){if(isCapitalize(value)){elem.firstChild.innerHTML="&#10004;"
elem.firstChild.classList.remove("cross")
elem.firstChild.classList.add("checkmark")}else{elem.firstChild.innerHTML="&#x2718;"
elem.firstChild.classList.remove("checkmark")
elem.firstChild.classList.add("cross")}},'2':function(value,elem){if(isNumeric(value)){elem.firstChild.innerHTML="&#10004;"
elem.firstChild.classList.remove("cross")
elem.firstChild.classList.add("checkmark")}else{elem.firstChild.innerHTML="&#x2718;"
elem.firstChild.classList.remove("checkmark")
elem.firstChild.classList.add("cross")}},'3':function(value,elem){if(isSpecialCharacter(value)){elem.firstChild.innerHTML="&#10004;"
elem.firstChild.classList.remove("cross")
elem.firstChild.classList.add("checkmark")}else{elem.firstChild.innerHTML="&#x2718;"
elem.firstChild.classList.remove("checkmark")
elem.firstChild.classList.add("cross")}}};if(url.getCurrentEndpoint()=="/"){function animateCounter(selector){const target=document.querySelector(selector)
let counter=parseInt(target.innerHTML)
let current=0;if(!target){throw new Error("invalid count element")}
const increment=counter/(2000/16);const interval=setInterval(()=>{current+=increment;const roundedCurrent=Math.round(current);document.querySelector(selector).innerHTML=roundedCurrent.toLocaleString("pt-BR");if(current>=counter){clearInterval(interval);document.querySelector(selector).innerHTML=counter.toLocaleString("pt-BR")}},50)}
window.addEventListener('load',function(){animateCounter(".freelancers-register span");animateCounter(".businessman-register span")})};const skipPopop=document.getElementById("skipPopop")
if(skipPopop){skipPopop.addEventListener('click',function(event){event.preventDefault()
this.parentElement.parentElement.style.display="none"
try{const form=new FormData()
form.append("cookie",JSON.parse(this.dataset.agree))
fetch(url.getStringUrl()+"cookies/set-cookie",{method:"POST",body:form}).then(data=>data.json()).then(function(response){console.log(response)})}catch(e){throw new Error(e)}})};if(url.getCurrentEndpoint()=="user/register"){const form=document.getElementById("registerForm")
const email=document.getElementById("email")
const password=document.getElementById("password")
const confirmPassword=document.getElementById("confirmPassword")
const conditions=document.querySelectorAll("#conditions li")
const eyeIconPassword=document.getElementById("eyeIconPassword")
const eyeIconConfirmPassword=document.getElementById("eyeIconConfirmPassword")
const photoImage=document.getElementById("photoImage")
const photoPreview=document.getElementById("photoPreview")
if(photoImage){photoImage.addEventListener('change',function(){const file=this.files[0];if(file){const imageUrl=URL.createObjectURL(file);photoPreview.firstElementChild.src=imageUrl;photoPreview.style.display='block'}else{photoPreview.style.display='none'}})}
if(eyeIconPassword){eyeIconPassword.addEventListener('click',function(){if(this.classList.contains("fa-eye-slash")){this.classList.remove("fa-eye-slash")
this.classList.add("fa-eye")
this.parentElement.firstElementChild.setAttribute('type','text')}else{this.classList.remove("fa-eye")
this.classList.add("fa-eye-slash")
this.parentElement.firstElementChild.setAttribute('type','password')}})}
if(eyeIconConfirmPassword){eyeIconConfirmPassword.addEventListener('click',function(){if(this.classList.contains("fa-eye-slash")){this.classList.remove("fa-eye-slash")
this.classList.add("fa-eye")
this.parentElement.firstElementChild.setAttribute('type','text')}else{this.classList.remove("fa-eye")
this.classList.add("fa-eye-slash")
this.parentElement.firstElementChild.setAttribute('type','password')}})}
const validateByColor={'true':'1px solid #63a69d','false':'1px solid #ff2c2c'}
const getPassword={password:''}
if(password){password.addEventListener('input',function(){const value=this.value
let color=validateByColor[isValidPassword(value)]
this.style.borderBottom=color
color=color.split(" ").pop()
this.nextElementSibling.style.color=color
conditions.forEach(function(elem,index){validatePassword[index](value,elem)})
getPassword.password=value})}
if(confirmPassword){confirmPassword.addEventListener('input',function(){if(this.value!=getPassword.password){this.nextElementSibling.style.color="#ff2c2c"
this.style.borderBottom='1px solid #ff2c2c'}else{this.nextElementSibling.style.color="#63a69d"
this.style.borderBottom='1px solid #63a69d'}})}
if(email){email.addEventListener('input',function(){let color=validateByColor[isValidEmail(this.value)]
this.style.borderBottom=color
color=color.split(" ").pop()
this.nextElementSibling.style.color=color})}
let endpoint={"localhost":"braid/framework-php/user/register","clientes.laborcode.com.br":"user/register","braid.com.br":"user/register","www.braid.com.br":"user/register",}
if(form){form.addEventListener('submit',function(e){e.preventDefault()
const inputs=Array.from(this.getElementsByTagName('input'))
inputs.forEach(function(elem){try{if(elem.dataset.required){const elementBoolean=JSON.parse(elem.dataset.required)
if(elementBoolean){if(elem.value==''){elem.style.borderBottom='1px solid #ff2c2c'
throw new Error(`empty data ${elem.name}`)}else{elem.style.borderBottom='1px solid #2196f3'}}}}catch(error){throw new Error(`Erro ao converter dataset em booleano: ${error}`)}})
if(!isValidPassword(this.password.value)){throw new Error("invalid password")}
if(!isValidEmail(this.email.value)){throw new Error("invalid email")}
if(this.confirmPassword.value!=this.password.value){throw new Error("invalid confirm password")}
this.lastElementChild.lastElementChild.style.display='none'
this.lastElementChild.firstElementChild.style.display='block'
const form=new FormData(this)
endpoint=endpoint[url.getHostName()]||''
fetch(url.getUrlOrigin(endpoint),{method:'POST',body:form}).then(data=>data.json()).then(function(data){const errorMessage=document.getElementById("errorMessage")
if(data.email_already_exists){errorMessage.style.display='block'
errorMessage.innerHTML="E-mail já cadastrado"
throw new Error("E-mail já cadastrado")}
if(data.register_success){window.location.href=data.url_login}})})}};if(url.getCurrentEndpoint()=="user/register"){const registerType=document.getElementById("registerType")
const form=document.getElementById("genericForms")
const launchGenericModal=document.getElementById("launchGenericModal")
const titleNewMembership=document.getElementById("titleNewMembership")
let type=registerType.dataset.register
let obs={generic:(elem)=>elem.click(),businessman:'Cadastre-se como empresa',designer:'Cadastre-se como designer'}
window.addEventListener('load',function(){obs=typeof obs[type]=='function'?obs[type](launchGenericModal):obs[type]
if(titleNewMembership){titleNewMembership.innerHTML=obs||''}})
if(form){form.addEventListener('submit',function(ev){ev.preventDefault()
let params=url.parseQueryStringData()
obs={changeParam:(params,option)=>{params.userType=option
return params}}
params=obs.changeParam(params,this.option.value)
params=url.stringfyQueryStringData(params)
window.location.href=url.getStringUrl()+"?"+params})}};if(url.getCurrentEndpoint()=="/"){function typeWrite(text){const arrayText=text.split('');document.querySelector('.background-home h1').innerHTML=' ';arrayText.forEach(function(letter,i){setTimeout(function(){document.querySelector('.background-home h1').innerHTML+=letter},75*i)})}
const texts=[{title:"Potencialize seus projetos com a nossa plataforma para designers freelancers!",},{title:"Encontre projetos com a nossa plataforma para designers freelancers!",}]
let currentIndex=0;const intervalTime=10000;typeWrite(texts[currentIndex].title);setInterval(()=>{currentIndex++;currentIndex=currentIndex>=texts.length?0:currentIndex
typeWrite(texts[currentIndex].title)},intervalTime)}