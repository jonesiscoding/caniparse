<?php

namespace DevCoding\Parser\CanIUse;

use DevCoding\CodeObject\Object\Base\BaseVersion;
use DevCoding\CodeObject\Object\VersionImmutable;

class AgentStat
{
  const DISABLED    = 'd';
  const PARTIAL     = 'a';
  const POLYFILL    = 'p';
  const PREFIX      = 'x';
  const SUPPORTED   = 'y';
  const UNKNOWN     = 'u';
  const UNSUPPORTED = 'n';

  /** @var string */
  protected $value;
  /** @var VersionImmutable */
  protected $version;

  /**
   * @param string $version
   * @param string $value
   */
  public function __construct($version, string $value)
  {
    $this->version = new VersionImmutable($version);
    $this->value   = $value;
  }

  /**
   * @return VersionImmutable
   */
  public function getVersion()
  {
    return $this->version;
  }

  /**
   * @param BaseVersion $Version
   *
   * @return bool
   */
  public function isLessThan($Version)
  {
    return !isset($Version) || !$Version instanceof BaseVersion || $this->getVersion()->lt($Version);
  }

  public function is(string $str): bool
  {
    return false !== stripos($this->value, $str);
  }

  public function isSupported()
  {
    return false !== stripos($this->value, 'y');
  }

  public function isPolyfill()
  {
    return false !== stripos($this->value, 'p');
  }

  public function isAlmost()
  {
    return false === stripos($this->value, 'a');
  }

  public function isPrefix()
  {
    return false === stripos($this->value, 'x');
  }
}