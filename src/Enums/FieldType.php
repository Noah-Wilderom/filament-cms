<?php

namespace NoahWilderom\FilamentCMS\Enums;

enum FieldType: string {
   case Text = 'text';
   case DateTime = 'datetime';
   case Boolean = 'bool';

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