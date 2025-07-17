<?php
namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailer_Lib
{
    public function load()
    {
        require_once APPPATH . 'ThirdParty/PHPMailer/PHPMailer.php';
        require_once APPPATH . 'ThirdParty/PHPMailer/SMTP.php';
        require_once APPPATH . 'ThirdParty/PHPMailer/Exception.php';

        return new PHPMailer(true);
    }
}
