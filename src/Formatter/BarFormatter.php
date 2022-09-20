<?php

namespace Phprogress\Formatter;

use Phprogress\Models\Item;

class BarFormatter implements FormatterInterface {

  const TOKEN_TOTAL = '@total';

  const TOKEN_PROCESSED = '@processed';

  const TOKEN_BAR_CLASSIC = '@barc';

  const TOKEN_PERCENTAGE = '@percentage';

  const FORMAT_CLASSIC = '@percentage [@barc] @processed/@total';

  /**
   * Number of processed items.
   *
   * @var int
   */
  protected int $processedItems;

  /**
   * Total number of items.
   *
   * @var int
   */
  protected int $totalItems;

  protected int $barWidth = 40;

  protected string $barFillChar = '=';

  protected string $barEmptyChar = ' ';

  protected string $barArrowChar = '>';

  protected string $format;

  protected string $output;

  public function __construct(int $totalItems) {
    $this->totalItems = $totalItems;
    $this->processedItems = 0;
    $this->setFormat(static::FORMAT_CLASSIC);
    $this->output = '';
  }

  public function setFormat(string $format): static {
    $this->format = $format;
    return $this;
  }

  public function setBarArrowChar(string $char): static {
    $this->barArrowChar = $char;
    return $this;
  }

  public function setBarEmptyChar(string $char): static {
    $this->barEmptyChar = $char;
    return $this;
  }

  public function setBarFillChar(string $char): static {
    $this->barFillChar = $char;
    return $this;
  }

  public function process(Item $item): void {
    if (!$item->isFinished()) {
      return;
    }

    if ($this->processedItems === $this->totalItems) {
      throw new \BadMethodCallException();
    }

    $this->processedItems += 1;
  }

  public function render(): void {
    preg_match_all("/(@\w+)\b/", $this->format, $matches);
    if (!$matches) {
      throw new \BadMethodCallException("Format doesn't contain any token.");
    }

    $tokens = array_flip(array_pop($matches));
    foreach ($tokens as $token => $_) {
      $tokens[$token] = $this->formatToken($token);
    }

    $result = str_replace(array_keys($tokens), array_values($tokens), $this->format);
    echo "\r" . $result;
  }

  public function summarize(): void {}

  protected function formatToken(string $token): string {
    return match ($token) {
      self::TOKEN_TOTAL => $this->totalItems,
      self::TOKEN_PROCESSED => (string) $this->processedItems,
      self::TOKEN_PERCENTAGE => $this->getPercentage(1) . '%',
      self::TOKEN_BAR_CLASSIC => $this->getBarClassic(),
      default => $token,
    };
  }

  protected function getPercentage($decimals = 0): string {
    $percentage = ($this->processedItems / $this->totalItems) * 100;
    return number_format($percentage, $decimals);
  }

  protected function getBarClassic(): string {
    $progress = floor($this->getPercentage() * $this->barWidth / 100);
    $bar = str_repeat($this->barFillChar, $this->barArrowChar ? max($progress - 1, 0) : $progress);
    $bar .= $this->barArrowChar;
    $bar .= str_repeat($this->barEmptyChar, $this->barWidth - $progress);
    return $bar;
  }

}
