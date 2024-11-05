<?php

namespace Drupal\pragma_layouts\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\pragma_layouts\Plugin\Layout\MultiColumnBase;

/**
 * {@inheritdoc}
 */
class QuadColumn extends MultiColumnBase
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
    $configuration = $this->getConfiguration();
    $form['extra_classes'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Extra classes'),
      '#default_value' => $configuration['extra_classes'],
    ];

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
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state)
  {
    $this->configuration['extra_classes'] = (string) $form_state->getValue('extra_classes');
  }

  /**
   * {@inheritdoc}
   */
  public function build(array $regions)
  {
    $build = parent::build($regions);

    // Ensure extra_classes is always treated as an array of classes.
    $extra_classes = is_string($this->configuration['extra_classes']) ? explode(' ', $this->configuration['extra_classes']) : [];
    $build['#attributes']['class'] = array_merge($build['#attributes']['class'] ?? [], $extra_classes);

    return $build;
  }
}
