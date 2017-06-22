<?php

namespace Application\Model;

class Usuario{
        
        public $id, $name, $surname, $description, $email, $password, $image, $alternative;

        public function exchangeArray($data){
                //En lugar de GETTER o SETTER se utiliza la sgte forma
            
                $this->id = (!empty($data['id']) ? $data['id'] : null );
                $this->name = (!empty($data['name']) ? $data['name'] : null );
                $this->surname = (!empty($data['surname']) ? $data['surname'] : null );
                $this->description = (!empty($data['description']) ? $data['description'] : null );
                $this->email = (!empty($data['email']) ? $data['email'] : null );
                $this->password = (!empty($data['password']) ? $data['id'] : null );
                $this->image = (!empty($data['image']) ? $data['image'] : null );
                $this->alternative = (!empty($data['alternative']) ? $data['alternative'] : null );
        }
}