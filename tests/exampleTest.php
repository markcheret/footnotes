<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class ExampleTest extends TestCase {
    public function testAdd() {
        $result = 1 + 2;

        $this->assertEquals(3, $result);
    }
}

