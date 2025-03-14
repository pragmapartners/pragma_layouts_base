<?php

namespace Drupal\pragma_layouts_base\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\pragma_layouts_base\Plugin\Layout\LayoutBase;

/**
 * {@inheritdoc}
 */
class SingleColumn extends LayoutBase
{

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    return parent::defaultConfiguration() + [
      'extra_classes' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state)
  {
    $form = parent::buildConfigurationForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state)
  {
    // any additional form validation that is required
  }

  /**
   * {@inheritdoc}
   */
  public function build(array $regions)
  {
    $build = parent::build($regions);

    return $build;
  }
}
