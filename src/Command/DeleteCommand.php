<?php

namespace Drupal\blocks_profiler\Command;

use Drupal\block_content\Plugin\Derivative\BlockContent;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Core\Command\ContainerAwareCommand;
use Drupal\Console\Annotations\DrupalCommand;

/**
 * Class DeleteCommand.
 *
 * @DrupalCommand (
 *     extension="blocks_profiler",
 *     extensionType="module"
 * )
 */
class DeleteCommand extends ContainerAwareCommand {

  /**
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $storage;

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('blocks_profiler:delete')
      ->setDescription($this->trans('commands.blocks_profiler.delete.description'));
    $this->setAliases(['bpd']);
    $this->addArgument('type', InputArgument::OPTIONAL, 'resuable or non-reusable or all n/r/all', 'all');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $this->storage = \Drupal::entityTypeManager()->getStorage('block_content');
    $type = $input->getArgument('type');
    $reusable = NULL;
    $reusable_text = 'all';
    if ($type === 'reusable' || $type === 'r') {
      $reusable = TRUE;
      $reusable_text = 'reusable';
    }
    elseif ($type === 'non-reusable' || $type === 'n') {
      $reusable = FALSE;
      $reusable_text = 'non-reusable';
    }
    $this->getIo()->info("Deleting $reusable_text blocks!");
    while ($blocks = $this->getBlocks($reusable)) {
      $this->storage->delete($blocks);
    }

  }

  /**
   * @param $reusable
   *
   * @return \Drupal\Core\Entity\EntityInterface[]
   */
  protected function getBlocks($reusable) {
    $query = $this->storage->getQuery();
    if ($reusable !== NULL) {
      $this->getIo()->warning('setter');
      $query->condition('reusable', $reusable);
    }
    $query->range(0, 100);
    if ($block_ids = $query->execute()) {
      return $this->storage->loadMultiple($block_ids);
    }
    return [];
  }
}
