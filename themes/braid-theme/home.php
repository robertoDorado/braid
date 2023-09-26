<?php $v->layout("_theme") ?>

<!-- Header -->
<header class="w3-center background-home">
    <h1 class="w3-margin" class="first-title"></h1>
    <div class="container-btn">
        <a href="<?= url("user/register?userType=businessman") ?>" class="w3-button w3-black w3-padding-large w3-large w3-margin-top">Quero encontrar freelancers</a>
        <a href="<?= url("user/register?userType=designer") ?>" class="w3-button w3-padding-large w3-large w3-margin-top" style="background-color: #ff2c2c;">Sou um freelancer</a>
    </div>
</header>
<div class="call-to-action-1">
    <p>Ainda não tem uma conta? <a href="<?= url("user/register?userType=generic") ?>">Cadastre-se</a></p>
</div>

<section class="registers-view">
    <div class="freelancers-register">
        <span><?= $designerTotalData ?></span>
        <p>Freelancers cadastrados</p>
    </div>
    <div class="businessman-register">
        <span><?= $businessManTotalData ?></span>
        <p>Microempresas cadastrados</p>
    </div>
</section>

<section class="about-us" id="about-us">
    <div class="about-us-title">
        <h1>Como Funciona?</h1>
        <p>Microepresário: Anuncie a sua demanda facilmente, contrate freelancers e pague com segurança.</p>
        <p>Freelancer: Publique o seu currículo e o seu porfólio e se canditate a diversas vagas na plataforma.</p>
    </div>
    <div class="about-us-content">
        <div class="about-us-1">
            <i class="fa fa-file-o"></i>
            <h3>Publique uma vaga</h3>
            <p>Publique uma vaga e receba propostas de freelancers talentosos em minutos.</p>
        </div>
        <div class="about-us-2">
            <i class="fa fa-user-circle"></i>
            <h3>Contrate</h3>
            <p>Contrate com confiança: Avalie o histórico de trabalho,
                o feedback dos clientes e o portfólio para filtrar os candidatos.
                Em seguida, conduza uma entrevista através do chat e selecione o melhor.</p>
        </div>
        <div class="about-us-3">
            <i class="fa fa-credit-card"></i>
            <h3>Pagamento</h3>
            <p>Ao adquirir o nosso plano premium.
                Tenha acesso à nossa estrutura de contrato e chat para
                se comunicar com os freelancers com os quais deseja estabelecer vínculo.</p>
        </div>
    </div>
</section>

<section class="designers-type">
    <h2>Encontre profissionais talentosos para...</h2>
    <div class="grid">
        <div class="box-1 box">
            <p>Desenhar o seu <strong>website</strong></p>
        </div>
        <div class="box-2 box">
            <p>Desenhar o seu <strong>logotipo</strong></p>
        </div>
        <div class="box-3 box">
            <p>Criar o seu <strong>vídeo</strong></p>
        </div>
    </div>
    <div class="grid">
        <div class="box-4 box">
            <p>Criar o seu design de <strong>mídias</strong></p>
        </div>
        <div class="box-5 box">
            <p>Criar o seu design <strong>gráfico</strong></p>
        </div>
        <div class="box-6 box">
            <p>Criar o seu <strong>UX/UI</strong></p>
        </div>
    </div>
</section>

<section class="call-to-action">
    <h3 class="w3-margin w3-xlarge">Você está pronto para encontrar o freelancer ideal para o seu projeto?</h3>
    <a href="<?= url("user/register?userType=generic") ?>" class="w3-button w3-black w3-padding-large w3-large">Cadastre-se agora mesmo!</a>
</section>