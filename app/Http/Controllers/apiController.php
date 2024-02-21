<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Validator;

use App\Models\Jobs;
use App\Models\Skills;
use App\Models\Candidates;
use App\Models\SkillSets;


/**
* @OA\Info(
*      version="1.0.0",
*      title="Dokumentasi API",
*      description="API Documentation for Job Applyment.",
*      @OA\Contact(
*          email="setyawanarik@gmail.com"
*      ),
*      @OA\License(
*          name="Apache 2.0",
*          url="http://www.apache.org/licenses/LICENSE-2.0.html"
*      )
* )
*
* @OA\Server(
*      url=L5_SWAGGER_CONST_HOST,
*      description="Demo API Server"
* )
*/

class apiController extends Controller{
    private function setReturn($success,$message,$data,$error){
        $data_return = [
            "success"=>$success,
            "message"=>$message,
            "data"=>$data,
            "error"=>$error
        ];
        return $data_return;
    }

    public function Index(Request $request) {
        $jobs = DB::select("
            SELECT
                A.id,
                A.name
            FROM
                jobs A
        ");

        $skills = DB::select("
            SELECT
                A.id,
                A.name
            FROM
                skills A
        ");

        return view('index', compact('jobs', 'skills'));
    }


    /**
    *    @OA\Post(
    *       path="/api/v1/new-candidate",
    *       tags={"Candidate"},
    *       operationId="newCandidate",
    *       summary="New Candidate",
    *       description="Candidate apply for a job",
    *       @OA\RequestBody(
    *           required=true,
    *           @OA\JsonContent(
    *               type="object",
    *               @OA\Property(property="full_name", type="string", example="test_user"),
    *               @OA\Property(property="position", type="integer", example=1),
    *               @OA\Property(property="phone", type="string", example="085723339090"),
    *               @OA\Property(property="email", type="string", example="testuser@energeek.com"),
    *               @OA\Property(property="birth_year", type="integer", example=2000),
    *               @OA\Property(property="skills", type="array", @OA\Items(type="integer"), example={1,2,3}),
    *           )
    *       ),
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "success",
    *               "data": {
    *                   "job_id": 1,
    *                   "name": "test_user",
    *                   "email": "testuser@energeek.com",
    *                   "phone": "085723339090",
    *                   "year": 2000,
    *                   "created_by": null,
    *                   "updated_by": null,
    *                   "updated_at": "2024-02-21T13:20:39.000000Z",
    *                   "created_at": "2024-02-21T13:20:39.000000Z",
    *                   "id": 1
    *               },
    *               "error": null
    *           }),
    *      ),
    *       @OA\Response(
    *           response="400",
    *           description="Bad Request",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "fail",
    *               "data": null,
    *               "error": {
    *                   "email": {
    *                       "Email atau Nomor Telpon yang anda masukkan sudah pernah melamar dijabatan tersebut, silahkan memilih jabatan yang lain."
    *                   }
    *               }
    *           }),
    *      ),
    *  )
    */
    public function saveCandidate(Request $request){
        $validated = Validator::make($request->all(), [
            'full_name' => 'required',
            'position' => 'required|integer',
            'phone' => 'required',
            'email' => 'required',
            'birth_year' => 'required|integer',
            'skills' => 'required|array|min:1',
            'skills.*' => 'required|integer'
        ]);

        if ($validated->fails()) {
            $data_return = $this->setReturn(false, 'fail', null, $validated->messages()->get('*'));
            return response()->json($data_return, 400);
        }

        // Check phone string must be number
        if (!is_numeric($request->phone)) {
            $data_return = $this->setReturn(false, 'fail', null, ['phone' => ['Phone must be number']]);
            return response()->json($data_return, 400);
        }

        // check birth year must be number
        if (!is_numeric($request->birth_year)) {
            $data_return = $this->setReturn(false, 'fail', null, ['birth_year' => ['Birth year must be number']]);
            return response()->json($data_return, 400);
        }

        // check email must be valid email
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $data_return = $this->setReturn(false, 'fail', null, ['email' => ['Email must be valid']]);
            return response()->json($data_return, 400);
        }

        // Check if position exists with given ID
        $position = Jobs::find($request->position);
        if (!$position) {
            $data_return = $this->setReturn(false, 'fail', null, ['position' => ['Position not found']]);
            return response()->json($data_return, 400);
        }

        // loop through skills and check if they exist with given ID
        $skills = [];
        foreach ($request->skills as $skill) {
            $skill_obj = Skills::find($skill);
            if (!$skill_obj) {
                $data_return = $this->setReturn(false, 'fail', null, ['skills' => ['Skill not found']]);
                return response()->json($data_return, 400);
            }
            $skills[] = $skill_obj;
        }

        // Check if candidate with same email or phone already exists in that position
        $candidate = DB::table('candidates')
            ->where('job_id', $request->position)
            ->where(function ($query) use ($request) {
                $query->where('email', $request->email)
                    ->orWhere('phone', $request->phone);
            });
        
        if ($candidate->exists()) {
            $data_return = $this->setReturn(false, 'fail', null, ['email' => ['Email atau Nomor Telpon yang anda masukkan sudah pernah melamar dijabatan tersebut, silahkan memilih jabatan yang lain.']]);
            return response()->json($data_return, 400);
        }
        // Save candidate
        $candidate = Candidates::create([
            'job_id' => $request->position,
            'name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'year'=> $request->birth_year
        ]);

        $skillSets = [];
        // Save skills
        foreach ($skills as $skill) {
            $skillSets[] =[
                'candidate_id' => $candidate->id,
                'skill_id' => $skill->id
            ];
        }

        $skillSet = SkillSets::insert($skillSets);
        
        $data_return = $this->setReturn(true, 'success', $candidate, null);
        return response()->json($data_return, 200);
    }

    // Generate Swagger Documentation for getCandidates also with candidate_id and job_id as optional parameters
    /**
    *    @OA\Get(
    *       path="/api/v1/get-candidates",
    *       tags={"Candidate"},
    *       operationId="getCandidates",
    *       summary="Get Candidates",
    *       description="Get all candidates or by specific parameter",
    *       @OA\Parameter(
    *          name="candidate_id",
    *          in="query",
    *          description="Candidate ID",
    *          required=false,
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="job_id",
    *          in="query",
    *          description="Job ID",
    *          required=false,
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "success",
    *               "data": {
    *                   {
    *                       "id": 1,
    *                       "name": "test_user",
    *                       "email": "testuser@energeek.com",
    *                       "phone": "085723339090",
    *                       "birth_year": 2000,
    *                       "job": {
    *                           "id": 1,
    *                           "name": "Frontend Web Programmer"
    *                       },
    *                       "skills": {
    *                           {
    *                               "id": 1,
    *                               "name": "PHP"
    *                           }
    *                       }
    *                   },
    *                   {
    *                       "id": 2,
    *                       "name": "Arik Bagus Setyawan",
    *                       "email": "setyawanarik@gmail.com",
    *                       "phone": "085746115951",
    *                       "birth_year": 2000,
    *                       "job": {
    *                           "id": 1,
    *                           "name": "Frontend Web Programmer"
    *                       },
    *                       "skills": {
    *                           {
    *                               "id": 1,
    *                               "name": "PHP"
    *                           },
    *                           {
    *                               "id": 2,
    *                               "name": "PostgreSQL"
    *                           },
    *                           {
    *                               "id": 3,
    *                               "name": "API (JSON,REST)"
    *                           },
    *                           {
    *                               "id": 4,
    *                               "name": "Version Control System (Github, Gitlab)"
    *                           }
    *                       }
    *                   }
    *               },
    *               "error": null
    *           }),
    *      ), 
    *    )
    */

    public function getCandidates(Request $request){
        $baseQuery = "
            SELECT
                A.id,
                A.`name`,
                A.email,
                A.phone,
                A.`year` AS birth_year,
                B.id AS job_id,
                B.`name` AS job,
                D.id AS skill_id,
                D.`name` AS skill
            FROM
                candidates A
                JOIN jobs B ON A.job_id = B.id
                JOIN skill_sets C ON A.id = C.candidate_id
                JOIN skills D ON C.skill_id = D.id
        ";
        if (!is_null($request->candidate_id) || !is_null($request->job_id)) {
            if (!is_null($request->candidate_id) && !is_null($request->job_id)) {
                $baseQuery .= " WHERE A.id = ".$request->candidate_id." AND B.id = ".$request->job_id;
            } else {
                if ($request->candidate_id) {
                    $baseQuery .= " WHERE A.id = ".$request->candidate_id;
                }
    
                if ($request->job_id) {
                    $baseQuery .= " WHERE B.id = ".$request->job_id;
                }
            }
        }

        $candidates = [];
        $rawCandidates = DB::select($baseQuery);

        // candidates is list of candidate
        // loop rawCandidates and check if candidate is already in array
        foreach ($rawCandidates as $candidate) {
            $_candidate = [
                "id"=>$candidate->id,
                "name"=>$candidate->name,
                "email"=>$candidate->email,
                "phone"=>$candidate->phone,
                "birth_year"=>$candidate->birth_year,
                "job"=>[
                    "id"=>$candidate->job_id,
                    "name"=>$candidate->job
                ],
                "skills"=>[]
            ];
            if (!in_array($_candidate, $candidates)) {
                $candidates[] = $_candidate;
            }
        }

        // loop rawCandidates again
        // check if candidate is already in array
        // if yes, add the skill to the candidate's skills array
        foreach ($rawCandidates as $candidate) {
            foreach ($candidates as &$_candidate) {
                if ($candidate->id == $_candidate["id"]) {
                    $_candidate["skills"][] = ["id"=>$candidate->skill_id,"name"=>$candidate->skill];
                }
            }
        }

        $data_return = $this->setReturn(true, 'success', $candidates, null);
        return response()->json($data_return, 200);
    }
}
