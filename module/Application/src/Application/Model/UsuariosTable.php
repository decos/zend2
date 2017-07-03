<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class UsuariosTable {
    
        protected $tableGateway;

        public function __construct(TableGateway $tableGateway) {
                $this->tableGateway = $tableGateway;
        }
        
        // 1. Entrar al TableGateway
        // 2. Hacer uso de la entidad usuario
        // 3. Hacer un select y sacar todos los registro de esa tabla
        public function fetchAll(){
                $resultSet =  $this->tableGateway->select();
                return $resultSet;
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
                                $return = $this->tableGateway->update($data);
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
