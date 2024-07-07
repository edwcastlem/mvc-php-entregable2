<?php

require_once 'Perfil.php';

class Usuario {
    private int $id;
    private string $nombre;
    private string $apellido;
    private string $dni;
    private string $password;
    private string $email;
    private string $direccion;
    private \DateTime $fechaCreacion;
    private \DateTime $fechaActualizacion;
    private int $perfiles_id;
    private Perfil $perfil;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function getApellido(): string {
        return $this->apellido;
    }

    public function setApellido(string $apellido): void {
        $this->apellido = $apellido;
    }

    public function getDni(): string {
        return $this->dni;
    }

    public function setDni(string $dni): void {
        $this->dni = $dni;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getDireccion(): string {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): void {
        $this->direccion = $direccion;
    }

    public function getFechaCreacion(): \DateTime {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(\DateTime $fechaCreacion): void {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function getFechaActualizacion(): \DateTime {
        return $this->fechaActualizacion;
    }

    public function setFechaActualizacion(\DateTime $fechaActualizacion): void {
        $this->fechaActualizacion = $fechaActualizacion;
    }

    public function getPerfilesId(): int {
        return $this->perfiles_id;
    }

    public function setPerfilesId(int $perfiles_id): void {
        $this->perfiles_id = $perfiles_id;
    }

    public function getPerfil(): Perfil {
        return $this->perfil;
    }

    public function setPerfil(Perfil $perfil) {
        $this->perfil = $perfil;
    }
}