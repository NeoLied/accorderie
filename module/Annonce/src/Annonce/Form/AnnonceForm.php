<?php 
namespace Annonce\Form;

 use Zend\Form\Form;

 class AnnonceForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('annonce');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'titre',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Titre',
             ),
         ));
         $this->add(array(
             'name' => 'description',
             'type' => 'TextArea',
             'options' => array(
                 'label' => 'description',
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