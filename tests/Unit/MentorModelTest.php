<?php

namespace Tests\Unit;

use App\Models\Mentor;
use App\Models\MentorAssignment;
use App\Models\MentorMessage;
use PHPUnit\Framework\TestCase;

class MentorModelTest extends TestCase
{
    public function test_mentor_table_and_fillable(): void
    {
        $mentor = new Mentor();
        $this->assertEquals('Mentor', $mentor->getTable());
        $this->assertContains('userId', $mentor->getFillable());
        $this->assertContains('bio', $mentor->getFillable());
        $this->assertContains('languages', $mentor->getFillable());
        $this->assertContains('maxMentees', $mentor->getFillable());
        $this->assertContains('isActive', $mentor->getFillable());
        $this->assertContains('createdAt', $mentor->getFillable());
    }

    public function test_mentor_casts(): void
    {
        $mentor = new Mentor();
        $casts = $mentor->getCasts();
        $this->assertEquals('boolean', $casts['isActive']);
        $this->assertEquals('integer', $casts['maxMentees']);
        $this->assertEquals('datetime', $casts['createdAt']);
    }

    public function test_mentor_has_no_timestamps(): void
    {
        $mentor = new Mentor();
        $this->assertFalse($mentor->usesTimestamps());
    }

    public function test_mentor_assignment_table_and_fillable(): void
    {
        $assignment = new MentorAssignment();
        $this->assertEquals('MentorAssignment', $assignment->getTable());
        $this->assertContains('mentorId', $assignment->getFillable());
        $this->assertContains('menteeId', $assignment->getFillable());
        $this->assertContains('status', $assignment->getFillable());
        $this->assertContains('assignedAt', $assignment->getFillable());
    }

    public function test_mentor_assignment_casts(): void
    {
        $assignment = new MentorAssignment();
        $casts = $assignment->getCasts();
        $this->assertEquals('datetime', $casts['assignedAt']);
    }

    public function test_mentor_assignment_has_no_timestamps(): void
    {
        $assignment = new MentorAssignment();
        $this->assertFalse($assignment->usesTimestamps());
    }

    public function test_mentor_message_table_and_fillable(): void
    {
        $message = new MentorMessage();
        $this->assertEquals('MentorMessage', $message->getTable());
        $this->assertContains('assignmentId', $message->getFillable());
        $this->assertContains('senderId', $message->getFillable());
        $this->assertContains('message', $message->getFillable());
        $this->assertContains('isRead', $message->getFillable());
        $this->assertContains('createdAt', $message->getFillable());
    }

    public function test_mentor_message_casts(): void
    {
        $message = new MentorMessage();
        $casts = $message->getCasts();
        $this->assertEquals('boolean', $casts['isRead']);
        $this->assertEquals('datetime', $casts['createdAt']);
    }

    public function test_mentor_message_has_no_timestamps(): void
    {
        $message = new MentorMessage();
        $this->assertFalse($message->usesTimestamps());
    }

    public function test_all_mentor_models_fillable_count(): void
    {
        $this->assertCount(6, (new Mentor())->getFillable());
        $this->assertCount(4, (new MentorAssignment())->getFillable());
        $this->assertCount(5, (new MentorMessage())->getFillable());
    }
}
