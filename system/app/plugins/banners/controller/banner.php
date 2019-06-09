<?php

class Banner_Controller extends iMVC_Controller
{
	
	public function getBanner()
	{
		$this->load->plugin_model('Banners_Model', 'banners');
		$country = CoreHelp::getCountryCode();
		list($width, $height) = explode('x', CoreHelp::GetQuery('size'));
		$key  = 'banner_' . CoreHelp::getIp();
		$nKey = 'networkbanner_' . CoreHelp::getIp();
		usleep(rand(0, 50));
		$cached     = array();
		$avoid      = array();
		$bannerCode = array();
		$notIN      = "";
		$now        = time();
		
		$textadNum = array(
			'468x60' => 2,
			'728x90' => 3,
			'300x250' => 4
		);
		
		if(isset($textadNum[CoreHelp::GetQuery('size')]) && TEXTAD == 1) {
			$textads = $this->banners->db->query("SELECT * FROM ad_textads WHERE approved = 1 AND status = 1 AND ad_credit_placed > ad_credit_used + ad_credit_bid AND (countries LIKE '%" . $country . "%' or countries LIKE '%all%') ORDER BY -LOG(RAND())/ad_credit_bid LIMIT %d", $textadNum[CoreHelp::GetQuery('size')]);
			if(count($textads)>0){
				foreach ($textads as $textAd) {
					$textAdCode[] = array('url' => CoreHelp::getSiteUrl() . 'plugins/textads/textad/click/&hash=' . CoreHelp::encrypt($textAd['id'] . '|' . time()),
								 'title' => $textAd['headline'],
								 'd1' => $textAd['description1'],
								 'd2' => $textAd['description2']);		
				}										 
			}		
		}
		
		$num        = CoreHelp::GetQuery('num') ? intval(CoreHelp::GetQuery('num')) : 1;
		if (CoreHelp::getSession($key, false)) {
			$cached = unserialize(CoreHelp::getSession($key));
			$i      = 0;
			if (count($cached) > 0) {
				foreach ($cached as $viewed) {
					list($time, $id) = explode('|', $viewed);
					if ($time < $now - 60) {
						unset($cached[$i]);
					} else {
						$avoid[] = $id;
					}
				}
			}
			if (count($avoid) > 0) {
				$notIN = " AND id NOT IN(" . implode(',', $avoid) . ") ";
			}
		}
		
		$banners = $this->banners->db->query("SELECT * FROM ad_banners WHERE approved = 1 AND status = 1 AND ad_credit_placed > ad_credit_used + ad_credit_bid AND (countries LIKE '%" . $country . "%' or countries LIKE '%all%') AND banner_size = %s " . $notIN . " ORDER BY -LOG(RAND())/ad_credit_bid LIMIT $num", CoreHelp::GetQuery('size'));
		if (count($banners) > 0) {
			foreach ($banners as $banner) {				
				$bannerData   = $this->banners->db->queryFirstRow("SELECT * FROM  ad_banners WHERE id = %d ", $banner['id']);
				$bannerCode[] = array(
					'url' => CoreHelp::getSiteUrl() . 'plugins/banners/banner/click/&hash=' . CoreHelp::encrypt($bannerData['id'] . '|' . time()),
					'image' => $bannerData['banner_url'],
					'width' => $width,
					'height' => $height
				);
				$cached[]     = $now . '|' . $banner['id'];
			}
			CoreHelp::setSession($key, serialize($cached), 1);
			
		} else {
			$avoid  = array(
				0
			);
			$cached = array();
			$now    = time();
			if (CoreHelp::getSession($nKey, false)) {
				$cached = unserialize(CoreHelp::getSession($nKey));
				$i      = 0;
				foreach ($cached as $viewed) {
					list($time, $id) = explode('|', $viewed);
					if ($time < $now - 60) {
						unset($cached[$i]);
					} else {
						$avoid[] = $id;
					}
				}
			}
			$banners = $this->banners->db->query("SELECT * FROM ad_banner_networks WHERE size = %s AND id NOT IN(" . implode(',', $avoid) . ") ORDER BY RAND() LIMIT $num", CoreHelp::GetQuery('size'));
			if (count($banners) > 0) {
				foreach ($banners as $bann) {
					$banner = $this->banners->db->queryFirstRow("SELECT * FROM  ad_banner_networks WHERE id = %d ", $bann['id']);
					$this->banners->db->query("UPDATE ad_banner_networks SET impressions = impressions + 1 WHERE id = %d ", $bann['id']);
					$bannerCode[] = $banner['banner_code'];
					$cached[]     = $now . '|' . $banner['id'];
				}
				if ($bannerCode) {
					$banner = "";
					foreach ($bannerCode as $code):
						if (CoreHelp::GetQuery('carousel')):
							$code = '<div class="slide">' . $code . '</div>';
							$last = '';
						else:
							$last = '<br><br>';
						endif;
						$banner .= rawurlencode($code) . $last;
					endforeach;
					echo "document.writeln(decodeURIComponent('" . rtrim($banner, '<br><br>') . "'));";
					exit;
				}
				Cache::put($nKey, serialize($cached), 1);
			} else {
				$banner = $this->banners->db->queryFirstRow("SELECT * FROM  ad_banner_sizes WHERE width = %d AND height = %d ", $width, $height);
				if ($banner == null) {
					die('Wrong banner code');
				} else {
					$bannerCode[] = array(
						'url' => $banner['default_banner_target_url'],
						'image' => $banner['default_banner_url'],
						'width' => $width,
						'height' => $height
					);
				}
			}
		}
		
		if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || stripos($_SERVER['HTTP_REFERER'], "https") !== false) {
			foreach ($bannerCode as $banner) {
				$bannerCode[$i]['image'] = str_replace('https', 'http', $bannerCode[$i]['image']);
				$bannerCode[$i]['image'] = str_replace('http', 'https', $bannerCode[$i]['image']);
			}
		}	
		$banner = "";
		$last   = "";
		$rand = rand(0,1);		
		if(count($textAdCode) > 0 && $rand == 1){
			$banner = "";
			include('system/app/plugins/textads/views/text_ad_'.CoreHelp::GetQuery('size').'.php');
			//$tCode =  'system/app/plugins/textads/views/text_ad_'.CoreHelp::GetQuery('size').'.php';
			$banner .= rawurlencode($tCode);
			foreach ($textAdCode as $textad) {
				$this->banners->db->query("UPDATE ad_textads SET total_views = total_views + 1 WHERE id = %d ", $textad['id']);
			}
		}
		else {
			foreach ($bannerCode as $bann):
				$this->banners->db->query("UPDATE ad_banners SET total_views = total_views + 1 WHERE id = %d ", $bann['id']);
				if (CoreHelp::GetQuery('num') > 1):
					if (CoreHelp::GetQuery('carousel')):
						$code = '<div class="slide">' . '<a target="_blank" href="' . $bann['url'] . '"><img src="' . $bann['image'] . '" width="' . $bann['width'] . '" height="' . $bann['height'] . '" /></a>' . '</div>';
						$last = "";
					else:
						$code = '<a target="_blank" href="' . $bann['url'] . '"><img src="' . $bann['image'] . '" width="' . $bann['width'] . '" height="' . $bann['height'] . '" /></a>';
						$last = '<br><br>';
					endif;
					$banner .= rawurlencode($code) . $last;
				else:
					$code = '<a target="_blank" href="' . $bann['url'] . '"><img src="' . $bann['image'] . '" width="' . $bann['width'] . '" height="' . $bann['height'] . '" /></a>';
					$banner .= rawurlencode($code) . $last;
	
				endif;
			endforeach;	
		}
		
