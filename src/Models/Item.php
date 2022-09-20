<?php

namespace Phprogress\Models;

class Item {

  protected string $id;

  protected string $title;

  protected ?string $description;

  /**
   * Status, e.g. success or failure.
   *
   * @var int
   *   One of ItemStatus::* constants.
   *
   * @see \Phprogress\Models\ItemStatus
   */
  protected int $status;

  protected \DateTime $startedAt;

  protected ?\DateTime $finishedAt;

  public function __construct(string $id, string $title) {
    $this->id = $id;
    $this->title = $title;
    $this->description = NULL;
    $this->setStatus(ItemStatus::RUNNING);
    $this->startedAt = new \DateTime();
    $this->finishedAt = NULL;
  }

  public function getTitle(): string {
    return $this->title;
  }

  public function getDescription(): ?string {
    return $this->description;
  }

  public function setDescription(?string $description): static {
    $this->description = $description;
    return $this;
  }

  public function isFinished(): bool {
    return $this->getStatus() !== ItemStatus::RUNNING;
  }

  public function getStatus(): int {
    return $this->status;
  }

  public function setStatus(int $status): static {
    $this->status = $status;
    return $this;
  }

  public function setStartedAt(\DateTime $datetime): static {
    $this->startedAt = $datetime;
    return $this;
  }

  public function setFinishedAt(\DateTime $datetime): static {
    $this->finishedAt = $datetime;
    return $this;
  }

}
