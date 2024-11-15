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
      new TwigFilter('mymodule_with_only_first_of_bundle', [self::class, 'withOnlyFirstOfBundle']),
    ];

    return $filters;
  }

  /**
   * Filter an array of items to only include the first item of a bundle.
   *
   * @param array $items
   *   An array of entity items.
   * @param string $bundle
   *   The bundle to filter by.
   *
   * @return array
   *   The $items array, with only the first of bundle in the first position.
   */
  public static function withOnlyFirstOfBundle(array $items, string $bundle) {
    $firstOfBundle = FALSE;
    foreach (Element::getVisibleChildren($items) as $key) {
      $entity = $items[$key]['#entity'] ?? NULL;

      // If the first of bundle is not already found, and the bundle matches,
      // store the item for later.
      if (!$firstOfBundle && $entity->bundle() == $bundle) {
        $firstOfBundle = $items[$key];
      }

      // Remove each item. Add the first of bundle later in the first position.
      unset($items[$key]);
    }

    // If the first of bundle was found, add it to the first position.
    if ($firstOfBundle) {
      $items[0] = $firstOfBundle;
    }

    return $items;
  }

}
