<?php

	session_start();

	$_POST['valut_1'] = 'EUR';	

	$_POST['valut_2'] = 'BTC';

	$val1 = $_POST['valut_1'];

	$val2 = $_POST['valut_2']; 

	$urls = [];

	$getHtml = [];

	$sell_arrs = [];

	 //if ($_POST['summa']==''){$_POST['summa'] = '1';}
		   //if ($_POST['valut_1']==''){$_POST['valut_1'] = 'BTC';}
		   //if ($_POST['valut_2']==''){$_POST['valut_2'] = 'ETH';}
		  // if ($_POST['valut_2']=='BITCOIN'){$_POST['valut_2'] = 'BTC';}
		  // if ($_POST['valut_1']=='BITCOIN'){$_POST['valut_1'] = 'BTC';}

	require 'stock.php';

	require 'function.php';

	getParsCoinhouse($stock_arrs);


		//var_dump($urls_arr[$val1]);

			//var_dump($_SESSION['getHtml']);

				//exit();

		foreach ($stock_arrs as $stock => $stock_arr) {

			//var_dump($stock);
			//var_dump($stock_arr['url']);
			foreach ($stock_arr['url'] as $sell => $urls) {

				//var_dump($sell);
				//var_dump($urls);

				foreach ($urls as $buy => $href) {

					if ($i =< 50) {
						$sell_arrs[$stock][$sell][$buy]['href'] = $href;
					}
					$i++;
				}

				$getHtml[$stock][$sell] = getResponseByUrlsMulti($urls);

				//$_SESSION['getHtml'][] = $getHtml;

				//exit();

			}

		}

		//var_dump($getHtml);

		foreach ($getHtml as $stock => $value) {
			//var_dump($stock);
			foreach ($value as $sell => $buy_arr) {
				//var_dump($sell);
				foreach ($buy_arr as $buy => $html) {
					//var_dump($buy);
					//var_dump($html);

					$get_curs = getCursValut( $html, $stock_arrs[$stock]);

					//var_dump($get_curs);

					$sell_arrs['name_valut'][$sell][$buy][$stock]['curs'] = $get_curs;
					$sell_arrs['name_valut'][$sell][$buy][$stock]['href'] = $stock_arrs[$stock]['url'][$sell][$buy];

				}

				//exit();
			}
		}

		var_dump($sell_arrs);

 	//preg_match_all("/<form[^>]*>.*?<\/form>/s",$res[$val2],$res_str);

 	/*preg_match_all("/<form.*?>.*?<\/form>/si",$res[$val2],$res_str);*/

 	/*preg_match_all("/<form.*?>.*?<\/form>/si",$res[$val2],$res_str);*/

 	/*preg_match_all("/<div[^<>]+class=\"card\".*?>.*<\/div>/si",$res[$val2],$res_str);*/

 	//preg_match_all("#id=\"order-price\"(.*?)value=\"(.*?)\"#si",$res,$res_str);

 	//print_r($res_str[2]);

 	//$res_str = preg_replace('~\D+~','', $res_str[0]);

 	/*#<div[^>]+?id\s*?=\s*?["\']content["\'][^>]*?>(.+?)</div>#su*/

 	//$res_str = strip_tags($res[$val2], '<form>');

	//var_dump($res_str[2][0]);