<?php

namespace Source\Controllers;

use Source\Core\Controller;
use Source\Domain\Model\BusinessMan;
use Source\Domain\Model\Designer;

/**
 * Home Controllers
 * @package Source\Controllers
 */
class Home extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Home
     * 
     * @return array
     */

    public function index(): void
    {
        $businessMan = new BusinessMan();
        $businessManTotalData = $businessMan->getTotalData();

        $designer = new Designer();
        $designerTotalData = $designer->getTotalData();

        $cookie = empty($this->getCurrentSession()->cookie) ? 
            false : $this->getCurrentSession()->cookie;
        
        echo $this->view->render("home", [
            'businessManTotalData' => $businessManTotalData,
            'designerTotalData' => $designerTotalData,
            'cookie' => $cookie
        ]);
    }

    /**
     * Error
     *
     * @param array $data
     * @return void
     */
    public function error($data = [])
    {
        echo $this->view->render("error", [
            "title" => "Error",
            "errorCode" => $data['error_code']
        ]);
    }
}
