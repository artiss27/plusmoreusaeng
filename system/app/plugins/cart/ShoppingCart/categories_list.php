<?php
//
// List categories
//
$Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS);    //instantiate
$Db->query("SET NAMES 'utf8'");  // formating to utf8
$rows = $Db->search('bsc_category')->
        setColumns('*')->
        addFilter("visible=%d", 1)->
        sortByOrdering('ASC')->
        getRows();

foreach ($rows as $rs) {
          
    echo "<a href='/store/".$_SESSION['enroller']."/category/" . $rs['id'] . "/' class='btn btn-default' style='margin-bottom:20px; margin-right:20px;'>" . $rs['name'] . "</a>";
}

//
// View shopping cart only for smartphone
//
echo '<div class="visible-xs visible-sm" style="padding-bottom: 30px;"><a href="/store/'.$_SESSION['enroller'].'/cart/" class="btn btn-success" >View shoppingcart</a></div>';
?>

