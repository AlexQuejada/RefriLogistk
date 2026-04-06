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

    public function getByCliente($clienteId)
    {
        $sql = "SELECT * FROM ordenes WHERE cliente_id = :cliente_id ORDER BY fecha DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':cliente_id' => $clienteId]);
        return $stmt->fetchAll();
    }

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

    public function getCountByCurrentMonth()
    {
        $sql = "SELECT COUNT(*) as total FROM ordenes 
                WHERE MONTH(fecha) = MONTH(CURDATE()) 
                AND YEAR(fecha) = YEAR(CURDATE())";
        $stmt = $this->db->query($sql);
        return $stmt->fetch()['total'];
    }

    public function getIngresosCurrentMonth()
    {
        $sql = "SELECT COALESCE(SUM(costo), 0) as total FROM ordenes 
                WHERE MONTH(fecha) = MONTH(CURDATE()) 
                AND YEAR(fecha) = YEAR(CURDATE())";
        $stmt = $this->db->query($sql);
        return $stmt->fetch()['total'];
    }

    public function getCountByToday()
    {
        $sql = "SELECT COUNT(*) as total FROM ordenes WHERE fecha = CURDATE()";
        $stmt = $this->db->query($sql);
        return $stmt->fetch()['total'];
    }

    public function getChartData()
    {
        $sql = "SELECT 
                    DATE_FORMAT(fecha, '%Y-%m') as mes,
                    COUNT(*) as cantidad,
                    COALESCE(SUM(costo), 0) as ingresos
                FROM ordenes 
                WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 5 MONTH)
                GROUP BY DATE_FORMAT(fecha, '%Y-%m')
                ORDER BY mes ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getLatest($limit = 5)
    {
        $sql = "SELECT o.*, c.nombre as cliente_nombre 
                FROM ordenes o
                JOIN clientes c ON o.cliente_id = c.id
                ORDER BY o.fecha DESC
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUpcoming($dias = 7)
    {
        $sql = "SELECT o.*, c.nombre as cliente_nombre, c.telefono
                FROM ordenes o
                JOIN clientes c ON o.cliente_id = c.id
                WHERE o.fecha > CURDATE() 
                AND o.fecha <= DATE_ADD(CURDATE(), INTERVAL :dias DAY)
                ORDER BY o.fecha ASC
                LIMIT 5";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':dias', $dias, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getBetweenDates($start, $end)
{
    $sql = "SELECT o.*, c.nombre as cliente_nombre, c.telefono
            FROM ordenes o
            JOIN clientes c ON o.cliente_id = c.id
            WHERE o.fecha BETWEEN :start AND :end
            ORDER BY o.fecha ASC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':start' => $start, ':end' => $end]);
    return $stmt->fetchAll();
}


    public function cambiarEstado($id, $estado)
    {
        $sql = "UPDATE ordenes SET estado = :estado WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id, ':estado' => $estado]);
    }

    public function getPendientes()
    {
        $sql = "SELECT o.*, c.nombre as cliente_nombre, c.telefono
                FROM ordenes o
                JOIN clientes c ON o.cliente_id = c.id
                WHERE o.estado = 'pendiente' AND o.fecha >= CURDATE()
                ORDER BY o.fecha ASC
                LIMIT 10";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getEstadisticas()
    {
        $sql = "SELECT 
                    COUNT(CASE WHEN estado = 'pendiente' THEN 1 END) as pendientes,
                    COUNT(CASE WHEN estado = 'realizada' THEN 1 END) as realizadas,
                    COUNT(CASE WHEN estado = 'cancelada' THEN 1 END) as canceladas,
                    COUNT(CASE WHEN fecha = CURDATE() AND estado = 'pendiente' THEN 1 END) as hoy
                FROM ordenes";
        $stmt = $this->db->query($sql);
        return $stmt->fetch();
    }
}
