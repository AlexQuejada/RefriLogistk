<?php

namespace Models;

use Core\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    public function create($data)
    {
        $sql = "INSERT INTO clientes (nombre, telefono, email, direccion) 
                VALUES (:nombre, :telefono, :email, :direccion)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':telefono' => $data['telefono'] ?? null,
            ':email' => $data['email'] ?? null,
            ':direccion' => $data['direccion'] ?? null
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE clientes 
                SET nombre = :nombre, telefono = :telefono, email = :email, direccion = :direccion 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $data['nombre'],
            ':telefono' => $data['telefono'] ?? null,
            ':email' => $data['email'] ?? null,
            ':direccion' => $data['direccion'] ?? null
        ]);
    }


    public function getWithSummary($id)
    {
        $sql = "SELECT c.*, 
                       COUNT(o.id) as total_ordenes,
                       COALESCE(SUM(o.costo), 0) as total_gastado
                FROM clientes c
                LEFT JOIN ordenes o ON c.id = o.cliente_id
                WHERE c.id = :id
                GROUP BY c.id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getTotalCount()
{
    $stmt = $this->db->query("SELECT COUNT(*) as total FROM clientes");
    return $stmt->fetch()['total'];
}
}