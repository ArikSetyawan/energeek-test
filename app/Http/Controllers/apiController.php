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
*      description="Lorem Ipsum",
*      @OA\Contact(
*          email="hi.wasissubekti02@gmail.com"
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
    *       path="/kategori-berita",
    *       tags={"Berita"},
    *       operationId="kategoriBerita",
    *       summary="Kategori Berita",
    *       description="Mengambil Data Kategori Berita",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Kategori Berita",
    *               "data": {
    *                   {
    *                   "id": "1",
    *                   "nama_kategori": "Pendidikan",
    *                  }
    *              }
    *          }),
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
            $data_return = $this->setReturn(false, 'fail', [], $validated->messages()->get('*'));
            return response()->json($data_return, 400);
        }

        // Check phone string must be number
        if (!is_numeric($request->phone)) {
            $data_return = $this->setReturn(false, 'fail', [], ['phone' => ['Phone must be number']]);
            return response()->json($data_return, 400);
        }

        // check birth year must be number
        if (!is_numeric($request->birth_year)) {
            $data_return = $this->setReturn(false, 'fail', [], ['birth_year' => ['Birth year must be number']]);
            return response()->json($data_return, 400);
        }

        // check email must be valid email
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $data_return = $this->setReturn(false, 'fail', [], ['email' => ['Email must be valid']]);
            return response()->json($data_return, 400);
        }

        // Check if position exists with given ID
        $position = Jobs::find($request->position);
        if (!$position) {
            $data_return = $this->setReturn(false, 'fail', [], ['position' => ['Position not found']]);
            return response()->json($data_return, 400);
        }

        // loop through skills and check if they exist with given ID
        $skills = [];
        foreach ($request->skills as $skill) {
            $skill_obj = Skills::find($skill);
            if (!$skill_obj) {
                $data_return = $this->setReturn(false, 'fail', [], ['skills' => ['Skill not found']]);
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
            $data_return = $this->setReturn(false, 'fail', [], ['email' => ['Email atau Nomor Telpon yang anda masukkan sudah pernah melamar dijabatan tersebut, silahkan memilih jabatan yang lain.']]);
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
        
        $data_return = $this->setReturn(true, 'success', $candidate, []);
        return response()->json($data_return, 200);
    }
}
