function isValidEmail(value){return/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)}
function isValidPassword(value){return/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[@#$%^&+=!]).{8,}$/.test(value)}
function isCapitalize(value){return/[A-Z]/.test(value)}
function isNumeric(value){return/[\d]/.test(value)}
function isSpecialCharacter(value){return/[@#$%^&+=!]/.test(value)}
function validateRequiredFields(elem,errorMessage){if(elem.dataset.required){const elementBoolean=JSON.parse(elem.dataset.required)
if(elementBoolean){if(elem.value==''){errorMessage.style.display='block'
errorMessage.innerHTML=`Campo ${elem.dataset.error} não pode estar vazio`
elem.style.borderBottom='1px solid #ff2c2c'
throw new Error(`Campo ${elem.name} não pode estar vazio`)}else{elem.style.borderBottom='1px solid #2196f3'}}}};class Url{endpoint;queryString;stringUrl;urlOrigin;host;getHostName(){this.host=window.location.host
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
elem.firstChild.classList.add("cross")}}};if(url.getCurrentEndpoint()=="braid-system/client-report-form"){const remunerationData=document.getElementById("remunerationData")
const clientReportForm=document.getElementById("clientReportForm")
const errorMessage=document.getElementById("errorMessage")
const mask={money:function(value){value=value.replace(/\D/g,'')
value=parseFloat((value/100).toFixed(2))
value=value.toLocaleString('pt-BR',{style:'currency',currency:"BRL"})
return value}}
remunerationData.addEventListener("input",function(){this.value=mask[this.dataset.mask](this.value)})
clientReportForm.addEventListener("submit",function(event){event.preventDefault()
const inputs=Array.from(this.querySelectorAll(".form-control"))
inputs.forEach(function(elem){try{validateRequiredFields(elem,errorMessage)}catch(error){throw new Error(error.message)}})
const btnSubmit=this.getElementsByTagName("button")[0].lastElementChild
const loaderImage=this.getElementsByTagName("button")[0].firstElementChild
loaderImage.style.display='block'
btnSubmit.style.display='none'
let endpoint={"localhost":"/braid/braid-system/client-report-form","clientes.laborcode.com.br":"/braid/braid-system/client-report-form","braid.com.br":"/braid-system/client-report-form","www.braid.com.br":"/braid-system/client-report-form",}
endpoint=endpoint[url.getHostName()]||''
const form=new FormData(this)
const requestUrl=url.getUrlOrigin(endpoint)
fetch(requestUrl,{method:"POST",body:form}).then(data=>data.json()).then(function(data){if(data.invalid_datetime){throw new Error(data.msg)}
if(data.general_error){throw new Error(data.msg)}
if(data.success_create_job){window.location.href=data.url}}).catch(function(error){error=error.toString().replace("Error: ","")
btnSubmit.style.display='block'
loaderImage.style.display='none'
errorMessage.style.display='block'
errorMessage.innerHTML=error})})};if(url.getCurrentEndpoint()=="/"){function animateCounter(selector){const target=document.querySelector(selector)
let counter=parseInt(target.innerHTML)
let current=0;if(!target){throw new Error("invalid count element")}
const increment=counter/(2000/16);const interval=setInterval(()=>{current+=increment;const roundedCurrent=Math.round(current);document.querySelector(selector).innerHTML=roundedCurrent.toLocaleString("pt-BR");if(current>=counter){clearInterval(interval);document.querySelector(selector).innerHTML=counter.toLocaleString("pt-BR")}},50)}
window.addEventListener('load',function(){animateCounter(".freelancers-register span");animateCounter(".businessman-register span")})};if(url.getCurrentEndpoint()=="braid-system"){const formAlterProfile=document.getElementById("formAlterProfile")
const errorMessage=document.getElementById("errorMessage")
const photoImage=document.getElementById("photoImage")
const photoPreview=document.getElementById("photoPreview")
photoImage.addEventListener('change',function(){const file=this.files[0];if(file){const imageUrl=URL.createObjectURL(file);photoPreview.firstElementChild.src=imageUrl;photoPreview.style.display='block'}else{photoPreview.style.display='none'}})
formAlterProfile.addEventListener("submit",function(event){event.preventDefault()
const inputs=Array.from(this.getElementsByTagName("input"))
inputs.forEach(function(elem){try{validateRequiredFields(elem,errorMessage)}catch(error){throw new Error(error.message)}})
const userName=this.userName.value.trim().split(" ")
if(userName.length>1){errorMessage.style.display='block'
errorMessage.innerHTML=`Campo ${this.userName.dataset.error} não pode ter espaço em branco`
throw new Error(`invalid ${this.userName.name}`)}
const loaderImage=this.getElementsByTagName("button")[0].firstElementChild
const btnSubmit=this.getElementsByTagName("button")[0].lastElementChild
loaderImage.style.display='block'
btnSubmit.style.display='none'
let endpoint={"localhost":"/braid/braid-system","clientes.laborcode.com.br":"/braid/braid-system","braid.com.br":"/braid-system","www.braid.com.br":"/braid-system",}
endpoint=endpoint[url.getHostName()]||''
const form=new FormData(this)
const requestUrl=url.getUrlOrigin(endpoint)
fetch(requestUrl,{method:"POST",body:form}).then(data=>data.json()).then(function(data){if(data.invalid_image){throw new Error(data.msg)}
if(data.general_error){throw new Error(data.msg)}
if(data.update_success){window.location.href=window.location.href}}).catch(function(error){error=error.toString().replace("Error: ","")
btnSubmit.style.display='block'
loaderImage.style.display='none'
errorMessage.style.display='block'
errorMessage.innerHTML=error})})};if(/braid-system/.test(url.getCurrentEndpoint())){const exit=document.getElementById("exit")
exit.addEventListener('click',function(event){event.preventDefault()
let endpoint={"localhost":"/braid/braid-system/exit","clientes.laborcode.com.br":"/braid/braid-system/exit","braid.com.br":"/braid-system/exit","www.braid.com.br":"/braid-system/exit",}
endpoint=endpoint[url.getHostName()]||''
const requestUrl=url.getUrlOrigin(endpoint)
fetch(requestUrl,{method:"POST",body:JSON.stringify({action:"logout"}),headers:{"Content-Type":"application/json"}}).then(data=>data.json()).then(function(data){if(!data.logout_success){throw new Error("Erro geral ao tentar sair do sistema.")}
if(data.logout_success){window.location.href=data.url}}).catch(function(error){console.error(error.toString())})})};if(url.getCurrentEndpoint()=='user/login'){const form=document.getElementById("loginForm")
const eyeIconPassword=document.querySelector("[eye-icon='eyeIconPassword']")
const errorMessage=document.getElementById("errorMessage")
if(eyeIconPassword){eyeIconPassword.addEventListener('click',function(){if(this.classList.contains("fa-eye-slash")){this.classList.remove("fa-eye-slash")
this.classList.add("fa-eye")
this.parentElement.firstElementChild.setAttribute('type','text')}else{this.classList.remove("fa-eye")
this.classList.add("fa-eye-slash")
this.parentElement.firstElementChild.setAttribute('type','password')}})}
form.addEventListener('submit',function(event){event.preventDefault()
const inputs=Array.from(this.getElementsByTagName("input"))
inputs.forEach(function(elem){try{validateRequiredFields(elem,errorMessage)}catch(error){throw new Error(error.message)}})
if(!isValidPassword(this.password.value)){errorMessage.style.display='block'
errorMessage.innerHTML=`Campo ${this.password.dataset.error} inválido`
this.password.style.borderBottom='1px solid #ff2c2c'
throw new Error(`invalid ${this.password.name}`)}
const loaderImage=this.getElementsByTagName("button")[0].firstElementChild
const btnSubmitLogin=this.getElementsByTagName("button")[0].lastElementChild
loaderImage.style.display='block'
btnSubmitLogin.style.display='none'
let endpoint={"localhost":"/braid/user/login","clientes.laborcode.com.br":"/braid/user/login","braid.com.br":"/user/login","www.braid.com.br":"/user/login",}
endpoint=endpoint[url.getHostName()]||''
const form=new FormData(this)
const requestUrl=url.getUrlOrigin(endpoint)
fetch(requestUrl,{method:'POST',body:form}).then(data=>data.json()).then(function(data){if(data.invalid_email){throw new Error(data.msg)}
if(data.invalid_password){throw new Error(data.msg)}
if(data.access_denied){throw new Error(data.msg)}
if(data.success_login){if(errorMessage.style.display=='block'){errorMessage.style.display='none'}
window.location.href=data.url}}).catch(function(error){error=error.toString().replace("Error: ","")
btnSubmitLogin.style.display='block'
loaderImage.style.display='none'
errorMessage.style.display='block'
errorMessage.innerHTML=error})})};const skipPopop=document.getElementById("skipPopop")
if(skipPopop){skipPopop.addEventListener('click',function(event){event.preventDefault()
this.parentElement.parentElement.style.display="none"
try{const form=new FormData()
form.append("cookie",JSON.parse(this.dataset.agree))
let endpoint={"localhost":"/braid/cookies/set-cookie","clientes.laborcode.com.br":"/braid/cookies/set-cookie","braid.com.br":"/cookies/set-cookie","www.braid.com.br":"/cookies/set-cookie",}
endpoint=endpoint[url.getHostName()]||''
fetch(url.getUrlOrigin(endpoint),{method:"POST",body:form})}catch(e){throw new Error(e)}})};if(url.getCurrentEndpoint()=="user/recover-password-form"){const formRecoverPassword=document.getElementById("formRecoverPassword")
const errorMessage=document.getElementById("errorMessage")
const eyeIconPassword=document.querySelector("[eye-icon='eyeIconPassword']")
const eyeIconConfirmPassword=document.querySelector("[eye-icon='eyeIconConfirmPassword']")
if(eyeIconConfirmPassword){eyeIconConfirmPassword.addEventListener('click',function(){if(this.classList.contains("fa-eye-slash")){this.classList.remove("fa-eye-slash")
this.classList.add("fa-eye")
this.parentElement.firstElementChild.setAttribute('type','text')}else{this.classList.remove("fa-eye")
this.classList.add("fa-eye-slash")
this.parentElement.firstElementChild.setAttribute('type','password')}})}
if(eyeIconPassword){eyeIconPassword.addEventListener('click',function(){if(this.classList.contains("fa-eye-slash")){this.classList.remove("fa-eye-slash")
this.classList.add("fa-eye")
this.parentElement.firstElementChild.setAttribute('type','text')}else{this.classList.remove("fa-eye")
this.classList.add("fa-eye-slash")
this.parentElement.firstElementChild.setAttribute('type','password')}})}
formRecoverPassword.addEventListener('submit',function(event){event.preventDefault()
const inputs=Array.from(this.getElementsByTagName("input"))
inputs.forEach(function(elem){try{validateRequiredFields(elem,errorMessage)}catch(error){throw new Error(error.message)}})
if(!isValidPassword(this.password.value)){errorMessage.style.display='block'
errorMessage.innerHTML=`Campo ${this.password.dataset.error} inválido`
this.password.style.borderBottom='1px solid #ff2c2c'
throw new Error(`invalid ${this.password.name}`)}
if(!isValidPassword(this.confirmPassword.value)){errorMessage.style.display='block'
errorMessage.innerHTML=`Campo ${this.confirmPassword.dataset.error} inválido`
this.confirmPassword.style.borderBottom='1px solid #ff2c2c'
throw new Error(`invalid ${this.confirmPassword.name}`)}
const loaderImage=this.getElementsByTagName("button")[0].firstElementChild
const btnSubmit=this.getElementsByTagName("button")[0].lastElementChild
loaderImage.style.display='block'
btnSubmit.style.display='none'
let endpoint={"localhost":"/braid/user/recover-password-form","clientes.laborcode.com.br":"/braid/user/recover-password-form","braid.com.br":"/user/recover-password-form","www.braid.com.br":"/user/recover-password-form",}
endpoint=endpoint[url.getHostName()]||''
const form=new FormData(this)
const requestUrl=url.getUrlOrigin(endpoint)
fetch(requestUrl,{method:'POST',body:form}).then(data=>data.json()).then(function(data){if(data.invalid_passwords_value){throw new Error(data.msg)}
if(data.expired_link){window.location.href=data.url}
if(data.general_error){throw new Error(data.msg)}
if(data.invalid_password_value){throw new Error(data.msg)}
if(data.success_password_change){if(errorMessage.style.display=='block'){errorMessage.style.display='none'}
window.location.href=data.url}}).catch(function(error){error=error.toString().replace("Error: ","")
btnSubmit.style.display='block'
loaderImage.style.display='none'
errorMessage.style.display='block'
errorMessage.innerHTML=error})})};if(url.getCurrentEndpoint()=="user/recover-password"){const recoverPassword=document.getElementById("recoverPassword")
const errorMessage=document.getElementById("errorMessage")
recoverPassword.addEventListener("submit",function(event){event.preventDefault()
if(!isValidEmail(this.userEmail.value)){errorMessage.style.display='block'
errorMessage.innerHTML=`Campo ${this.userEmail.dataset.error} inválido`
this.userEmail.style.borderBottom='1px solid #ff2c2c'
throw new Error(`invalid ${this.userEmail.name}`)}
let endpoint={"localhost":"/braid/user/recover-password","clientes.laborcode.com.br":"/braid/user/recover-password","braid.com.br":"/user/recover-password","www.braid.com.br":"/user/recover-password",}
const loaderImage=this.getElementsByTagName("button")[0].firstElementChild
const btnSubmit=this.getElementsByTagName("button")[0].lastElementChild
loaderImage.style.display='block'
btnSubmit.style.display='none'
endpoint=endpoint[url.getHostName()]||''
const form=new FormData(this)
const requestUrl=url.getUrlOrigin(endpoint)
fetch(requestUrl,{method:"POST",body:form}).then(data=>data.json()).then(function(data){if(data.email_does_not_exist){throw new Error(data.msg)}
if(data.invalid_email_value){throw new Error(data.msg)}
if(data.invalid_recover_password_data){throw new Error(data.msg)}
if(data.recover_success){if(errorMessage.style.display=='block'){errorMessage.style.display='none'}
window.location.href=data.url}}).catch(function(error){error=error.toString().replace("Error: ","")
btnSubmit.style.display='block'
loaderImage.style.display='none'
errorMessage.style.display='block'
errorMessage.innerHTML=error})})};if(url.getCurrentEndpoint()=="user/register"){const form=document.getElementById("registerForm")
const email=document.getElementById("email")
const password=document.getElementById("password")
const confirmPassword=document.getElementById("confirmPassword")
const conditions=document.querySelectorAll("#conditions li")
const eyeIconPassword=document.querySelector("[eye-icon='eyeIconPassword']")
const eyeIconConfirmPassword=document.querySelector("[eye-icon='eyeIconConfirmPassword']")
const photoImage=document.getElementById("photoImage")
const photoPreview=document.getElementById("photoPreview")
const errorMessage=document.getElementById("errorMessage")
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
if(form){form.addEventListener('submit',function(e){e.preventDefault()
const inputs=Array.from(this.getElementsByTagName('input'))
inputs.forEach(function(elem){try{validateRequiredFields(elem,errorMessage)}catch(error){throw new Error(error.message)}})
const userName=this.userName.value.trim().split(" ")
if(userName.length>1){errorMessage.style.display='block'
errorMessage.innerHTML=`Campo ${this.userName.dataset.error} não pode ter espaço em branco`
throw new Error(`invalid ${this.userName.name}`)}
if(!isValidEmail(this.email.value)){errorMessage.style.display='block'
errorMessage.innerHTML=`Campo ${this.email.dataset.error} inválido`
this.email.style.borderBottom='1px solid #ff2c2c'
throw new Error(`invalid ${this.email.name}`)}
if(!isValidPassword(this.password.value)){errorMessage.style.display='block'
errorMessage.innerHTML=`Campo ${this.password.dataset.error} inválido`
this.password.style.borderBottom='1px solid #ff2c2c'
throw new Error(`invalid ${this.password.name}`)}
if(this.confirmPassword.value!=this.password.value){errorMessage.style.display='block'
errorMessage.innerHTML=`Campo ${this.confirmPassword.dataset.error} inválido`
this.confirmPassword.style.borderBottom='1px solid #ff2c2c'
throw new Error(`invalid ${this.confirmPassword.name}`)}
const btnSubmit=this.lastElementChild.lastElementChild
const loaderImage=this.lastElementChild.firstElementChild
btnSubmit.style.display='none'
loaderImage.style.display='block'
let endpoint={"localhost":"/braid/user/register","clientes.laborcode.com.br":"/braid/user/register","braid.com.br":"/user/register","www.braid.com.br":"/user/register",}
const form=new FormData(this)
endpoint=endpoint[url.getHostName()]||''
const requestUrl=url.getUrlOrigin(endpoint)
fetch(requestUrl,{method:'POST',body:form}).then(data=>data.json()).then(function(data){if(data.email_already_exists){throw new Error(data.msg)}
if(data.nickname_already_exists){throw new Error(data.msg)}
if(data.general_error){throw new Error(data.msg)}
if(data.invalid_image){throw new Error(data.msg)}
if(data.register_success){if(errorMessage.style.display=='block'){errorMessage.style.display='none'}
setTimeout(()=>{window.location.href=data.url_login},1000)}}).catch(function(error){error=error.toString().replace("Error: ","")
btnSubmit.style.display='block'
loaderImage.style.display='none'
errorMessage.style.display='block'
errorMessage.innerHTML=error})})}};if(url.getCurrentEndpoint()=="user/register"){const registerType=document.getElementById("registerType")
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