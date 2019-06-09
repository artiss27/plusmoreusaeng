<?php /* Smarty version Smarty-3.0.8, created on 2019-06-07 10:37:51
         compiled from "system/app/views/members/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3732760515cfaa0ef1548e8-87193369%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '725ee3a4d2f1aa7b4b2dd8be5ee776079583a20f' => 
    array (
      0 => 'system/app/views/members/header.tpl',
      1 => 1509423599,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3732760515cfaa0ef1548e8-87193369',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title><?php echo $_smarty_tpl->getVariable('lang')->value['backoffice_dashboard'];?>
</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="/assets/common/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="/assets/common/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="/assets/common/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="/assets/common/vendor/bootstrap/dist/css/bootstrap.css" />
    <link rel="stylesheet" href="/assets/common/vendor/datatables_plugins/integration/bootstrap/3/dataTables.bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="/assets/common/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="/assets/common/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="/assets/common/styles/style.css">

</head>
<body>

<!-- Header -->
<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version">
        <span>
            <?php echo $_smarty_tpl->getVariable('lang')->value['backoffice_dashboard'];?>

        </span>
    </div>
    <nav role="navigation">
        <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>

       <!-- <form role="search" class="navbar-form-custom" method="post" action="#">
            <div class="form-group">
                <input type="text" placeholder="Search something special" class="form-control" name="search">
            </div>
        </form> -->
		<?php echo $_smarty_tpl->getVariable('hooks')->value->do_action('head_nav');?>
		
        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">
                
                <?php $_smarty_tpl->tpl_vars['message_count'] = new Smarty_variable($_smarty_tpl->getVariable('hooks')->value->apply_filters('get_message_number',$_SESSION['member_id']), null, null);?>
                
                <li class="dropdown">
                    <a class="dropdown-toggle label-menu-corner" href="#" data-toggle="dropdown">
                        <i class="pe-7s-mail"></i>
                        <?php if ($_smarty_tpl->getVariable('message_count')->value>0){?><span class="label label-success"><?php echo $_smarty_tpl->getVariable('message_count')->value;?>
</span><?php }?>
                    </a>
                    <ul class="dropdown-menu hdropdown animated flipInX">
                        <div class="title">
                            You have <?php echo $_smarty_tpl->getVariable('message_count')->value;?>
 new messages
                        </div>                        
                        <li class="summary"><a href="/members/messages">Go To Inbox</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="/members/logout">
                        <i class="pe-7s-upload pe-rotate-90"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>