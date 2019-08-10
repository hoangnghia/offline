<?php

namespace App\Http\Controllers\Admin;

use App\Shop\Admins\Requests\CreateEmployeeRequest;
use App\Shop\Admins\Requests\UpdateEmployeeRequest;
use App\Shop\Agency\EmployeesAgency;
use App\Shop\Employees\Employee;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Shop\Roles\Repositories\RoleRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * @var EmployeeRepositoryInterface
     */
    private $employeeRepo;
    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepo;

    /**
     * EmployeeController constructor.
     *
     * @param EmployeeRepositoryInterface $employeeRepository
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        RoleRepositoryInterface $roleRepository
    ) {
        $this->employeeRepo = $employeeRepository;
        $this->roleRepo = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $list = $this->employeeRepo->listEmployees('created_at', 'desc');

        $list = DB::table('employees as e')
            ->select('e.*','ro.display_name')
            ->join('role_user as r', 'r.user_id', '=', 'e.id')
            ->join('roles as ro', 'ro.id', '=', 'r.role_id')
            ->orderBy('e.created_at', 'desc')
            ->get();
        return view('admin.employees.list', [
            'employees' => $this->employeeRepo->paginateArrayResults($list->all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->roleRepo->listRoles();

        return view('admin.employees.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateEmployeeRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployeeRequest $request)
    {
        $employee = $this->employeeRepo->createEmployee($request->all());

        if ($request->has('role')) {
            $employeeRepo = new EmployeeRepository($employee);
            $employeeRepo->syncRoles([$request->input('role')]);
        }
        return redirect()->route('admin.employees.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $employee = $this->employeeRepo->findEmployeeById($id);
        return view('admin.employees.show', ['employee' => $employee]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $employee = $this->employeeRepo->findEmployeeById($id);
        $roles = $this->roleRepo->listRoles('created_at', 'desc');
        $isCurrentUser = $this->employeeRepo->isAuthUser($employee);

        return view(
            'admin.employees.edit',
            [
                'employee' => $employee,
                'roles' => $roles,
                'isCurrentUser' => $isCurrentUser,
                'selectedIds' => $employee->roles()->pluck('role_id')->all()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEmployeeRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        $employee = $this->employeeRepo->findEmployeeById($id);
        $isCurrentUser = $this->employeeRepo->isAuthUser($employee);

        $empRepo = new EmployeeRepository($employee);
        $empRepo->updateEmployee($request->except('_token', '_method', 'password'));

        if ($request->has('password') && !empty($request->input('password'))) {
            $employee->password = Hash::make($request->input('password'));
            $employee->save();
        }

        if ($request->has('roles') and !$isCurrentUser) {
            $employee->roles()->sync($request->input('roles'));
        } elseif (!$isCurrentUser) {
            $employee->roles()->detach();
        }

        return redirect()->route('admin.employees.edit', $id)
            ->with('message', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        $employeesAgency = EmployeesAgency::where('employees_id',$id)->get();
        $count = count($employeesAgency);
        if ($count == 0)
        {
            $list = DB::table('employees')->where('id',$id)->delete();
            return redirect()->route('admin.employees.index')->with('message', 'Xóa thành công');
        }
//        $employee = $this->employeeRepo->findEmployeeById($id);
//        $employeeRepo = new EmployeeRepository($employee);
//        $employeeRepo->deleteEmployee();
        return redirect()->route('admin.employees.index')->with('error', 'Error ! Nhân sự có liên kết, không thể xóa.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function status($id)
    {

        $employee = $this->employeeRepo->findEmployeeById($id);
        if($employee->status == 1)
        {
            $employee->status = 0;
        }else{
            $employee->status = 1;
        }
        $employee->save();
        return redirect()->route('admin.employees.index')->with('message', 'Thành công');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProfile($id)
    {
        $employee = $this->employeeRepo->findEmployeeById($id);
        return view('admin.employees.profile', ['employee' => $employee]);
    }

    /**
     * @param UpdateEmployeeRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(UpdateEmployeeRequest $request, $id)
    {
        $employee = $this->employeeRepo->findEmployeeById($id);

        $update = new EmployeeRepository($employee);
        $update->updateEmployee($request->except('_token', '_method', 'password'));

        if ($request->has('password') && $request->input('password') != '') {
            $update->updateEmployee($request->only('password'));
        }

        return redirect()->route('admin.employee.profile', $id)
            ->with('message', 'Cập nhật thành công');
    }
}
