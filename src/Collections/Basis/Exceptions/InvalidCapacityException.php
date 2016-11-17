<?php

namespace Minerva\Collections\Basis\Exceptions;

/**
 * InvalidCapacityException
 *
 * Exception lançada quando houver a tentativa de informar uma
 * capacidade máxima de itens que não pode ser entendida pela
 * biblioteca. Apenas números inteiros podem ser definidos como
 * capacidade máxima para uma storage.
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Minerva\Collections\Basis\Exceptions
 */
class InvalidCapacityException extends \Exception
{
    /* ... */
}