<?php


spl_autoload_register(function ($className)
{
  $dir = dirname(__DIR__);
  $path = "\\application\\";
  $extension = ".php";
  $fullPath = $dir . $path . $className . $extension;
  $fullPath = str_replace("\\", DIRECTORY_SEPARATOR, $fullPath);
 
  if (file_exists($fullPath)) 
  {
      include_once $fullPath;
  }
});

