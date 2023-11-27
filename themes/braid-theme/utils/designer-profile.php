<strong><i class="fas fa-book mr-1"></i> Descrição do perfil</strong>
<p class="text-muted">
    <?= empty($profileData->biography_data) ? "Não especificado" : $profileData->biography_data ?>
</p>
<hr>
<strong><i class="fa fa-bullseye mr-1"></i> Objetivos profissionais</strong>
<p class="text-muted">
    <?= empty($profileData->goals_data) ? "Não especificado" : $profileData->goals_data ?>
</p>
<hr>
<strong><i class="fas fa-pencil-alt mr-1"></i> Qualificações</strong>
<p class="text-muted">
    <?= empty($profileData->qualifications_data) ? "Não específicado" : $profileData->qualifications_data ?>
</p>
<hr>
<strong><i class="fas fa-pencil-alt mr-1"></i> Experiências anteriores</strong>
<p class="text-muted">
    <?= empty($profileData->experience_data) ? "Não específicado" : $profileData->experience_data ?>
</p>