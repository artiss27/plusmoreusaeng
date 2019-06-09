<?php


class Sponsorinfo_Controller extends iMVC_Controller
{
    public function index()
    {
        $this->load->library('Smarty_Wrapper', 'smarty');
        $this->smarty->template_dir = 'public/';

        $this->load->model('Main_Model', 'main');

        $this->site_url = $this->main->GetSiteSetting('site_url');
        $this->smarty->assign('site_url', $this->site_url);

        if (!$_COOKIE['enroller']) {
            $_SESSION['enroller'] = $this->main->FirstField('Select username From members Where is_active=1 And m_level>0 Order By RAND() Limit 1', 1);

            setcookie('enroller', $_SESSION['enroller'], mktime(0, 0, 0, 12, 31, 2045), '/');
        } else {
            $_SESSION['enroller'] = $_COOKIE['enroller'];
        }

        $display_name = $this->main->FirstField("Select display_name From members Where username='".$_SESSION['enroller']."'", 0);
        $display_email = $this->main->FirstField("Select display_email From members Where username='".$_SESSION['enroller']."'", 0);

  //  echo "<b>Sponsor Info :</b> <select size='1' id='select1' name='sponsor_info'>";
   // echo "<option value='' selected='selected'>Username: ".$_SESSION['enroller']."</option>";                
    echo 'Username: <strong>'.$_SESSION['enroller'].'</strong><br><br>';
        if ($display_name == 1) {
            $name = $this->main->FirstField("select CONCAT(first_name, ' ',last_name) from members where username='".$_SESSION['enroller']."'", '');
    //echo "<option value=''>Name: ".$name."</option>"; 

    echo 'Name: <strong>'.$name.'</strong><br><br>';
        }

        if ($display_email == 1) {
            $email = $this->main->FirstField("select email from members where username='".$_SESSION['enroller']."'", '');
    //echo "<option value=''>Email: ".$email."</option>"; 

    echo 'Email: <strong>'.$email.'</strong><br><br>';
        }
    }
}
