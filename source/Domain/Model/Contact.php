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

    /** @var User Contato do usuário */
    private User $contactUser;

    /** @var ModelsContact Objeto de persistência */
    private ModelsContact $contact;

    public function setModelContact(Contact $obj)
    {
        $getters = checkGettersFilled($obj);
        $isMethods = checkIsMethodsFilled($obj);

        if (is_array($getters) && is_array($isMethods)) {
            $this->contact = new ModelsContact();
            $this->contact->id_user = $this->getUser()->getId();
            $this->contact->id_contact = $this->getContactUser()->getId();
            if (!$this->contact->save()) {
                if (!empty($this->contact->fail())) {
                    throw new \PDOException($this->contact->fail()->getMessage());
                } else {
                    throw new \PDOException($this->contact->message());
                }
            }
        }
    }

    public function getContactsUserByIdUser(User $user)
    {
        $this->contact = new ModelsContact();
        $contactsDataRepeat = $this->contact
            ->find("", "id_contact")
            ->advancedJoin(
                "messages",
                "braid.messages.sender_id = braid.contact.id_contact OR braid.messages.receiver_id = braid.contact.id_contact",
                "receiver_id=:receiver_id OR sender_id=:sender_id",
                ":receiver_id=" . $user->getId() . "&:sender_id=" . $user->getId() . "",
                "content, date_time"
            )
            ->advancedJoin("user", "user.id = contact.id_contact", "", "", "full_name, path_photo")
            ->fetch(true);

        $contactsData = [];
        if (!empty($contactsDataRepeat)) {
            foreach ($contactsDataRepeat as &$contact) {
                $contactId = $contact->id_contact;
                if ($user->getId() != $contactId) {
                    if (!isset($contactsData[$contactId])) {
                        $contactsData[$contactId] = [];
                    }

                    $contactsData[$contactId] = $contact;
                    $contact->date_time = date("d/m/Y H:i", strtotime($contact->date_time));
                }
            }
        }

        return $contactsData;
    }

    public function getContactUser()
    {
        return $this->contactUser;
    }

    public function setContactUser(User $contactUser)
    {
        $this->contactUser = $contactUser;
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
