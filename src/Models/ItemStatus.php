<?php

namespace Phprogress\Models;

class ItemStatus {

  const RUNNING = 0;

  const SUCCESS = 1;

  const FAILURE = -1;

  public static function all(): array {
    return [
      self::RUNNING,
      self::SUCCESS,
      self::FAILURE,
    ];
  }

}
