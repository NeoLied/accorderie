<?php
namespace Annonce\Model;

use Zend\Db\TableGateway\TableGateway;

class AnnonceTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function getAnnonce($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveAnnonce(Annonce $annonce)
	{
		$data = array(
				'titre' => $annonce->titre,
				'description'  => $annonce->description,
		);

		$id = (int) $annonce->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getAnnonce($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Annonce id does not exist');
			}
		}
	}

	public function deleteAnnonce($id)
	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}
}