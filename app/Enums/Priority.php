<?php

namespace App\Enums;
/**
 * @method static static Lowest()
 * @method static static Low()
 * @method static static Normal()
 * @method static static High()
 * @method static static Highest()
 * @method static static Critical()
 */
enum Priority: string
{
    case Lowest =      "Lowest";
    case Low =         "Low";
    case Normal =      "Normal";
    case High =        "High";
    case Highest =     "Highest";
    case Critical =    "Critical";
}
