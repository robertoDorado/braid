<?php

namespace Source\Domain\Model;

use Source\Models\Contact as ModelsContact;

/**
 * Contact Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class Contact
{
    /** @var User Usuário que possui os contatos */
    private User $user;

    /** @var Conversation Contato do usuário */
    private Conversation $conversation;

    /** @var ModelsContact Objeto de persistência */
    private ModelsContact $contact;

    public function setModelContact(Contact $obj)
    {
        $getters = checkGettersFilled($obj);
        $isMethods = checkIsMethodsFilled($obj);

        if (is_array($getters) && is_array($isMethods)) {
            $this->contact = new ModelsContact();
            $this->contact->id_user = $this->getUser()->getId();
            $this->contact->id_conversation = $this->getConversation()->getId();
            if (!$this->contact->save()) {
                if (!empty($this->contact->fail())) {
                    throw new \PDOException($this->contact->fail()->getMessage() . " " . $this->contact->queryExecuted());
                } else {
                    throw new \PDOException($this->contact->message());
                }
            }
        }
    }

    public function getContactsUserByIdUser(User $user)
    {
        $this->contact = new ModelsContact();
        $contactsResponse = $this->contact
            ->find("id_user=:id_user", ":id_user=" . $user->getId() . "", "*")
            ->advancedJoin("conversation", "braid.conversation.id = braid.contact.id_conversation")
            ->advancedJoin(
                "messages",
                "braid.messages.id = braid.conversation.id_message",
                "sender_id=:sender_id OR receiver_id=:receiver_id",
                ":sender_id=" . $user->getId() . "&:receiver_id=" . $user->getId() . "&:id_user=" . $user->getId() . "",
                "content, date_time, receiver_id, sender_id"
            )->fetch(true);

        $contactsData = [];
        $userIds = [];

        if (!empty($contactsResponse)) {
            foreach ($contactsResponse as $ids) {
                $userIds[] = $ids->sender_id;
                $userIds[] = $ids->receiver_id;
            }

            if (!empty($userIds)) {
                $userIds = array_filter($userIds, function ($id) use ($user) {
                    return $id != $user->getId();
                });

                $userIds = array_values($userIds);

                foreach ($userIds as $id) {
                    $user->setId($id);
                    $userData = $user->getUserById($user);

                    if (!isset($contactsData[$userData->id])) {
                        $contactsData[$userData->id] = [];
                    }
                    $contactsData[$userData->id] = $userData;
                }
            }

            foreach ($contactsResponse as &$contactValue) {

                foreach ($contactsData as &$contact) {
                    if ($contact->id == $contactValue->sender_id) {
                        $contact->content = $contactValue->content;
                        $contact->date_time = date("d/m/Y H:i", strtotime($contactValue->date_time));
                    }else if ($contact->id == $contactValue->receiver_id) {
                        $contact->content = $contactValue->content;
                        $contact->date_time = date("d/m/Y H:i", strtotime($contactValue->date_time));
                    }
                }
            }
        }

        return $contactsData;
    }

    public function getConversation()
    {
        return $this->conversation;
    }

    public function setConversation(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }
}
