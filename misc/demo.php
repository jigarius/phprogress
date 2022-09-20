#!/usr/bin/env php
<?php

/**
 * @file
 * Phprogress demo.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Phprogress\Formatter\BarFormatter;
use Phprogress\Formatter\DefaultFormatter;
use Phprogress\Formatter\DotsFormatter;
use Phprogress\Models\Item;
use Phprogress\Models\ItemStatus;

$params = getopt('', ['formatter::', 'items::']);
$param_formatter = $params['formatter'] ?? 'random';
$param_items = $params['items'] ?? 100;

if ($param_formatter === 'random') {
  $param_formatter = ['bar', 'dots', 'default'][rand(0, 2)];
  echo "Random formatter: $param_formatter" . PHP_EOL;
  sleep(1);
}

switch ($param_formatter) {
  case 'bar':
    $formatter = new BarFormatter($params['items']);
    $formatter->setBarArrowChar('>')
      ->setBarEmptyChar(' ')
      ->setBarFillChar('-');
    break;

  case 'dots':
    $formatter = new DotsFormatter();
    break;

  case 'default':
    $formatter = new DefaultFormatter();
    break;

  default:
    throw new \InvalidArgumentException("Unrecognized formatter: {$params['formatter']}");
}

for ($i = 1; $i <= $param_items; $i++) {
  $item = new Item($i, "Item $i");
  $formatter->process($item);

  // Let's assume that the item is being processed here.
  usleep(rand(50000, 200000));

  // Update status.
  $item->setStatus([ItemStatus::SUCCESS, ItemStatus::FAILURE][rand(0, 1)]);
  $formatter->process($item);
  $formatter->render();
}


// Display overall summary, if any.
$formatter->summarize();

echo PHP_EOL;
