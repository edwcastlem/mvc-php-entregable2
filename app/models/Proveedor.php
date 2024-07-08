<?php

class Proveedor
{
    private int $id;
    private string $ruc;
    private string $razon_social;
    private string $representante_legal;
    private string $email;
    private string $telefono;
    private string $celular;
    private string $direccion;
    private string $cuenta_bancaria;
    private string $cuenta_cci;
    private string $banco;
    private DateTime $fecha_creacion;
    private DateTime $fecha_actualizacion;
    
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }


    public function getRuc(): string {
        return $this->ruc;
    }

    public function setRuc(string $ruc): void {
        $this->ruc = $ruc;
    }

    public function getRazonSocial(): string {
        return $this->razon_social;
    }

    public function setRazonSocial(string $razon_social): void {
        $this->razon_social = $razon_social;
    }

    public function getRepresentanteLegal(): string {
        return $this->representante_legal;
    }

    public function setRepresentanteLegal(string $representante_legal): void {
        $this->representante_legal = $representante_legal;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getTelefono(): string {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): void {
        $this->telefono = $telefono;
    }

    public function getCelular(): string {
        return $this->celular;
    }

    public function setCelular(string $celular): void {
        $this->celular = $celular;
    }

    public function getDireccion(): string {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): void {
        $this->direccion = $direccion;
    }

    public function getCuentaBancaria(): string {
        return $this->cuenta_bancaria;
    }

    public function setCuentaBancaria(string $cuenta_bancaria): void {
        $this->cuenta_bancaria = $cuenta_bancaria;
    }

    public function getCuentaCci(): string {
        return $this->cuenta_cci;
    }

    public function setCuentaCci(string $cuenta_cci): void {
        $this->cuenta_cci = $cuenta_cci;
    }

    public function getBanco(): string {
        return $this->banco;
    }

    public function setBanco(string $banco): void {
        $this->banco = $banco;
    }

    public function getFechaCreacion(): DateTime {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(DateTime $fecha_creacion): void {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function getFechaActualizacion(): DateTime {
        return $this->fecha_actualizacion;
    }

    public function setFechaActualizacion(DateTime $fecha_actualizacion): void {
        $this->fecha_actualizacion = $fecha_actualizacion;
    }
}