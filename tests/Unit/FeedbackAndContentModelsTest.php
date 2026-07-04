<?php

namespace Tests\Unit;

use App\Models\Feedback;
use App\Models\SavedContent;
use App\Models\UserTaskCompletion;
use PHPUnit\Framework\TestCase;

class FeedbackAndContentModelsTest extends TestCase
{
    // MARK: - Feedback

    public function test_feedback_table_and_fillable(): void
    {
        $feedback = new Feedback();
        $this->assertEquals('Feedback', $feedback->getTable());
        $this->assertContains('userId', $feedback->getFillable());
        $this->assertContains('subject', $feedback->getFillable());
        $this->assertContains('message', $feedback->getFillable());
        $this->assertContains('createdAt', $feedback->getFillable());
    }

    public function test_feedback_casts(): void
    {
        $feedback = new Feedback();
        $casts = $feedback->getCasts();
        $this->assertEquals('datetime', $casts['createdAt']);
    }

    public function test_feedback_has_no_timestamps(): void
    {
        $feedback = new Feedback();
        $this->assertFalse($feedback->usesTimestamps());
    }

    public function test_feedback_fillable_count(): void
    {
        $feedback = new Feedback();
        $this->assertCount(4, $feedback->getFillable());
    }

    // MARK: - SavedContent

    public function test_saved_content_table_and_fillable(): void
    {
        $saved = new SavedContent();
        $this->assertEquals('SavedContent', $saved->getTable());
        $this->assertContains('userId', $saved->getFillable());
        $this->assertContains('contentType', $saved->getFillable());
        $this->assertContains('contentId', $saved->getFillable());
        $this->assertContains('savedAt', $saved->getFillable());
    }

    public function test_saved_content_casts(): void
    {
        $saved = new SavedContent();
        $casts = $saved->getCasts();
        $this->assertEquals('datetime', $casts['savedAt']);
        $this->assertEquals('integer', $casts['contentId']);
    }

    public function test_saved_content_has_no_timestamps(): void
    {
        $saved = new SavedContent();
        $this->assertFalse($saved->usesTimestamps());
    }

    public function test_saved_content_fillable_count(): void
    {
        $saved = new SavedContent();
        $this->assertCount(4, $saved->getFillable());
    }

    // MARK: - UserTaskCompletion

    public function test_user_task_completion_table_and_fillable(): void
    {
        $completion = new UserTaskCompletion();
        $this->assertEquals('UserTaskCompletion', $completion->getTable());
        $this->assertContains('userId', $completion->getFillable());
        $this->assertContains('taskId', $completion->getFillable());
        $this->assertContains('completedAt', $completion->getFillable());
        $this->assertContains('date', $completion->getFillable());
    }

    public function test_user_task_completion_casts(): void
    {
        $completion = new UserTaskCompletion();
        $casts = $completion->getCasts();
        $this->assertEquals('datetime', $casts['completedAt']);
    }

    public function test_user_task_completion_has_no_timestamps(): void
    {
        $completion = new UserTaskCompletion();
        $this->assertFalse($completion->usesTimestamps());
    }

    public function test_user_task_completion_fillable_count(): void
    {
        $completion = new UserTaskCompletion();
        $this->assertCount(4, $completion->getFillable());
    }

    // MARK: - All new models consistency

    public function test_all_new_models_use_custom_tables(): void
    {
        $models = [
            new Feedback(),
            new SavedContent(),
            new UserTaskCompletion(),
        ];

        foreach ($models as $model) {
            $tableName = $model->getTable();
            // Table names should be PascalCase (not snake_case)
            $this->assertMatchesRegularExpression(
                '/^[A-Z][a-zA-Z]+$/',
                $tableName,
                get_class($model) . " table '$tableName' should be PascalCase"
            );
        }
    }
}
