<?php

namespace App\Http\Livewire;
use App\Models\Libro;

use Livewire\Component;

class Libros extends Component
{
    public $libros,$nombre,$autor,$categoria,$precio,$id_libro;
    public $modal = false;

    public function render()
    {
        $this->libros = Libro::all();
        return view('livewire.libros');
    }

    public function crear()
    {
        $this->limpiarCampos();
        $this->abrirModal();
    }

    public function abrirModal()
    {
        $this->modal =true;
    }

    public function cerrarModal()
    {
        $this->modal =false;
    }

    public function limpiarCampos()
    {
        $this->nombre= '';
        $this->autor= '';
        $this->categoria= '';
        $this->precio= '';
        $this->id_libro= '';
    }

    public function editar($id)
    {
        $libro = Libro::findOrFail($id);
        $this->id_libro = $id;
        $this->nombre = $libro->nombre;
        $this->autor = $libro->autor;
        $this->categoria = $libro->categoria;
        $this->precio = $libro->precio;
        $this->abrirModal();
    }
    public function borrar($id)
    {
        Libro::find($id)->delete();
        session()->flash('message','Libro eliminado correctamente');
    }

    public function guardar()
    {
       Libro::updateOrCreate(['id'=>$this->id_libro],
       [
           'nombre'=>$this->nombre,
           'autor'=>$this->autor,
           'categoria'=>$this->categoria,
           'precio'=>$this->precio
       ]);
       session()->flash('message',$this->id_libro ? '¡Libro actualizado!' : '¡Libro agregado!');
       $this->cerrarModal();
       $this->limpiarCampos();
    }
}
