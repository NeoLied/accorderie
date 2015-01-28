<?php
namespace Annonce\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Annonce\Model\Annonce;          // <-- Add this import
use Annonce\Form\AnnonceForm;       // <-- Add this import

class AnnonceController extends AbstractActionController
{
	protected $annonceTable;
	
	public function indexAction()
	{
		return new ViewModel(array(
				'annonces' => $this->getAnnonceTable()->fetchAll(),
		));
	}

	public function addAction()
	{
		$form = new AnnonceForm();
		$form->get('submit')->setValue('Add');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$annonce = new Annonce();
			$form->setInputFilter($annonce->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$annonce->exchangeArray($form->getData());
				$this->getAnnonceTable()->saveAnnonce($annonce);
		
				// Redirect to list of annonces
				return $this->redirect()->toRoute('annonce');
			}
		}
		return array('form' => $form);
	}

	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('annonce', array(
					'action' => 'add'
			));
		}
		try {
			$annonce = $this->getAnnonceTable()->getAnnonce($id);
		}
		catch (\Exception $ex) {
			return $this->redirect()->toRoute('annonce', array(
					'action' => 'index'
			));
		}
		
		$form  = new AnnonceForm();
		$form->bind($annonce);
		$form->get('submit')->setAttribute('value', 'Edit');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($annonce->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$this->getAnnonceTable()->saveAnnonce($annonce);
		
				return $this->redirect()->toRoute('annonce');
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
			return $this->redirect()->toRoute('annonce');
		}
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'No');
		
			if ($del == 'Yes') {
				$id = (int) $request->getPost('id');
				$this->getAnnonceTable()->deleteAnnonce($id);
			}
		
			// Redirect to list of albums
			return $this->redirect()->toRoute('annonce');
		}
		
		return array(
				'id'    => $id,
				'annonce' => $this->getAnnonceTable()->getAnnonce($id)
		);
	}
	
	public function getAnnonceTable()
	{
		if (!$this->annonceTable) {
			$sm = $this->getServiceLocator();
			$this->annonceTable = $sm->get('Annonce\Model\AnnonceTable');
		}
		return $this->annonceTable;
	}
}