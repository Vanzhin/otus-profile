<?php

declare(strict_types=1);

namespace App\Shared\Domain\Repository;

readonly class Pager
{
    public const DEFAULT_PAGE = 1;
    public const ITEMS_PER_PAGE = 10;

    public function __construct(
        public int $page,
        public int $limit,
        public ?int $total = null
    ) {
    }

    public static function fromPage(?int $page = null, ?int $perPage = null): self
    {
        return new self($page ?? self::DEFAULT_PAGE, $perPage ?? self::ITEMS_PER_PAGE);
    }

    public function getOffset(): int
    {
        if (1 === $this->page) {
            return 0;
        }

        return $this->page * $this->limit - $this->limit;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
