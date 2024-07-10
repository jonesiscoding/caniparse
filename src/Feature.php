<?php

namespace DevCoding\Parser\CanIUse;

class Feature
{
  /** @var array  */
  protected $_data;
  /** @var StatCollection[]|null */
  protected $_stats;

  /**
   * Feature constructor.
   *
   * @param $data
   */
  public function __construct($data)
  {
    if (is_string($data))
    {
      $data = json_decode($data, true);
    }

    $this->_data = $data;
  }

  /**
   * @return string|null
   */
  public function getCategory()
  {
    $cats = $this->_data['categories'] ?? array(null);

    return array_shift($cats);
  }

  /**
   * @return string|null
   */
  public function getName()
  {
    return $this->_data['name'] ?? null;
  }

  /**
   * @return StatCollection[]|null
   */
  public function getStats()
  {
    if (!isset($this->_stats))
    {
      if (isset($this->_data['stats']))
      {
        foreach ($this->_data['stats'] as $agent => $stats)
        {
          $this->_stats[$agent] = new StatCollection($agent, $stats);
        }
      }
    }

    return $this->_stats;
  }

  /**
   * @return int|float
   */
  public function getUsage()
  {
    return isset($this->_data['usage_perc_y']) ? (float)$this->_data['usage_perc_y'] : 0;
  }

  /**
   * @param Agent $agent
   *
   * @return bool
   */
  public function isSupported(Agent $agent)
  {
    return $agent->isSupported($this);
  }

  /**
   * @param Agent $agent
   *
   * @return bool
   */
  public function isAlmost(Agent $agent)
  {
    return $agent->isAlmost($this);
  }

  /**
   * @param Agent $agent
   *
   * @return bool
   */
  public function isPrefix(Agent $agent)
  {
    return $agent->isPrefix($this);
  }

  /**
   * @param Agent $agent
   *
   * @return bool
   */
  public function isPolyfill(Agent $agent)
  {
    return $agent->isPolyfill($this);
  }
}