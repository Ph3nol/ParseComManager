<?php

namespace Sly\ParseComManager\Exception;

/**
 * NotFoundHttpException.
 *
 * @uses \InvalidArgumentException
 * @uses \ExceptionInterface
 * @author Cédric Dugat <cedric@dugat.me>
 */
class NotFoundHttpException extends \InvalidArgumentException implements ExceptionInterface
{
}
