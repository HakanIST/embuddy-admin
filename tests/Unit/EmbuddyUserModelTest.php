<?php

namespace Tests\Unit;

use App\Models\EmbuddyUser;
use App\Models\MoodEntry;
use App\Models\Streak;
use PHPUnit\Framework\TestCase;

class EmbuddyUserModelTest extends TestCase
{
    public function test_user_table_name(): void
    {
        $user = new EmbuddyUser();
        $this->assertEquals('User', $user->getTable());
    }

    public function test_user_fillable_fields(): void
    {
        $user = new EmbuddyUser();
        $fillable = $user->getFillable();

        $this->assertContains('email', $fillable);
        $this->assertContains('fullName', $fillable);
        $this->assertContains('department', $fillable);
        $this->assertContains('country', $fillable);
        $this->assertContains('xpPoints', $fillable);
        $this->assertContains('level', $fillable);
        $this->assertContains('isActive', $fillable);
        $this->assertContains('language', $fillable);
    }

    public function test_user_casts(): void
    {
        $user = new EmbuddyUser();
        $casts = $user->getCasts();

        $this->assertEquals('boolean', $casts['isActive']);
        $this->assertEquals('integer', $casts['xpPoints']);
        $this->assertEquals('integer', $casts['level']);
    }

    public function test_user_has_no_timestamps(): void
    {
        $user = new EmbuddyUser();
        $this->assertFalse($user->usesTimestamps());
    }
}
