<?php

namespace App\Enums;

/**
 * @method static static Backlog()
 * @method static static ToDo()
 * @method static static InProgress()
 * @method static static Waiting()
 * @method static static InTesting()
 * @method static static Completed()
 * @method static static CantComplete()
 */
enum Status: string
{
    case Backlog =         "Backlog";
    case ToDo =            "To Do";
    case InProgress =      "In Progress";
    case Waiting =         "Waiting";
    case InTesting =       "In Testing";
    case Completed =       "Completed";
    case CantComplete =    "Can't Complete";
}
