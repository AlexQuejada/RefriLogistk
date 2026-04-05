<?php

namespace Controllers;

use Core\Controller;
use Models\Cliente;
use Models\Orden;

class ClienteController extends Controller
{
    private $clienteModel;
    private $ordenModel;

    public function __construct()
    {
        $this->clienteModel = new Cliente();
        $this->ordenModel = new Orden();
    }

    /**
     * GET /clientes
     * Listar todos los clientes
     */
    public function index()
    {
        $clientes = $this->clienteModel->all('nombre ASC');
        
        $this->view('clientes/index', [
            'clientes' => $clientes,
            'title' => 'Listado de Clientes'
        ]);
    }

    /**
     * GET /clientes/nuevo
     * Mostrar formulario para crear cliente
     */
    public function create()
    {
        $this->view('clientes/nuevo', [
            'title' => 'Nuevo Cliente'
        ]);
    }

    /**
     * POST /clientes/nuevo
     * Guardar nuevo cliente
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/RefriLogistk/public/clientes');
        }

        $result = $this->clienteModel->create($_POST);
        
        if ($result) {
            $_SESSION['success'] = 'Cliente creado exitosamente';
            $this->redirect('/RefriLogistk/public/clientes');
        } else {
            $_SESSION['error'] = 'Error al crear el cliente';
            $this->redirect('/RefriLogistk/public/clientes/nuevo');
        }
    }

    /**
     * GET /clientes/ver/{id}
     * Ver detalle de un cliente con su historial
     */
    public function show($id)
    {
        $cliente = $this->clienteModel->getWithSummary($id);
        
        if (!$cliente) {
            $_SESSION['error'] = 'Cliente no encontrado';
            $this->redirect('/RefriLogistk/public/clientes');
        }
        
        $ordenes = $this->ordenModel->getByCliente($id);
        
        $this->view('clientes/ver', [
            'cliente' => $cliente,
            'ordenes' => $ordenes,
            'title' => $cliente['nombre']
        ]);
    }

    /**
     * GET /clientes/editar/{id}
     * Mostrar formulario para editar cliente
     */
    public function edit($id)
    {
        $cliente = $this->clienteModel->find($id);
        
        if (!$cliente) {
            $_SESSION['error'] = 'Cliente no encontrado';
            $this->redirect('/RefriLogistk/public/clientes');
        }
        
        $this->view('clientes/editar', [
            'cliente' => $cliente,
            'title' => 'Editar Cliente'
        ]);
    }

    /**
     * POST /clientes/editar/{id}
     * Actualizar cliente
     */
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/RefriLogistk/public/clientes');
        }

        $result = $this->clienteModel->update($id, $_POST);
        
        if ($result) {
            $_SESSION['success'] = 'Cliente actualizado exitosamente';
            $this->redirect("/RefriLogistk/public/clientes/ver/{$id}");
        } else {
            $_SESSION['error'] = 'Error al actualizar el cliente';
            $this->redirect("/RefriLogistk/public/clientes/editar/{$id}");
        }
    }

    /**
     * GET /clientes/eliminar/{id}
     * Eliminar cliente
     */
    public function destroy($id)
    {
        $result = $this->clienteModel->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'Cliente eliminado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar el cliente';
        }
        
        $this->redirect('/RefriLogistk/public/clientes');
    }

    /**
     * POST /ordenes/guardar
     * Guardar nueva orden de servicio
     */
    public function storeOrden()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/RefriLogistk/public/clientes');
        }

        $result = $this->ordenModel->create($_POST);
        
        if ($result) {
            $_SESSION['success'] = 'Orden de servicio agregada';
        } else {
            $_SESSION['error'] = 'Error al agregar la orden';
        }
        
        $this->redirect("/RefriLogistk/public/clientes/ver/{$_POST['cliente_id']}");
    }

    /**
     * GET /ordenes/eliminar/{id}
     * Eliminar una orden de servicio
     */
    public function destroyOrden($id)
    {
        $orden = $this->ordenModel->find($id);
        
        if ($orden) {
            $clienteId = $orden['cliente_id'];
            $result = $this->ordenModel->delete($id);
            
            if ($result) {
                $_SESSION['success'] = 'Orden eliminada';
            } else {
                $_SESSION['error'] = 'Error al eliminar la orden';
            }
            
            $this->redirect("/RefriLogistk/public/clientes/ver/{$clienteId}");
        } else {
            $_SESSION['error'] = 'Orden no encontrada';
            $this->redirect('/RefriLogistk/public/clientes');
        }
    }
}