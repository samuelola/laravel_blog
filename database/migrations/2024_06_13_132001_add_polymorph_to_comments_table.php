<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {

            if(env('DB_CONNECTION') !== 'sqlite_testing'){
                $table->dropForeign(['blog_post_id']);
                $table->dropColumn('blog_post_id');
            }

            $table->morphs('commentable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            if(env('DB_CONNECTION') !== 'sqlite_testing'){

                  $table->unsignedBigInteger('blog_post_id')->index();
            $table->dropMorphs('commentable');
            }

            
            
        });
    }
};
