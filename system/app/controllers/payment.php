<?php


class Payment_Controller extends iMVC_Controller
{
    public function index()
    {
        $this->load->library('Smarty_Wrapper', 'smarty');
        $this->smarty->template_dir = 'public/';

        $this->load->model('Main_Model', 'main');

        $this->site_url = $this->main->GetSiteSetting('site_url');
        $this->smarty->assign('site_url', $this->site_url);

        $code = $this->main->GetQuery('code');

        if ($code == 'y') {
            $this->smarty->assign('status', 'Thank You for your Payment! You can login now and enjoy Full access to our Backoffice! <a href="'.$this->site_url.'members">Login here to the member area</a>');
        } else {
            $this->smarty->assign('status', 'There were problems on your transaction, contact Administration if need further help.');
        }

        $this->smarty->display('payment.tpl');
    }
}
