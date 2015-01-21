<?php

namespace Utilisateur\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UtilisateurController extends AbstractActionController
{
	protected $utilisateurTable;
	
	public function indexAction()
	{
		return new ViewModel(array(
				'utilisateurs' => $this->getUtilisateurTable()->fetchAll(),
		));
	}

	public function addAction()
	{
	}

	public function editAction()
	{
	}

	public function deleteAction()
	{
	}
	
	public function getUtilisateurTable()
	{
		if (!$this->utilisateurTable) {
			$sm = $this->getServiceLocator();
			$this->utilisateurTable = $sm->get('Utilisateur\Model\UtilisateurTable');
		}
		return $this->utilisateurTable;
	}
}