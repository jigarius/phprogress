<?php

namespace Phprogress\Formatter;

use Phprogress\Models\Item;

interface FormatterInterface {

  /**
   * Processes an item.
   *
   * Depending on the formatter and the item's status, output is prepared.
   *
   * @param \Phprogress\Models\Item $item
   *   An item.
   */
  public function process(Item $item): void;

  /**
   * Prints summary, if any, after all items have been processed.
   */
  public function summarize(): void;

  /**
   * Renders the progress.
   */
  public function render(): void;

}
