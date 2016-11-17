<?php

namespace Minerva\Collections\Basis\Exceptions;

/**
 * ReadOnlyStorageException
 *
 * Essa exceção é lançada quando existe a tentativa se inserir um valor
 * em uma storage de dados que é apenas para leitura.
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Minerva\Collections\Exceptions
 */
class ReadOnlyStorageException extends \Exception
{
    /* ... */
}