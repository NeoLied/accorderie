<?php
namespace Utilisateur\Model;

use Zend\Db\TableGateway\TableGateway;

class UtilisateurTable
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

	public function getUtilisateur($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveUtilisateur(Utilisateur $utilisateur)
	{
		$data = array(
				'artist' => $utilisateur->artist,
				'title'  => $utilisateur->title,
		);

		$id = (int) $utilisateur->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getUtilisateur($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Utilisateur id does not exist');
			}
		}
	}

	public function deleteUtilisateur($id)
	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}
}