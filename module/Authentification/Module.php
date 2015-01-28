<?php
namespace Authentification;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class Module implements AutoloaderProviderInterface
{
	public function getAutoloaderConfig(){
		return array(
				'Zend\Loader\ClassMapAutoloader' => array(
						__DIR__ . '/autoload_classmap.php',
				),
				'Zend\Loader\StandardAutoloader' => array(
						'namespaces' => array(
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
						),
				),
		);
	}
	public function getConfig(){
		return include __DIR__ . '/config/module.config.php';
	}
	 
	public function getServiceConfig()
	{
		return array(
				'factories'=>array(
						'Authentification\Model\MyAuthStorage' => function($sm){
							return new \Authentification\Model\MyAuthStorage('zend_tuto');
						},
						 
						'AuthService' => function($sm) {
							// Ici connexion BDD
							$dbAdapter           = $sm->get('Zend\Db\Adapter\Adapter');
							//		'table','login','mdp', 'MD5(?)');
							$dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter,
									'utilisateur','login','mdp', '');
							
							$authService = new AuthenticationService();
							$authService->setAdapter($dbTableAuthAdapter);
							$authService->setStorage($sm->get('Authentification\Model\MyAuthStorage'));

							return $authService;
						},
				),
		);
	}

}