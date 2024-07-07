<?php

class Categoria 
{
    // atributos
    private int $id;
    private string $nombre;

    // getters y setters
    public function getId(): int 
    {
        return $this->id;        
    }

    public function setId(int $id): void 
    {
        $this->id = $id;
    }

    public function getNombre(): string 
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }
}