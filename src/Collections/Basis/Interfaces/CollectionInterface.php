<?php

namespace Minerva\Collections\Basis\Interfaces;

/**
 * Interface CollectionInterface
 * 
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Minerva\Collections\Interfaces
 */
interface CollectionInterface extends StorageInterface
{
    /**
     * Adiciona um item na coleção
     *
     * @param $item
     * @return void
     */
    public function add($item);
}