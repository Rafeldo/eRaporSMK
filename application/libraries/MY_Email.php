<?php

class MY_Email extends CI_Email  {

    function send_email($subject  = '', $to = '',  $body = '', $attachment = ''){
        $from_email = 'do-not-reply@quinexinves.com' ;
        $settings = Setting::first();
        $from_name = $settings->site_title;

        $this->load->library("email");
        $this->email->set_mailtype('text');
        $this->email->set_newline("\r\n");
        $this->email->from($from_email, $from_name);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($body);
        
        if($attachment != '')
        $this->email->attach($attachment);

        if($this->email->send()){
            return true;
        }
    }
} 
