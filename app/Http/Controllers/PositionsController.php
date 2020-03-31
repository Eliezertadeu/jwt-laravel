<?php

namespace App\Http\Controllers;

use App\PositionsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionsController extends Controller
{
    /**
     * @var Model
     */

    protected $positions;

    public function __construct(PositionsModel $positions)
    {
        $this->positions = $positions;
    }

    public function showAll()
    {
        try {
            $data = $this->positions->all();
            if (sizeof($data) === 0) {
                return response()->json(
                    $data,
                    204
                );
            } else {
                return response()->json(
                    $data,
                    200
                );
            }
        } catch (\Exception $err) {
            return response()->json([
                'message' => $err
            ], 500);
        }
    }

    public function insertOne(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                $this->rules,
                $this->messages,
                $this->attributes
            );
            if ($validator->fails()) {
                return response()->json([
                    $validator->errors()
                ], 404);
            } else {
                $newPositions = $this->positions->create($request->all());
                return response()->json([
                    'message' => [
                        'created' => $newPositions,
                        'status_code' => 201
                    ]
                ], 201);
            }
        } catch (\Exception $err) {
            return response()->json([
                'message' => [
                    'error' => $err->getMessage(),
                    'status_code' => 500
                ]
            ], 500);
        }
    }

    private $rules = [
        'position_name' => 'required|unique:positions|min:3|max:20'
    ];
    private $messages = [
        'required' => 'O campo :attribute não deve ser vazio',
        'unique' => 'Já existe um :attribute com esse nome',
        'min' => 'O campo :attribute deve ter mais que :min caracteres',
        'max' => 'O campo :attribute deve ter menos que :max caracteres'

    ];
    private $attributes = [
        'position_name' => 'cargo'
    ];
}
