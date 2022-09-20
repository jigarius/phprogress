<?php

namespace Phprogress\Formatter;

use Phprogress\Models\Item;
use Phprogress\Models\ItemStatus;

class DotsFormatter implements FormatterInterface {

  protected string $output;

  public function __construct() {
    $this->output = '';
  }

  public function process(Item $item): void {
    if (!$item->isFinished()) {
      return;
    }

    $this->output .= $item->getStatus() === ItemStatus::SUCCESS ? '.' : 'F';
  }

  public function summarize(): void {}

  public function render(): void {
    echo $this->output;
    $this->output = '';
  }

}
