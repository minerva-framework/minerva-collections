<?php

namespace Minerva\Collections;

use Minerva\Collections\Basis\Abstractions\AbstractStorage;
use Minerva\Collections\Basis\Exceptions\InvalidOffsetTypeException;
use Minerva\Collections\Basis\Exceptions\MaxCapacityReachedException;
use Minerva\Collections\Basis\Exceptions\OverrideOperationException;
use Minerva\Collections\Basis\Exceptions\ReadOnlyStorageException;
use Minerva\Collections\Basis\Interfaces\DictionaryInterface;

/**
 * Dicionário de dados
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Minerva\Collections
 */
class Dictionary extends AbstractStorage implements DictionaryInterface
{
    /**
     * Define se o override de dados é permitido
     *
     * @var bool
     */
    protected $overrideAllowed = true;

    /**
     * Retorna se a classe permite override
     *
     * @return boolean
     */
    public function isOverrideAllowed()
    {
        return $this->overrideAllowed;
    }

    /**
     * Define o comportamento do objeto acerca do override
     *
     * @param boolean $overrideAllowed
     */
    public function setOverrideAllowed($overrideAllowed)
    {
        $this->overrideAllowed = $overrideAllowed;
    }

    /**
     * Define um valor para uma chave
     *
     * Esse método tem por finalidade apenas adicionar uma especialização
     * para os contextos de utilização de um dicionário de dados.
     *
     * @param mixed $offset
     * @param mixed $value
     * @throws InvalidOffsetTypeException
     * @throws MaxCapacityReachedException
     * @throws ReadOnlyStorageException
     * @throws OverrideOperationException
     */
    public function offsetSet($offset, $value)
    {
        if($this->offsetExists($offset) && !$this->isOverrideAllowed())
            throw new OverrideOperationException();
        
        
        parent::offsetSet($offset, $value);
    }

    /**
     * Retorna a chave do elemento atual no dicionário
     *
     * @return int|float|bool|string
     */
    public function key()
    {
        $keys = [];
        
        foreach ($this->storage as $key => $item){
            $keys[] = $key;
        }
        
        if(isset($keys[$this->current]))
            return $keys[$this->current];
    }

    /**
     * Retorna o elemento atual
     *
     * @return mixed
     */
    public function current()
    {
        return $this->storage[$this->key()];
    }

    /**
     * Verifica se a posição atual é válida
     *
     * @return bool
     */
    public function valid()
    {
        return isset($this->storage[$this->key()]);
    }
}