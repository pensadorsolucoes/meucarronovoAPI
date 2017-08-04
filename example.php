<?php

use meucarronovoAPI\MeuCarroNovo as MCN;
require('vendor/autoload.php');

//======================================================================
// Oauth
//======================================================================

$mcn = new MCN(
	array(
	    'grant_type' => '{grant_type}',
	    'username'   => '{username}',
	    'password'   => '{password}',
	    'auth64'     => '{auth64}'
	)
);
$token = $mcn->getToken();

//======================================================================
// features
//======================================================================

$mcn = new MCN($token['token']);

/*GET Accessories*/
$data = $mcn->getAccessories();

/*Get Makes*/
$data = $mcn->getMakes();

/*GET numer doors*/
$data = $mcn->getDoors();

/*GET models by make*/
$params=[
	'make_id'=> 4,
	'make_name' => 'FIAT'
];
$data = $mcn->getModels($params);

/* GET version by make and model*/
$params =[
	'make_id' => 4,
	'model_name' => 'PALIO WAY'
];
$data = $mcn->getVersions($params);

/*GET make years*/
$params['version_id'] = 200003666;
$data = $mcn->getMakeYears($params);

/*GET colors*/
$data = $mcn->getColors();

/*GET fuel types used*/
$data = $mcn->getFuelTypes();

/*GET types exchange*/
$data = $mcn->getExchange();

//======================================================================
// Ads
//======================================================================

$mcn = new MCN(
	array(
	    'grant_type' => '{grant_type}',
	    'username'   => '{username}',
	    'password'   => '{password}',
	    'auth64'     => '{auth64}'
	)
);
$token = $mcn->getLoginEnterprise();

$mcn = new MCN($token['token']);

/*Get list of ads*/
$data = $mcn->getAds();

/*Post new ad*/
$params = [
	'version'   	   => '200003666',
    'make_year'    	   => '2015',
    'model_year'	   => '2015',
    'plate' 		   => 'ASD1234',
    'renavam' 		   => '18749726159',
    'color'		   	   => '6',
    'fuel'             => '13'
    'km' 		       => '25000',
    'exchange'	       => '1',
	'door' 		       => '2',
	'price' 		   => '27000',
    'accept_exchange'  => false,
    'text' 			   => 'Etiam et dignissim neque. Maecenas ut elit sit amet justo ultricies finibus quis vitae mi.',
    'current_document' => true,
    'armored' 		   => false,
    'pne' 			   => false,
    'car_used'         => true,
    'options'          => ['1','2','3','6','30']
];
$data = $mcn->postDeal($params);

/*Update a ad*/
$params = [
	'id'               => '{ad_id}'
	'version'   	   => '200003666',
    'make_year'    	   => '2015',
    'model_year'	   => '2015',
    'plate' 		   => 'ASD1234',
    'renavam' 		   => '18749726159',
    'color'		   	   => '6',
    'fuel'             => '13'
    'km' 		       => '25000',
    'exchange'	       => '1',
	'door' 		       => '2',
	'price' 		   => '27000',
    'accept_exchange'  => false,
    'text' 			   => 'Etiam et dignissim neque. Maecenas ut elit sit amet justo ultricies finibus quis vitae mi.',
    'current_document' => true,
    'armored' 		   => false,
    'pne' 			   => false,
    'car_used'         => true,
    'options'          => ['1','2','3','6','30']
];
$data = $mcn->putDeal($params);

/*post a picture ad*/
$params = [
	'ad_id' => '{ad_id}',
	'url'   => '{url}',
	'order' => '{order}',
	'cover' => '{cover}'
];
$data = $mcn->postPicture($params);

/*delete a ad*/
$params = ['ad_id' => '{ad_id}'];
$data = $mcn->deleteAd($params);

/*delete a ad*/
$params = ['ad_id' => '{ad_id}'];
$data = $mcn->deleteAllPicture($params);

/*delete one picture*/
$params = [
	'ad_id' => '{ad_id}',
	'picture_id' => '{picture_id}'
	];
$data = $mcn->deletePicture($params);