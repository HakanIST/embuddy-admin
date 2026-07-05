<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Creates Prisma-managed tables in the test/admin database.
 * These mirror the Prisma schema exactly so that:
 * 1. Filament resources can query them in tests
 * 2. The admin panel can read/write to the same tables as the API
 *
 * In production, these tables are created by Prisma (embuddy-api).
 * This migration ensures the admin panel can also create them
 * for testing and fresh deployments.
 */
return new class extends Migration
{
    public function up(): void
    {
        // User table (Prisma: model User)
        // In production, Prisma creates this table first.
        // We use hasTable() guards to avoid "table already exists" errors
        // that would prevent subsequent migrations (users, sessions) from running.
        if (!Schema::hasTable('User')) {
            Schema::create('User', function (Blueprint $table) {
                $table->id();
                $table->string('email', 255)->unique();
                $table->string('fullName', 255);
                $table->string('hashedPassword', 255);
                $table->string('department', 255)->nullable();
                $table->string('country', 100)->nullable();
                $table->integer('year')->nullable();
                $table->string('avatarUrl', 500)->nullable();
                $table->string('language', 10)->default('en');
                $table->integer('xpPoints')->default(0);
                $table->integer('level')->default(1);
                $table->boolean('isActive')->default(true);
                $table->dateTime('createdAt')->useCurrent();
            });
        }

        // MoodEntry table
        if (!Schema::hasTable('MoodEntry')) {
            Schema::create('MoodEntry', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('userId');
                $table->string('mood', 50);
                $table->text('note')->nullable();
                $table->dateTime('createdAt')->useCurrent();
                $table->foreign('userId')->references('id')->on('User');
                $table->index('userId');
            });
        }

        // Streak table
        if (!Schema::hasTable('Streak')) {
            Schema::create('Streak', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('userId')->unique();
                $table->integer('currentStreak')->default(0);
                $table->integer('longestStreak')->default(0);
                $table->string('lastCheckinDate', 10)->nullable();
                $table->foreign('userId')->references('id')->on('User');
            });
        }

        // GuideCategory table
        if (!Schema::hasTable('GuideCategory')) {
            Schema::create('GuideCategory', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('icon', 100)->nullable();
                $table->string('color', 20)->nullable();
                $table->integer('articleCount')->default(0);
            });
        }

        // Guide table
        if (!Schema::hasTable('Guide')) {
            Schema::create('Guide', function (Blueprint $table) {
                $table->id();
                $table->string('title', 255);
                $table->text('summary')->nullable();
                $table->longText('content')->nullable();
                $table->unsignedBigInteger('categoryId');
                $table->integer('readTimeMinutes')->default(5);
                $table->boolean('isMandatory')->default(false);
                $table->string('icon', 100)->nullable();
                $table->dateTime('createdAt')->useCurrent();
                $table->foreign('categoryId')->references('id')->on('GuideCategory');
                $table->index('categoryId');
            });
        }

        // CampusLocation table
        if (!Schema::hasTable('CampusLocation')) {
            Schema::create('CampusLocation', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('campus', 100);
                $table->string('building', 100)->nullable();
                $table->string('floor', 50)->nullable();
                $table->string('schedule', 100)->nullable();
                $table->string('category', 50)->nullable();
                $table->float('latitude')->nullable();
                $table->float('longitude')->nullable();
                $table->boolean('hasWheelchairAccess')->default(false);
            });
        }

        // Event table
        if (!Schema::hasTable('Event')) {
            Schema::create('Event', function (Blueprint $table) {
                $table->id();
                $table->string('title', 255);
                $table->text('description')->nullable();
                $table->string('location', 255)->nullable();
                $table->string('eventDate', 10);
                $table->string('eventTime', 5)->nullable();
                $table->string('tag', 50)->nullable();
                $table->string('imageUrl', 500)->nullable();
                $table->integer('attendeeCount')->default(0);
            });
        }

        // MediaItem table
        if (!Schema::hasTable('MediaItem')) {
            Schema::create('MediaItem', function (Blueprint $table) {
                $table->id();
                $table->string('title', 255);
                $table->string('mediaType', 20);
                $table->string('creator', 255)->nullable();
                $table->integer('episode')->nullable();
                $table->integer('durationMinutes')->nullable();
                $table->string('thumbnailUrl', 500)->nullable();
                $table->string('mediaUrl', 500)->nullable();
            });
        }

        // Achievement table
        if (!Schema::hasTable('Achievement')) {
            Schema::create('Achievement', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->text('description')->nullable();
                $table->string('icon', 100)->nullable();
                $table->integer('xpReward')->default(0);
                $table->string('conditionType', 50)->nullable();
                $table->integer('conditionValue')->default(1);
            });
        }

        // UserAchievement pivot table
        if (!Schema::hasTable('UserAchievement')) {
            Schema::create('UserAchievement', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('userId');
                $table->unsignedBigInteger('achievementId');
                $table->dateTime('earnedAt')->useCurrent();
                $table->foreign('userId')->references('id')->on('User');
                $table->foreign('achievementId')->references('id')->on('Achievement');
                $table->unique(['userId', 'achievementId']);
                $table->index('userId');
                $table->index('achievementId');
            });
        }

        // WordOfDay table
        if (!Schema::hasTable('WordOfDay')) {
            Schema::create('WordOfDay', function (Blueprint $table) {
                $table->id();
                $table->string('turkishWord', 255);
                $table->string('pronunciation', 255)->nullable();
                $table->string('englishTranslation', 255);
                $table->text('definition')->nullable();
                $table->string('date', 10)->unique();
                $table->integer('xpReward')->default(25);
            });
        }

        // DailyTask table
        if (!Schema::hasTable('DailyTask')) {
            Schema::create('DailyTask', function (Blueprint $table) {
                $table->id();
                $table->string('title', 255);
                $table->integer('xpReward')->default(10);
                $table->string('taskType', 50);
                $table->boolean('isRecurring')->default(true);
            });
        }

        // UserTaskCompletion table
        if (!Schema::hasTable('UserTaskCompletion')) {
            Schema::create('UserTaskCompletion', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('userId');
                $table->unsignedBigInteger('taskId');
                $table->dateTime('completedAt')->useCurrent();
                $table->string('date', 10);
                $table->foreign('userId')->references('id')->on('User');
                $table->foreign('taskId')->references('id')->on('DailyTask');
                $table->unique(['userId', 'taskId', 'date']);
                $table->index('userId');
                $table->index('taskId');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('UserTaskCompletion');
        Schema::dropIfExists('DailyTask');
        Schema::dropIfExists('WordOfDay');
        Schema::dropIfExists('UserAchievement');
        Schema::dropIfExists('Achievement');
        Schema::dropIfExists('MediaItem');
        Schema::dropIfExists('Event');
        Schema::dropIfExists('CampusLocation');
        Schema::dropIfExists('Guide');
        Schema::dropIfExists('GuideCategory');
        Schema::dropIfExists('Streak');
        Schema::dropIfExists('MoodEntry');
        Schema::dropIfExists('User');
    }
};
