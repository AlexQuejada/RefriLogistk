<?php

namespace Controllers;

use Core\Controller;
use Models\Cliente;
use Models\Orden;

class DashboardController extends Controller
{
    private $clienteModel;
    private $ordenModel;

    public function __construct()
    {
        $this->clienteModel = new Cliente();
        $this->ordenModel = new Orden();
    }


    public function index()
    {
        $totalClientes = $this->clienteModel->getTotalCount();
        $ordenesMes = $this->ordenModel->getCountByCurrentMonth();
        $ingresosMes = $this->ordenModel->getIngresosCurrentMonth();
        $ordenesHoy = $this->ordenModel->getCountByToday();
        
        $datosGrafico = $this->ordenModel->getChartData();
        
        $ultimasOrdenes = $this->ordenModel->getLatest(5);
        
        $proximosServicios = $this->ordenModel->getUpcoming(7);
        
        $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'totalClientes' => $totalClientes,
            'ordenesMes' => $ordenesMes,
            'ingresosMes' => $ingresosMes,
            'ordenesHoy' => $ordenesHoy,
            'datosGrafico' => $datosGrafico,
            'ultimasOrdenes' => $ultimasOrdenes,
            'proximosServicios' => $proximosServicios
        ]);
    }
}