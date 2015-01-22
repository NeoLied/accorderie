<?php
namespace Utilisateur\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Utilisateur\Model\Utilisateur;          // <-- Add this import
use Utilisateur\Form\UtilisateurForm;       // <-- Add this import

class UtilisateurController extends AbstractActionController
{
	protected $utilisateurTable;
	
	public function indexAction()
	{
		return new ViewModel(array(
				'utilisateurs' => $this->getUtilisateurTable()->fetchAll(),
		));
	}
	
	public function inscriptionAction()
	{
		$form = new UtilisateurForm();
		$form->get('submit')->setValue('Add');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$utilisateur = $this->getServiceLocator()->get('Utilisateur/Model/Utilisateur');
			$form->setInputFilter($utilisateur->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$utilisateur->exchangeArray($form->getData());
				$this->getUtilisateurTable()->saveUtilisateur($utilisateur);
		
				// Redirect to list of utilisateurs
				return $this->redirect()->toRoute('utilisateur', array(
													'action' => 'inscription'));
			}
		}
		return array('form' => $form);
	}

	public function addAction()
	{
		$form = new UtilisateurForm();
		$form->get('submit')->setValue('Add');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$utilisateur = $this->getServiceLocator()->get('Utilisateur/Model/Utilisateur');
			$form->setInputFilter($utilisateur->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$utilisateur->exchangeArray($form->getData());
				$this->getUtilisateurTable()->saveUtilisateur($utilisateur);
		
				// Redirect to list of utilisateurs
				return $this->redirect()->toRoute('utilisateur');
			}
		}
		return array('form' => $form);
	}

	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('utilisateur', array(
					'action' => 'add'
			));
		}
		
		// Get the Utilisateur with the specified id.  An exception is thrown
		// if it cannot be found, in which case go to the index page.
		try {
			$utilisateur = $this->getUtilisateurTable()->getUtilisateur($id);
		}
		catch (\Exception $ex) {
			return $this->redirect()->toRoute('utilisateur', array(
					'action' => 'index'
			));
		}
		
		$form  = new UtilisateurForm();
		$form->bind($utilisateur);
		$form->get('submit')->setAttribute('value', 'Edit');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($utilisateur->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$this->getUtilisateurTable()->saveUtilisateur($utilisateur);
		
				// Redirect to list of utilisateurs
				return $this->redirect()->toRoute('utilisateur');
			}
		}
		
		return array(
				'id' => $id,
				'form' => $form,
		);
	}

	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('utilisateur');
		}
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'No');
		
			if ($del == 'Yes') {
				$id = (int) $request->getPost('id');
				$this->getUtilisateurTable()->deleteUtilisateur($id);
			}
		
			// Redirect to list of utilisateurs
			return $this->redirect()->toRoute('utilisateur');
		}
		
		return array(
				'id'    => $id,
				'utilisateur' => $this->getUtilisateurTable()->getUtilisateur($id)
		);
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