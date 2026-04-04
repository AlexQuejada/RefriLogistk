<?php

namespace Models;

use Core\Model;

class Orden extends Model
{
    protected $table = 'ordenes';

    /**
     * Crear una nueva orden
     */
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

    /**
     * Obtener todas las órdenes de un cliente
     */
    public function getByCliente($clienteId)
    {
        $sql = "SELECT * FROM ordenes WHERE cliente_id = :cliente_id ORDER BY fecha DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':cliente_id' => $clienteId]);
        return $stmt->fetchAll();
    }
}