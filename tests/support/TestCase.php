<?php

declare(strict_types=1);

if (!function_exists('str_starts_with')) {
    function str_starts_with(string $haystack, string $needle): bool
    {
        return $needle === '' || strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

abstract class TestCase
{
    abstract protected function setUp(): void;

    public function bootstrap(): void
    {
        $this->setUp();
    }

    public function getName(): string
    {
        return static::class;
    }

    /**
     * @return array<int, string>
     */
    public function getTestMethods(): array
    {
        return array_values(array_filter(
            get_class_methods($this),
            static fn (string $method): bool => str_starts_with($method, 'test')
        ));
    }

    protected function assertTrue(bool $condition, string $message = ''): void
    {
        if (!$condition) {
            throw new RuntimeException($message !== '' ? $message : 'Expected condition to be true.');
        }
    }

    protected function assertEquals(mixed $expected, mixed $actual, string $message = ''): void
    {
        if ($expected !== $actual) {
            $msg = $message !== '' ? $message : sprintf(
                'Expected %s but got %s',
                var_export($expected, true),
                var_export($actual, true)
            );
            throw new RuntimeException($msg);
        }
    }

    protected function assertNull(mixed $value, string $message = ''): void
    {
        if ($value !== null) {
            throw new RuntimeException($message !== '' ? $message : 'Expected value to be null.');
        }
    }
}
