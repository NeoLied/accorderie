<?php
return array(
    'controller' => array(
        'classes' => array(
            'utilisateur/utilisateur' => 'Utilisateur\Controller\UtilisateurController',
        ),
    ),
		'router' => array(
				'routes' => array(
						'utilisateur' => array(
								'type' => 'segment',
								'options' => array(
										'route' => '/utilisateur[/:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id' => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'utilisateur',
												'action' => 'index',
										),
								),
						),
				),
		),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);