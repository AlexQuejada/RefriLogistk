<?php

namespace Models;

use Core\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    public function findByUsername($username)
    {
        $sql = "SELECT * FROM usuarios WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch();
    }

    public function updatePerfil($id, $data)
    {
        $sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $data['nombre'],
            ':email' => $data['email']
        ]);
    }

    public function cambiarPassword($id, $passwordActual, $passwordNueva)
    {
        $usuario = $this->find($id);
        
        if (!$usuario || !password_verify($passwordActual, $usuario['password'])) {
            return false;
        }
        
        $hashedPassword = password_hash($passwordNueva, PASSWORD_DEFAULT);
        
        $sql = "UPDATE usuarios SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':password' => $hashedPassword
        ]);
    }

    public function updateUltimoAcceso($id)
    {
        $sql = "UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}