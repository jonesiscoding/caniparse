<?php

namespace DevCoding\Parser\CanIUse;

use DevCoding\CodeObject\Resolver\ProjectResolver;

class FeatureFactory
{
  protected $path;

  /**
   * @param string $featuresJsonPath;
   */
  public function __construct($featuresJsonPath = null)
  {
    $this->path = $featuresJsonPath ?? (new ProjectResolver())->getDir() . '/vendor/fyrd/caniuse/features-json';
  }

  public function build($name)
  {
    if ($config = $this->getConfig($name))
    {
      return new Feature($config);
    }

    throw new \InvalidArgumentException(sprintf('The feature "%s" was not found in the Can I Use data.', $name));
  }

  protected function getConfig($name)
  {
    if ($file = $this->getConfigFile($name))
    {
      return file_get_contents($file);
    }

    return null;
  }

  protected function getConfigFile($name)
  {
    $name = strtolower(preg_replace('~(?<=\\w)([A-Z])~', '-$1', $name));
    $file = sprintf('%s/%s.json', $this->path, $name);

    if (!is_readable($file))
    {
      $try2 = substr($name, strpos($name, '-') + 1);
      $file = sprintf('%s/%s.json', $this->path, $try2);

      if (!is_readable($file))
      {
        return null;
      }
    }

    return $file;
  }


}