<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPublicInfo extends Model
{
    use HasFactory;

    //protected $primaryKey = 'corporateNumber';
    //public $incrementing = false;

    protected $fillable = [
        'corporateNumber',
        'process',
        'correct',
        'updateDate',
        'changeDate',
        'name',
        'kind',
        'prefectureName',
        'cityName',
        'streetNumber',
        'prefectureCode',
        'cityCode',
        'postCode',
//        'closeDate',
//        'closeCause',
//        'successorCorporateNumber',
//        'changeCause',
        'assignmentDate',
        'latest',
        'furigana',
        'hihyoji',
    ];


}
