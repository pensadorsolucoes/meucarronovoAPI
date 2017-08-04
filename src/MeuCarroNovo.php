<?php
namespace meucarronovoAPI;

/**
 * meucarronovoAPI v1.
 *
 * TERMS OF USE:
 * - This code is in no way affiliated with, authorized, maintained, sponsored
 *   or endorsed by meucarronovo or any of its affiliates or subsidiaries. This is
 *   an independent and unofficial API. Use at your own risk.
 * - We do NOT support or tolerate anyone who wants to use this API to send spam
 *   or commit other online crimes.
 *
 */

class MeuCarroNovo
{

	/**
	* config to all requests
	*
	* @var array
	**/
	private static $cfg = [];

	/**
	* Login url
	*
	* @var string
	**/
	protected $_loginUrl = 'https://ext.meucarronovo.com.br/login-server';

	/**
	* Rest API
	*
	* @var string
	**/
	protected $_api = 'https://ext.meucarronovo.com.br/api-server/v1';

	/**
	* use a 2 types of data
	* @var array
	*		   grant_type
	*		   username
	*		   password
	*		   auth64
	*
	* @var string
	*		   token
	**/
	public function __construct(
        $data = null)
	{

		if(empty($data))
			throw new Exception("Empty data in __construct");

		if(is_array($data)){

			self::$cfg['grant_type'] = $data['grant_type'];
			self::$cfg['username']   = $data['username'];			
			self::$cfg['password'] 	 = $data['password'];
			self::$cfg['auth64']     = $data['auth64'];

		} else{

			self::$cfg['token'] = 'Bearer ' . $data;
		}
    }

    /**
    *
    * Used internally, but can also be used by end-users if they want
    * to create completely custom API queries without modifying this library.
    *
    * @param string $url
    *
    * @return array
    */
    public function request(
        $url)
    {
        return new Request($this, $url);
    }

    //======================================================================
	// Oauth
	//======================================================================

    /**
	* 
	* GET Token by integrator
	*
	* @return array 	
	*
	**/
	public function getToken()
	{
		$endpoint = $this->_loginUrl . '/token?grant_type=client_credentials';
		
		return $this->request($endpoint)
			->addHeader('authorization', self::$cfg['auth64'])
			->addHeader('Content-Type', 'application/x-www-form-urlencoded')
			->addHeader('Accept', 'application/json')
			->addPost('grant_type', 'client_credentials')
            ->getResponse();
	}

    /**
	* 
	* GET Token by client
	*
	* @return array 	
	*
	**/
	public function getLoginEnterprise()
	{
		$endpoint = $this->_loginUrl . '/token';
		return $this->request($endpoint)
			->addHeader('authorization', self::$cfg['auth64'])
			->addHeader('Content-Type', 'application/x-www-form-urlencoded')
			->addHeader('Accept', 'application/json')
			->addPost('username', self::$cfg['username'])
			->addPost('password', self::$cfg['password'])
			->addPost('grant_type', 'password')
            ->getResponse();
	}

    //======================================================================
	// Features Databaseservice
	//======================================================================

	/**
	* 
	* GET Categories
	*
	* @return string 	
	*
	**/
	public function getCategories()
	{
		$endpoint = $this->_api . '/catalogo/categorias';

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->getResponse();
	}

	/**
	* 
	* GET Accessories
	*
	* @return string 	
	*
	**/
	public function getAccessories()
	{
		$endpoint = $this->_api . '/catalogo/categorias/1/acessorios';

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->getResponse();
	}

	/**
	* 
	* Get Makes
	*
	* @return string 	
	*
	**/
	public function getMakes()
	{
		$endpoint = $this->_api . '/catalogo/categorias/1/marcas';

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->getResponse();
	}

	/**
	* 
	* GET numer doors
	*
	* @return string 	
	*
	**/
	public function getDoors()
	{
		$endpoint = $this->_api . '/catalogo/categorias/1/quantidade-portas';

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->getResponse();
	}

	/**
	* 
	* GET models by make
	*
	* @var array
	*		   make_id
	*		   make_name
	*
	* @return string 	
	*
	**/
	public function getModels($params)
	{
		$endpoint = $this->_api . '/catalogo/modelos?categoriaId=1&categoriaNome=AUTOMÓVEL&'.http_build_query(array('marcaId'=>$params['make_id'], 'marcaNome'=>$params['make_name']));

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->getResponse();
	}

	/**
	* 
	* GET version by make and model
	* @var array
	*		   make_id
	*		   model_name
	*
	* @return string 	
	*
	**/
	public function getVersions($params)
	{
		$endpoint = $this->_api . '/catalogo/versoes?categoria=1&'.http_build_query(array('marca'=>$params['make_id'], 'modelo'=>$params['model_name'], 'removerNomeModelo'=>false));

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->getResponse();
	}

	/**
	* 
	* GET make years
	* @var array
	*		   version_id
	*
	* @return string 	
	*
	**/
	public function getMakeYears($params)
	{
		$endpoint = $this->_api . '/catalogo/versoes/'.$params['version_id'].'/anos-fabricacao';

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->getResponse();
	}

	/**
	* 
	* GET colors
	*
	* @return string 	
	*
	**/
	public function getColors()
	{
		$endpoint = $this->_api . '/catalogo/cores';

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->getResponse();
	}

	/**
	* 
	* GET fuel types used
	*		   
	*
	* @return array 	
	*
	**/
    public function getFuelTypes()
	{
		$endpoint = $this->_api . '/catalogo/combustiveis';

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->getResponse();

	}

	/**
	* 
	* GET types exchange
	*
	* @return string 	
	*
	**/
	public function getExchange()
	{
		$endpoint = $this->_api . '/catalogo/tipos-cambio';

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->getResponse();
	}

