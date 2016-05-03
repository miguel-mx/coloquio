<?php

namespace Drupal\coloquio\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'ColoquioBlock' block.
 *
 * @Block(
 *  id = "coloquio_block",
 *  admin_label = @Translation("Coloquio block"),
 * )
 */
class ColoquioBlock extends BlockBase
{

  /**
   * {@inheritdoc}
   */
  public function build()
  {

    // Return: Render array
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://gaspacho.matmor.unam.mx/seminarios2/evento/coloquio-semana.xml");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/xml'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
    $data = new \SimpleXMLElement($response);

    $coloquio = (array)$data;

    return [
        '#theme' => 'coloquio_ccm',   // Defined in .module
        '#coloquio' => $coloquio,   // twig paramenters
        '#attached' => [
            'library' => [
                'seminarios/seminarios-styles', //include our custom library for this response
            ]
        ]
    ];


  }
}
