<?php

namespace Controllers;

use Core\Controller;
use Models\Orden;
use Models\Cliente;

class ReporteController extends Controller
{
    private $ordenModel;
    private $clienteModel;

    public function __construct()
    {
        $this->ordenModel = new Orden();
        $this->clienteModel = new Cliente();
    }

    public function index()
    {
        $this->view('reportes/index', [
            'title' => 'Reportes'
        ]);
    }

    public function ordenes()
    {
        $fechaInicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
        $fechaFin = $_GET['fecha_fin'] ?? date('Y-m-t');
        
        $ordenes = $this->ordenModel->getReporteByFechas($fechaInicio, $fechaFin);
        $resumen = $this->ordenModel->getResumenByFechas($fechaInicio, $fechaFin);
        
        $this->view('reportes/ordenes', [
            'title' => 'Reporte de Órdenes',
            'ordenes' => $ordenes,
            'resumen' => $resumen,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin
        ]);
    }

    public function excel()
    {
        $fechaInicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
        $fechaFin = $_GET['fecha_fin'] ?? date('Y-m-t');
        
        $ordenes = $this->ordenModel->getReporteByFechas($fechaInicio, $fechaFin);
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="ordenes_' . $fechaInicio . '_al_' . $fechaFin . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['ID', 'Cliente', 'Fecha', 'Descripción', 'Costo', 'Estado']);
        
        foreach ($ordenes as $orden) {
            fputcsv($output, [
                $orden['id'],
                $orden['cliente_nombre'],
                date('d/m/Y', strtotime($orden['fecha'])),
                $orden['descripcion'],
                $orden['costo'] ? '$' . number_format($orden['costo'], 2) : '-',
                $orden['estado']
            ]);
        }
        
        fclose($output);
        exit;
    }

    public function clientesTop()
    {
        $clientes = $this->clienteModel->getTopClientes(10);
        
        $this->view('reportes/clientes_top', [
            'title' => 'Top Clientes',
            'clientes' => $clientes
        ]);
    }

    public function ingresosMensuales()
    {
        $ingresos = $this->ordenModel->getIngresosMensuales(12);
        
        $this->view('reportes/ingresos_mensuales', [
            'title' => 'Ingresos Mensuales',
            'ingresos' => $ingresos
        ]);
    }
}