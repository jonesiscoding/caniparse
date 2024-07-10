<?php

namespace DevCoding\Parser\CanIUse;

class SupportLevel
{
  const SUPPORTED   = 'y';
  const PREFIX      = 'x';
  const ALMOST      = 'a';
  const POLYFILL    = 'p';
  const UNSUPPORTED = 'n';

  public static function getLevels()
  {
    return static::getConstants();
  }

  private static function getConstants()
  {
    $oClass = new \ReflectionClass(__CLASS__);
    return $oClass->getConstants();
  }
}