<?php


class Cymember_Controller extends iMVC_Controller
{
    public function anyLevels()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $this->smarty->template_dir = 'system/app/';
        $this->load->plugin_model('Cycler_Model', 'cycler');
        $lang = CoreHelp::getLang('members');
        $plugin_lang = CoreHelp::getLangPlugin('members', 'cycler');

        $level = CoreHelp::GetQuery('level', 1);
        $memberId = CoreHelp::getMemberId();
        $profile = $this->member->getProfile($memberId);
        $result = $this->cycler->getCycleTypes();
        $links = "<form action='' method='POST'><div class='form-group'> <select class='form-control' name='level' style='width:240px;' onChange='this.form.submit();'> \r\n";
        foreach ($result as $row) {
            $order_index = $row['order_index'];
            $title = CoreHelp::dec($row['title']);
            $selected = ($order_index == $level) ? 'selected' : '';
            $links .= "<option value='".$order_index."' $selected>".$title.'</option>';
        }
        $links .= '</select></div></form>';
        $content = $this->cycler->matrixTreeMemberSet($memberId, $level);
        $this->smarty->assign('links', $links);
        $this->smarty->assign('content', $content);
        $this->smarty->assign('lang', $lang);
        $this->smarty->assign('plugin_lang', $plugin_lang);
        CoreHelp::setSession('menu', array(
            'main' => 'my_network',
            'sub' => 'cycler_levels',
        ));
        $this->smarty->display('plugins/cycler/views/member_levels.tpl');
    }
}
