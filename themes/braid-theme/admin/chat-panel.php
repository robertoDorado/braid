<?php $v->layout("admin/_admin") ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card card-danger direct-chat direct-chat-danger">
                <div class="card-header ui-sortable-handle">
                    <h3 class="card-title"><?= $receiverName ?></h3>
                    <div class="card-tools">
                        <?php if (!empty($conversationData)) : ?>
                            <span data-toggle="tooltip" class="badge badge-light"><?= number_format(count($conversationData), 0, "", ".") . " Mensagens" ?></span>
                        <?php endif ?>
                        <button type="button" id="contactsTrigger" style="display:none" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                            <i class="fas fa-comments"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="direct-chat-messages">
                        <?php if (!empty($conversationData)) : ?>
                            <?php foreach ($conversationData as $conversation) : ?>
                                <?php if ($conversation->is_receiver) : ?>
                                    <div class="direct-chat-msg">
                                        <div class="direct-chat-infos clearfix">
                                            <span class="direct-chat-name float-left"><?= $conversation->full_name ?></span>
                                            <span class="direct-chat-timestamp float-right"><?= $conversation->date_time ?></span>
                                        </div>
                                        <img class="direct-chat-img" src="<?= empty($conversation->path_photo) ?
                                                                                theme("assets/img/user/default.png") :
                                                                                theme("assets/img/user/" . $conversation->path_photo . "") ?>" alt="message user image">
                                        <div class="direct-chat-text">
                                            <?= $conversation->content ?>
                                        </div>
                                    </div>
                                <?php elseif ($conversation->is_sender) : ?>
                                    <div class="direct-chat-msg right">
                                        <div class="direct-chat-infos clearfix">
                                            <span class="direct-chat-name float-right"><?= $conversation->full_name ?></span>
                                            <span class="direct-chat-timestamp float-left"><?= $conversation->date_time ?></span>
                                        </div>
                                        <img class="direct-chat-img" src="<?= empty($conversation->path_photo) ?
                                                                                theme("assets/img/user/default.png") :
                                                                                theme("assets/img/user/" . $conversation->path_photo . "") ?>" alt="message user image">
                                        <div class="direct-chat-text">
                                            <?= $conversation->content ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                    <div class="direct-chat-contacts">
                        <ul class="contacts-list">
                            <?php if (!empty($contactsData)) : ?>
                                <?php foreach ($contactsData as $contact) : ?>
                                    <li>
                                        <a href="#" class="btnOpenChat" data-csrf="<?= empty($csrfToken) ? "" : $csrfToken ?>" data-hash="<?= base64_encode($contact->full_email) ?>">
                                            <img class="contacts-list-img" src="<?= empty($contact->path_photo) ? 
                                                theme("assets/img/user/default.png") : 
                                                theme("assets/img/user/" . $contact->path_photo . "") ?>">
                                            <div class="contacts-list-info">
                                                <span class="contacts-list-name">
                                                    <?= $contact->full_name ?>
                                                    <small class="contacts-list-date float-right"><?= $contact->date_time ?></small>
                                                </span>
                                                <span class="contacts-list-msg"><?= $contact->content ?></span>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach ?>
                            <?php endif ?>
                        </ul>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="#" method="post" class="form-chat-panel">
                        <div class="input-group">
                            <input type="text" name="message" placeholder="Mensagem..." class="form-control">
                            <span class="input-group-append">
                                <button type="button" class="btn btn-primary">Enviar</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <button id="seeContacts" class="btn btn-danger">Ver os meus contatos</button>
</div>