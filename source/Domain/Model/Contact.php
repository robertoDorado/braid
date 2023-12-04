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
            $this->contact->id_contact = $this->getUser()->getId();
            if (!$this->contact->save()) {
                if (!empty($this->contact->fail())) {
                    throw new \PDOException($this->contact->fail()->getMessage());
                }else {
                    throw new \PDOException($this->contact->message());
                }
            }
        }
    }

    public function getContactUser()
    {
        return $this->contactUser;
    }

    public function setContactUser(User $user)
    {
        $this->user = $user;
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
