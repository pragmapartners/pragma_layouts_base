<?php

namespace Drupal\pragma_layouts_base\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\pragma_layouts_base\Plugin\Layout\MultiColumnBase;

/**
 * {@inheritdoc}
 */
class TripleColumn extends MultiColumnBase
{

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    return parent::defaultConfiguration() + [
      'col_widths' => '33_33_33',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state)
  {
    $form = parent::buildConfigurationForm($form, $form_state);

    $configuration = $this->getConfiguration();
    $form['col_widths'] = [
      '#type' => 'select',
      '#title' => $this->t('Column widths'),
      '#weight' => '-1',
      '#default_value' => $configuration['col_widths'],
      '#options' => [
        "25_50_25" => $this->t("25% 50% 25%"),
        "33_33_33" => $this->t("33% 33% 33%"),
        "25_25_50" => $this->t("25% 25% 50%"),
        "50_25_25" => $this->t("50% 25% 25%"),
      ],
      '#description' => $this->t('Choose the column widths for this layout.'),
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
    $this->configuration['col_widths'] = $form_state->getValue('col_widths');
    parent::submitConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function build(array $regions)
  {
    $build = parent::build($regions);

    $build['#attributes']['data-widths'] = $this->configuration['col_widths'];

    return $build;
  }
}
