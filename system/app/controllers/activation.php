<?php


class Activation_Controller extends iMVC_Controller
{
    public function index()
    {
        $this->load->library('Smarty_Wrapper', 'smarty');
        $this->smarty->template_dir = 'system/app/views/main/';
        $this->load->model('Main_Model', 'main');
        $this->site_url = $this->main->GetSiteSetting('site_url');
        $this->smarty->assign('site_url', $this->site_url);
        $code = CoreHelp::GetQuery('code');
        $this->main->db->query("update members set is_active='1' where member_id='$code'");
        $this->smarty->display('activation.tpl');
    }
}
