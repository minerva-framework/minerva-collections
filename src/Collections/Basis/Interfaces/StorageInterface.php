<?php

namespace Minerva\Collections\Basis\Interfaces;

use \ArrayAccess;
use \Iterator;

/**
 * Interface StorageInterface
 *
 * Essa interface é de implementação obrigatória para qualquer classe de
 * objetos que irá realizar a função de armazenar dados. A implementação
 * obrigatória do Iterator serve para forçar a classe a ser transversal
 * e percorrível por loops do tipo foreach.
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Minerva\Collections\Interfaces
 */
interface StorageInterface extends ArrayAccess, Iterator
{
    /**
     * Retorna se o storage é apenas para leitura
     *
     * @return bool
     */
    public function isReadOnly();

    /**
     * Fecha a coleção para apenas leitura
     */
    public function lock();

    /**
     * Retorna o número de elementos que pode armazenar
     *
     * @return int
     */
    public function getCapacity();

    /**
     * Define o número de elementos que se pode armazenar
     *
     * @param $capacity
     */
    public function setCapacity($capacity);

    /**
     * Executa callback para cada elemento armazenado
     *
     * @param callable $callback
     * @return void
     */
    public function each(callable $callback);

    /**
     * Filtra elementos armazenados de acordo com callback
     *
     * @param callable $callback
     * @return StorageInterface
     */
    public function filter(callable $callback);

    /**
     * Conta o número de elementos armazenados
     *
     * @return int
     */
    public function count();

    /**
     * Remove todos os elementos do storage
     *
     * @return void
     */
    public function clear();

    /**
     * Copia o conteúdo do storage para dentro de outra array ou storage
     *
     * @param $array
     * @return void
     */
    public function copyTo(&$array);

    /**
     * Converte o objeto para array
     *
     * @return array
     */
    public function toArray();
}