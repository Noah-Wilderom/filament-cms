<?php

namespace NoahWilderom\FilamentCMS\Enums;

enum PostType: string {
    case Post = 'post';
    case Page = 'page';

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