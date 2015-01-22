<?php 
namespace Utilisateur\Form;

 use Zend\Form\Form;

 class UtilisateurForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('utilisateur');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         
         $this->add(array(
         		'name' => 'nom',
         		'type' => 'Text',
         		'options' => array(
         				'label' => 'Nom',
         		),
         ));
         
         $this->add(array(
         		'name' => 'prenom',
         		'type' => 'Text',
         		'options' => array(
         				'label' => 'Prénom',
         		),
         ));
         
         $this->add(array(
         		'name' => 'telephone',
         		'type' => 'Text',
         		'options' => array(
         				'label' => 'Téléphone',
         		),
         ));
         
         $this->add(array(
         		'name' => 'mail',
         		'type' => 'Text',
         		'options' => array(
         				'label' => 'Adresse Mail',
         		),
         ));
         
         $this->add(array(
         		'name' => 'adresse',
         		'type' => 'Text',
         		'options' => array(
         				'label' => 'Adresse',
         		),
         ));
         
         $this->add(array(
         		'name' => 'code_postal',
         		'type' => 'Text',
         		'options' => array(
         				'label' => 'Code Postal',
         		),
         ));
         
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }