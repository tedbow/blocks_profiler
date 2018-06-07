<?php

namespace Drupal\blocks_profiler\Command;

use Drupal\block_content\Entity\BlockContent;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Core\Command\ContainerAwareCommand;
use Drupal\Console\Annotations\DrupalCommand;

/**
 * Class GenerateCommand.
 *
 * @DrupalCommand (
 *     extension="blocks_profiler",
 *     extensionType="module"
 * )
 */
class GenerateCommand extends ContainerAwareCommand {

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('blocks_profile:generate')
      ->setDescription($this->trans('commands.blocks_profile.generate.description'));
    $this->setAliases(['bpg']);
    $this->addArgument(
      'type',
      InputArgument::REQUIRED
    );
    $this->addArgument(
      'number',
      InputArgument::REQUIRED
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $reusable = $input->getArgument('type') === 'reusable'? TRUE : FALSE ;
    $count = (int)$input->getArgument('number');
    $reusable_text = $reusable ? 'reusable' : 'non-reusable';
    $this->getIo()->info("Generating $count $reusable_text blocks");

    for ($i = 0; $i < $count; $i++) {
      BlockContent::create([
        'info' => "Block-$reusable_text-$i-" . random_int(1, 1000),
        'type' => 'basic_block',
        'reusable' => $reusable,
      ])->save();
    }
  }
}
