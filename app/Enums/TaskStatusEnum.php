<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case Pending = 'pending';
    case Progress = 'progress';
    case Completed = 'completed';
}
