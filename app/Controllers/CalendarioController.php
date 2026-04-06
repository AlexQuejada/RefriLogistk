<?php

namespace Controllers;

use Core\Controller;
use Models\Orden;
use Models\Cliente;
use Exception;

class CalendarioController extends Controller
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
        $pendientes = $this->ordenModel->getPendientes();
        $estadisticas = $this->ordenModel->getEstadisticas();
        $clientes = $this->clienteModel->all('nombre ASC');
        
        $this->view('calendario/index', [
            'title' => 'Calendario',
            'pendientes' => $pendientes,
            'estadisticas' => $estadisticas,
            'clientes' => $clientes
        ]);
    }


    public function eventos()
    {

        if (ob_get_length()) ob_clean();
        
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');
        
        try {
            $start = $_GET['start'] ?? date('Y-m-01');
            $end = $_GET['end'] ?? date('Y-m-t');
            
            $ordenes = $this->ordenModel->getBetweenDates($start, $end);
            
            $eventos = [];
            foreach ($ordenes as $orden) {
                $color = match($orden['estado']) {
                    'pendiente' => '#ffc107',
                    'realizada' => '#198754',
                    'cancelada' => '#dc3545',
                    default => '#0d6efd'
                };
                
                $textColor = match($orden['estado']) {
                    'pendiente' => '#000000',
                    default => '#ffffff'
                };
                
                $eventos[] = [
                    'id' => $orden['id'],
                    'title' => htmlspecialchars($orden['cliente_nombre'] . ': ' . substr($orden['descripcion'], 0, 25)),
                    'start' => $orden['fecha'],
                    'color' => $color,
                    'textColor' => $textColor,
                    'estado' => $orden['estado'],
                    'url' => '/RefriLogistk/public/ordenes/ver/' . $orden['id']
                ];
            }
            
            $json = json_encode($eventos);
            
            if ($json === false) {
                echo json_encode(['error' => 'JSON encoding failed']);
            } else {
                echo $json;
            }
            
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        
        exit;
    }


    public function agendar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/RefriLogistk/public/calendario');
        }
        
        $result = $this->ordenModel->create([
            'cliente_id' => $_POST['cliente_id'],
            'fecha' => $_POST['fecha'],
            'descripcion' => $_POST['descripcion'],
            'costo' => $_POST['costo'] ?? null
        ]);
        
        if ($result) {
            $_SESSION['success'] = 'Servicio agendado correctamente';
        } else {
            $_SESSION['error'] = 'Error al agendar el servicio';
        }
        
        $this->redirect('/RefriLogistk/public/calendario');
    }


    public function cambiarEstado($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/RefriLogistk/public/calendario');
        }
        
        $orden = $this->ordenModel->find($id);
        
        if (!$orden) {
            $_SESSION['error'] = 'Orden no encontrada';
            $this->redirect('/RefriLogistk/public/calendario');
        }
        
        $result = $this->ordenModel->cambiarEstado($id, $_POST['estado']);
        
        if ($result) {
            $_SESSION['success'] = 'Estado actualizado correctamente';
        } else {
            $_SESSION['error'] = 'Error al actualizar el estado';
        }
        
        $this->redirect('/RefriLogistk/public/calendario');
    }
}