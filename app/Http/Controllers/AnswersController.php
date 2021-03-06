<?php
namespace App\Http\Controllers;

use App\Tracker\Answers\SheetsJsonFeedBuilder;
use Illuminate\Http\Response;

/**
 * Answers Controller
 *
 * Endpoints related to updating answers from the spreadsheet
 *
 * @package App\Http\Controllers
 */
class AnswersController
{
    /**
     * @return Response
     */
    public function update()
    {
        $builder = new SheetsJsonFeedBuilder();
        $builder->setSheetId(env('GSHEET_ID'));
        $builder->updateJsonFile(storage_path('content.en.json'));

        return response('Updated', 200);
    }
}
