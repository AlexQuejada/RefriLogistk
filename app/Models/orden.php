<?php

namespace Models;

use Core\Model;

class Orden extends Model
{
    protected $table = 'ordenes';

    public function getAllWithClientes()
{
    $sql = "SELECT o.*, c.nombre as cliente_nombre 
            FROM ordenes o
            JOIN clientes c ON o.cliente_id = c.id
            ORDER BY o.fecha DESC";
    
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll();
}

/**
 * Obtener una orden con datos del cliente
 */
public function getWithCliente($id)
{
    $sql = "SELECT o.*, c.nombre as cliente_nombre, c.telefono, c.email
            FROM ordenes o
            JOIN clientes c ON o.cliente_id = c.id
            WHERE o.id = :id";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

    /* Crear una nueva orden*/
    public function create($data)
    {
        $sql = "INSERT INTO ordenes (cliente_id, fecha, descripcion, costo) 
                VALUES (:cliente_id, :fecha, :descripcion, :costo)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':cliente_id' => $data['cliente_id'],
            ':fecha' => $data['fecha'],
            ':descripcion' => $data['descripcion'],
            ':costo' => $data['costo'] ?? null
        ]);
    }

    /* Obtener todas las órdenes de un cliente*/
    public function getByCliente($clienteId)
    {
        $sql = "SELECT * FROM ordenes WHERE cliente_id = :cliente_id ORDER BY fecha DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':cliente_id' => $clienteId]);
        return $stmt->fetchAll();
    }

    /* Actualizar una orden existente*/
    public function update($id, $data)
    {
        $sql = "UPDATE ordenes 
                SET fecha = :fecha, descripcion = :descripcion, costo = :costo 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':fecha' => $data['fecha'],
            ':descripcion' => $data['descripcion'],
            ':costo' => $data['costo'] ?? null
        ]);
    }
}