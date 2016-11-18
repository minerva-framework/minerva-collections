<?php

namespace Minerva\Collections;

use Minerva\Collections\Basis\Abstractions\AbstractStorage;
use Minerva\Collections\Basis\Exceptions\InvalidOffsetTypeException;
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

    /**
     * Especialização do offset
     *
     * Pela regra da coleção os seus elementos só podem
     * ter chaves de contagem inteira progressiva. Por exemplo
     * 0, 1, 2, 3, 4, 5. Não pode fugir ao padrão progressivo.
     *
     * @param mixed $offset
     * @param mixed $value
     * @throws Basis\Exceptions\InvalidOffsetTypeException
     * @throws Basis\Exceptions\MaxCapacityReachedException
     * @throws Basis\Exceptions\ReadOnlyStorageException
     */
    public function offsetSet($offset, $value)
    {
        if(!is_int($offset))
            throw new InvalidOffsetTypeException("Apenas inteiros são permitidos");

        parent::offsetSet($offset, $value);
    }
}