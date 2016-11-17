<?php

namespace Minerva\Collections;

use Minerva\Collections\Basis\Abstractions\AbstractStorage;
use Minerva\Collections\Basis\Interfaces\CollectionInterface;

/**
 * Coleção de dados
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Minerva\Collections
 */
class Collection extends AbstractStorage implements CollectionInterface
{
    /**
     * Adiciona um item na coleção
     *
     * @param $item
     */
    public function add($item)
    {
        $position = $this->count();
        $this->offsetSet($position, $item);
    }

}