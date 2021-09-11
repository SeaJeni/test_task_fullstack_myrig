<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Employee
 * @package App\Models
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property Carbon $date_of_birth
 * @property double $weight
 * @property string $height
 * @property double $salary
 * @property string $position
 */
class Employee extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
            'first_name',
            'last_name',
            'date_of_birth',
            'weight',
            'height',
            'salary',
            'position',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'salary' => 'float',
        'date_of_birth' => 'datetime',
    ];

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;
}
