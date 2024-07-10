<?php

namespace DevCoding\Parser\CanIUse;

use DevCoding\CodeObject\Object\VersionImmutable;

/**
 * Class Agent
 * @package DevCoding\Parser\CanIUse
 */
class Agent
{
  /** @var string */
  protected $agent;
  /** @var VersionImmutable */
  protected $version;

  /**
   * @param string           $agent
   * @param VersionImmutable $version
   */
  public function __construct(string $agent, VersionImmutable $version)
  {
    $this->agent   = $agent;
    $this->version = $version;
  }

  public function has(Feature $feature, $level = SupportLevel::SUPPORTED)
  {
    switch ($level)
    {
      case SupportLevel::SUPPORTED:
        return $this->isSupported($feature);
      case SupportLevel::ALMOST:
        return $this->isSupported($feature) || $this->isAlmost($feature);
      case SupportLevel::PREFIX:
        return $this->isSupported($feature) || $this->isAlmost($feature) || $this->isPrefix($feature);
      case SupportLevel::POLYFILL:
        return $this->isSupported($feature) || $this->isAlmost($feature) || $this->isPrefix($feature) || $this->isPolyfill($feature);
      default:
        return false;
    }
  }

  /**
   * @param Feature $feature
   *
   * @return bool
   */
  public function isSupported(Feature $feature)
  {
    if ($sVersion = $this->getAgentStat($feature)->getSupported())
    {
      return $this->version->gte($sVersion);
    }

    return false;
  }

  /**
   * @param Feature $feature
   *
   * @return bool
   */
  public function isAlmost(Feature $feature)
  {
    if ($sVersion = $this->getAgentStat($feature)->getAlmost())
    {
      return $this->version->gte($sVersion);
    }

    return false;
  }

  /**
   * @param Feature $feature
   *
   * @return bool
   */
  public function isPrefix(Feature $feature)
  {
    if ($sVersion = $this->getAgentStat($feature)->getPrefix())
    {
      return $this->version->gte($sVersion);
    }

    return false;
  }

  /**
   * @param Feature $feature
   *
   * @return bool
   */
  public function isPolyfill(Feature $feature)
  {
    if ($sVersion = $this->getAgentStat($feature)->getPolyfill())
    {
      return $this->version->gte($sVersion);
    }

    return false;
  }

  /**
   * @param Feature $feature
   *
   * @return StatCollection|null
   */
  protected function getAgentStat(Feature $feature)
  {
    $stats = $feature->getStats();

    return $stats[$this->agent] ?? null;
  }
}
