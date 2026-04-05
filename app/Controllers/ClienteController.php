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



    public function index()
    {
        $clientes = $this->clienteModel->all('nombre ASC');
        
        $this->view('clientes/index', [
            'clientes' => $clientes,
            'title' => 'Listado de Clientes'
        ]);
    }


    public function create()
    {
        $this->view('clientes/nuevo', [
            'title' => 'Nuevo Cliente'
        ]);
    }


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
    public function editOrden($id)
    {
        $orden = $this->ordenModel->find($id);
        
        if (!$orden) {
            $_SESSION['error'] = 'Orden no encontrada';
            $this->redirect('/RefriLogistk/public/clientes');
        }
        
        $cliente = $this->clienteModel->find($orden['cliente_id']);
        
        $this->view('ordenes/editar', [
            'orden' => $orden,
            'cliente' => $cliente,
            'title' => 'Editar Orden'
        ]);
    }

    public function updateOrden($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/RefriLogistk/public/clientes');
        }
        
        $orden = $this->ordenModel->find($id);
        
        if (!$orden) {
            $_SESSION['error'] = 'Orden no encontrada';
            $this->redirect('/RefriLogistk/public/clientes');
        }
        
        $result = $this->ordenModel->update($id, $_POST);
        
        if ($result) {
            $_SESSION['success'] = 'Orden actualizada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al actualizar la orden';
        }
        
        $this->redirect("/RefriLogistk/public/clientes/ver/{$orden['cliente_id']}");
    }
}