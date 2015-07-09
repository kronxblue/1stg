<?php

class contact_model extends model {

    function __construct() {
        parent::__construct();
        session::init();
    }

    public function exec($data) {
        $response_array = array();

        $name = ucwords($data['name']);
        $email = $data['email'];
        $phone = ($data['phone'] != "") ? $data['phone'] : "-";
        $message = $data['message'];

//        NOTIFY RECEIVER BY EMAIL
//        Generate Email BODY

        $html = file_get_contents(BASE_PATH . 'email_template/contact');
        $html = htmlspecialchars($html);

        $html = str_replace('[NAME]', $name, $html);
        $html = str_replace('[EMAIL]', $email, $html);
        $html = str_replace('[PHONE]', $phone, $html);
        $html = str_replace('[MESSAGE]', $message, $html);

        $html = html_entity_decode($html);

        $body = $html;

//        Send Email
        $mailer = new mailer();

        $mailer->IsSMTP();                      // set mailer to use SMTP
        $mailer->Port = EMAIL_PORT;
        $mailer->Host = EMAIL_HOST;  // specify main and backup server
        $mailer->SMTPAuth = true;               // turn on SMTP authentication
        $mailer->Username = NOREPLY_EMAIL;            // SMTP username
        $mailer->Password = NOREPLY_PASS;           // SMTP password
        $mailer->From = NOREPLY_EMAIL;
        $mailer->FromName = SUPPORT_NAME;
        $mailer->AddReplyTo($email, $name);
        $mailer->AddAddress(CONTACT_EMAIL);
        $mailer->IsHTML(true);

        $mailer->Subject = "NEW message from $email via 1STG Contact Form.";
        $mailer->Body = $body;

        if (!$mailer->Send()) {
            $response_array['r'] = "false";
            $response_array['msg'] = "Technical Error: " . $mailer->ErrorInfo;
        } else {
            $response_array['r'] = "true";
            $response_array['msg'] = "Your message has been successfully submit.";
        }

        return $response_array;
    }

}
