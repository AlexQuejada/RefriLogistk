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
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/RefriLogistk/public/ordenes/nuevo');
        }
        
        $precioNormal = $_POST['precio_normal'] ?? null;
        $descuento = $_POST['descuento'] ?? null;
        
        // El precio final se calcula o viene del formulario
        $precioFinal = $_POST['precio_final'] ?? null;
        
        // Si no enviaron precio_final, lo calculamos
        if ($precioFinal === null && $precioNormal !== null && $descuento !== null) {
            $precioFinal = $precioNormal - $descuento;
        }
        
        // IMPORTANTE: costo = precio_final
        $costo = $precioFinal;
        
        $data = [
            'cliente_id' => $_POST['cliente_id'],
            'fecha' => $_POST['fecha'],
            'descripcion' => $_POST['descripcion'],
            'precio_normal' => $precioNormal,
            'descuento' => $descuento,
            'costo' => $costo  // ← Guarda lo mismo que precio_final
        ];
        
        $result = $this->ordenModel->create($data);
        
        if ($result) {
            $_SESSION['success'] = 'Orden creada correctamente';
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
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/RefriLogistk/public/ordenes/editar/' . $id);
        }
        
        $precioNormal = $_POST['precio_normal'] ?? null;
        $descuento = $_POST['descuento'] ?? null;
        $precioFinal = $_POST['precio_final'] ?? null;
        
        if ($precioFinal === null && $precioNormal !== null && $descuento !== null) {
            $precioFinal = $precioNormal - $descuento;
        }
        
        // costo = precio_final
        $costo = $precioFinal;
        
        $data = [
            'cliente_id' => $_POST['cliente_id'],
            'fecha' => $_POST['fecha'],
            'descripcion' => $_POST['descripcion'],
            'precio_normal' => $precioNormal,
            'descuento' => $descuento,
            'costo' => $costo
        ];
        
        $result = $this->ordenModel->update($id, $data);
        
        if ($result) {
            $_SESSION['success'] = 'Orden actualizada correctamente';
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