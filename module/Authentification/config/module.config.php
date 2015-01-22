<?php
return array(
		'controllers' => array(
				'invokables' => array(
						'Authentification\Controller\Auth' => 'Authentification\Controller\AuthController',
						'Authentification\Controller\Success' => 'Authentification\Controller\SuccessController'
				),
		),
		'router' => array(
				'routes' => array(
						 
						'login' => array(
								'type'    => 'Literal',
								'options' => array(
										'route'    => '/authentification',
										'defaults' => array(
												'__NAMESPACE__' => 'Authentification\Controller',
												'controller'    => 'Auth',
												'action'        => 'login',
										),
								),
								'may_terminate' => true,
								'child_routes' => array(
										'process' => array(
												'type'    => 'Segment',
												'options' => array(
														'route'    => '/[:action]',
														'constraints' => array(
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
														),
														'defaults' => array(
														),
												),
										),
								),
						),
						 
						'success' => array(
								'type'    => 'Literal',
								'options' => array(
										'route'    => '/succes',
										'defaults' => array(
												'__NAMESPACE__' => 'Authentification\Controller',
												'controller'    => 'Success',
												'action'        => 'index',
										),
								),
								'may_terminate' => true,
								'child_routes' => array(
										'default' => array(
												'type'    => 'Segment',
												'options' => array(
														'route'    => '/[:action]',
														'constraints' => array(
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
														),
														'defaults' => array(
														),
												),
										),
								),
						),
						 
				),
		),
		'view_manager' => array(
				'template_path_stack' => array(
						'Authentification' => __DIR__ . '/../view',
				),
		),
);