<?php

namespace Drupal\mymodule;

use Drupal\Core\Render\Element;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * MyModule Twig Extension.
 *
 * Adds twig functions and filters required for this project.
 */
class MyModuleTwigExtension extends AbstractExtension {

	/**
	 * {@inheritdoc}
	 */
  public function getFilters(): array {
    $filters = [
      new TwigFilter('mymodule_add_link_class', [self::class, 'addLinkClass']),
    ];

    return $filters;
  }

  /**
   * Add classes to link field links.
   *
   * @param array $items
   *   The render array for the link field.
   * @param array|string $classes
   *   The classes to add to links. Can be a space separated string or an array.
   *
   * @return array
   *   The $items array, with the classes added to the links.
   */
  public static function addLinkClass(array $items, array|string $classes): array {;
    // Ensure $classes is always an array.
    $classes = is_array($classes) ? $classes : explode(' ', $classes);

    foreach (Element::children($items) as $key) {
      $original_classes = $items[$key]['#attributes']['class'] ?? [];
      $items[$key]['#attributes']['class'] = $classes + $original_classes;
    }

    return $items;
  }

}
