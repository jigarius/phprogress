<?php

namespace Phprogress\Formatter;

use Phprogress\Models\Item;

class DefaultFormatter implements FormatterInterface {

  protected string $output;

  public function __construct() {
    $this->output = '';
  }

  public function process(Item $item): void {
    if (!$item->isFinished()) {
      $this->output .= 'Started: ' . $item->getTitle() . PHP_EOL;
      return;
    }

    $result = 'Finished: ' . $item->getTitle() . PHP_EOL;

    if ($item->getDescription()) {
      $result .= $item->getDescription() . PHP_EOL;
    }

    $this->output .= $result;
  }

  public function summarize(): void {}

  public function render(): void {
    echo $this->output;
    $this->output = '';
  }

}
