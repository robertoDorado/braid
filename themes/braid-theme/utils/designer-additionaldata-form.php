<div class="form-group">
    <label for="documentData">CPF ou RG</label>
    <input type="text" name="documentData" class="form-control" data-required="true" data-error="CPF ou RG" id="documentData" placeholder="CPF ou RG">
</div>
<div class="form-group">
    <label for="biographyData">Descrição pessoal</label>
    <textarea type="text" name="biographyData" class="form-control" data-required="true" data-error="Descrição pessoal" id="biographyData" placeholder="Descrição pessoal"></textarea>
</div>
<div class="form-group">
    <label for="experienceData">Objetivos pessoais</label>
    <textarea type="text" name="goalsData" class="form-control" data-required="true" data-error="Objetivos pessoais" id="goalsData" placeholder="Objetivos pessoais"></textarea>
</div>
<div class="form-group">
    <label for="qualificationsData">Qualificações</label>
    <textarea type="text" name="qualificationsData" class="form-control" data-required="true" data-error="Qualificações" id="qualificationsData" placeholder="Qualificações"></textarea>
</div>
<div class="form-group">
    <label for="portfolioData">Portfólio</label>
    <textarea type="text" name="portfolioData" class="form-control" data-required="true" data-error="Portfólio" id="portfolioData" placeholder="Portfólio"></textarea>
</div>
<div class="form-group">
    <label for="experienceData">Experiência</label>
    <textarea type="text" name="experienceData" class="form-control" data-required="true" data-error="Experiência" id="experienceData" placeholder="Experiência"></textarea>
</div>
<div class="form-group">
    <label for="positionData">Profissão atual</label>
    <textarea type="text" name="positionData" class="form-control" data-required="true" data-error="Profissão atual" id="positionData" placeholder="Profissão atual"></textarea>
    <input type="hidden" class="form-control" name="csrfToken" value="<?= empty($csrfToken) ? "" : $csrfToken ?>" data-required="true" data-error="Token">
</div>