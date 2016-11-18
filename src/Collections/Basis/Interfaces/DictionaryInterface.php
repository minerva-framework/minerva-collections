<?php

namespace Minerva\Collections\Basis\Interfaces;

/**
 * Interface DictionaryInterface
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Minerva\Collections\Basis\Interfaces
 */
interface DictionaryInterface extends StorageInterface
{
    /**
     * Retorna se a classe permite override
     *
     * @return boolean
     */
    public function isOverrideAllowed();

    /**
     * Define o comportamento do objeto acerca do override
     *
     * @param boolean $overrideAllowed
     */
    public function setOverrideAllowed($overrideAllowed);
}