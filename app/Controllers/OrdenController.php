<?php

namespace Controllers;

use Core\Controller;
use Models\Orden;
use Models\Cliente;

class OrdenController extends Controller
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
        $ordenes = $this->ordenModel->getAllWithClientes();
        
        $this->view('ordenes/index', [
            'ordenes' => $ordenes,
            'title' => 'Todas las Órdenes'
        ]);
    }

    public function create()
    {
        $clientes = $this->clienteModel->all('nombre ASC');
        
        $this->view('ordenes/nuevo', [
            'clientes' => $clientes,
            'title' => 'Nueva Orden de Servicio'
        ]);
    }

    public function cambiarEstado()
    {
        // Verificar autenticación
        $this->requireAuth();
        
        // Solo POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            return;
        }
        
        // Obtener datos
        $id = $_POST['id'] ?? 0;
        $estado = $_POST['estado'] ?? '';
        
        // Validar
        $estadosValidos = ['pendiente', 'realizada', 'cancelada'];
        if (!$id || !in_array($estado, $estadosValidos)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
            return;
        }
        
        // Cambiar estado
        $result = $this->ordenModel->cambiarEstado($id, $estado);
        
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/RefriLogistk/public/ordenes');
        }

        $result = $this->ordenModel->create($_POST);
        
        if ($result) {
            $_SESSION['success'] = 'Orden de servicio creada exitosamente';
            $this->redirect('/RefriLogistk/public/ordenes');
        } else {
            $_SESSION['error'] = 'Error al crear la orden';
            $this->redirect('/RefriLogistk/public/ordenes/nuevo');
        }
    }


    public function show($id)
    {
        $orden = $this->ordenModel->getWithCliente($id);
        
        if (!$orden) {
            $_SESSION['error'] = 'Orden no encontrada';
            $this->redirect('/RefriLogistk/public/ordenes');
        }
        
        $this->view('ordenes/ver', [
            'orden' => $orden,
            'title' => 'Detalle de Orden'
        ]);
    }


    public function edit($id)
    {
        $orden = $this->ordenModel->find($id);
        
        if (!$orden) {
            $_SESSION['error'] = 'Orden no encontrada';
            $this->redirect('/RefriLogistk/public/ordenes');
        }
        
        $clientes = $this->clienteModel->all('nombre ASC');
        
        $this->view('ordenes/editar', [
            'orden' => $orden,
            'clientes' => $clientes,
            'title' => 'Editar Orden'
        ]);
    }


    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/RefriLogistk/public/ordenes');
        }
        
        $orden = $this->ordenModel->find($id);
        
        if (!$orden) {
            $_SESSION['error'] = 'Orden no encontrada';
            $this->redirect('/RefriLogistk/public/ordenes');
        }
        
        $result = $this->ordenModel->update($id, $_POST);
        
        if ($result) {
            $_SESSION['success'] = 'Orden actualizada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al actualizar la orden';
        }
        
        $this->redirect('/RefriLogistk/public/ordenes');
    }


    public function destroy($id)
    {
        $orden = $this->ordenModel->find($id);
        
        if (!$orden) {
            $_SESSION['error'] = 'Orden no encontrada';
            $this->redirect('/RefriLogistk/public/ordenes');
        }
        
        $result = $this->ordenModel->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'Orden eliminada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar la orden';
        }
        
        $this->redirect('/RefriLogistk/public/ordenes');
    }
}