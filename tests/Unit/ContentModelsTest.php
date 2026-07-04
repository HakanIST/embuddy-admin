<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\CampusLocation;
use App\Models\MediaItem;
use App\Models\Achievement;
use App\Models\WordOfDay;
use App\Models\DailyTask;
use App\Models\MoodEntry;
use App\Models\Streak;
use PHPUnit\Framework\TestCase;

class ContentModelsTest extends TestCase
{
    public function test_event_table_and_fillable(): void
    {
        $event = new Event();
        $this->assertEquals('Event', $event->getTable());
        $this->assertContains('title', $event->getFillable());
        $this->assertContains('eventDate', $event->getFillable());
        $this->assertContains('tag', $event->getFillable());
        $this->assertContains('attendeeCount', $event->getFillable());
    }

    public function test_campus_location_table_and_casts(): void
    {
        $loc = new CampusLocation();
        $this->assertEquals('CampusLocation', $loc->getTable());
        $this->assertContains('campus', $loc->getFillable());
        $this->assertContains('latitude', $loc->getFillable());
        $casts = $loc->getCasts();
        $this->assertEquals('boolean', $casts['hasWheelchairAccess']);
        $this->assertEquals('float', $casts['latitude']);
    }

    public function test_media_item_table_and_fillable(): void
    {
        $media = new MediaItem();
        $this->assertEquals('MediaItem', $media->getTable());
        $this->assertContains('title', $media->getFillable());
        $this->assertContains('mediaType', $media->getFillable());
        $this->assertContains('creator', $media->getFillable());
    }

    public function test_achievement_table_and_fillable(): void
    {
        $ach = new Achievement();
        $this->assertEquals('Achievement', $ach->getTable());
        $this->assertContains('name', $ach->getFillable());
        $this->assertContains('xpReward', $ach->getFillable());
        $this->assertContains('conditionType', $ach->getFillable());
    }

    public function test_word_of_day_table_and_fillable(): void
    {
        $word = new WordOfDay();
        $this->assertEquals('WordOfDay', $word->getTable());
        $this->assertContains('turkishWord', $word->getFillable());
        $this->assertContains('englishTranslation', $word->getFillable());
        $this->assertContains('date', $word->getFillable());
    }

    public function test_daily_task_table_and_casts(): void
    {
        $task = new DailyTask();
        $this->assertEquals('DailyTask', $task->getTable());
        $this->assertContains('title', $task->getFillable());
        $this->assertContains('taskType', $task->getFillable());
        $casts = $task->getCasts();
        $this->assertEquals('boolean', $casts['isRecurring']);
    }

    public function test_mood_entry_table(): void
    {
        $mood = new MoodEntry();
        $this->assertEquals('MoodEntry', $mood->getTable());
        $this->assertContains('mood', $mood->getFillable());
        $this->assertContains('userId', $mood->getFillable());
    }

    public function test_streak_table(): void
    {
        $streak = new Streak();
        $this->assertEquals('Streak', $streak->getTable());
        $this->assertContains('currentStreak', $streak->getFillable());
        $this->assertContains('longestStreak', $streak->getFillable());
    }

    public function test_all_models_have_no_timestamps(): void
    {
        $models = [
            new Event(), new CampusLocation(), new MediaItem(),
            new Achievement(), new WordOfDay(), new DailyTask(),
            new MoodEntry(), new Streak(),
        ];

        foreach ($models as $model) {
            $this->assertFalse(
                $model->usesTimestamps(),
                get_class($model) . ' should not use timestamps'
            );
        }
    }
}
