<div class="form-group">
    <label for="documentData">CPF</label>
    <input type="text" name="documentData" value="<?= empty($personData->document_data) ? "" : $personData->document_data ?>" class="form-control" data-required="true" data-mask="cpf" data-error="CPF" id="documentData" placeholder="CPF">
</div>
<div class="form-group">
    <label for="biographyData">Descrição pessoal</label>
    <textarea type="text" name="biographyData" value="<?= empty($personData->biography_data) ? "" : $personData->biography_data ?>" class="form-control" data-required="true" data-error="Descrição pessoal" id="biographyData" placeholder="Descrição pessoal"><?= empty($personData->biography_data) ? "" : $personData->biography_data ?></textarea>
</div>
<div class="form-group">
    <label for="goalsData">Objetivos pessoais</label>
    <textarea type="text" name="goalsData" value="<?= empty($personData->goals_data) ? "" : $personData->goals_data ?>" class="form-control" data-required="true" data-error="Objetivos pessoais" id="goalsData" placeholder="Objetivos pessoais"><?= empty($personData->goals_data) ? "" : $personData->goals_data ?></textarea>
</div>
<div class="form-group">
    <label for="qualificationsData">Qualificações</label>
    <textarea type="text" name="qualificationsData" value="<?= empty($personData->qualifications_data) ? "" : $personData->qualifications_data ?>" class="form-control" data-required="true" data-error="Qualificações" id="qualificationsData" placeholder="Qualificações"><?= empty($personData->qualifications_data) ? "" : $personData->qualifications_data ?></textarea>
</div>
<div class="form-group">
    <label for="portfolioData">Portfólio</label>
    <textarea type="text" name="portfolioData" value="<?= empty($personData->portfolio_data) ? "" : $personData->portfolio_data ?>" class="form-control" data-required="true" data-error="Portfólio" id="portfolioData" placeholder="Portfólio"><?= empty($personData->portfolio_data) ? "" : $personData->portfolio_data ?></textarea>
</div>
<div class="form-group">
    <label for="experienceData">Experiência</label>
    <textarea type="text" name="experienceData" class="form-control" value="<?= empty($personData->experience_data) ? "" : $personData->experience_data ?>" data-required="true" data-error="Experiência" id="experienceData" placeholder="Experiência"><?= empty($personData->experience_data) ? "" : $personData->experience_data ?></textarea>
</div>
<div class="form-group">
    <label for="positionData">Profissão atual</label>
    <input type="text" name="positionData" value="<?= empty($personData->position_data) ? "" : $personData->position_data ?>" class="form-control" data-required="true" data-error="Profissão atual" id="positionData" placeholder="Profissão atual">
    <input type="hidden" class="form-control" name="csrfToken" value="<?= empty($csrfToken) ? "" : $csrfToken ?>" data-required="true" data-error="Token">
</div>