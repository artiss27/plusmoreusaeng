<?php


class Spam_Controller extends iMVC_Controller
{
    public function index()
    {
        $this->load->library('Smarty_Wrapper', 'smarty');
        $this->smarty->template_dir = 'public/';

        $this->load->model('Main_Model', 'main');

        $this->site_url = $this->main->GetSiteSetting('site_url');
        $this->smarty->assign('site_url', $this->site_url);

        $email = $this->main->GetQuery('email');
        $subject = $this->main->GetQuery('subject');
        $name = $this->main->GetQuery('name');
        $message = $this->main->GetQuery('question');
        $ip = $this->main->GetQuery('ip');
        $username = $this->main->GetQuery('username');

        $message = $message."
		
Reported IP Address: $ip
Reported Username: $username
		
";

        $this->emailHeader = "From: <$name> ".$email."\r\n";

        $this->thisSiteTitle = $this->main->GetSiteSetting('site_name');

        $subject = 'Spam Report From ['.$this->thisSiteTitle.'] : '.$subject;

        $this->contactEmail = $this->main->GetSiteSetting('admin_email');

        $this->main->sendMail($this->contactEmail, $subject, $message, $this->emailHeader);

        $this->smarty->display('spam_thank.tpl');
    }
}
