<?php

namespace Minerva\Collections\Basis\Exceptions;

/**
 * InvalidOffsetException
 *
 * Essa exception é lançada quando tenta-se executar uma operação
 * sobre um offset que não existe quando essa operação depende da
 * existência do mesmo, ou seja, qualquer operação que não a operação
 * de criação de um offset.
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Minerva\Collections\Basis\Exceptions
 */
class InvalidOffsetException extends \Exception
{
    /* ... */
}