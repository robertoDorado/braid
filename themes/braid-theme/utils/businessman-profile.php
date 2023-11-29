<strong><i class="fas fa-pencil-alt mr-1"></i> CNPJ</strong>
<p class="text-muted">
    <?= empty($profileData->register_number) ? "Não especificado" : $profileData->register_number ?>
</p>
<hr>
<strong><i class="fas fa-pencil-alt mr-1"></i> Descrições da empresa</strong>
<p class="text-muted">
    <?= empty($profileData->company_description) ? "Não específicado" : $profileData->company_description ?>
</p>
<hr>
<strong><i class="fas fa-pencil-alt mr-1"></i> Ramo da empresa</strong>
<p class="text-muted">
    <?= empty($profileData->branch_of_company) ? "Não específicado" : $profileData->branch_of_company ?>
</p>