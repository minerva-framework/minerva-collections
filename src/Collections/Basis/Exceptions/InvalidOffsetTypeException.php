<?php

namespace Minerva\Collections\Basis\Exceptions;

/**
 * InvalidOffsetTypeException
 *
 * Essa exception é lançada quando ocorrer a tentativa de adicionar
 * um elemento com uma chave ou offset de tipo inválido. Os tipos de
 * offset permitidos são bool, int, float e string.
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Minerva\Collections\Basis\Exceptions
 */
class InvalidOffsetTypeException extends \Exception
{
    /* ... */
}