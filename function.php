<?php

	function getParsCoinhouse($stock_arrs){

		//3. Парсим https://www.coinhouse.com
		
		$DOPVALS = ['BTC', 'ETH', 'LTC', 'BCH', 'XRP'];

		foreach ($DOPVALS as $dopval) {
			

			$coinhouse = Pars('https://www.coinhouse.com');
			$coinhouse = preg_replace("/&#?[a-z0-9]{2,8};/i","",$coinhouse); //удаляем HTML-сущности
			$coinhouse = substr($coinhouse, strpos($coinhouse, 'coin-symbol'.$_POST['valut_2']));
			$coinhouse = substr($coinhouse, 0, strpos($coinhouse, 'data-rate'));
			$coinhouse = substr($coinhouse, strpos($coinhouse, '=')+1);
			$coinhouse = trim($coinhouse);
			$res_coinhouse = round($_POST['summa'] /$coinhouse, 5); 
			
			$href = 'https://www.coinhouse.com/buy-'.$CURR[$_POST['valut_2']];

			$result_arr["www.coinhouse.com"]["href"] = $href;
			$result_arr["www.coinhouse.com"]["data"] = $res_coinhouse;
			$kurses[] = $res_coinhouse;	

		
			$result_arr["www.coinhouse.com"]["id_exchange"]	= 'coinhouse';

		}

	}

	function getCursValut( $html, $patern)
	{

			if ($patern) {
				# code...
			}
	 		preg_match_all( $patern, $html, $res_str);
	 		$res = floatval(1/$res_str[2][0]);
	 		return $res;
	}

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
	    foreach ($urls as $bay => $url) {
	        // Init of requests without executing

	        if ($url == '') {
	        	$chArray[$bay] = '';
	        	continue;
	        }
	        $ch = curl_init($url);
	        curl_setopt_array($ch, $curlOptions);

	        $chArray[$bay] = $ch;

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