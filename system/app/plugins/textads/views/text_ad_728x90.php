<?php 
$iframe = '<html><head><meta charset="UTF-8"><style>body{background-color:transparent;font-family:verdana,arial,sans-serif;height:100%;font-size:10px}table{margin:0px;padding:0px;table-layout:fixed;width:100%;height:100%;border-spacing:0px;border-collapse:collapse}td{padding:0px 6px 5px 0px;vertical-align:top}.w{overflow:hidden;width:700px;height:90px}.z{position:absolute;right:1px;bottom:1px;font-size:9px;width:68px}.zs{background-color:#0000FF}.zsl{border-left-color:#FFFFFF;border-left-style:solid}.zst{border-top-color:#FFFFFF;border-top-style:solid}.za{color:#FFF;text-decoration:none;position:absolute;top:1px;left:6px}.zr{position:absolute;font-weight:bold;white-space:nowrap;display:none;right:4px;bottom:13px;background-color:#FFFFFF;padding:5px}.zr a{border:1px solid #0000FF;color:#0000FF;display:block;text-decoration:none;padding:2px 5px}.z:hover .zr{display:block}.h{position:absolute;display:none;background-color:#FFFFFF;color:#222;left:5px;bottom:1px;font-family:arial;font-size:9px;padding:1px 3px 0px 0px;cursor:pointer}.w:hover .h{display:block}.t{font-size:12px;font-weight:bold;overflow:hidden;}.t a{color:#0000FF;font-size:13px;}.d{color:#000000;font-size:12px;display:block;overflow:hidden}.u{font-size:10px;line-height:12px;overflow:hidden;white-space:nowrap}.u a{color:#0000FF;text-decoration:none}.r1,.r2{border-color:transparent #0000FF;border-style:none solid;background-color:#FFFFFF}.b{margin:0px 4px;height:0px;border-top:1px solid #0000FF}.r1{margin:0px 2px;height:1px;border-width:0px 2px}.r2{margin:0px 1px;height:2px;border-width:0px 1px}.c{margin:0px;height:73px;overflow:hidden;border-left:1px solid #0000FF;border-right:1px solid #0000FF;padding-left:6px;padding-bottom:9px;background-color:#FFFFFF}</style><meta name=robots content="noindex, nofollow" /></head><body><div class=w><div class=b></div><div class=r1></div><div class=r2></div><div class=c><table><tr>';

foreach ($textAdCode as $textad):
	$iframe .= '<td style=width:33%;><div class="t"><a href="'.$textad['url'].'" target="_blank">'.$textad['title'].'</a></div><div class="d">'.$textad['d1'].', '.$textad['d2'].'</div></td>';
endforeach;

$iframe .= '</tr></table></div><div class=h style=font-weight:bold; onclick="window.open(\'http://'.$_SERVER['HTTP_HOST'].'\');">ADVERTISE HERE</div><div class=z><div class="zs zsl zst" style=height:1px;border-left-width:4px;border-top-width:1px;></div><div class="zs zsl" style=height:1px;border-left-width:2px;></div><div class="zs zsl" style=height:2px;border-left-width:1px;></div><div class=zs style=height:5px;></div><div class=zs style=height:2px;margin-right:1px;></div><div class=zs style=height:1px;margin-right:2px;></div><a class=za href="http://'.$_SERVER['HTTP_HOST'].'" target=_blank>Text Ads</a></div><div class=r2></div><div class=r1></div><div class=b></div></div></body></html>
';

$tCode = '<ins style="height:90px;width:700px;border:none;margin:0px;padding:0px;display:inline-table;visibility:visible;position:relative"><ins style="height:90px;width:700px;border:none;margin:0px;padding:0px;display:block;visibility:visible;position:relative"><iframe vspace="0" style="height:90px;width:700px;border:none;position:absolute;left:0px;top:0px;opacity:1;filter:none" marginwidth="0" marginheight="0" hspace="0" allowtransparency="true" scrolling="no" src="data:text/html;base64, '.base64_encode($iframe).'" frameborder="0" height="90" width="700"></iframe></ins></ins>';

