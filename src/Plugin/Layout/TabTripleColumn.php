<?php

namespace Drupal\pragma_layouts\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Layout\LayoutDefault;
use Drupal\Core\Plugin\PluginFormInterface;

/**
 * {@inheritdoc}
 */
class TabTripleColumn extends LayoutDefault implements PluginFormInterface
{

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    return parent::defaultConfiguration() + [
      'col_gap' => 'md',
      'row_gap' => 'md',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state)
  {
    $form = parent::buildConfigurationForm($form, $form_state);
    $configuration = $this->getConfiguration();
    $form['col_gap'] = [
      '#type' => 'select',
      '#title' => $this->t('Column gap'),
      '#default_value' => $configuration['col_gap'],
      '#options' => [
        "nil" => $this->t("None"),
        "sm" => $this->t("Small"),
        "md" => $this->t("Medium"),
        "lg" => $this->t("Large"),
      ],
      '#description' => $this->t('The amount of space between columns.'),
    ];
    $form['row_gap'] = [
      '#type' => 'select',
      '#title' => $this->t('Row gap'),
      '#default_value' => $configuration['col_gap'],
      '#options' => [
        "nil" => $this->t("None"),
        "sm" => $this->t("Small"),
        "md" => $this->t("Medium"),
        "lg" => $this->t("Large"),
      ],
      '#description' => $this->t('The amount of space between rows.'),
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
    $this->configuration['col_gap'] = $form_state->getValue('col_gap');
    $this->configuration['row_gap'] = $form_state->getValue('row_gap');
  }

  /**
   * {@inheritdoc}
   */
  public function build(array $regions)
  {
    $build = parent::build($regions);

    $build['#attributes']['data-widths'] = '33_33_33';
    $build['#attributes']['data-col-gap'] = $this->configuration['col_gap'];
    $build['#attributes']['data-row-gap'] = $this->configuration['row_gap'];

    return $build;
  }
}
