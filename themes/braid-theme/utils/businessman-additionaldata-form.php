<div class="form-group">
    <label for="companyName">Nome da empresa</label>
    <input type="text" name="companyName" value="<?= empty($personData->company_name) ? "" : $personData->company_name ?>" class="form-control" data-required="true" data-error="Nome da empresa" id="companyName" placeholder="Nome da empresa">
</div>
<div class="form-group">
    <label for="registerNumber">CNPJ</label>
    <input type="text" name="registerNumber" value="<?= empty($personData->register_number) ? "" : $personData->register_number ?>" class="form-control" data-mask="cnpj" data-required="true" data-error="CNPJ" id="registerNumber" placeholder="CNPJ">
</div>
<div class="form-group">
    <label for="companyDescription">Descrição da empresa</label>
    <textarea type="text" name="companyDescription" value="<?= empty($personData->company_description) ? "" : $personData->company_description ?>" class="form-control" data-required="true" data-error="Descrição da empresa" id="companyDescription" placeholder="Descrição da empresa"><?= empty($personData->company_description) ? "" : $personData->company_description ?></textarea>
</div>
<div class="form-group">
    <label for="branchOfCompany">Ramo da empresa</label>
    <input type="text" name="branchOfCompany" value="<?= empty($personData->branch_of_company) ? "" : $personData->branch_of_company ?>" class="form-control" data-required="true" data-error="Ramo da empresa" id="branchOfCompany" placeholder="Ramo da empresa">
    <input type="hidden" class="form-control" name="csrfToken" value="<?= empty($csrfToken) ? "" : $csrfToken ?>" data-required="true" data-error="Token">
</div>