	/**
	* 
	* GET types exchange
	*
	* @return string 	
	*
	**/
	public function getPlan(){

		$endpoint = $this->_api . '/meus-dados/plano-vingente';

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->getResponse();

	}

    //======================================================================
	// Features Dealer
	//======================================================================

	/**
	* 
	* GET ads list
	*
	* @return string 	
	*
	**/
	public function getAds()
	{
		$endpoint = $this->_api . '/meus-dados/anuncios';

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->getResponse();
	}

	/**
	* 
	* GET pictures by ad
	*
	* @return string 	
	*
	**/
	public function getPicutre($params)
	{
		$endpoint = $this->_api . '/meus-dados/anuncios/'.$params['ad_id'].'/fotos';

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->getResponse();
	}


	/**
	* 
	* Create a new ad in the inventory
	* 
	* @var array 
	*		  version
    *		  make_year
   	*		  model_year
    *		  plate
    *		  renavam
    *		  color
    *		  fuel
    *		  km
    *		  exchange
	*		  door
	*		  price
    *		  accept_exchange
    *		  text
    *		  current_document
    *		  armored
    *		  pne
    *		  car_used
    *		  options  
	*
	* @return array 	
	*
	**/
	public function postDeal($params)
	{

		$endpoint = $this->_api . '/meus-dados/anuncios';

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->addPost('idCategoria', 1)
            ->addPost('idVersao', $params['version'])
            ->addPost('anoFabricacao', $params['make_year'])
            ->addPost('anoModelo', $params['model_year'])
            ->addPost('placa', $params['plate'])
            ->addPost('renavam', $params['renavam'])
            ->addPost('idCor', $params['color'])
            ->addPost('idCombustivel', $params['fuel'])
            ->addPost('quilometragem', $params['km'])
            ->addPost('idCambio', $params['exchange'])
            ->addPost('idPortas', $params['door'])
            ->addPost('valor', $params['price'])
            ->addPost('aceitaTroca', $params['accept_exchange'])
            ->addPost('observacoes', $params['text'])
            ->addPost('documentacaoEmDia', $params['current_document'])
            ->addPost('blindado', $params['armored'])
            ->addPost('adaptadoPne', $params['pne'])
            ->addPost('veiculoUsado', $params['car_used'])
            ->addPost('idOpcional', $params['options'])
            ->getResponse();
	}

	/**
	* 
	* Create a new ad in the inventory
	* 
	* @var array 
	*		  url
	*		  order
	*		  cover
	*
	* @return array 	
	*
	**/
	public function postPicture($params)
	{

		$endpoint = $this->_api . '/meus-dados/anuncios/'.$params['ad_id'].'/fotos';

		$picture =[
			'url'   => $params['url'],
			'ordem' => $param['order'],
			'capa'  => $param['cover']
		];

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->addPost(0, $picture)
            ->getResponse();
	}

	/**
	* 
	* update a ad in the inventory
	* 
	* @var array 
	*		  id
	*		  version
    *		  make_year
   	*		  model_year
    *		  plate
    *		  renavam
    *		  color
    *		  fuel
    *		  km
    *		  exchange
	*		  door
	*		  price
    *		  accept_exchange
    *		  text
    *		  current_document
    *		  armored
    *		  pne
    *		  car_used
    *		  options  
	*
	* @return array 	
	*
	**/
	public function putDeal($params)
	{
		$endpoint = $this->_api . '/meus-dados/anuncios';

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->addPut('idAnuncio', $params['id'])
            ->addPut('idCategoria', 1)
            ->addPut('idVersao', $params['version'])
            ->addPut('anoFabricacao', $params['make_year'])
            ->addPut('anoModelo', $params['model_year'])
            ->addPut('placa', $params['plate'])
            ->addPut('renavam', $params['renavam'])
            ->addPut('idCor', $params['color'])
            ->addPut('idCombustivel', $params['fuel'])
            ->addPut('quilometragem', $params['km'])
            ->addPut('idCambio', $params['exchange'])
            ->addPut('idPortas', $params['door'])
            ->addPut('valor', $params['price'])
            ->addPut('aceitaTroca', $params['accept_exchange'])
            ->addPut('observacoes', $params['text'])
            ->addPut('documentacaoEmDia', $params['current_document'])
            ->addPut('blindado', $params['armored'])
            ->addPut('adaptadoPne', $params['pne'])
            ->addPut('veiculoUsado', $params['car_used'])
            ->addPut('idOpcional', $params['options'])
            ->getResponse();
	}


	/**
	* 
	* delte ad
	* 
	* @var array 
	*		ad_id
	*
	* @return array 	
	*
	**/
	public function deleteAd($params)
	{
		$endpoint = $this->_api . '/meus-dados/anuncios/'.$params['ad_id'];

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->addDelete(true)
            ->getResponse();
	}

	/**
	* 
	* Delete All pictures in ad
	* @var array 
	*		ad_id
	*
	* @return string 	
	*
	**/
	public function deleteAllPicture(){
		$endpoint = $this->_api . '/meus-dados/anuncios/'.$params['ad_id'].'/fotos';

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->addDelete(true)
            ->getResponse();
	}

	/**
	* 
	* Delete one picture
	* @var array 
	*		ad_id
	*		picture_id
	*
	* @return string 	
	*
	**/
	public function deletePicture($params){
		$endpoint = $this->_api . '/meus-dados/anuncios/'.$params['ad_id'].'/fotos/'.$params['picture_id'];

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('Authorization', self::$cfg['token'])
            ->addDelete(true)
            ->getResponse();
	}
}