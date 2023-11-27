<strong><i class="fas fa-book mr-1"></i> Nome da empresa</strong>
<p class="text-muted">
    <?= empty($profileData->biography_data) ? "Não especificado" : $profileData->company_name ?>
</p>
<hr>
<strong><i class="fa fa-bullseye mr-1"></i> Número do documento</strong>
<p class="text-muted">
    <?= empty($profileData->goals_data) ? "Não especificado" : $profileData->register_number ?>
</p>
<hr>
<strong><i class="fas fa-pencil-alt mr-1"></i> Descrições da empresa</strong>
<p class="text-muted">
    <?= empty($profileData->qualifications_data) ? "Não específicado" : $profileData->company_description ?>
</p>