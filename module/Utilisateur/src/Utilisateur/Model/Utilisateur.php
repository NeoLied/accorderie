<?php
namespace Utilisateur\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Utilisateur implements InputFilterAwareInterface
{
	public $id;
	public $nom;
	public $prenom;
	public $mail;
	public $adresse;
	public $code_postal;
	public $telephone;
	
	protected $inputFilter;
	private $_dbAdapter;
	
	public function exchangeArray($data)
	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->nom  = (!empty($data['nom'])) ? $data['nom'] : null;
		$this->prenom  = (!empty($data['prenom'])) ? $data['prenom'] : null;
		$this->mail  = (!empty($data['mail'])) ? $data['mail'] : null;
		$this->adresse  = (!empty($data['adresse'])) ? $data['adresse'] : null;
		$this->code_postal  = (!empty($data['code_postal'])) ? $data['code_postal'] : null;
		$this->telephone  = (!empty($data['telephone'])) ? $data['telephone'] : null;
	}
	
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	
	public function setDbAdapter($dbAdapter) {
		$this->_dbAdapter = $dbAdapter;
	}
	
	public function getDbAdapter() {
		return $this->_dbAdapter;
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}
	
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
	
			$inputFilter->add(array(
					'name'     => 'id',
					'required' => true,
					'filters'  => array(
							array('name' => 'Int'),
					),
			));
			
			$inputFilter->add(array(
					'name'     => 'nom',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			));
			
			$inputFilter->add(array(
					'name'     => 'prenom',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			));
			
			$inputFilter->add(array(
					'name'     => 'adresse',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			));
			
			$inputFilter->add(array(
					'name'     => 'code_postal',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 5,
											'max'      => 5,
									),
							),
							array(
									'name'    => 'Digits',
									),
							),
			));
			
			$inputFilter->add(array(
					'name'     => 'telephone',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 10,
											'max'      => 10,
									),
							),
							array(
									'name'    => 'Digits',
							),
					),
			));
			
			$inputFilter->add(array(
					'name'     => 'mail',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
							
							array(
									'name'    => 'EmailAddress',
							),							
					
							array(
                     	 		'name'    => 'Db\NoRecordExists',
                      			'options' => array(
                        			'table' => 'utilisateur',
                        			'field' => 'mail',
                      				'adapter' => $this->_dbAdapter,
                        			'messages' => array(
                            			'recordFound'   => "Email already exist ... !",  
                        			),
                    			),
                			),
					),
							
			));
	
			$this->inputFilter = $inputFilter;
		}
	
		return $this->inputFilter;
	}
}