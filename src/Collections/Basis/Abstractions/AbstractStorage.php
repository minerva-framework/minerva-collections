<?php

namespace Minerva\Collections\Basis\Abstractions;

use Minerva\Collections\Basis\Exceptions\InvalidCapacityException;
use Minerva\Collections\Basis\Exceptions\InvalidOffsetException;
use Minerva\Collections\Basis\Exceptions\InvalidOffsetTypeException;
use Minerva\Collections\Basis\Exceptions\MaxCapacityReachedException;
use Minerva\Collections\Basis\Interfaces\StorageInterface;
use Minerva\Collections\Basis\Exceptions\ReadOnlyStorageException;

/**
 * Implementação abstrata do storage
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Minerva\Collections\Basis\Abstractions
 */
abstract class AbstractStorage implements StorageInterface
{
    /**
     * Array onde os dados serão armazenados
     *
     * @var array
     */
    protected $storage = array();

    /**
     * Elemento atual em operação
     *
     * @var int
     */
    protected $current = 0;

    /**
     * Define se o storage é apenas para leitura
     *
     * @var bool
     */
    private $readOnly = false;

    /**
     * Define a capacidade máxima do storage
     *
     * @var int|null
     */
    private $capacity = null;

    /**
     * Valida um offset
     *
     * @param $offset
     * @throws InvalidOffsetTypeException
     */
    private function validateOffsetType($offset)
    {
        if(!is_bool($offset) && !is_int($offset) && !is_float($offset) && !is_string($offset))
            throw new InvalidOffsetTypeException();
    }


    /**
     * @return boolean
     */
    public function isReadOnly()
    {
        return $this->readOnly;
    }

    /**
     * Fecha a coleção para apenas leitura
     */
    public function lock()
    {
        $this->readOnly = true;
    }

    /**
     * @return int|null
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param int|null $capacity
     * @throws InvalidCapacityException
     */
    public function setCapacity($capacity)
    {
        if(!is_int($capacity))
            throw new InvalidCapacityException();

        if($this->count() > $capacity)
            throw new InvalidCapacityException();

        $this->capacity = $capacity;
    }

    /**
     * Executa callback para cada elemento armazenado
     *
     * @param callable $callback
     * @return void
     */
    public function each(callable $callback)
    {
        foreach ($this->storage as $key => $item)
            $callback($item, $key);
    }

    /**
     * Filtra elementos armazenados de acordo com callback
     *
     * @param callable $callback
     * @return StorageInterface
     */
    public function filter(callable $callback)
    {
        $storage = clone $this;
        $storage->clear();

        $this->each(function($item, $key) use(&$storage, $callback){
            if($callback($item, $key) === true)
                $storage[$key] = $item;
        });

        return $storage;
    }

    /**
     * Copia o conteúdo do storage para dentro de outra array ou storage
     *
     * @param $array
     * @param bool $override
     */
    public function copyTo(&$array, $override = true)
    {
        $this->each(function($item, $key) use(&$array, $override){
            if(!$override && isset($array[$key]))
                return ;

           $array[$key] = $item;
        });
    }

    /**
     * Limpa o storage completamente
     *
     * @throws ReadOnlyStorageException
     */
    public function clear()
    {
        if($this->isReadOnly())
            throw new ReadOnlyStorageException();

        $this->storage = array();
    }

    /**
     * Retorna o número de elementos armazenados
     *
     * @return int
     */
    public function count()
    {
        return count($this->storage);
    }

    /**
     * Return the current element
     *
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->storage[$this->current];
    }

    /**
     * Move forward to next element
     *
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        ++$this->current;
    }

    /**
     * Return the key of the current element
     *
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->current;
    }

    /**
     * Checks if current position is valid
     *
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->storage[$this->current]);
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->current = 0;
    }

    /**
     * Whether a offset exists
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->storage[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @throws InvalidOffsetException
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        if(!$this->offsetExists($offset))
            throw new InvalidOffsetException();

        return $this->storage[$offset];
    }

    /**
     * Offset to set
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @throws InvalidOffsetTypeException
     * @throws MaxCapacityReachedException
     * @throws ReadOnlyStorageException
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if($this->isReadOnly())
            throw new ReadOnlyStorageException();

        if($this->count() === $this->getCapacity())
            throw new MaxCapacityReachedException();

        $this->validateOffsetType($offset);
        $this->storage[$offset] = $value;
    }

    /**
     * Offset to unset
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @throws InvalidOffsetException
     * @throws ReadOnlyStorageException
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        if(!$this->offsetExists($offset))
            throw new InvalidOffsetException();

        if($this->isReadOnly())
            throw new ReadOnlyStorageException();

        $this->validateOffsetType($offset);
        unset($this->storage[$offset]);
    }

    /**
     * Converte o objeto para array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->storage;
    }
}