<?php

namespace Drupal\mymodule;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * MyModule Twig Extension.
 *
 * Adds twig functions and filters required for this project.
 */
class MyModuleTwigExtension extends AbstractExtension {

  /**
   * {@inheritdoc}
   */
  public function getFunctions(): array {
    $functions = [
      new TwigFunction('mymodule_view', [self::class, 'getView']),
    ];

    return $functions;
  }

  /**
   * Get a view render array.
   *
   * @param string $view_name
   *   The machine name of the view.
   * @param string $display_id
   *   The machine name of the view display.
   * @param array $arguments
   *   An array of arguments to pass to the view.
   *
   * @return array
   *   A render array for the view.
   */
  public static function getView(string $view_name, string $display_id = 'default', array $arguments = []): array {
    return [
      '#type' => 'view',
      '#name' => $view_name,
      '#display_id' => $display_id,
      '#arguments' => $arguments,
    ];
  }

}