		echo "document.writeln(decodeURIComponent('".rtrim($banner, '<br><br>')."'));";
		exit;
	}
	
	public function getClick()
	{
		$this->load->plugin_model('Banners_Model', 'banners');
		$hash    = CoreHelp::decrypt(CoreHelp::GetQuery('hash'));
		$country = CoreHelp::getCountryCode();
		list($bannerId, $time) = explode('|', $hash);
		if ($bannerId > 0 && time() - $time < 60 * 60 * 8) {
			$banner = $this->banners->db->queryFirstRow("SELECT * FROM  ad_banners WHERE id = %d ", $bannerId);
			if (CoreHelp::getSession('clicked_today', false)) {
				if (in_array($bannerId, unserialize(CoreHelp::getSession('clicked_today')))) {
					CoreHelp::redirect($banner['target_url']);
				}
			}
			$this->banners->db->query("UPDATE ad_banners SET total_clicks = total_clicks + 1, ad_credit_used = ad_credit_used + %d WHERE id = %d ", $banner['ad_credit_bid'], $bannerId);
			$this->banners->db->insert('ad_banner_clicks', 
			array('banner_id' => $bannerId, 'ip_address' => CoreHelp::getIp(), 'country' => $country));
			$session = CoreHelp::getSession('clicked_today', false) ? unserialize(CoreHelp::getSession('clicked_today')) : array();
			array_push($session, $bannerId);
			CoreHelp::setSession('clicked_today', serialize($session));
			return CoreHelp::redirect($banner['target_url']);
		} else {
			die('Wrong session click');
		}
	}
	

}
