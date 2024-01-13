<?php

namespace NoahWilderom\FilamentCMS\Enums;

enum PostStatus: string {
    case Published = 'published';
    case Draft = 'draft';
    case Closed = 'closed';

    public function toString(): string {
       return ucfirst($this->value);
    }
    public static function casesToString(): array {
        $cases = [];

        foreach(self::cases() as $case) {
            $cases[$case->value] = $case->toString();
        }

        return $cases;
    }

}