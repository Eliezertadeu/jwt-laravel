<?php

namespace App\Http\Controllers;

use App\EmployeesModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeesController extends Controller
{
    /**
     * @var Employees
     */
    protected $employees;

    //construtor do model EmployeesModel que extends ao Model
    //eloquent que trabalha com a comunicação com o banco
    public function __construct(EmployeesModel $employees)
    {
        $this->employees = $employees;
    }

    //exibir todos os employees
    public function showAll()
    {
        try {
            $data = $this->employees
                ->join('positions', 'position_key', '=', 'positions.position_id')
                ->select(
                    'employees.name',
                    'employees.last_name',
                    'employees.email',
                    'employees.age',
                    'employees.cpf',
                    'employees.image',

                    'positions.position_name'
                )->paginate(10);

            if (sizeof($data)) {
                return response()->json(
                    $data,
                    200
                );
            } else {
                return response()->json(
                    $data,
                    204
                );
            }
        } catch (Exception $err) {
            return response()->json([
                'message' => $err
            ], 500);
        }
    }

    //exibir apenas um employees por id
    public function showOne($id)
    {
        try {
            if ($this->employees->find($id) == null) {
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'user' =>  $this->employees->find($id)
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'message' => $err
            ], 500);
        }
    }

    //cadastrar employees
    public function insertOne(Request $request)
    {
        try {
            $data = $request->all();
            $image = $data['image'];
            $path = $image->store('images', 'public');
            $data['image'] = $path;
            //validator
            $validator = Validator::make(
                //pegamos os dados vindo da requisição
                $data,
                //aplicamos as regras
                $this->rules,
                //alteramos as mensagens pois por padrão vem em inglês
                $this->messages,
                //damos um novo apelido os attributes vindo da requisição
                $this->attributes
            );

            //verifica se a validação teve falhas
            if ($validator->fails()) {
                return response()->json([
                    //retornamos as falhas
                    $validator->errors()
                    //código 400 badrequest
                ], 400);
            } else {
                //cadastrar o emploeeys
                $newEmployees = $this->employees->create($data);
                return response()->json([
                    'message' => [
                        'created' => $newEmployees,
                        'status_code' => 201
                    ]
                    //código 201 created
                ], 201);
            }
            // tratando qualquer exception
            //retornando erro 500 internal server error
        } catch (\Exception $err) {
            return response()->json([
                'message' => [
                    'error' => $err->getMessage(),
                    'status_code' => 500
                ]
            ], 500);
        }
    }

    //menssagens de validação o -> :attribute pega o campo que está sendo validado
    //se o nome não for informado ele substitui o :attribute por 'nome'
    private $messages =
    [
        'required' => 'O campo :attribute não deve ser vazio',
        'email' => 'O campo :attribute informado é inválido',
        'numeric' => 'O campo :attribute é do tipo númerico',
        'unique' => 'O campo :attribute já está em uso',
        'min' => 'O campo :attribute deve conter mais que :min caracteres',
        'max' => 'O campo :attribute deve conter menos que :max caracteres'
    ];

    //São as regras aplicadas de acordo com os dados informados
    private $rules = [
        'name' => 'required|max:15|min:5',
        'last_name' => 'required|min:5',
        'email' => 'required|unique:employees|email',
        'age' => 'required|numeric',
        'cpf' => 'required|unique:employees'
    ];
    //os attributes são os dados que chegam, como name, last_name
    //podemos alterar usando este modo 'name'=>'nome
    private  $attributes =  [
        'name' => 'nome',
        'last_name' => 'sobrenome',
        'email' => 'e-mail',
        'age' => 'idade',
        'cpf' => 'CPF',
        'position_key' => 'cargo'
    ];
}
