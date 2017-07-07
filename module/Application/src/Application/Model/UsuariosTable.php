<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

//CONSULTAS SQL NATIVO
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;

//CONVERTIR UN ARRAY DEL COMPONENTE RESULT SET EN UN ARRAY DE OBJETOS
use Zend\Db\ResultSet\ResultSet;

class UsuariosTable {
    
        protected $tableGateway;
        //CONSULTAS SQL NATIVO
        protected $dbAdapter;

        public function __construct(TableGateway $tableGateway) {
                $this->tableGateway = $tableGateway;
                //CONSULTAS SQL NATIVO
                $this->dbAdapter = $tableGateway->adapter;
        }
        
        // 1. Entrar al TableGateway
        // 2. Hacer uso de la entidad usuario
        // 3. Hacer un select y sacar todos los registro de esa tabla
        public function fetchAll(){
                $resultSet =  $this->tableGateway->select();
                return $resultSet;
        }
        
        //CONSULTAS SQL NATIVO
        public function fetchAllSql(){
                /*$query = $this->dbAdapter->createStatement("SELECT * FROM usuarios;");
                $data = $query->execute();
                return $data;
                
                //Es lo mismo hacer esto
                $consulta = $this->dbAdapter->query("SELECT * FROM usuarios", Adapter::QUERY_MODE_EXECUTE);
                $datos = $consulta->toArray();
                return $datos;*/
            
                //QUERY BUILDER (array)
                $sql = new SQL($this->dbAdapter);
                $select = $sql->select();
                $select->from("usuarios");
                
                $statement = $sql->prepareStatementForSqlObject($select);
                $data = $statement->execute();
                
                //CONVERTIR UN ARRAY DEL COMPONENTE RESULT SET EN UN ARRAY DE OBJETOS
                $resultSet = new ResultSet();
                $data = $resultSet->initialize($data);
                //
                
                return $data;
        }
        
        // Obtener un solo usuario
        public function getUsuario($id){
                $id = (int) $id;
                
                $rowset = $this->tableGateway->select(array("id" => $id));
                $row = $rowset->current();
                
                return  $row;
        }
        
         // Obtener un solo usuario por correo
        public function getUsuarioByEmail($email){
                
                $rowset = $this->tableGateway->select(array("email" => $email));
                $row = $rowset->current();
                
                return  $row;
        }
        
        public function saveUsuario(Usuario $usuario){
                $data = array(
                        "name" => $usuario->name,
                        "surname" => $usuario->surname,
                        "description" => $usuario->description,
                        "email" => $usuario->email,
                        "password" => $usuario->password,
                        "image" => $usuario->image,
                        "alternative" => $usuario->alternative,
                );
                
                $id = (int) $usuario->id;
                
                if($id==0){
                        $return = $this->tableGateway->insert($data);
                } else {
                        if($this->getUsuario($id)){
                                $return = $this->tableGateway->update($data, array("id" => $id));
                        } else{
                            throw new \Exception("El usuario no existe");
                        }
                }
                
                return $return;
        }
    
        public function deleteUsuario($id){
                $delete  = $this->tableGateway->delete(array("id" => $id));
        
                return $delete;
        }
}
