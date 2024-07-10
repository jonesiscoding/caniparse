<?php

namespace DevCoding\Parser\CanIUse;

use DevCoding\CodeObject\Object\VersionImmutable;


class StatCollection
{
  /** @var string */
  protected $_browser;
  /** @var VersionImmutable */
  protected $supported;
  /** @var VersionImmutable */
  protected $polyfill;
  /** @var VersionImmutable */
  protected $prefix;
  /** @var VersionImmutable */
  protected $almost;

  /**
   * @param string|array $statsArray
   */
  public function __construct(string $browser, array $statsArray)
  {
    $this->_browser = $browser;

    $this->parse($statsArray);
  }

  public function getVersions()
  {
    return array(
        'supported' => $this->getSupported(),
        ''
    );
  }

  public function getAlmost()
  {
    return $this->almost;
  }

  /**
   * @return VersionImmutable
   */
  public function getSupported()
  {
    return $this->supported;
  }

  public function getPolyfill()
  {
    return $this->polyfill;
  }

  public function getPrefix()
  {
    return $this->prefix;
  }

  /**
   * @param array $data
   *
   * @return array
   */
  protected function parse($data)
  {
    $parsed = array();
    foreach ($data as $ver => $val)
    {
      if (strpos($ver, '-') !== false)
      {
        $parts = explode('-', $ver);
        $ver = array_shift($parts);
      }

      $Stat = new AgentStat($ver, $val);

      if ($Stat->isSupported())
      {
        if ($Stat->isLessThan($this->supported))
        {
          $this->supported = $Stat->getVersion();
        }
      }

      if ($Stat->isAlmost())
      {
        if ($Stat->isLessThan($this->almost))
        {
          $this->almost = $Stat->getVersion();
        }
      }

      if ($Stat->isPrefix())
      {
        if ($Stat->isLessThan($this->prefix))
        {
          $this->prefix = $Stat->getVersion();
        }
      }

      if ($Stat->isPolyfill())
      {
        if ($Stat->isLessThan($this->polyfill))
        {
          $this->polyfill = $Stat->getVersion();
        }
      }
    }

    return $parsed;
  }
}