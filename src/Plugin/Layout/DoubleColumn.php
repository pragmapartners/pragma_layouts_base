<?php

namespace Drupal\pragma_layouts\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\pragma_layouts\Plugin\Layout\MultiColumnBase;

/**
 * {@inheritdoc}
 */
class DoubleColumn extends MultiColumnBase
{

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    return parent::defaultConfiguration() + [
      'col_widths' => '50_50',
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
        "50_50" => $this->t("50% 50%"),
        "25_75" => $this->t("25% 75%"),
        "75_25" => $this->t("75% 25%"),
        "33_66" => $this->t("33% 66%"),
        "66_33" => $this->t("66% 33%"),
        "fit_auto" => $this->t("Fit auto"),
        "auto_fit" => $this->t("Auto fit"),
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
