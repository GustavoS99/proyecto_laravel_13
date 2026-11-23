<?php

namespace Tests\Unit;

use App\Support\Initials;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class InitialsTest extends TestCase
{
    public function test_it_uses_the_first_letter_of_the_first_and_last_name(): void
    {
        // Arrange: preparar los datos
        $name = 'Ana López';

        // Act: ejecutar lo que se prueba
        $initials = Initials::from($name);

        // Assert: comprobar el resultado
        $this->assertSame('AL', $initials);
    }

    #[DataProvider('edgeCases')]
    public function test_it_handles_edge_cases(string $name, string $expected): void
    {
        $this->assertSame($expected, Initials::from($name));
    }

    public static function edgeCases(): array
    {
        return [
            'nombre compuesto'  => ['Ana María López', 'AL'],
            'minúsculas'        => ['ana lópez', 'AL'],
            'espacios de sobra' => ['  Ana   López  ', 'AL'],
            'una sola palabra'  => ['Ana', 'A'],
            'tildes y eñes'     => ['Óscar Ñúñez', 'ÓÑ'],
            'cadena vacía'      => ['', ''],
        ];
    }
}