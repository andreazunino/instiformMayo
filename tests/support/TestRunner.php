<?php

declare(strict_types=1);

class TestRunner
{
    /** @var array<int, TestCase> */
    private array $testSuites = [];

    public function addTest(TestCase $test): void
    {
        $this->testSuites[] = $test;
    }

    public function run(): bool
    {
        $allPassed = true;
        foreach ($this->testSuites as $suite) {
            $suite->bootstrap();
            foreach ($suite->getTestMethods() as $method) {
                try {
                    $suite->$method();
                    $this->printResult($suite->getName(), $method, true);
                } catch (Throwable $e) {
                    $allPassed = false;
                    $this->printResult($suite->getName(), $method, false, $e->getMessage());
                }
            }
        }

        $this->printSummary($allPassed);
        return $allPassed;
    }

    private function printResult(string $suite, string $method, bool $status, string $message = ''): void
    {
        $label = $status ? '[OK] ' : '[FAIL] ';
        $line = sprintf("%s%s::%s", $label, $suite, $method);
        if ($message !== '') {
            $line .= ' - ' . $message;
        }
        echo $line . PHP_EOL;
    }

    private function printSummary(bool $status): void
    {
        echo PHP_EOL . ($status ? "Todos los test pasaron con éxito" : "Los test fallaron") . PHP_EOL;
    }
}
