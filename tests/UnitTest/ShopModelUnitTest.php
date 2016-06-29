<?php

use App\Models\Shop;

class ShopModelUnitTest extends TestCase
{
    public function testInstance()
    {
        new Shop();
        $this->assertTrue(true);
    }
}
