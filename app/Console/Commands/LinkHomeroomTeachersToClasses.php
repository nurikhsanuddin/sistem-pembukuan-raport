<?php

namespace App\Console\Commands;

use App\Models\HomeroomTeacher;
use App\Models\SchoolClass;
use Illuminate\Console\Command;

class LinkHomeroomTeachersToClasses extends Command
{
    protected $signature = 'homeroom:link';
    protected $description = 'Link existing homeroom teachers to classes';

    public function handle()
    {
        $teachers = HomeroomTeacher::all();
        $count = 0;

        foreach ($teachers as $teacher) {
            if ($teacher->class_id) {
                $class = SchoolClass::find($teacher->class_id);
                if ($class) {
                    $class->homeroom_teacher_id = $teacher->id;
                    $class->save();
                    $count++;
                }
            }
        }

        $this->info("Linked $count homeroom teachers to classes");
        return Command::SUCCESS;
    }
}
