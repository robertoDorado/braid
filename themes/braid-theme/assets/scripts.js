function formatDate(stringDate){const date=new Date(stringDate);let day=date.getDate();let month=date.getMonth()+1;let year=date.getFullYear();let hour=date.getHours();let minute=date.getMinutes();if(day<10)day="0"+day;if(month<10)month="0"+month;if(hour<10)hour="0"+hour;if(minute<10)minute="0"+minute;return{day,month,year,hour,minute}}
function isValidEmail(value){return/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)}
function isValidPassword(value){return/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[@#$%^&+=!]).{8,}$/.test(value)}
function isCapitalize(value){return/[A-Z]/.test(value)}
function isNumeric(value){return/[\d]/.test(value)}
function isSpecialCharacter(value){return/[@#$%^&+=!]/.test(value)}
function validateRequiredFields(elem,errorMessage){if(elem.dataset.required){const elementBoolean=JSON.parse(elem.dataset.required)
if(elementBoolean){if(elem.value==''){errorMessage.style.display='block'
errorMessage.innerHTML=`Campo ${elem.dataset.error} não pode estar vazio`
elem.style.borderBottom='1px solid #ff2c2c'
throw new Error(`Campo ${elem.name} não pode estar vazio`)}else{elem.style.borderBottom='1px solid #2196f3'}}}}
function createNewElement(elementName){const element=document.createElement(elementName)
return element}
function setAttributesToElement(attributeName,attributeValue,element){element.setAttribute(attributeName,attributeValue)}
function removeParamFromEndpoint(endpoint,getEndpointParam=!1){endpoint=endpoint.split("/")
if(!getEndpointParam){endpoint.pop()
return endpoint.join("/")}else{return endpoint}}
function isBase64(str){try{const decodedString=atob(str);const base64String=btoa(decodedString);return base64String===str}catch(error){return!1}};class Url{endpoint;queryString;stringUrl;urlOrigin;host;getHostName(){this.host=window.location.host
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
elem.firstChild.classList.add("cross")}}};if(url.getCurrentEndpoint()=="braid-system/additional-data"){const additionalDataForm=document.getElementById("additionalDataForm")
const documentData=document.getElementById("documentData")
const registerNumber=document.getElementById("registerNumber")
const errorMessage=document.getElementById("errorMessage")
const mask={cpf:function(value){value=value.replace(/\D/g,'').replace(/(\d{3})(\d)/,"$1.$2").replace(/(\d{3})(\d)/,"$1.$2").replace(/(\d{3})(\d)/,"$1-$2")
return value.slice(0,14)},cnpj:function(value){value=value.replace(/\D/g,'').replace(/(\d{2})(\d)/,"$1.$2").replace(/(\d{3})(\d)/,"$1.$2").replace(/(\d{3})(\d)/,"$1/$2").replace(/(\d{4})(\d)/,"$1-$2")
return value.slice(0,18)}}
documentData?.addEventListener("input",function(){this.value=mask[this.dataset.mask](this.value)})
registerNumber?.addEventListener("input",function(){this.value=mask[this.dataset.mask](this.value)})
additionalDataForm.addEventListener("submit",function(event){event.preventDefault()
const inputs=Array.from(this.querySelectorAll(".form-control"))
inputs.forEach(function(elem){try{validateRequiredFields(elem,errorMessage)}catch(error){throw new Error(error.message)}})
if(this.documentData){if(!/^(\d{3})\.(\d{3})\.(\d{3})-(\d{2})$/.test(this.documentData.value)){errorMessage.style.display='block'
errorMessage.innerHTML="Valor do cpf inválido"
throw new Error("Valor do cpf inválido")}}
const btnSubmit=this.getElementsByTagName("button")[0].lastElementChild
const loaderImage=this.getElementsByTagName("button")[0].firstElementChild
loaderImage.style.display='block'
btnSubmit.style.display='none'
let endpoint={"localhost":"/braid/braid-system/token","clientes.laborcode.com.br":"/braid/braid-system/token","braid.com.br":"/braid-system/token","www.braid.com.br":"/braid-system/token",}
endpoint=endpoint[url.getHostName()]||''
let requestUrl=url.getUrlOrigin(endpoint)
const form=new FormData(this)
fetch(requestUrl).then(response=>response.json()).then(function(response){if(!response.tokenData){throw new Error("requisição inválida")}
endpoint={"localhost":"/braid/braid-system/additional-data","clientes.laborcode.com.br":"/braid/braid-system/additional-data","braid.com.br":"/braid-system/additional-data","www.braid.com.br":"/braid-system/additional-data",}
endpoint=endpoint[url.getHostName()]||''
requestUrl=url.getUrlOrigin(endpoint)
fetch(requestUrl,{method:"POST",body:form,headers:{Authorization:"Bearer "+response.tokenData}}).then(response=>response.json()).then(function(response){if(response.invalid_length){throw new Error(response.msg)}
if(response.invalid_document){throw new Error(response.msg)}
if(response.success){errorMessage.style.display='none'
setTimeout(()=>{window.location.href=response.url},2000)}}).catch(function(error){error=error.toString().replace("Error: ","")
btnSubmit.style.display='block'
loaderImage.style.display='none'
errorMessage.style.display='block'
errorMessage.innerHTML=error})})})};const endpointSystem=removeParamFromEndpoint(url.getCurrentEndpoint(),!0)
const endpointParam=endpointSystem.pop()
if(endpointSystem.join("/")=="braid-system/edit-project"){const clientReportFormEdit=document.getElementById("clientReportFormEdit")
const remunerationData=document.getElementById("remunerationData")
const errorMessage=document.getElementById("errorMessage")
const mask={money:function(value){value=value.replace(/\D/g,'')
value=parseFloat((value/100).toFixed(2))
value=value.toLocaleString('pt-BR',{style:'currency',currency:"BRL"})
return value}}
remunerationData.addEventListener("input",function(){this.value=mask[this.dataset.mask](this.value)})
clientReportFormEdit.addEventListener("submit",function(event){event.preventDefault()
const inputs=Array.from(this.querySelectorAll(".form-control"))
inputs.forEach(function(elem){try{validateRequiredFields(elem,errorMessage)}catch(error){throw new Error(error.message)}})
const btnSubmit=this.getElementsByTagName("button")[0].lastElementChild
const loaderImage=this.getElementsByTagName("button")[0].firstElementChild
loaderImage.style.display='block'
btnSubmit.style.display='none'
let endpoint={"localhost":"/braid/braid-system/edit-project","clientes.laborcode.com.br":"/braid/braid-system/edit-project","braid.com.br":"/braid-system/edit-project","www.braid.com.br":"/braid-system/edit-project",}
endpoint=endpoint[url.getHostName()]||''
const form=new FormData(this)
const requestUrl=url.getUrlOrigin(endpoint)
fetch(requestUrl,{method:"POST",headers:{Authorization:"Bearer "+endpointParam},body:form}).then(data=>data.json()).then(function(data){if(data.invalid_datetime){throw new Error(data.msg)}
if(data.general_error){throw new Error(data.msg)}
if(data.invalid_length_description_field){throw new Error(data.msg)}
if(data.invalid_length_job_name_field){throw new Error(data.msg)}
if(data.invalid_remuneration_data){throw new Error(data.msg)}
if(data.success_update_job){window.location.href=data.url}}).catch(function(error){error=error.toString().replace("Error: ","")
btnSubmit.style.display='block'
loaderImage.style.display='none'
errorMessage.style.display='block'
errorMessage.innerHTML=error})})};if(url.getCurrentEndpoint()=="braid-system/client-report-form"){const remunerationData=document.getElementById("remunerationData")
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
if(data.invalid_length_description_field){throw new Error(data.msg)}
if(data.invalid_length_job_name_field){throw new Error(data.msg)}
if(data.invalid_remuneration_data){throw new Error(data.msg)}
if(data.success_create_job){window.location.href=data.url}}).catch(function(error){error=error.toString().replace("Error: ","")
btnSubmit.style.display='block'
loaderImage.style.display='none'
errorMessage.style.display='block'
errorMessage.innerHTML=error})})};const endpointSystemForm=removeParamFromEndpoint(url.getCurrentEndpoint(),!0)
const endpointParamForm=endpointSystemForm.pop()
let elementCreated=!1
if(endpointSystemForm.join("/")=="braid-system/project-detail"){const makeProposal=document.getElementById("makeProposal")
let endpoint={"localhost":"/braid/themes/braid-theme/assets/img/loading.gif","clientes.laborcode.com.br":"/braid/themes/braid-theme/assets/img/loading.gif","braid.com.br":"/themes/braid-theme/assets/img/loading.gif","www.braid.com.br":"/themes/braid-theme/assets/img/loading.gif",}
endpoint=endpoint[url.getHostName()]||''
const urlLoader=url.getUrlOrigin(endpoint)
const containerProjectDescription=document.getElementById("containerProjectDescription")
const row=createNewElement("div")
const col=createNewElement("div")
const h3=createNewElement("h3")
const contractForm=createNewElement("form")
const cardBody=createNewElement("div")
const cardPrimary=createNewElement("div")
const cardHeader=createNewElement("div")
const formGroup=createNewElement("div")
const label=createNewElement("label")
const textArea=createNewElement("textarea")
const csrfToken=createNewElement("input")
const cardFooter=createNewElement("div")
const buttonSubmit=createNewElement("button")
const img=createNewElement("img")
const span=createNewElement("span")
const alertMessage=createNewElement("div")
row.style.marginTop=".9rem"
label.innerHTML="Faça uma proposta para este projeto"
contractForm.id="contractForm"
buttonSubmit.type="submit"
textArea.type="text"
textArea.name="additionalDescription"
textArea.dataset.required=!0
textArea.dataset.error="Descrições adicionais"
textArea.id="additionalDescription"
csrfToken.name="csrfToken"
csrfToken.type="hidden"
csrfToken.dataset.required=!0
csrfToken.dataset.error="Token"
csrfToken.id="csrfToken"
img.style.width="20px"
img.style.display="none"
img.style.margin="0 auto"
img.src=urlLoader
img.alt="loader"
h3.innerHTML="Fazer uma proposta"
span.innerHTML="Enviar proposta"
alertMessage.style.textAlign="center"
alertMessage.style.display="none"
alertMessage.id="alertMessage"
setAttributesToElement("class","row",row)
setAttributesToElement("class","col",col)
setAttributesToElement("class","card card-primary",cardPrimary)
setAttributesToElement("class","card-header bg-danger",cardHeader)
setAttributesToElement("class","card-title",h3)
setAttributesToElement("class","card-body",cardBody)
setAttributesToElement("class","form-group",formGroup)
setAttributesToElement("for","additionalDescription",label)
setAttributesToElement("class","form-control",textArea)
setAttributesToElement("placeholder","Descrições sobre a proposta",textArea)
setAttributesToElement("class","card-footer",cardFooter)
setAttributesToElement("class","btn bg-danger",buttonSubmit)
setAttributesToElement("class","alert alert-danger",alertMessage)
setAttributesToElement("class","form-control",csrfToken)
endpoint={"localhost":"/braid/braid-system/project-detail","clientes.laborcode.com.br":"/braid/braid-system/project-detail","braid.com.br":"/braid-system/project-detail","www.braid.com.br":"/braid-system/project-detail",}
endpoint=endpoint[url.getHostName()]||''
const projectDetailUrl=url.getUrlOrigin(endpoint)
if(makeProposal){makeProposal.addEventListener("click",function(event){event.preventDefault()
if(!elementCreated){containerProjectDescription.appendChild(row)
row.appendChild(col)
col.appendChild(cardPrimary)
cardPrimary.append(cardHeader,contractForm)
cardHeader.appendChild(h3)
contractForm.append(cardBody,cardFooter,alertMessage)
cardBody.appendChild(formGroup)
formGroup.append(label,textArea,csrfToken)
cardFooter.appendChild(buttonSubmit)
buttonSubmit.append(img,span)
window.scrollTo(0,document.body.scrollHeight);fetch(projectDetailUrl,{method:"POST",body:JSON.stringify({request_csrf_token:!0})}).then(data=>data.json()).then(function(data){csrfToken.value=data.csrf_token})
elementCreated=!0}})}
contractForm.addEventListener("submit",function(event){event.preventDefault()
const inputs=Array.from(this.querySelectorAll(".form-control"))
inputs.forEach(function(elem){validateRequiredFields(elem,alertMessage)})
const form=new FormData(this)
form.append("jobId",atob(endpointParamForm))
span.style.display='none'
img.style.display='block'
fetch(projectDetailUrl,{method:"POST",body:form}).then(data=>data.json()).then(function(data){if(data.invalid_job_id){throw new Error(data.msg)}
if(data.contract_success){alertMessage.classList.remove("alert-danger")
alertMessage.classList.add("alert-success")
alertMessage.innerHTML="Candidatura realizada com sucesso"
alertMessage.style.display='block'
setTimeout(()=>{window.location.href=data.url},2000)}}).catch(function(error){error=error.toString().replace("Error: ","")
span.style.display='block'
img.style.display='none'
alertMessage.style.display='block'
alertMessage.innerHTML=error})})};if(url.getCurrentEndpoint()=="/"){function animateCounter(selector){const target=document.querySelector(selector)
let counter=parseInt(target.innerHTML)
let current=0;if(!target){throw new Error("invalid count element")}
const increment=counter/(2000/16);const interval=setInterval(()=>{current+=increment;const roundedCurrent=Math.round(current);document.querySelector(selector).innerHTML=roundedCurrent.toLocaleString("pt-BR");if(current>=counter){clearInterval(interval);document.querySelector(selector).innerHTML=counter.toLocaleString("pt-BR")}},50)}
window.addEventListener('load',function(){animateCounter(".freelancers-register span");animateCounter(".businessman-register span")})};if(url.getCurrentEndpoint()=="braid-system/client-report"){const deleteProject=Array.from(document.querySelectorAll(".delete-project"))
const launchSureDeleteModal=document.getElementById("launchSureDeleteModal")
const calloutModalDeleteProject=document.getElementById("calloutModalDeleteProject")
const deleteBtnModal=document.getElementById("deleteBtnModal")
deleteProject.forEach(function(elem){elem.addEventListener("click",function(event){event.preventDefault()
launchSureDeleteModal.click()
const projectElement=this.parentElement.parentElement.parentElement
const dataProject=Array.from(projectElement.children)
const hashId=this.dataset.hash
if(calloutModalDeleteProject){const modalDataProject=Array.from(calloutModalDeleteProject.children)
console.log(dataProject)
modalDataProject[0].innerHTML=dataProject[0].innerHTML
modalDataProject[1].innerHTML=dataProject[1].innerHTML
modalDataProject[2].innerHTML=dataProject[2].innerHTML
modalDataProject[3].innerHTML=dataProject[3].innerHTML}
let enpointDeleteProject={"localhost":"/braid/braid-system/delete-project","clientes.laborcode.com.br":"/braid/braid-system/delete-project","braid.com.br":"/braid-system/delete-project","www.braid.com.br":"/braid-system/delete-project",}
enpointDeleteProject=enpointDeleteProject[url.getHostName()]||''
const requestUrlDeleteProject=url.getUrlOrigin(enpointDeleteProject)
deleteBtnModal.addEventListener("click",function(){const hideModal=this.previousElementSibling
fetch(requestUrlDeleteProject,{method:"POST",headers:{Authorization:"Bearer "+hashId}}).then(response=>response.json()).then(function(response){if(response.success_delete_project){projectElement.parentElement.style.display="none"
hideModal.click()}})})})})};if(url.getCurrentEndpoint()=="braid-system"){const formAlterProfile=document.getElementById("formAlterProfile")
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
errorMessage.innerHTML=error})})};const endpointProfileData=removeParamFromEndpoint(url.getCurrentEndpoint(),!0)
const paramProfileData=endpointProfileData.pop()
if(endpointProfileData.join("/")=="braid-system/profile-data"){const evaluationProfileForm=document.getElementById("evaluationProfile")
const containerEvaluation=document.getElementById("containerEvaluation")
const containerCandidates=document.getElementById("containerCandidates")
if(evaluationProfileForm){evaluationProfileForm.addEventListener("submit",function(event){event.preventDefault()
const submitBtn=this.getElementsByTagName("button")[0]
const loaderImg=submitBtn.firstElementChild
const spanBtn=submitBtn.lastElementChild
loaderImg.style.display="block"
spanBtn.style.display="none"
if(this.evaluateDescription.value==""){this.evaluateDescription.style.borderColor="#ff0000"
loaderImg.style.display="none"
spanBtn.style.display="block"
throw new Error("Descrição da avaliação é obrigatório")}else{this.evaluateDescription.style.borderColor="#ced4da"}
if(this.evaluateDescription.value.length>1000){this.evaluateDescription.style.borderColor="#ff0000"
loaderImg.style.display="none"
spanBtn.style.display="block"
throw new Error("Descrição da avaliação é obrigatório")}else{this.evaluateDescription.style.borderColor="#ced4da"}
if(this.fb.value>5){throw new Error("Avaliação de estrelas não pode ser acima de 5")}
let endpoint={"localhost":"/braid/braid-system/profile-data","clientes.laborcode.com.br":"/braid/braid-system/profile-data","braid.com.br":"/braid-system/profile-data","www.braid.com.br":"/braid-system/profile-data",}
endpoint=endpoint[url.getHostName()]||''
const requestUrl=url.getUrlOrigin(endpoint)
const form=new FormData(this)
fetch(requestUrl,{method:"POST",body:form,headers:{Authorization:"Bearer "+paramProfileData}}).then(data=>data.json()).then(function(data){if(data.success){this.evaluateDescription.value=""
loaderImg.style.display="none"
spanBtn.style.display="block"
const containerDesigner=createNewElement("div")
const descriptionDataDesigner=createNewElement("div")
const stars=createNewElement("div")
const evaluateDescription=createNewElement("p")
evaluateDescription.innerHTML=data.evaluation_description
const inputEmpty=createNewElement("input")
const inputOne=createNewElement("input")
const inputTwo=createNewElement("input")
const inputThree=createNewElement("input")
const inputFour=createNewElement("input")
const inputFive=createNewElement("input")
const ratingInputs=[inputEmpty,inputOne,inputTwo,inputThree,inputFour,inputFive]
for(let i=0;i<6;i++){ratingInputs[i].type="radio"
ratingInputs[i].value=i>0?i:""
if(i>0){ratingInputs[i].checked=data.rating==i}
if(data.rating==0&&ratingInputs[i].value==""){ratingInputs[i].checked=data.rating==i}}
const labelOne=createNewElement("label")
const labelTwo=createNewElement("label")
const labelThree=createNewElement("label")
const labelFour=createNewElement("label")
const labelFive=createNewElement("label")
setAttributesToElement("class","callout callout-danger container-designer",containerDesigner)
setAttributesToElement("class","description-data-designer",descriptionDataDesigner)
setAttributesToElement("class","stars",stars)
const ratingLabels=[labelOne,labelTwo,labelThree,labelFour,labelFive]
for(let i=0;i<5;i++){if(i>0){ratingLabels[i].style.marginLeft=".3rem"}
const icon=createNewElement("i")
setAttributesToElement("class","fa",icon)
ratingLabels[i].appendChild(icon)}
stars.append(inputEmpty,labelOne,inputOne,labelTwo,inputTwo,labelThree,inputThree,labelFour,inputFour,labelFive,inputFive)
descriptionDataDesigner.appendChild(stars)
descriptionDataDesigner.appendChild(evaluateDescription)
containerDesigner.appendChild(descriptionDataDesigner)
if(containerEvaluation.children){if(containerEvaluation.children.length>=3){containerEvaluation.removeChild(containerEvaluation.lastElementChild)}
containerEvaluation.insertBefore(containerDesigner,containerEvaluation.firstElementChild)}else{containerEvaluation.appendChild(containerDesigner)}
const alertThaksForEvaluation=createNewElement("div")
setAttributesToElement("class","alert alert-success",alertThaksForEvaluation)
alertThaksForEvaluation.innerHTML="Obrigado por avaliar este perfil"
containerCandidates.innerHTML=""
containerCandidates.appendChild(alertThaksForEvaluation)}})})}};if(/braid-system/.test(url.getCurrentEndpoint())){const exit=document.getElementById("exit")
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
let endpoint={"localhost":"/braid/user/token","clientes.laborcode.com.br":"/braid/user/token","braid.com.br":"/user/token","www.braid.com.br":"/user/token",}
endpoint=endpoint[url.getHostName()]||''
let requestUrl=url.getUrlOrigin(endpoint)
const bodyData=JSON.stringify({username:this.userName.value,password:this.password.value})
fetch(requestUrl,{method:"POST",body:bodyData})
endpoint={"localhost":"/braid/user/login","clientes.laborcode.com.br":"/braid/user/login","braid.com.br":"/user/login","www.braid.com.br":"/user/login",}
endpoint=endpoint[url.getHostName()]||''
const form=new FormData(this)
requestUrl=url.getUrlOrigin(endpoint)
fetch(requestUrl,{method:'POST',body:form}).then(data=>data.json()).then(function(data){if(data.invalid_email){throw new Error(data.msg)}
if(data.invalid_password){throw new Error(data.msg)}
if(data.access_denied){throw new Error(data.msg)}
if(data.success_login){if(errorMessage.style.display=='block'){errorMessage.style.display='none'}
window.location.href=data.url}}).catch(function(error){error=error.toString().replace("Error: ","")
btnSubmitLogin.style.display='block'
loaderImage.style.display='none'
errorMessage.style.display='block'
errorMessage.innerHTML=error})})};const response=removeParamFromEndpoint(url.getCurrentEndpoint(),!0)
const endpointParamValue=response.pop()
const endpointData=response.join("/")
if(endpointData=="braid-system/project-detail"){const loadCandidates=document.getElementById("loadCandidates")
const containerCandidates=document.getElementById("containerCandidates")
let page=1
const limit=3
if(loadCandidates){loadCandidates.addEventListener("click",function(event){event.preventDefault()
const loaderBtn=this
const imgLoader=this.firstElementChild
const btnLoader=this.lastElementChild
imgLoader.style.display="block"
btnLoader.style.display="none"
page++
let endpoint={"localhost":"/braid/braid-system/token","clientes.laborcode.com.br":"/braid/braid-system/token","braid.com.br":"/braid-system/token","www.braid.com.br":"/braid-system/token",}
endpoint=endpoint[url.getHostName()]||''
let requestUrl=url.getUrlOrigin(endpoint)
fetch(requestUrl).then(response=>response.json()).then(function(response){if(!response.tokenData){throw new Error("Erro ao retornar o token do usuário")}
response.page=page
response.max=limit
response.job_id=atob(endpointParamValue)
endpoint={"localhost":"/braid/braid-system/charge-on-demand-candidates","clientes.laborcode.com.br":"/braid/braid-system/charge-on-demand-candidates","braid.com.br":"/braid-system/charge-on-demand-candidates","www.braid.com.br":"/braid-system/charge-on-demand-candidates",}
endpoint=endpoint[url.getHostName()]||''
requestUrl=url.getUrlOrigin(endpoint)
const stringBase64=btoa(JSON.stringify(response))
fetch(requestUrl+"/"+stringBase64,{method:"GET",headers:{Authorization:"Bearer "+response.tokenData}}).then(response=>response.json()).then(function(response){imgLoader.style.display="none"
btnLoader.style.display="block"
const totalJobsObject=response.pop()
const paginate=Math.ceil(totalJobsObject.total_contracts/limit)
if(paginate==page){loaderBtn.style.display="none"}
response=Array.from(response)
response.forEach(function(item){endpoint={"localhost":"/braid/themes/braid-theme/assets/img/user","clientes.laborcode.com.br":"/braid/themes/braid-theme/assets/img/user","braid.com.br":"/themes/braid-theme/assets/img/user","www.braid.com.br":"/themes/braid-theme/assets/img/user",}
endpoint=endpoint[url.getHostName()]||''
requestUrl=url.getUrlOrigin(endpoint)
const containerDesigner=createNewElement("div")
const designerData=createNewElement("div")
const photoDesigner=createNewElement("img")
const freelancerName=createNewElement("p")
const descriptionDataDesigner=createNewElement("div")
const descriptionData=createNewElement("p")
const btnSeeProfileCandidate=createNewElement("a")
let endpointProfileData={"localhost":"/braid/braid-system/profile-data","clientes.laborcode.com.br":"/braid/braid-system/profile-data","braid.com.br":"/braid-system/profile-data","www.braid.com.br":"/braid-system/profile-data",}
endpointProfileData=endpointProfileData[url.getHostName()]||''
const requestUrlProfileData=url.getUrlOrigin(endpointProfileData)
containerDesigner.dataset.hash=btoa(item.designer_id)
btnSeeProfileCandidate.innerHTML="Ver perfil do candidato"
btnSeeProfileCandidate.href=requestUrlProfileData+"/"+btoa(item.designer_id)
if(item.path_photo==null){photoDesigner.src=requestUrl+"/default.png"
photoDesigner.alt="default.png"}else{photoDesigner.src=requestUrl+"/"+item.path_photo
photoDesigner.alt=item.path_photo}
freelancerName.innerHTML=item.full_name
descriptionData.innerHTML=item.additional_description
setAttributesToElement("class","callout callout-danger container-designer",containerDesigner)
setAttributesToElement("class","designer-data",designerData)
setAttributesToElement("class","photo-designer",photoDesigner)
setAttributesToElement("class","description-data-designer",descriptionDataDesigner)
setAttributesToElement("class","btn btn-primary see-profile",btnSeeProfileCandidate)
descriptionDataDesigner.appendChild(descriptionData)
descriptionDataDesigner.appendChild(btnSeeProfileCandidate)
designerData.append(photoDesigner,freelancerName)
containerDesigner.append(designerData,descriptionDataDesigner)
containerCandidates.appendChild(containerDesigner)})})})})}};const endpointEvaluationCharging=removeParamFromEndpoint(url.getCurrentEndpoint(),!0)
const hashEndpoint=endpointEvaluationCharging.pop()
if(endpointEvaluationCharging.join("/")=="braid-system/profile-data"||url.getCurrentEndpoint()=="braid-system/my-profile"){const sectionDataHash=document.querySelector(".content")
const paramEvaluationCharging=isBase64(hashEndpoint)?hashEndpoint:sectionDataHash.dataset.hash
const loadEvaluate=document.getElementById("loadEvaluate")
let page=1
const limit=3
if(loadEvaluate){loadEvaluate.addEventListener("click",function(event){event.preventDefault()
const loaderButton=this
const loaderImage=this.firstElementChild
const loaderLabel=this.lastElementChild
loaderLabel.style.display="none"
loaderImage.style.display="block"
page++;let endpoint={"localhost":"/braid/braid-system/token","clientes.laborcode.com.br":"/braid/braid-system/token","braid.com.br":"/braid-system/token","www.braid.com.br":"/braid-system/token",}
endpoint=endpoint[url.getHostName()]||''
let requestUrl=url.getUrlOrigin(endpoint)
fetch(requestUrl).then(response=>response.json()).then(function(response){if(!response.tokenData){throw new Error("Erro ao retornar o token do usuário")}
response.page=page
response.max=limit
response.profile_id=atob(paramEvaluationCharging)
endpoint={"localhost":"/braid/braid-system/charge-on-demand-evaluation","clientes.laborcode.com.br":"/braid/braid-system/charge-on-demand-evaluation","braid.com.br":"/braid-system/charge-on-demand-evaluation","www.braid.com.br":"/braid-system/charge-on-demand-evaluation",}
endpoint=endpoint[url.getHostName()]||''
requestUrl=url.getUrlOrigin(endpoint)
const stringBase64=btoa(JSON.stringify(response))
fetch(requestUrl+"/"+stringBase64,{method:"GET",headers:{Authorization:"Bearer "+response.tokenData}}).then(response=>response.json()).then(function(response){const containerEvaluation=document.getElementById("containerEvaluation")
loaderImage.style.display="none"
loaderLabel.style.display="block"
const totalEvaluation=response.pop()
const paginate=Math.ceil(totalEvaluation.total_evaluation/limit)
if(paginate==page){loaderButton.style.display="none"}
response=Array.from(response)
response.forEach(function(data){const containerDesigner=createNewElement("div")
const descriptionDataDesigner=createNewElement("div")
const stars=createNewElement("div")
const evaluateDescription=createNewElement("p")
evaluateDescription.innerHTML=data.evaluation_description
const inputEmpty=createNewElement("input")
const inputOne=createNewElement("input")
const inputTwo=createNewElement("input")
const inputThree=createNewElement("input")
const inputFour=createNewElement("input")
const inputFive=createNewElement("input")
const ratingInputs=[inputEmpty,inputOne,inputTwo,inputThree,inputFour,inputFive]
for(let i=0;i<6;i++){ratingInputs[i].type="radio"
ratingInputs[i].value=i>0?i:""
if(i>0){ratingInputs[i].checked=data.rating_data==i}
if(data.rating_data==0&&ratingInputs[i].value==""){ratingInputs[i].checked=data.rating_data==i}}
const labelOne=createNewElement("label")
const labelTwo=createNewElement("label")
const labelThree=createNewElement("label")
const labelFour=createNewElement("label")
const labelFive=createNewElement("label")
setAttributesToElement("class","callout callout-danger container-designer",containerDesigner)
setAttributesToElement("class","description-data-designer",descriptionDataDesigner)
setAttributesToElement("class","stars",stars)
const ratingLabels=[labelOne,labelTwo,labelThree,labelFour,labelFive]
for(let i=0;i<5;i++){if(i>0){ratingLabels[i].style.marginLeft=".3rem"}
const icon=createNewElement("i")
setAttributesToElement("class","fa",icon)
ratingLabels[i].appendChild(icon)}
stars.append(inputEmpty,labelOne,inputOne,labelTwo,inputTwo,labelThree,inputThree,labelFour,inputFour,labelFive,inputFive)
descriptionDataDesigner.appendChild(stars)
descriptionDataDesigner.appendChild(evaluateDescription)
containerDesigner.appendChild(descriptionDataDesigner)
containerEvaluation.appendChild(containerDesigner)})})})})}};if(url.getCurrentEndpoint()=="braid-system/client-report"){const deleteBtnModal=document.getElementById("deleteBtnModal")
const launchSureDeleteModal=document.getElementById("launchSureDeleteModal")
const calloutModalDeleteProject=document.getElementById("calloutModalDeleteProject")
const loadNewProjects=document.getElementById("loadNewProjects")
const rows=Array.from(document.querySelectorAll(".row"))
const cardBody=document.getElementById("cardBody")
const userType=cardBody.dataset.user
let page=1
const limit=3
if(loadNewProjects){loadNewProjects.addEventListener("click",function(event){event.preventDefault()
const loaderButton=this
const loaderImage=this.firstElementChild
const loaderLabel=this.lastElementChild
loaderImage.style.display="block"
loaderLabel.style.display="none"
page++;let endpoint={"localhost":"/braid/braid-system/token","clientes.laborcode.com.br":"/braid/braid-system/token","braid.com.br":"/braid-system/token","www.braid.com.br":"/braid-system/token",}
endpoint=endpoint[url.getHostName()]||''
let requestUrl=url.getUrlOrigin(endpoint)
fetch(requestUrl).then(response=>response.json()).then(function(response){if(!response.tokenData){throw new Error("Erro ao retornar o token do usuário")}
response.page=page
response.max=limit
endpoint={"localhost":"/braid/braid-system/charge-on-demand","clientes.laborcode.com.br":"/braid/braid-system/charge-on-demand","braid.com.br":"/braid-system/charge-on-demand","www.braid.com.br":"/braid-system/charge-on-demand",}
endpoint=endpoint[url.getHostName()]||''
requestUrl=url.getUrlOrigin(endpoint)
const stringBase64=btoa(JSON.stringify(response))
fetch(requestUrl+"/"+stringBase64,{method:"GET",headers:{Authorization:"Bearer "+response.tokenData}}).then(response=>response.json()).then(function(response){loaderImage.style.display="none"
loaderLabel.style.display="block"
const wrapElement=rows[2].firstElementChild
let endpointEditProject={"localhost":"/braid/braid-system/edit-project","clientes.laborcode.com.br":"/braid/braid-system/edit-project","braid.com.br":"/braid-system/edit-project","www.braid.com.br":"/braid-system/edit-project",}
endpointEditProject=endpointEditProject[url.getHostName()]||''
const requestUrlEditProject=url.getUrlOrigin(endpointEditProject)
let enpointDeleteProject={"localhost":"/braid/braid-system/delete-project","clientes.laborcode.com.br":"/braid/braid-system/delete-project","braid.com.br":"/braid-system/delete-project","www.braid.com.br":"/braid-system/delete-project",}
enpointDeleteProject=enpointDeleteProject[url.getHostName()]||''
const requestUrlDeleteProject=url.getUrlOrigin(enpointDeleteProject)
const totalJobsObject=response.pop()
const paginate=Math.ceil(totalJobsObject.total_jobs/limit)
if(paginate==page){loaderButton.style.display="none"}
response=Array.from(response)
response.forEach(function(item){const cardBodyElement=createNewElement("div")
setAttributesToElement("class","card-body",cardBodyElement)
setAttributesToElement("data-hash",btoa(item.id),cardBodyElement)
const callOutInfoElement=createNewElement("div")
setAttributesToElement("class","callout callout-info",callOutInfoElement)
const titleProject=createNewElement("h5")
const descriptionProject=createNewElement("p")
const projectValue=createNewElement("p")
const projectDeliveryTime=createNewElement("p")
const viewProject=createNewElement("a")
const tooltipCandidatesFreelancer=createNewElement("div")
const faIconUser=createNewElement("i")
const totalCandidates=createNewElement("span")
const containerFooterCallout=createNewElement("div")
const buttonsCalloutProjects=createNewElement("div")
const editLink=createNewElement("a")
const deleteLink=createNewElement("a")
editLink.innerHTML="Editar dados do projeto"
deleteLink.innerHTML="Excluir projeto"
deleteLink.style.marginLeft=".2rem"
viewProject.style.marginLeft=".2rem"
setAttributesToElement("class","tooltip-candidates-freelancer",tooltipCandidatesFreelancer)
setAttributesToElement("class","fa-solid fa-user",faIconUser)
setAttributesToElement("class","total-candidates",totalCandidates)
setAttributesToElement("class","container-footer-callout",containerFooterCallout)
setAttributesToElement("class","buttons-callout-projects",buttonsCalloutProjects)
setAttributesToElement("href",`${requestUrlEditProject}/${btoa(item.id)}`,editLink)
setAttributesToElement("href","#",deleteLink)
setAttributesToElement("class","btn btn-primary sample-format-link",editLink)
setAttributesToElement("class","btn btn-danger sample-format-link delete-project",deleteLink)
totalCandidates.innerHTML=item.total_candidates
tooltipCandidatesFreelancer.append(faIconUser,totalCandidates)
let endpointViewProject={"localhost":`/braid/braid-system/project-detail/${btoa(item.id)}`,"clientes.laborcode.com.br":`/braid/braid-system/project-detail/${btoa(item.id)}`,"braid.com.br":`/braid-system/project-detail/${btoa(item.id)}`,"www.braid.com.br":`/braid-system/project-detail/${btoa(item.id)}`,}
endpointViewProject=endpointViewProject[url.getHostName()]||''
const requestUrlViewProject=url.getUrlOrigin(endpointViewProject)
setAttributesToElement("href",requestUrlViewProject,viewProject)
setAttributesToElement("class","btn btn-primary project-detail",viewProject)
wrapElement.appendChild(cardBodyElement)
cardBodyElement.appendChild(callOutInfoElement)
const date=formatDate(item.delivery_time)
const valueCurrencyFormat=parseFloat(item.remuneration_data).toLocaleString("pt-BR",{style:"currency",currency:"BRL"})
titleProject.innerHTML=item.job_name
descriptionProject.innerHTML=item.job_description
projectValue.innerHTML=`Valor do acordo: ${valueCurrencyFormat}`
viewProject.innerHTML="Ver detalhes do projeto"
projectDeliveryTime.innerHTML=`Prazo de entrega: 
                            ${date.day}/${date.month}/${date.year} ${date.hour}:${date.minute}`
if(userType=="businessman"){buttonsCalloutProjects.append(editLink,viewProject,deleteLink)}else{buttonsCalloutProjects.appendChild(viewProject)}
containerFooterCallout.append(buttonsCalloutProjects,tooltipCandidatesFreelancer)
if(deleteLink){deleteLink.addEventListener("click",function(event){event.preventDefault()
launchSureDeleteModal.click()
const dataProject=Array.from(this.parentElement.parentElement.parentElement.children)
setAttributesToElement("data-hash",btoa(item.id),deleteBtnModal)
if(calloutModalDeleteProject){const modalDataProject=Array.from(calloutModalDeleteProject.children)
modalDataProject[0].innerHTML=dataProject[0].innerHTML
modalDataProject[1].innerHTML=dataProject[1].innerHTML
modalDataProject[2].innerHTML=dataProject[2].innerHTML
modalDataProject[3].innerHTML=dataProject[3].innerHTML}})}
callOutInfoElement.append(titleProject,descriptionProject,projectValue,projectDeliveryTime,containerFooterCallout)})
deleteBtnModal.addEventListener("click",function(){const hideModalBtn=this.previousElementSibling
fetch(requestUrlDeleteProject,{method:"POST",headers:{Authorization:"Bearer "+this.dataset.hash}}).then(response=>response.json()).then(function(response){if(response.success_delete_project){let allDataProject=Array.from(document.querySelectorAll(".card-body"))
allDataProject=allDataProject.filter((elem)=>elem.dataset.hash!=null)
allDataProject.forEach(function(elem){const projectId=atob(elem.dataset.hash)
if(!/^\d+$/.test(projectId)){throw new Error("Data hash inválido")}
if(response.id==projectId){elem.style.display="none"
hideModalBtn.click()}})}})})})})})}};const skipPopop=document.getElementById("skipPopop")
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
window.location.href=url.getStringUrl()+"?"+params})}};if(url.getCurrentEndpoint()=="braid-system/client-report"){const deleteBtnModal=document.getElementById("deleteBtnModal")
const launchSureDeleteModal=document.getElementById("launchSureDeleteModal")
const calloutModalDeleteProject=document.getElementById("calloutModalDeleteProject")
const formSearchProject=document.getElementById("formSearchProject")
const rows=Array.from(document.querySelectorAll(".row"))
const cardBody=document.getElementById("cardBody")
const userType=cardBody.dataset.user
formSearchProject.addEventListener("submit",function(event){event.preventDefault()
const fieldSearch=this.getElementsByTagName("input")[0]
const formAction=formSearchProject.action.replace("#","")
const urlRequest=new URL(formAction)
urlRequest.searchParams.set(fieldSearch.name,fieldSearch.value)
window.history.replaceState({},document.title,urlRequest.href)
const querySetringParams=new URLSearchParams(urlRequest.search)
if(querySetringParams.get("searchProject")){let endpoint={"localhost":"/braid/braid-system/token","clientes.laborcode.com.br":"/braid/braid-system/token","braid.com.br":"/braid-system/token","www.braid.com.br":"/braid-system/token",}
endpoint=endpoint[url.getHostName()]||''
let requestUrl=url.getUrlOrigin(endpoint)
fetch(requestUrl).then(response=>response.json()).then(function(response){endpoint={"localhost":"/braid/braid-system/search-project","clientes.laborcode.com.br":"/braid/braid-system/search-project","braid.com.br":"/braid-system/search-project","www.braid.com.br":"/braid-system/search-project",}
endpoint=endpoint[url.getHostName()]||''
requestUrl=url.getUrlOrigin(endpoint)
fetch(requestUrl+urlRequest.search,{method:"GET",headers:{Authorization:"Bearer "+response.tokenData}}).then(response=>response.json()).then(function(response){const wrapElement=rows[2].firstElementChild
wrapElement.innerHTML=""
let endpointEditProject={"localhost":"/braid/braid-system/edit-project","clientes.laborcode.com.br":"/braid/braid-system/edit-project","braid.com.br":"/braid-system/edit-project","www.braid.com.br":"/braid-system/edit-project",}
endpointEditProject=endpointEditProject[url.getHostName()]||''
const requestUrlEditProject=url.getUrlOrigin(endpointEditProject)
let enpointDeleteProject={"localhost":"/braid/braid-system/delete-project","clientes.laborcode.com.br":"/braid/braid-system/delete-project","braid.com.br":"/braid-system/delete-project","www.braid.com.br":"/braid-system/delete-project",}
enpointDeleteProject=enpointDeleteProject[url.getHostName()]||''
const requestUrlDeleteProject=url.getUrlOrigin(enpointDeleteProject)
const data=Array.from(response)
data.forEach(function(item){const cardBodyElement=createNewElement("div")
setAttributesToElement("class","card-body",cardBodyElement)
setAttributesToElement("data-hash",btoa(item.id),cardBodyElement)
const callOutInfoElement=createNewElement("div")
setAttributesToElement("class","callout callout-info",callOutInfoElement)
const titleProject=createNewElement("h5")
const descriptionProject=createNewElement("p")
const projectValue=createNewElement("p")
const projectDeliveryTime=createNewElement("p")
const viewProject=createNewElement("a")
const tooltipCandidatesFreelancer=createNewElement("div")
const faIconUser=createNewElement("i")
const totalCandidates=createNewElement("span")
const containerFooterCallout=createNewElement("div")
const buttonsCalloutProjects=createNewElement("div")
const editLink=createNewElement("a")
const deleteLink=createNewElement("a")
editLink.innerHTML="Editar dados do projeto"
deleteLink.innerHTML="Excluir projeto"
deleteLink.style.marginLeft=".2rem"
viewProject.style.marginLeft=".2rem"
let endpointViewProject={"localhost":`/braid/braid-system/project-detail/${btoa(item.id)}`,"clientes.laborcode.com.br":`/braid/braid-system/project-detail/${btoa(item.id)}`,"braid.com.br":`/braid-system/project-detail/${btoa(item.id)}`,"www.braid.com.br":`/braid-system/project-detail/${btoa(item.id)}`,}
endpointViewProject=endpointViewProject[url.getHostName()]||''
const requestUrlViewProject=url.getUrlOrigin(endpointViewProject)
setAttributesToElement("href",requestUrlViewProject,viewProject)
setAttributesToElement("class","btn btn-primary project-detail",viewProject)
setAttributesToElement("class","tooltip-candidates-freelancer",tooltipCandidatesFreelancer)
setAttributesToElement("class","fa-solid fa-user",faIconUser)
setAttributesToElement("class","total-candidates",totalCandidates)
setAttributesToElement("class","container-footer-callout",containerFooterCallout)
setAttributesToElement("class","buttons-callout-projects",buttonsCalloutProjects)
setAttributesToElement("href",`${requestUrlEditProject}/${btoa(item.id)}`,editLink)
setAttributesToElement("href","#",deleteLink)
setAttributesToElement("class","btn btn-primary sample-format-link",editLink)
setAttributesToElement("class","btn btn-danger sample-format-link delete-project",deleteLink)
totalCandidates.innerHTML=item.total_candidates
tooltipCandidatesFreelancer.append(faIconUser,totalCandidates)
wrapElement.appendChild(cardBodyElement)
cardBodyElement.appendChild(callOutInfoElement)
const date=formatDate(item.delivery_time)
const valueCurrencyFormat=parseFloat(item.remuneration_data).toLocaleString("pt-BR",{style:"currency",currency:"BRL"})
titleProject.innerHTML=item.job_name
descriptionProject.innerHTML=item.job_description
projectValue.innerHTML=`Valor do acordo: ${valueCurrencyFormat}`
viewProject.innerHTML="Ver detalhes do projeto"
projectDeliveryTime.innerHTML=`Prazo de entrega: 
                        ${date.day}/${date.month}/${date.year} ${date.hour}:${date.minute}`
if(userType=="businessman"){buttonsCalloutProjects.append(editLink,viewProject,deleteLink)}else{buttonsCalloutProjects.appendChild(viewProject)}
containerFooterCallout.append(buttonsCalloutProjects,tooltipCandidatesFreelancer)
if(deleteLink){deleteLink.addEventListener("click",function(event){event.preventDefault()
launchSureDeleteModal.click()
const dataProject=Array.from(this.parentElement.parentElement.parentElement.children)
setAttributesToElement("data-hash",btoa(item.id),deleteBtnModal)
if(calloutModalDeleteProject){const modalDataProject=Array.from(calloutModalDeleteProject.children)
modalDataProject[0].innerHTML=dataProject[0].innerHTML
modalDataProject[1].innerHTML=dataProject[1].innerHTML
modalDataProject[2].innerHTML=dataProject[2].innerHTML
modalDataProject[3].innerHTML=dataProject[3].innerHTML}})}
callOutInfoElement.append(titleProject,descriptionProject,projectValue,projectDeliveryTime,containerFooterCallout)})
deleteBtnModal.addEventListener("click",function(){const hideModalBtn=this.previousElementSibling
fetch(requestUrlDeleteProject,{method:"POST",headers:{Authorization:"Bearer "+this.dataset.hash}}).then(response=>response.json()).then(function(response){if(response.success_delete_project){let allDataProject=Array.from(document.querySelectorAll(".card-body"))
allDataProject=allDataProject.filter((elem)=>elem.dataset.hash!=null)
allDataProject.forEach(function(elem){const projectId=atob(elem.dataset.hash)
if(!/^\d+$/.test(projectId)){throw new Error("Data hash inválido")}
if(response.id==projectId){elem.style.display="none"
hideModalBtn.click()}})}})})
if(response.empty_request){const messageContainer=rows[2].firstElementChild
const messageWrap=createNewElement("div")
setAttributesToElement("class","warning-empty-registers",messageWrap)
messageContainer.appendChild(messageWrap)
const message=createNewElement("p")
message.style.padding="1rem 0"
messageWrap.appendChild(message)
message.innerHTML=response.msg
rows[3].style.display="none"}})})}})};if(url.getCurrentEndpoint()=="/"){function typeWrite(text){const arrayText=text.split('');document.querySelector('.background-home h1').innerHTML=' ';arrayText.forEach(function(letter,i){setTimeout(function(){document.querySelector('.background-home h1').innerHTML+=letter},75*i)})}
const texts=[{title:"Potencialize seus projetos com a nossa plataforma para designers freelancers!",},{title:"Encontre projetos com a nossa plataforma para designers freelancers!",}]
let currentIndex=0;const intervalTime=10000;typeWrite(texts[currentIndex].title);setInterval(()=>{currentIndex++;currentIndex=currentIndex>=texts.length?0:currentIndex
typeWrite(texts[currentIndex].title)},intervalTime)}