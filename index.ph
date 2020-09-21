<?php

	$_POST['valut_1'] = 'EUR';	

	$_POST['valut_2'] = 'BTC';

	$val1 = $_POST['valut_1'];

	$val2 = $_POST['valut_2']; 

	 //if ($_POST['summa']==''){$_POST['summa'] = '1';}
		   //if ($_POST['valut_1']==''){$_POST['valut_1'] = 'BTC';}
		   //if ($_POST['valut_2']==''){$_POST['valut_2'] = 'ETH';}
		  // if ($_POST['valut_2']=='BITCOIN'){$_POST['valut_2'] = 'BTC';}
		  // if ($_POST['valut_1']=='BITCOIN'){$_POST['valut_1'] = 'BTC';}

	//2. парсим  https://bitvalex.com

		$patern_str = [
				'bitvalex' => '#id=\"order-price\"(.*?)value=\"(.*?)\"#si'
			];

		$urls_arr = array(
				'EUR' => [
					'BTC' => 'https://bitvalex.com/trade/buy/BTC-EUR',
					'LTC' => 'https://bitvalex.com/trade/buy/LTC-EUR',
					'ETH' => 'https://bitvalex.com/trade/buy/ETH-EUR',
					'BCH' => 'https://bitvalex.com/trade/buy/BCH-EUR'
				],
				'USD' => [
					'BTC' => 'https://bitvalex.com/trade/buy/BTC-USD',
					'LTC' => 'https://bitvalex.com/trade/buy/LTC-USD',
					'ETH' => 'https://bitvalex.com/trade/buy/ETH-USD',
					'BCH' => 'https://bitvalex.com/trade/buy/BCH-USD'
				],
				'BTC' => [
					'LTC' => 'https://bitvalex.com/trade/buy/LTC-BTC',
					'ETH' => 'https://bitvalex.com/trade/buy/ETH-BTC',
					'BCH' => 'https://bitvalex.com/trade/buy/BCH-BTC',
					'USD' => 'https://bitvalex.com/trade/sell/BTC-USD',
					'EUR' => 'https://bitvalex.com/trade/sell/BTC-EUR'
				],
				'LTC' => [
					'EUR' => 'https://bitvalex.com/trade/sell/LTC-EUR',
					'BTC' => 'https://bitvalex.com/trade/sell/LTC-BTC',
					'USD' => 'https://bitvalex.com/trade/sell/LTC-USD',
				],
				'ETH' => [
					'EUR' => 'https://bitvalex.com/trade/sell/ETH-EUR',
					'BTC' => 'https://bitvalex.com/trade/sell/ETH-BTC',
					'USD' => 'https://bitvalex.com/trade/sell/ETH-USD'
				]
		);

		//var_dump($urls_arr[$val1]);

		$urls = array();

		foreach ($urls_arr as $key => $value) {
			foreach ($value as $key => $href) {
				//var_dump($key);
				$urls[$key] = $href;
			}
		}
		//$urls = $urls_arr[$val1];
	//var_dump($urls);

	$res = getResponseByUrlsMulti($urls);

	//var_dump($res);

 	//preg_match_all("/<form[^>]*>.*?<\/form>/s",$res[$val2],$res_str);

 	/*preg_match_all("/<form.*?>.*?<\/form>/si",$res[$val2],$res_str);*/

 	/*preg_match_all("/<form.*?>.*?<\/form>/si",$res[$val2],$res_str);*/

 	/*preg_match_all("/<div[^<>]+class=\"card\".*?>.*<\/div>/si",$res[$val2],$res_str);*/

 	foreach ($res as $key => $value) {
 		var_dump($value);
 		preg_match_all("#<input.*id=\"order-price\".*value=\".*\".?>#si",$value,$res_str);
 		var_dump($res_str);
 		exit();
 	}

 	//preg_match_all("#id=\"order-price\"(.*?)value=\"(.*?)\"#si",$res,$res_str);

 	//print_r($res_str[2]);

 	//$res_str = preg_replace('~\D+~','', $res_str[0]);

 	/*#<div[^>]+?id\s*?=\s*?["\']content["\'][^>]*?>(.+?)</div>#su*/

 	//$res_str = strip_tags($res[$val2], '<form>');

		var_dump($res_str[2][0]);

	function getResponseByUrlsMulti($urls, $followLocation = false, $maxRedirects = 10)
	{
	    // Options
	    $curlOptions = [
	        CURLOPT_HEADER => false,
	        CURLOPT_NOBODY => false,
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_TIMEOUT => 10,
	        CURLOPT_CONNECTTIMEOUT => 10,
	    ];

	    if ($followLocation) {
	        $curlOptions[CURLOPT_FOLLOWLOCATION] = true;
	        $curlOptions[CURLOPT_MAXREDIRS] = $maxRedirects;
	    }

	    // Init multi-curl
	    $mh = curl_multi_init();
	    $chArray = [];

	    $urls = !is_array($urls) ? [$urls] : $urls;
	    foreach ($urls as $key => $url) {
	        // Init of requests without executing
	        $ch = curl_init($url);
	        curl_setopt_array($ch, $curlOptions);

	        $chArray[$key] = $ch;

	        // Add the handle to multi-curl
	        curl_multi_add_handle($mh, $ch);
	    }

	    // Execute all requests simultaneously
	    $active = null;
	    do {
	        $mrc = curl_multi_exec($mh, $active);
	    } while ($mrc == CURLM_CALL_MULTI_PERFORM);

	    while ($active && $mrc == CURLM_OK) {
	        // Wait for activity on any curl-connection
	        if (curl_multi_select($mh) === -1) {
	            usleep(100);
	        }

	        while (curl_multi_exec($mh, $active) == CURLM_CALL_MULTI_PERFORM);
	    }

	    // Close the resources
	    foreach ($chArray as $ch) {
	        curl_multi_remove_handle($mh, $ch);
	    }
	    curl_multi_close($mh);

	    // Access the results
	    $result = [];
	    foreach ($chArray as $key => $ch) {
	        // Get response
	        $result[$key] = curl_multi_getcontent($ch);
	    }

	    return $result;
	}