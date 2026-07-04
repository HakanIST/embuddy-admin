<?php

namespace Tests\Unit;

use App\Models\Guide;
use App\Models\GuideCategory;
use PHPUnit\Framework\TestCase;

class GuideModelTest extends TestCase
{
    public function test_guide_table_name(): void
    {
        $guide = new Guide();
        $this->assertEquals('Guide', $guide->getTable());
    }

    public function test_guide_fillable_fields(): void
    {
        $guide = new Guide();
        $fillable = $guide->getFillable();

        $this->assertContains('title', $fillable);
        $this->assertContains('summary', $fillable);
        $this->assertContains('content', $fillable);
        $this->assertContains('categoryId', $fillable);
        $this->assertContains('readTimeMinutes', $fillable);
        $this->assertContains('isMandatory', $fillable);
    }

    public function test_guide_casts(): void
    {
        $guide = new Guide();
        $casts = $guide->getCasts();

        $this->assertEquals('boolean', $casts['isMandatory']);
        $this->assertEquals('integer', $casts['readTimeMinutes']);
    }

    public function test_guide_category_table_name(): void
    {
        $cat = new GuideCategory();
        $this->assertEquals('GuideCategory', $cat->getTable());
    }

    public function test_guide_category_fillable(): void
    {
        $cat = new GuideCategory();
        $this->assertContains('name', $cat->getFillable());
        $this->assertContains('color', $cat->getFillable());
        $this->assertContains('icon', $cat->getFillable());
    }
}
