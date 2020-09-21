<?php

	$stock_arrs = [];

	//2.  https://bitvalex.com

	$stock_arrs['bitvalex']['patern_str'] = '#id=\"order-price\"(.*?)value=\"(.*?)\"#si';

	$stock_arrs['bitvalex']['url'] = [
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
			];

	$stock_arrs['coinhouse']['url'] = [
									'EUR' => [
										'BTC' => 'https://www.coinhouse.com',
										'LTC' => '',
										'ETH' => '',
										'BCH' => ''
									]
			];
