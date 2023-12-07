<?php
if (!empty(session()->login_user->receiverUser) && !empty(session()->login_user->user)) {
    $conversation = new \Source\Domain\Model\Conversation();
    $conversationData = $conversation->getConversationAndMessages([session()->login_user->user->getId(), session()->login_user->receiverUser->getId()]);
}
?>
<?php if (!preg_match("/braid-system\/chat-panel/", server()["REQUEST_URI"])) : ?>
    <div style="<?= empty(session()->login_user->isChatClosed) ? "display:block" : "display:none" ?>" class="card card-danger direct-chat direct-chat-danger chat-box" id="chatBox" data-csrf="<?= session()->csrf_token ?>">
        <div class="card-header">
            <h3 class="card-title"><?= empty(session()->login_user->success) ? "Chat" : session()->login_user->receiverName ?></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" id="contactsTrigger" style="display:none" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                    <i class="fas fa-comments"></i>
                </button>
                <button type="button" id="btnRemoveChat" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="direct-chat-messages">
                <?php if (!empty($conversationData)) : ?>
                    <?php foreach ($conversationData as $conversation) : ?>
                        <?php if (session()->login_user->user->getId() == $conversation->receiver_id) : ?>
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
                        <?php elseif (session()->login_user->user->getId() == $conversation->sender_id) : ?>
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
                    <!-- <li>
                                        <a href="#">
                                            <img class="contacts-list-img" src="#">
                                            <div class="contacts-list-info">
                                                <span class="contacts-list-name">
                                                    Count Dracula
                                                    <small class="contacts-list-date float-right">2/28/2015</small>
                                                </span>
                                                <span class="contacts-list-msg">How have you been? I was...</span>
                                            </div>
                                        </a>
                                    </li> -->
                </ul>
            </div>
        </div>
        <div class="card-footer">
            <form action="#" method="post" id="formChatBox" data-receiver="<?= empty(session()->login_user->paramProfileData) ? "" : session()->login_user->paramProfileData ?>">
                <div class="input-group">
                    <input type="text" name="messageData" placeholder="Mensagem..." class="form-control">
                    <input type="hidden" name="csrfToken" value="<?= empty(session()->csrf_token) ? "" : session()->csrf_token ?>">
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
<?php endif ?>